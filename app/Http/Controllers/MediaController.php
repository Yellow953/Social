<?php

namespace App\Http\Controllers;

use App\Models\MaterialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class MediaController extends Controller
{
    /**
     * Show media detail page
     */
    public function detail(MaterialMedia $media)
    {
        $user = Auth::user();
        $material = $media->material;

        if (!$material->canBeAccessedBy($user)) {
            abort(403, 'You need an active SOCIALPLUS subscription to access this media.');
        }

        return view('media.detail', compact('media', 'material'));
    }

    /**
     * View media with watermark (for images)
     */
    public function view(MaterialMedia $media)
    {
        $user = Auth::user();
        $material = $media->material;

        if (!$material->canBeAccessedBy($user)) {
            abort(403, 'You need an active SOCIALPLUS subscription to access this media.');
        }

        $filePath = Storage::disk('local')->path($media->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'Media file not found.');
        }

        // For images, we'll serve them with watermark overlay via frontend
        // For PDFs and videos, we'll use viewers that prevent downloads
        if ($media->type === 'image') {
            return $this->viewImage($media, $filePath, $user);
        } elseif ($media->type === 'pdf') {
            return $this->viewPdf($media, $filePath, $user);
        } elseif ($media->type === 'video') {
            return $this->viewVideo($media, $filePath, $user);
        }

        abort(400, 'Unsupported media type.');
    }

    /**
     * View image with watermark
     */
    private function viewImage(MaterialMedia $media, string $filePath, $user)
    {
        // Create watermarked image
        $image = imagecreatefromstring(file_get_contents($filePath));
        
        if (!$image) {
            abort(500, 'Failed to load image.');
        }

        $width = imagesx($image);
        $height = imagesy($image);

        // Load watermark logo
        $logoPath = public_path('assets/images/logo-transparent.png');
        if (file_exists($logoPath)) {
            $logo = imagecreatefrompng($logoPath);
            if ($logo) {
                $logoWidth = imagesx($logo);
                $logoHeight = imagesy($logo);
                
                // Resize logo to be 15% of image width
                $newLogoWidth = (int)($width * 0.15);
                $newLogoHeight = (int)($logoHeight * ($newLogoWidth / $logoWidth));
                
                $resizedLogo = imagecreatetruecolor($newLogoWidth, $newLogoHeight);
                imagealphablending($resizedLogo, false);
                imagesavealpha($resizedLogo, true);
                imagecopyresampled($resizedLogo, $logo, 0, 0, 0, 0, $newLogoWidth, $newLogoHeight, $logoWidth, $logoHeight);
                
                // Add username text
                $username = strtoupper($user->name);
                $fontSize = 5; // Built-in font size (1-5, 5 is largest)
                $textColor = imagecolorallocatealpha($image, 92, 92, 92, 40); // Gray with transparency (#5c5c5c)
                
                // Calculate text position (center-bottom)
                // Estimate text width: approximately 6 pixels per character for font 5
                $textWidth = strlen($username) * 6;
                $textX = ($width - $textWidth) / 2;
                $textY = $height - 40;
                
                // Use built-in font (more reliable across systems)
                imagestring($image, $fontSize, (int)$textX, (int)$textY, $username, $textColor);
                
                // Place logo in center
                $logoX = ($width - $newLogoWidth) / 2;
                $logoY = ($height - $newLogoHeight) / 2;
                imagecopymerge($image, $resizedLogo, (int)$logoX, (int)$logoY, 0, 0, $newLogoWidth, $newLogoHeight, 70);
                
                imagedestroy($resizedLogo);
                imagedestroy($logo);
            }
        }

        // Output image
        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        imagedestroy($image);

        return Response::make($imageData, 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'inline; filename="' . $media->original_filename . '"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    /**
     * View PDF - only allow when requested by our viewer (XHR with header).
     * Direct browser/iframe access returns 403 to prevent download/save.
     */
    private function viewPdf(MaterialMedia $media, string $filePath, $user)
    {
        // Only serve PDF to our PDF.js viewer (sends this header), not to direct navigation/iframe
        if (!request()->header('X-PDF-Viewer-Request')) {
            abort(403, 'Direct access to this resource is not allowed. View the document from the session page.');
        }

        return Response::file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $media->original_filename . '"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    /**
     * View video (we'll use video player with watermark overlay in frontend)
     */
    private function viewVideo(MaterialMedia $media, string $filePath, $user)
    {
        // For videos, we'll serve them through a player that prevents downloads
        // The watermark will be added via canvas overlay in frontend
        $file = Storage::disk('local')->get($media->file_path);
        
        return Response::make($file, 200, [
            'Content-Type' => $media->mime_type ?? 'video/mp4',
            'Content-Disposition' => 'inline; filename="' . $media->original_filename . '"',
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    /**
     * Stream video with range support
     */
    public function stream(MaterialMedia $media)
    {
        $user = Auth::user();
        $material = $media->material;

        if (!$material->canBeAccessedBy($user)) {
            abort(403, 'You need an active SOCIALPLUS subscription to access this media.');
        }

        if ($media->type !== 'video') {
            abort(400, 'This endpoint is only for video streaming.');
        }

        $filePath = Storage::disk('local')->path($media->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'Media file not found.');
        }

        $fileSize = filesize($filePath);
        $start = 0;
        $end = $fileSize - 1;

        // Handle range requests for video streaming
        if (isset($_SERVER['HTTP_RANGE'])) {
            preg_match('/bytes=(\d+)-(\d*)/', $_SERVER['HTTP_RANGE'], $matches);
            $start = intval($matches[1]);
            if (!empty($matches[2])) {
                $end = intval($matches[2]);
            }
        }

        $length = $end - $start + 1;

        $file = fopen($filePath, 'rb');
        fseek($file, $start);

        $data = fread($file, $length);
        fclose($file);

        return Response::make($data, 206, [
            'Content-Type' => $media->mime_type ?? 'video/mp4',
            'Content-Length' => $length,
            'Content-Range' => "bytes $start-$end/$fileSize",
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}

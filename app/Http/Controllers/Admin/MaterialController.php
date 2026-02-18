<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Course;
use App\Models\MaterialMedia;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::with('course')
            ->orderBy('course_id')
            ->orderBy('created_at')
            ->paginate(20);

        return view('admin.materials.index', compact('materials'));
    }

    public function create()
    {
        $courses = Course::orderBy('name')->get();
        return view('admin.materials.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'type' => 'required|string|in:cours,tp,video_recording',
            'is_locked' => 'boolean',
            'watermark_type' => 'nullable|string|in:none,full,logo_only,username_only',
            'media' => 'nullable|array',
            'media.*' => 'file|mimes:pdf,mp4,webm,ogg,mov,avi,mkv,m4v,jpg,jpeg,png,gif,webp|max:524288',
            'material_temp_uploads' => 'nullable|string',
            'material_temp_names' => 'nullable|string',
        ]);

        $validated['is_locked'] = $request->has('is_locked');
        $validated['watermark_type'] = $validated['watermark_type'] ?? 'full';

        $material = Material::create($validated);

        if ($request->hasFile('media')) {
            $this->handleMediaUploads($request, $material);
        }

        $tempIds = $request->input('material_temp_uploads') ? json_decode($request->input('material_temp_uploads'), true) : [];
        $tempNames = $request->input('material_temp_names') ? json_decode($request->input('material_temp_names'), true) : [];
        if (is_array($tempIds) && !empty($tempIds)) {
            $this->processTempUploads($material, $tempIds, is_array($tempNames) ? $tempNames : []);
        }

        $this->notifyUsersAboutMaterial($material, 'created');

        return redirect()->route('admin.materials.index')
            ->with('success', 'Material created successfully.');
    }

    public function edit(Material $material)
    {
        $courses = Course::orderBy('name')->get();
        $material->load('media');
        return view('admin.materials.edit', compact('material', 'courses'));
    }

    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'type' => 'required|string|in:cours,tp,video_recording',
            'is_locked' => 'boolean',
            'watermark_type' => 'nullable|string|in:none,full,logo_only,username_only',
            'keep_media' => 'nullable|array',
            'keep_media.*' => 'integer|exists:material_media,id',
            'media_lock' => 'nullable|array',
            'media_lock.*' => 'boolean',
            'material_temp_uploads' => 'nullable|string',
            'material_temp_names' => 'nullable|string',
            'media_name' => 'nullable|array',
            'media_name.*' => 'nullable|string|max:255',
        ]);

        $validated['is_locked'] = $request->has('is_locked');
        if (array_key_exists('watermark_type', $validated)) {
            $validated['watermark_type'] = $validated['watermark_type'] ?? 'full';
        }

        $material->update($validated);

        if ($request->hasFile('media')) {
            $this->handleMediaUploads($request, $material);
        }

        $tempIds = $request->input('material_temp_uploads') ? json_decode($request->input('material_temp_uploads'), true) : [];
        $tempNames = $request->input('material_temp_names') ? json_decode($request->input('material_temp_names'), true) : [];
        if (is_array($tempIds) && !empty($tempIds)) {
            $this->processTempUploads($material, $tempIds, is_array($tempNames) ? $tempNames : []);
        }

        if ($request->has('keep_media')) {
            $keepMedia = (array) $request->input('keep_media', []);
            $mediaNames = $request->input('media_name', []);
            $mediaLocks = $request->input('media_lock', []);
            $material->media()->whereIn('id', $keepMedia)->each(function (MaterialMedia $media) use ($mediaNames, $mediaLocks) {
                $updates = [];
                if (isset($mediaNames[$media->id]) && is_string($mediaNames[$media->id]) && trim($mediaNames[$media->id]) !== '') {
                    $updates['original_filename'] = trim($mediaNames[$media->id]);
                }
                if (array_key_exists($media->id, $mediaLocks)) {
                    $updates['is_locked'] = !empty($mediaLocks[$media->id]);
                }
                if (!empty($updates)) {
                    $media->update($updates);
                }
            });
            $material->media()->whereNotIn('id', $keepMedia)->each(function (MaterialMedia $media) {
                Storage::disk('local')->delete($media->file_path);
                $media->delete();
            });
        }

        return redirect()->route('admin.materials.index')
            ->with('success', 'Material updated successfully.');
    }

    /**
     * Toggle material lock state (AJAX). Each material's lock is independent.
     */
    public function toggleLock(Request $request, Material $material)
    {
        $material->update(['is_locked' => !$material->is_locked]);
        return response()->json(['is_locked' => $material->is_locked]);
    }

    /**
     * Upload a single file to temp storage; returns temp id for form submit.
     * Enables immediate upload with progress; form submit only sends temp ids.
     */
    public function uploadTemp(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,mp4,webm,ogg,mov,avi,mkv,m4v,jpg,jpeg,png,gif,webp|max:524288',
        ]);

        $file = $request->file('file');
        $ext = strtolower($file->getClientOriginalExtension());
        $type = $this->getMediaTypeFromExtension($ext);
        if (!$type) {
            return response()->json(['error' => 'Unsupported file type'], 422);
        }

        $uuid = Str::uuid()->toString();
        $tempName = $uuid . '.' . $ext;
        $path = $file->storeAs('temp/materials', $tempName, 'local');
        if (!$path) {
            return response()->json(['error' => 'Upload failed'], 500);
        }

        $sessionKey = 'material_temp_uploads';
        $uploads = session($sessionKey, []);
        $uploads[$uuid] = [
            'path' => $path,
            'original_filename' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'type' => $type,
            'size' => $file->getSize(),
        ];
        session([$sessionKey => $uploads]);

        return response()->json([
            'id' => $uuid,
            'original_filename' => $file->getClientOriginalName(),
            'type' => $type,
            'size' => $file->getSize(),
        ]);
    }

    /**
     * Download a media file (admin only).
     */
    public function downloadMedia(MaterialMedia $material_media)
    {
        $path = $this->resolveMediaFilePath($material_media->file_path);
        $name = $material_media->original_filename ?: basename($path);
        return response()->download($path, $name, [
            'Content-Type' => $material_media->mime_type ?? 'application/octet-stream',
        ]);
    }

    /**
     * Convert an image media to PDF and add it as a new media item (keeps the image).
     */
    public function convertToPdf(Request $request, MaterialMedia $material_media)
    {
        if ($material_media->type !== 'image') {
            return redirect()->back()->with('error', 'Only image files can be converted to PDF.');
        }

        $path = $this->resolveMediaFilePath($material_media->file_path);
        $material = $material_media->material;

        try {
            $newPath = $this->convertImageToPdf($path, $material->id, $material_media->order);
            if (!$newPath) {
                \Log::warning('convertToPdf: conversion returned null', ['material_media_id' => $material_media->id]);
                return redirect()->back()->with('error', 'Conversion failed. Use a JPEG, PNG or GIF image. If the problem persists, check storage/logs/laravel.log.');
            }

            $fullPath = Storage::disk('local')->path($newPath);
            if (!file_exists($fullPath)) {
                return redirect()->back()->with('error', 'PDF was created but file not found. Please try again.');
            }

            $nextOrder = (int) $material->media()->max('order') + 1;
            $baseName = pathinfo($material_media->original_filename, PATHINFO_FILENAME) . '.pdf';

            MaterialMedia::create([
                'material_id' => $material->id,
                'type' => 'pdf',
                'file_path' => $newPath,
                'original_filename' => $baseName,
                'mime_type' => 'application/pdf',
                'file_size' => (int) filesize($fullPath),
                'order' => $nextOrder,
                'is_locked' => $material_media->is_locked,
            ]);

            return redirect()->back()->with('success', 'PDF created and added to this material. The image file is kept.');
        } catch (\Throwable $e) {
            \Log::error('convertToPdf failed', ['material_media_id' => $material_media->id, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Conversion failed: ' . $e->getMessage());
        }
    }

    private function resolveMediaFilePath(string $filePath): string
    {
        $path = Storage::disk('local')->path($filePath);
        if (file_exists($path)) {
            return $path;
        }
        $legacyPath = storage_path('app/' . $filePath);
        if (file_exists($legacyPath)) {
            return $legacyPath;
        }
        abort(404, 'Media file not found.');
    }

    /**
     * Convert image file to PDF. Returns relative path (e.g. materials/media/...) or null on failure.
     * Uses Imagick if available, otherwise setasign/fpdf (Composer, no system extension).
     */
    private function convertImageToPdf(string $imagePath, int $materialId, int $order): ?string
    {
        $dir = Storage::disk('local')->path('materials/media');
        if (!is_dir($dir)) {
            \Illuminate\Support\Facades\File::makeDirectory($dir, 0755, true);
        }
        $filename = sprintf('material_%d_pdf_%d_%s.pdf', $materialId, $order, Str::random(8));
        $pdfPath = $dir . '/' . $filename;

        if (class_exists(\Imagick::class)) {
            try {
                $im = new \Imagick($imagePath);
                $im->setImageFormat('pdf');
                $im->writeImages($pdfPath, true);
                $im->clear();
                $im->destroy();
                return 'materials/media/' . $filename;
            } catch (\Throwable $e) {
                // Fall through to FPDF
            }
        }

        return $this->convertImageToPdfWithFpdf($imagePath, $pdfPath)
            ? 'materials/media/' . $filename
            : null;
    }

    /**
     * Convert image to PDF using setasign/fpdf (pure PHP, no Imagick).
     */
    private function convertImageToPdfWithFpdf(string $imagePath, string $pdfPath): bool
    {
        if (!class_exists(\FPDF::class)) {
            return false;
        }
        $info = @getimagesize($imagePath);
        if (!$info || !in_array($info[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF], true)) {
            return false;
        }
        $wPx = (int) $info[0];
        $hPx = (int) $info[1];
        if ($wPx <= 0 || $hPx <= 0) {
            return false;
        }
        $mmPerPx = 25.4 / 96;
        $wMm = $wPx * $mmPerPx;
        $hMm = $hPx * $mmPerPx;
        try {
            $pdf = new \FPDF('P', 'mm', [$wMm, $hMm]);
            $pdf->SetMargins(0, 0, 0);
            $pdf->SetAutoPageBreak(false, 0);
            $pdf->AddPage();
            $pdf->Image($imagePath, 0, 0, $wMm, $hMm);
            $pdf->Output('F', $pdfPath);
            return file_exists($pdfPath);
        } catch (\Throwable $e) {
            \Log::warning('FPDF image to PDF failed', ['path' => $imagePath, 'error' => $e->getMessage()]);
            return false;
        }
    }

    public function destroy(Material $material)
    {
        foreach ($material->media as $media) {
            Storage::disk('local')->delete($media->file_path);
        }

        $material->delete();

        return redirect()->route('admin.materials.index')
            ->with('success', 'Material deleted successfully.');
    }

    private function getMediaTypeFromExtension(string $ext): ?string
    {
        if ($ext === 'pdf') {
            return 'pdf';
        }
        if (in_array($ext, ['mp4', 'webm', 'ogg', 'mov', 'avi', 'mkv', 'm4v', 'flv'])) {
            return 'video';
        }
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            return 'image';
        }
        return null;
    }

    /**
     * Generate a consistent stored filename: material_{id}_{type}_{order}_{shortid}.{ext}
     */
    private function storedMediaFilename(Material $material, string $type, int $order, string $ext): string
    {
        $ext = strtolower($ext);
        if ($type === 'image' && in_array($ext, ['png', 'gif'])) {
            $ext = 'png';
        } elseif ($type === 'image') {
            $ext = 'jpg';
        }
        return sprintf('material_%d_%s_%d_%s.%s', $material->id, $type, $order, Str::random(8), $ext);
    }

    /**
     * Process temp uploads from session: move/compress to final path with renamed file, create MaterialMedia.
     * $tempNames: optional array [uuid => custom display name] for original_filename.
     */
    private function processTempUploads(Material $material, array $tempIds, array $tempNames = []): void
    {
        $uploads = session('material_temp_uploads', []);
        $maxOrder = (int) $material->media()->max('order');
        $dir = Storage::disk('local')->path('materials/media');
        if (!is_dir($dir)) {
            \Illuminate\Support\Facades\File::makeDirectory($dir, 0755, true);
        }

        foreach ($tempIds as $uuid) {
            if (!isset($uploads[$uuid])) {
                continue;
            }
            $entry = $uploads[$uuid];
            $tempPath = Storage::disk('local')->path($entry['path']);
            if (!file_exists($tempPath)) {
                unset($uploads[$uuid]);
                continue;
            }

            $displayName = isset($tempNames[$uuid]) && is_string($tempNames[$uuid]) && trim($tempNames[$uuid]) !== ''
                ? trim($tempNames[$uuid])
                : $entry['original_filename'];

            $maxOrder++;
            $type = $entry['type'];
            $ext = pathinfo($entry['original_filename'], PATHINFO_EXTENSION) ?: ($type === 'pdf' ? 'pdf' : ($type === 'video' ? 'mp4' : 'jpg'));
            $filename = $this->storedMediaFilename($material, $type, $maxOrder, $ext);
            $finalRelativePath = 'materials/media/' . $filename;

            try {
                if ($type === 'image') {
                    [$finalRelativePath, $storedSize] = $this->storeImageCompressedFromPath($tempPath, $ext, $material->id, $maxOrder);
                } else {
                    $storedSize = (int) filesize($tempPath);
                    Storage::disk('local')->put($finalRelativePath, file_get_contents($tempPath));
                }

                MaterialMedia::create([
                    'material_id' => $material->id,
                    'type' => $type,
                    'file_path' => $finalRelativePath,
                    'original_filename' => $displayName,
                    'mime_type' => $entry['mime_type'],
                    'file_size' => $storedSize,
                    'order' => $maxOrder,
                    'is_locked' => $material->is_locked,
                ]);
            } finally {
                @unlink($tempPath);
            }
            unset($uploads[$uuid]);
        }
        session(['material_temp_uploads' => $uploads]);
    }

    private function handleMediaUploads(Request $request, Material $material)
    {
        if (!$request->hasFile('media')) {
            return;
        }

        $files = $request->file('media');
        if (!is_array($files)) {
            $files = [$files];
        }

        $maxOrder = (int) $material->media()->max('order');

        foreach ($files as $file) {
            if (!$file || !$file->isValid()) {
                continue;
            }

            $extension = strtolower($file->getClientOriginalExtension());
            $type = $this->getMediaTypeFromExtension($extension);
            if (!$type) {
                continue;
            }

            try {
                $maxOrder++;
                $storedSize = $file->getSize();
                $mimeType = $file->getMimeType();
                $filename = $this->storedMediaFilename($material, $type, $maxOrder, $extension);

                if ($type === 'image') {
                    [$path, $storedSize] = $this->storeImageCompressed($file, $material, $maxOrder);
                } else {
                    $path = $file->storeAs('materials/media', $filename, 'local');
                }

                if (!$path) {
                    $maxOrder--;
                    continue;
                }

                MaterialMedia::create([
                    'material_id' => $material->id,
                    'type' => $type,
                    'file_path' => $path,
                    'original_filename' => $file->getClientOriginalName(),
                    'mime_type' => $mimeType,
                    'file_size' => $storedSize,
                    'order' => $maxOrder,
                    'is_locked' => $material->is_locked,
                ]);
            } catch (\Exception $e) {
                $maxOrder--;
                continue;
            }
        }
    }

    private function notifyUsersAboutMaterial(Material $material, string $action = 'created')
    {
        $material->load('course');
        $course = $material->course;

        // Only notify users whose study year and major match the course (e.g. 1st year + GIS)
        $query = User::where('role', 'user');
        if ($course->year !== null && $course->year !== '') {
            $query->where('study_year', $course->year);
        }
        if ($course->major !== null && $course->major !== '') {
            $query->where('major', $course->major);
        }
        $users = $query->get();

        $title = $action === 'created' ? 'New Material Available' : 'Material Updated';
        $message = $action === 'created'
            ? "New material \"{$material->title}\" has been added to the course \"{$course->name}\"."
            : "The material \"{$material->title}\" in course \"{$course->name}\" has been updated.";

        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'type' => 'session',
                'title' => $title,
                'message' => $message,
                'data' => [
                    'material_id' => $material->id,
                    'material_title' => $material->title,
                    'course_id' => $material->course_id,
                    'course_name' => $course->name,
                ],
                'read' => false,
            ]);
        }
    }

    /**
     * Store image with compression (max width 1920, JPEG quality 85 or PNG 8).
     * Uses renamed filename when $material and $order are provided.
     */
    private function storeImageCompressed(\Illuminate\Http\UploadedFile $file, ?Material $material = null, ?int $order = null): array
    {
        $extension = strtolower($file->getClientOriginalExtension());
        return $this->storeImageCompressedFromPath($file->getRealPath(), $extension, $material?->id, $order);
    }

    /**
     * Compress image from a temp path and save with renamed filename.
     */
    private function storeImageCompressedFromPath(string $tempPath, string $extension, ?int $materialId, ?int $order): array
    {
        $maxWidth = 1920;
        $jpegQuality = 85;
        $pngCompression = 8;
        $dir = Storage::disk('local')->path('materials/media');
        if (!is_dir($dir)) {
            \Illuminate\Support\Facades\File::makeDirectory($dir, 0755, true);
        }

        $contents = file_get_contents($tempPath);
        $image = @imagecreatefromstring($contents);
        if (!$image && $extension === 'webp' && function_exists('imagecreatefromwebp')) {
            $image = @imagecreatefromwebp($tempPath);
        }
        if (!$image) {
            $filename = ($materialId && $order !== null)
                ? sprintf('material_%d_image_%d_%s.%s', $materialId, $order, Str::random(8), $extension)
                : 'img_' . uniqid('', true) . '.' . $extension;
            $path = 'materials/media/' . $filename;
            Storage::disk('local')->put($path, $contents);
            return [$path, strlen($contents)];
        }

        $width = imagesx($image);
        $height = imagesy($image);
        $needsResize = $width > $maxWidth;
        $newWidth = $needsResize ? $maxWidth : $width;
        $newHeight = $needsResize ? (int) round($height * ($maxWidth / $width)) : $height;

        $out = imagecreatetruecolor($newWidth, $newHeight);
        if (!$out) {
            imagedestroy($image);
            $filename = ($materialId && $order !== null)
                ? sprintf('material_%d_image_%d_%s.%s', $materialId, $order, Str::random(8), $extension === 'png' || $extension === 'gif' ? 'png' : 'jpg')
                : 'img_' . uniqid('', true) . '.' . ($extension === 'png' || $extension === 'gif' ? 'png' : 'jpg');
            $path = 'materials/media/' . $filename;
            Storage::disk('local')->put($path, $contents);
            return [$path, strlen($contents)];
        }

        imagealphablending($out, false);
        imagesavealpha($out, true);
        $transparent = imagecolorallocatealpha($out, 255, 255, 255, 127);
        imagefilledrectangle($out, 0, 0, $newWidth, $newHeight, $transparent);
        imagecopyresampled($out, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagedestroy($image);

        $ext = ($extension === 'png' || $extension === 'gif') ? 'png' : 'jpg';
        $filename = ($materialId !== null && $order !== null)
            ? sprintf('material_%d_image_%d_%s.%s', $materialId, $order, Str::random(8), $ext)
            : 'img_' . uniqid('', true) . '.' . $ext;
        $fullPath = $dir . '/' . $filename;

        if ($ext === 'png') {
            imagepng($out, $fullPath, $pngCompression);
        } else {
            imagejpeg($out, $fullPath, $jpegQuality);
        }
        imagedestroy($out);

        $path = 'materials/media/' . $filename;
        $storedSize = (int) filesize($fullPath);
        return [$path, $storedSize];
    }

    private function handleMediaDeletion(array $mediaIds)
    {
        foreach ($mediaIds as $mediaId) {
            $media = MaterialMedia::find($mediaId);
            if ($media) {
                Storage::disk('local')->delete($media->file_path);
                $media->delete();
            }
        }
    }
}

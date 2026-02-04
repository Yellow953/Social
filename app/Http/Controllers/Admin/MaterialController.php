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
            'media' => 'nullable|array',
            'media.*' => 'file|mimes:pdf,mp4,webm,ogg,mov,avi,mkv,m4v,jpg,jpeg,png,gif,webp|max:524288',
        ]);

        $validated['is_locked'] = $request->has('is_locked');

        $material = Material::create($validated);

        if ($request->hasFile('media')) {
            $this->handleMediaUploads($request, $material);
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
        ]);

        $validated['is_locked'] = $request->has('is_locked');

        $material->update($validated);

        if ($request->hasFile('media')) {
            $this->handleMediaUploads($request, $material);
        }

        if ($request->has('delete_media')) {
            $this->handleMediaDeletion($request->delete_media);
        }

        return redirect()->route('admin.materials.index')
            ->with('success', 'Material updated successfully.');
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

    private function handleMediaUploads(Request $request, Material $material)
    {
        if (!$request->hasFile('media')) {
            return;
        }

        $files = $request->file('media');
        if (!is_array($files)) {
            $files = [$files];
        }

        foreach ($files as $file) {
            if (!$file || !$file->isValid()) {
                continue;
            }

            $extension = strtolower($file->getClientOriginalExtension());
            $type = null;
            if ($extension === 'pdf') {
                $type = 'pdf';
            } elseif (in_array($extension, ['mp4', 'webm', 'ogg', 'mov', 'avi', 'mkv', 'm4v', 'flv'])) {
                $type = 'video';
            } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $type = 'image';
            }

            if (!$type) {
                continue;
            }

            try {
                $path = null;
                $storedSize = $file->getSize();
                $mimeType = $file->getMimeType();

                if ($type === 'image') {
                    [$path, $storedSize] = $this->storeImageCompressed($file);
                } else {
                    $path = $file->store('materials/media', 'local');
                }

                if (!$path) {
                    continue;
                }

                $maxOrder = $material->media()->max('order') ?? 0;

                MaterialMedia::create([
                    'material_id' => $material->id,
                    'type' => $type,
                    'file_path' => $path,
                    'original_filename' => $file->getClientOriginalName(),
                    'mime_type' => $mimeType,
                    'file_size' => $storedSize,
                    'order' => $maxOrder + 1,
                ]);
            } catch (\Exception $e) {
                continue;
            }
        }
    }

    private function notifyUsersAboutMaterial(Material $material, string $action = 'created')
    {
        $users = User::where('role', 'user')->get();

        $title = $action === 'created' ? 'New Material Available' : 'Material Updated';
        $message = $action === 'created'
            ? "New material \"{$material->title}\" has been added to the course \"{$material->course->name}\"."
            : "The material \"{$material->title}\" in course \"{$material->course->name}\" has been updated.";

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
                    'course_name' => $material->course->name,
                ],
                'read' => false,
            ]);
        }
    }

    /**
     * Store image with compression (max width 1920, JPEG quality 85 or PNG 8).
     * PDF and video are stored as-is (no compression).
     */
    private function storeImageCompressed(\Illuminate\Http\UploadedFile $file): array
    {
        $path = null;
        $extension = strtolower($file->getClientOriginalExtension());
        $maxWidth = 1920;
        $jpegQuality = 85;
        $pngCompression = 8;

        $contents = $file->get();
        $image = @imagecreatefromstring($contents);
        if (!$image && $extension === 'webp' && function_exists('imagecreatefromwebp')) {
            $image = @imagecreatefromwebp($file->getRealPath());
        }
        if (!$image) {
            $path = $file->store('materials/media', 'local');
            return [$path, $file->getSize()];
        }

        $width = imagesx($image);
        $height = imagesy($image);
        $needsResize = $width > $maxWidth;
        $newWidth = $needsResize ? $maxWidth : $width;
        $newHeight = $needsResize ? (int) round($height * ($maxWidth / $width)) : $height;

        $out = imagecreatetruecolor($newWidth, $newHeight);
        if (!$out) {
            imagedestroy($image);
            $path = $file->store('materials/media', 'local');
            return [$path, $file->getSize()];
        }

        imagealphablending($out, false);
        imagesavealpha($out, true);
        $transparent = imagecolorallocatealpha($out, 255, 255, 255, 127);
        imagefilledrectangle($out, 0, 0, $newWidth, $newHeight, $transparent);

        imagecopyresampled($out, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagedestroy($image);

        $dir = storage_path('app/materials/media');
        if (!is_dir($dir)) {
            \Illuminate\Support\Facades\File::makeDirectory($dir, 0755, true);
        }
        $filename = uniqid('img_', true) . '.' . ($extension === 'png' || $extension === 'gif' ? 'png' : 'jpg');
        $fullPath = $dir . '/' . $filename;

        if ($extension === 'png' || $extension === 'gif') {
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

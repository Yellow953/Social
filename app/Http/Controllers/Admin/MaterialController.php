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
            'media.*' => 'file|mimes:pdf,mp4,webm,ogg,mov,avi,jpg,jpeg,png,gif,webp|max:512000',
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
            } elseif (in_array($extension, ['mp4', 'webm', 'ogg', 'mov', 'avi', 'mkv', 'flv'])) {
                $type = 'video';
            } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $type = 'image';
            }

            if (!$type) {
                continue;
            }

            try {
                $path = $file->store('materials/media', 'local');
                $maxOrder = $material->media()->max('order') ?? 0;

                MaterialMedia::create([
                    'material_id' => $material->id,
                    'type' => $type,
                    'file_path' => $path,
                    'original_filename' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
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

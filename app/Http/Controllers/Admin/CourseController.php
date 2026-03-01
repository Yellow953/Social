<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Material;
use App\Models\MaterialMedia;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::withCount('materials')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'description' => 'nullable|string',
            'major' => ['required', 'string', Rule::in(array_merge([null, ''], config('majors')))],
            'year' => 'required|string|max:50',
            'semester' => 'required|string|in:1,2',
        ]);

        $course = Course::create($validated);

        $this->notifyUsers('course', 'New Course Available', "A new course \"{$course->name}\" has been added to the platform.", [
            'course_id' => $course->id,
            'course_name' => $course->name,
        ]);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course created successfully.');
    }

    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'description' => 'nullable|string',
            'major' => ['required', 'string', Rule::in(array_merge([null, ''], config('majors')))],
            'year' => 'required|string|max:50',
            'semester' => 'required|string|in:1,2',
        ]);

        $course->update($validated);

        $this->notifyUsers('course', 'Course Updated', "The course \"{$course->name}\" has been updated.", [
            'course_id' => $course->id,
            'course_name' => $course->name,
        ]);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course updated successfully.');
    }

    public function duplicate(Course $course)
    {
        $newCourse = Course::create([
            'name' => $course->name,
            'code' => $course->code,
            'description' => $course->description,
            'major' => $course->major,
            'year' => $course->year,
            'semester' => $course->semester,
        ]);

        foreach ($course->materials()->with('media')->get() as $material) {
            $newMaterial = Material::create([
                'title' => $material->title,
                'description' => $material->description,
                'course_id' => $newCourse->id,
                'type' => $material->type,
                'is_locked' => $material->is_locked,
                'watermark_type' => $material->watermark_type,
            ]);

            foreach ($material->media as $media) {
                $newFilePath = $this->duplicateMediaFile($media->file_path, $newMaterial->id, $media->type, $media->order);
                MaterialMedia::create([
                    'material_id' => $newMaterial->id,
                    'type' => $media->type,
                    'file_path' => $newFilePath ?? $media->file_path,
                    'original_filename' => $media->original_filename,
                    'mime_type' => $media->mime_type,
                    'file_size' => $media->file_size,
                    'order' => $media->order,
                    'is_locked' => $media->is_locked,
                ]);
            }
        }

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course duplicated successfully.');
    }

    private function duplicateMediaFile(string $filePath, int $materialId, string $type, int $order): ?string
    {
        if (!Storage::disk('local')->exists($filePath)) {
            return null;
        }
        $ext = pathinfo($filePath, PATHINFO_EXTENSION);
        $newFilename = sprintf('material_%d_%s_%d_%s.%s', $materialId, $type, $order, Str::random(8), $ext);
        $newPath = 'materials/media/' . $newFilename;
        Storage::disk('local')->copy($filePath, $newPath);
        return $newPath;
    }

    public function destroy(Course $course)
    {
        // Check if course has materials
        if ($course->materials()->count() > 0) {
            return redirect()->route('admin.courses.index')
                ->with('error', 'Cannot delete course with existing materials. Please delete or reassign materials first.');
        }

        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course deleted successfully.');
    }

    /**
     * Notify users about course changes
     */
    private function notifyUsers(string $type, string $title, string $message, array $data = [])
    {
        $users = User::where('role', 'user')->get();

        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'data' => $data,
                'read' => false,
            ]);
        }
    }
}

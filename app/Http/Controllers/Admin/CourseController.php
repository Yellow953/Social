<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
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
            'code' => 'required|string|max:50|unique:courses,code',
            'description' => 'nullable|string',
            'major' => ['nullable', 'string', Rule::in(array_merge([null, ''], config('majors')))],
            'year' => 'nullable|string|max:50',
        ]);

        if (($validated['major'] ?? '') === '') {
            $validated['major'] = null;
        }
        $course = Course::create($validated);

        // Notify all users about new course
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
            'code' => 'required|string|max:50|unique:courses,code,' . $course->id,
            'description' => 'nullable|string',
            'major' => ['nullable', 'string', Rule::in(array_merge([null, ''], config('majors')))],
            'year' => 'nullable|string|max:50',
        ]);

        if (($validated['major'] ?? '') === '') {
            $validated['major'] = null;
        }
        $course->update($validated);

        // Notify all users about course update
        $this->notifyUsers('course', 'Course Updated', "The course \"{$course->name}\" has been updated.", [
            'course_id' => $course->id,
            'course_name' => $course->name,
        ]);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course updated successfully.');
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

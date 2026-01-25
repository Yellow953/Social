<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::withCount('videoSessions')
            ->with(['videoSessions' => function($q) {
                $q->select('id', 'course_id', 'title');
            }]);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by course ID if provided
        if ($request->has('course') && $request->course) {
            $query->where('id', $request->course);
        }

        $courses = $query->orderBy('name')->paginate(12);

        return view('courses.index', compact('courses'));
    }
}

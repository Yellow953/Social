<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoSession;
use App\Models\Course;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = VideoSession::with('course')
            ->orderBy('course_id')
            ->orderBy('year')
            ->orderBy('order')
            ->paginate(20);

        return view('admin.sessions.index', compact('sessions'));
    }

    public function create()
    {
        $courses = Course::orderBy('name')->get();
        return view('admin.sessions.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'year' => 'required|integer|min:1|max:10',
            'video_url' => 'required|url',
            'duration' => 'nullable|integer|min:0',
            'is_locked' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['is_locked'] = $request->has('is_locked');

        VideoSession::create($validated);

        return redirect()->route('admin.sessions.index')
            ->with('success', 'Session created successfully.');
    }

    public function edit(VideoSession $session)
    {
        $courses = Course::orderBy('name')->get();
        return view('admin.sessions.edit', compact('session', 'courses'));
    }

    public function update(Request $request, VideoSession $session)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'year' => 'required|integer|min:1|max:10',
            'video_url' => 'required|url',
            'duration' => 'nullable|integer|min:0',
            'is_locked' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['is_locked'] = $request->has('is_locked');

        $session->update($validated);

        return redirect()->route('admin.sessions.index')
            ->with('success', 'Session updated successfully.');
    }

    public function destroy(VideoSession $session)
    {
        $session->delete();

        return redirect()->route('admin.sessions.index')
            ->with('success', 'Session deleted successfully.');
    }
}

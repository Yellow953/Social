<?php

namespace App\Http\Controllers;

use App\Models\VideoSession;
use App\Models\SessionAccessLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = VideoSession::with('course')
            ->orderBy('course_id')
            ->orderBy('year')
            ->orderBy('order');

        // Filter by course if provided
        if ($request->has('course') && $request->course) {
            $query->where('course_id', $request->course);
        }

        $sessions = $query->get();

        // Group sessions by course and year
        $groupedSessions = $sessions->groupBy(function ($session) {
            return $session->course->name . ' - Year ' . $session->year;
        });

        return view('sessions.index', compact('sessions', 'groupedSessions'));
    }

    public function show(VideoSession $session)
    {
        $user = Auth::user();

        // Check if user can access this session
        if (!$session->canBeAccessedBy($user)) {
            return redirect()->route('sessions')
                ->with('error', 'You need an active SOCIALPLUS subscription to access this session.');
        }

        // Log access
        SessionAccessLog::create([
            'user_id' => $user->id,
            'video_session_id' => $session->id,
            'accessed_at' => now(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // Eager load media with the session
        $session->load('media');

        return view('sessions.show', compact('session'));
    }

    public function updateWatchTime(Request $request, VideoSession $session)
    {
        $user = Auth::user();

        $request->validate([
            'duration_seconds' => 'required|integer|min:0',
        ]);

        // Update or create access log with watch time
        $log = SessionAccessLog::where('user_id', $user->id)
            ->where('video_session_id', $session->id)
            ->whereDate('accessed_at', today())
            ->first();

        if ($log) {
            $log->update([
                'duration_seconds' => max($log->duration_seconds, $request->duration_seconds),
            ]);
        } else {
            SessionAccessLog::create([
                'user_id' => $user->id,
                'video_session_id' => $session->id,
                'accessed_at' => now(),
                'duration_seconds' => $request->duration_seconds,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }

        return response()->json(['success' => true]);
    }
}

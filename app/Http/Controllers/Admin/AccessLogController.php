<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SessionAccessLog;
use Illuminate\Http\Request;

class AccessLogController extends Controller
{
    public function index(Request $request)
    {
        $query = SessionAccessLog::with(['user', 'videoSession.course']);

        // Filter by user if provided
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by session if provided
        if ($request->has('session_id') && $request->session_id) {
            $query->where('video_session_id', $request->session_id);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('accessed_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('accessed_at', '<=', $request->date_to);
        }

        $logs = $query->latest('accessed_at')->paginate(30);

        // Calculate total watch time
        $totalWatchTime = SessionAccessLog::sum('duration_seconds');

        return view('admin.access-logs.index', compact('logs', 'totalWatchTime'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaterialAccessLog;
use Illuminate\Http\Request;

class AccessLogController extends Controller
{
    public function index(Request $request)
    {
        $query = MaterialAccessLog::with(['user', 'material.course']);

        // Filter by user if provided
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by material if provided
        if ($request->has('material_id') && $request->material_id) {
            $query->where('material_id', $request->material_id);
        }
        if ($request->has('session_id') && $request->session_id) {
            $query->where('material_id', $request->session_id);
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
        $totalWatchTime = MaterialAccessLog::sum('duration_seconds');

        return view('admin.access-logs.index', compact('logs', 'totalWatchTime'));
    }
}

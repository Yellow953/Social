<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Material;
use App\Models\MaterialAccessLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard
     */
    public function index()
    {
        // Get statistics
        $totalUsers = User::where('role', 'user')->count();
        $totalCourses = Course::count();
        $totalSessions = Material::count();

        // Get user growth data for the last 30 days
        $userGrowth = User::where('role', 'user')
            ->where('created_at', '>=', now()->subDays(30))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Get recent activity (last 20 access logs)
        $recentActivity = MaterialAccessLog::with(['user', 'material.course'])
            ->orderBy('accessed_at', 'desc')
            ->limit(20)
            ->get();

        // Format user growth data for chart
        $growthData = [];
        $growthLabels = [];
        foreach ($userGrowth as $day) {
            $growthLabels[] = date('M d', strtotime($day->date));
            $growthData[] = $day->count;
        }

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalCourses' => $totalCourses,
            'totalSessions' => $totalSessions,
            'growthLabels' => $growthLabels,
            'growthData' => $growthData,
            'recentActivity' => $recentActivity,
        ]);
    }
}

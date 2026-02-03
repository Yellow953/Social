<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Material;
use App\Models\MaterialAccessLog;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', '30'); // Default to 30 days
        
        // Calculate date range based on period
        $days = match($period) {
            '7' => 7,
            '30' => 30,
            '365' => 365,
            default => 30
        };
        
        $startDate = now()->subDays($days);
        
        // Key Metrics
        $totalUsers = User::where('role', 'user')->count();
        $totalCourses = Course::count();
        $totalSessions = Material::count();
        
        // Materials completed (unique user-material combinations with watch time > 0)
        $sessionsCompleted = MaterialAccessLog::where('duration_seconds', '>', 0)
            ->select('user_id', 'material_id')
            ->distinct()
            ->count();
        
        // Total study time across all users
        $totalStudyTimeSeconds = MaterialAccessLog::sum('duration_seconds');
        $totalStudyTimeHours = floor($totalStudyTimeSeconds / 3600);
        
        // User Growth Chart Data
        $userGrowth = User::where('role', 'user')
            ->where('created_at', '>=', $startDate)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        
        // Fill in missing dates with 0
        $growthLabels = [];
        $growthData = [];
        $currentDate = $startDate->copy();
        $growthMap = $userGrowth->keyBy('date');
        
        while ($currentDate <= now()) {
            $dateKey = $currentDate->format('Y-m-d');
            $growthLabels[] = $currentDate->format('M d');
            $growthData[] = $growthMap->has($dateKey) ? $growthMap[$dateKey]->count : 0;
            $currentDate->addDay();
        }
        
        // User Distribution
        $activeUsers = User::where('role', 'user')
            ->whereHas('materialAccessLogs', function($query) use ($startDate) {
                $query->where('accessed_at', '>=', $startDate);
            })
            ->count();
        
        $newUsers = User::where('role', 'user')
            ->where('created_at', '>=', $startDate)
            ->count();
        
        $inactiveUsers = $totalUsers - $activeUsers;
        
        // Top Courses (by access count)
        $topCourses = Course::with(['materials' => function($query) use ($startDate) {
                $query->withCount(['accessLogs' => function($q) use ($startDate) {
                    $q->where('accessed_at', '>=', $startDate);
                }]);
            }])
            ->get()
            ->map(function($course) {
                $course->total_accesses = $course->materials->sum('access_logs_count');
                return $course;
            })
            ->sortByDesc('total_accesses')
            ->take(5)
            ->values();
        
        // Recent Activity
        $recentActivity = MaterialAccessLog::with(['user', 'material.course'])
            ->where('accessed_at', '>=', $startDate)
            ->orderBy('accessed_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function($log) {
                return [
                    'type' => 'session_access',
                    'icon' => 'play-circle',
                    'title' => 'Material Accessed',
                    'description' => $log->user->name . ' accessed ' . $log->material->title,
                    'course' => $log->material->course->name,
                    'time' => $log->accessed_at,
                    'timestamp' => $log->accessed_at->timestamp,
                ];
            });
        
        // Add user registrations to recent activity
        $recentUsers = User::where('role', 'user')
            ->where('created_at', '>=', $startDate)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function($user) {
                return [
                    'type' => 'user_registered',
                    'icon' => 'user-plus',
                    'title' => 'New User Registered',
                    'description' => $user->name . ' joined the platform',
                    'time' => $user->created_at,
                    'timestamp' => $user->created_at->timestamp,
                ];
            });
        
        // Merge and sort by timestamp, then format time
        $allActivity = $recentActivity->concat($recentUsers)
            ->sortByDesc('timestamp')
            ->take(10)
            ->values()
            ->map(function($item) {
                // Convert datetime to diffForHumans
                if (isset($item['time']) && is_object($item['time'])) {
                    $item['time'] = $item['time']->diffForHumans();
                }
                return $item;
            });
        
        return view('admin.analytics.index', [
            'totalUsers' => $totalUsers,
            'totalCourses' => $totalCourses,
            'sessionsCompleted' => $sessionsCompleted,
            'totalStudyTimeHours' => $totalStudyTimeHours,
            'growthLabels' => $growthLabels,
            'growthData' => $growthData,
            'activeUsers' => $activeUsers,
            'inactiveUsers' => $inactiveUsers,
            'newUsers' => $newUsers,
            'topCourses' => $topCourses,
            'recentActivity' => $allActivity,
            'period' => $period,
        ]);
    }
}

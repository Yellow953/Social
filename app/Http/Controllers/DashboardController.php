<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Material;
use App\Models\MaterialAccessLog;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the user dashboard
     */
    public function index()
    {
        $user = auth()->user();

        // Get unique courses the user has accessed
        $activeCourses = MaterialAccessLog::where('user_id', $user->id)
            ->join('materials', 'material_access_logs.material_id', '=', 'materials.id')
            ->distinct()
            ->count('materials.course_id');

        // Get unique materials completed (materials with watch time > 0)
        $sessionsCompleted = MaterialAccessLog::where('user_id', $user->id)
            ->where('duration_seconds', '>', 0)
            ->distinct()
            ->count('material_id');

        // Get total study time in seconds
        $totalStudyTimeSeconds = MaterialAccessLog::where('user_id', $user->id)
            ->sum('duration_seconds');

        // Format study time
        $hours = floor($totalStudyTimeSeconds / 3600);
        $minutes = floor(($totalStudyTimeSeconds % 3600) / 60);
        $studyTimeFormatted = $hours > 0 ? sprintf('%dh %dm', $hours, $minutes) : sprintf('%dm', $minutes);

        // Calculate progress (materials completed / total available materials)
        $totalSessions = Material::where(function($query) use ($user) {
            $query->where('is_locked', false);
            if ($user->hasActiveSubscription() || $user->isAdmin()) {
                $query->orWhere('is_locked', true);
            }
        })->count();

        $progress = $totalSessions > 0
            ? round(($sessionsCompleted / $totalSessions) * 100)
            : 0;

        // Get recent activity (last 10 access logs)
        $recentActivity = MaterialAccessLog::where('user_id', $user->id)
            ->with(['material.course'])
            ->orderBy('accessed_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function($log) {
                return [
                    'type' => 'session',
                    'icon' => 'check',
                    'title' => 'Completed Material',
                    'description' => $log->material ? $log->material->title : 'Unknown Material',
                    'course' => $log->material && $log->material->course ? $log->material->course->name : null,
                    'time' => $log->accessed_at->diffForHumans(),
                    'accessed_at' => $log->accessed_at,
                ];
            });

        // Get recent courses (courses the user has accessed)
        $recentCourses = Course::whereHas('materials', function($query) use ($user) {
            $query->whereHas('accessLogs', function($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        })
        ->with(['materials' => function($query) {
            $query->orderBy('created_at', 'desc')->limit(1);
        }])
        ->orderBy('created_at', 'desc')
        ->limit(6)
        ->get();

        // Get recent notifications (user-specific or global)
        $recentNotifications = Notification::where(function($query) use ($user) {
            $query->whereNull('user_id') // Global notifications
                ->orWhere('user_id', $user->id); // User-specific notifications
        })
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get()
        ->map(function($notification) {
            return [
                'type' => $notification->type,
                'icon' => $this->getNotificationIcon($notification->type),
                'title' => $notification->title,
                'message' => $notification->message,
                'time' => $notification->created_at->diffForHumans(),
                'read' => $notification->read,
            ];
        });

        return view('dashboard', [
            'activeCourses' => $activeCourses,
            'sessionsCompleted' => $sessionsCompleted,
            'studyTimeFormatted' => $studyTimeFormatted,
            'studyTimeHours' => $hours,
            'progress' => $progress,
            'recentActivity' => $recentActivity,
            'recentCourses' => $recentCourses,
            'recentNotifications' => $recentNotifications,
        ]);
    }

    /**
     * Get icon for notification type
     */
    private function getNotificationIcon($type): string
    {
        return match($type) {
            'success' => 'check-circle',
            'warning' => 'exclamation-triangle',
            'course' => 'book',
            'session' => 'play-circle',
            'announcement' => 'bullhorn',
            default => 'bell',
        };
    }
}

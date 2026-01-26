<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc');
        
        // Filter by type if provided
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }
        
        // Filter by read status
        if ($request->has('filter')) {
            if ($request->filter === 'unread') {
                $query->where('read', false);
            } elseif ($request->filter === 'read') {
                $query->where('read', true);
            }
        }
        
        $notifications = $query->paginate(20);
        
        return view('notifications.index', compact('notifications'));
    }
    
    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }
        
        $notification->markAsRead();
        
        return back()->with('success', 'Notification marked as read.');
    }
    
    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('read', false)
            ->update([
                'read' => true,
                'read_at' => now()
            ]);
        
        return back()->with('success', 'All notifications marked as read.');
    }
    
    public function destroy(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }
        
        $notification->delete();
        
        return back()->with('success', 'Notification deleted.');
    }
}

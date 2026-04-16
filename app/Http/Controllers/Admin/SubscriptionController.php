<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Notification;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');
        $search = trim($request->input('search', ''));
        $allowedStatuses = ['pending', 'approved', 'rejected'];

        $query = Subscription::with(['user', 'approver'])
            ->latest();

        if ($status && in_array($status, $allowedStatuses)) {
            $query->where('status', $status);
        }

        if ($search !== '') {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $subscriptions = $query->paginate(20)->withQueryString();

        $stats = [
            'pending'  => Subscription::where('status', 'pending')->count(),
            'approved' => Subscription::where('status', 'approved')->count(),
            'rejected' => Subscription::where('status', 'rejected')->count(),
        ];

        return view('admin.subscriptions.index', compact('subscriptions', 'stats', 'status', 'search'));
    }

    public function approve(Subscription $subscription)
    {
        $subscription->update([
            'status'      => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
            'expires_at'  => now()->addYear(),
        ]);

        Notification::create([
            'user_id' => $subscription->user_id,
            'type'    => 'subscription',
            'title'   => 'Subscription Approved',
            'message' => "Your {$subscription->subscription_type} subscription has been approved! You now have access to all locked materials.",
            'data'    => [
                'subscription_id'   => $subscription->id,
                'subscription_type' => $subscription->subscription_type,
            ],
            'read' => false,
        ]);

        return redirect()->back()->with('success', 'Subscription approved successfully (valid for 1 year).');
    }

    public function reject(Request $request, Subscription $subscription)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $subscription->update([
            'status'           => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'approved_by'      => auth()->id(),
        ]);

        Notification::create([
            'user_id' => $subscription->user_id,
            'type'    => 'subscription',
            'title'   => 'Subscription Rejected',
            'message' => "Your {$subscription->subscription_type} subscription request has been rejected. Reason: {$request->rejection_reason}",
            'data'    => [
                'subscription_id'   => $subscription->id,
                'subscription_type' => $subscription->subscription_type,
                'rejection_reason'  => $request->rejection_reason,
            ],
            'read' => false,
        ]);

        return redirect()->back()->with('success', 'Subscription rejected.');
    }

    public function cancel(Subscription $subscription)
    {
        $subscription->update([
            'expires_at' => now(),
        ]);

        Notification::create([
            'user_id' => $subscription->user_id,
            'type'    => 'subscription',
            'title'   => 'Subscription Cancelled',
            'message' => "Your {$subscription->subscription_type} subscription has been cancelled by an admin.",
            'data'    => [
                'subscription_id'   => $subscription->id,
                'subscription_type' => $subscription->subscription_type,
            ],
            'read' => false,
        ]);

        return redirect()->back()->with('success', 'Subscription cancelled.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::with(['user', 'approver'])
            ->latest()
            ->paginate(20);

        $stats = [
            'pending' => Subscription::where('status', 'pending')->count(),
            'approved' => Subscription::where('status', 'approved')->count(),
            'rejected' => Subscription::where('status', 'rejected')->count(),
        ];

        return view('admin.subscriptions.index', compact('subscriptions', 'stats'));
    }

    public function approve(Subscription $subscription)
    {
        $subscription->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Subscription approved successfully.');
    }

    public function reject(Request $request, Subscription $subscription)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $subscription->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'approved_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Subscription rejected.');
    }
}

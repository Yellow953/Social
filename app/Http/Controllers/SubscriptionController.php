<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $subscriptions = $user->subscriptions()->latest()->get();
        $activeSubscription = $user->activeSubscription();

        return view('subscriptions.index', compact('subscriptions', 'activeSubscription'));
    }

    public function create()
    {
        $user = Auth::user();

        // Check if user already has a pending subscription
        $pendingSubscription = $user->subscriptions()
            ->where('status', 'pending')
            ->first();

        if ($pendingSubscription) {
            return redirect()->route('subscriptions.index')
                ->with('info', 'You already have a pending subscription request. Please wait for admin approval.');
        }

        return view('subscriptions.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Check if user already has a pending subscription
        $pendingSubscription = $user->subscriptions()
            ->where('status', 'pending')
            ->first();

        if ($pendingSubscription) {
            return redirect()->route('subscriptions.index')
                ->with('error', 'You already have a pending subscription request.');
        }

        $subscription = Subscription::create([
            'user_id' => $user->id,
            'status' => 'pending',
            'subscription_type' => 'SOCIALPLUS',
        ]);

        return redirect()->route('subscriptions.index')
            ->with('success', 'Subscription request submitted successfully. Please wait for admin approval.');
    }
}

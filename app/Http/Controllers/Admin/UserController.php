<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('subscriptions')->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,admin',
            'study_year' => 'nullable|string|in:Sup,Spé,1e,2e,3e',
            'major' => 'nullable|string|max:255',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:user,admin',
            'study_year' => 'nullable|string|in:Sup,Spé,1e,2e,3e',
            'major' => 'nullable|string|max:255',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function createQuickSubscription(User $user)
    {
        // Check if user already has an active subscription
        $activeSubscription = $user->activeSubscription();
        
        if ($activeSubscription) {
            return response()->json([
                'success' => false,
                'message' => 'User already has an active subscription.'
            ], 400);
        }

        // Create and approve subscription for 1 year
        $subscription = Subscription::create([
            'user_id' => $user->id,
            'status' => 'approved',
            'subscription_type' => 'SOCIALPLUS',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
            'expires_at' => now()->addYear(), // 1 year from now
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Subscription created successfully for 1 year.',
            'subscription' => $subscription
        ]);
    }
}

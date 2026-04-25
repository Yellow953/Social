<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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
            'major' => ['nullable', 'string', Rule::in(array_merge([null, ''], config('majors')))],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        if (($validated['major'] ?? '') === '') {
            $validated['major'] = null;
        }

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        if ($user->isAdminLevel() && !auth()->user()->isSuperAdmin()) {
            abort(403, 'Only a super admin can edit admin users.');
        }

        $courses = Course::orderBy('name')->get();

        return view('admin.users.edit', compact('user', 'courses'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->isAdminLevel() && !auth()->user()->isSuperAdmin()) {
            abort(403, 'Only a super admin can edit admin users.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:user,admin',
            'study_year' => 'nullable|string|in:Sup,Spé,1e,2e,3e',
            'major' => ['nullable', 'string', Rule::in(array_merge([null, ''], config('majors')))],
            'is_active' => 'boolean',
            'extra_course_ids' => 'nullable|array',
            'extra_course_ids.*' => 'exists:courses,id',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if (($validated['major'] ?? '') === '') {
            $validated['major'] = null;
        }
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        if ($user->isSuperAdmin()) {
            unset($validated['role']);
        }

        unset($validated['extra_course_ids']);
        $user->update($validated);
        $user->extraCourses()->sync($request->input('extra_course_ids', []));

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        if ($user->isAdminLevel() && !auth()->user()->isSuperAdmin()) {
            abort(403, 'Only a super admin can delete admin users.');
        }

        $user->materialAccessLogs()->delete();
        $user->subscriptions()->delete();
        $user->otps()->delete();
        $user->notifications()->delete();
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function toggleActive(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $user->is_active,
            'message' => $user->is_active ? 'Account enabled.' : 'Account disabled.',
        ]);
    }

    public function disableAllUsers()
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403);
        }

        User::where('role', 'user')->update(['is_active' => false]);

        return redirect()->route('admin.users.index')
            ->with('success', 'All student accounts have been disabled.');
    }

    public function forceVerify(User $user)
    {
        if ($user->hasVerifiedEmail()) {
            return response()->json(['success' => false, 'message' => 'Email is already verified.'], 400);
        }

        $user->markEmailAsVerified();

        return response()->json(['success' => true, 'message' => 'Email verified successfully.']);
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

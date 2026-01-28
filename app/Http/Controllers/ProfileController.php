<?php

namespace App\Http\Controllers;

use App\Models\SessionAccessLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $coursesCount = SessionAccessLog::where('user_id', $user->id)
            ->join('video_sessions', 'session_access_logs.video_session_id', '=', 'video_sessions.id')
            ->distinct()
            ->count('video_sessions.course_id');

        $sessionsCount = SessionAccessLog::where('user_id', $user->id)
            ->where('duration_seconds', '>', 0)
            ->distinct()
            ->count('video_session_id');

        return view('profile.index', [
            'coursesCount' => $coursesCount,
            'sessionsCount' => $sessionsCount,
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($request->only(['name', 'email', 'phone']));

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->route('profile')->with('success', 'Password updated successfully!');
    }

    public function updateTwoFactor(Request $request)
    {
        $request->validate([
            'enabled' => 'required|boolean',
        ]);

        auth()->user()->update([
            'two_factor_enabled' => (bool) $request->enabled,
        ]);

        return redirect()->route('profile')->with('success', $request->enabled
            ? 'Two-factor authentication has been enabled.'
            : 'Two-factor authentication has been disabled.');
    }
}

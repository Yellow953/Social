<?php

namespace App\Http\Controllers;

use App\Models\MaterialAccessLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $coursesCount = MaterialAccessLog::where('user_id', $user->id)
            ->join('materials', 'material_access_logs.material_id', '=', 'materials.id')
            ->distinct()
            ->count('materials.course_id');

        $sessionsCount = MaterialAccessLog::where('user_id', $user->id)
            ->where('duration_seconds', '>', 0)
            ->distinct()
            ->count('material_id');

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

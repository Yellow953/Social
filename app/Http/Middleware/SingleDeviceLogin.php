<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SingleDeviceLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user) {
            $currentDeviceIdentifier = User::generateDeviceIdentifier($request);

            // Check if this is a different device
            if (!empty($user->device_identifier) && !$user->isDeviceAllowed($currentDeviceIdentifier)) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->with('error', 'You cannot be logged in from multiple devices at the same time. Please log out from other devices first.');
            }

            // Update device info on each request (to track last activity)
            if ($user->device_identifier !== $currentDeviceIdentifier) {
                $user->updateDeviceInfo($currentDeviceIdentifier);
            }
        }

        return $next($request);
    }
}

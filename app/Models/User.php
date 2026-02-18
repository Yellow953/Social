<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'study_year',
        'major',
        'device_token',
        'device_identifier',
        'last_device_login_at',
        'email_verified',
        'email_verified_at',
        'two_factor_enabled',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_device_login_at' => 'datetime',
        ];
    }

    /**
     * Check if user is an admin (admin or super_admin; both can access admin panel).
     */
    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'super_admin'], true);
    }

    /**
     * Check if user is a super admin (can manage other admins).
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Check if this user is an admin-level account (admin or super_admin).
     * Used to restrict regular admins from editing/deleting each other.
     */
    public function isAdminLevel(): bool
    {
        return in_array($this->role, ['admin', 'super_admin'], true);
    }

    /**
     * Get the user's subscriptions
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get the user's active subscription
     */
    public function activeSubscription()
    {
        return $this->subscriptions()
            ->where('status', 'approved')
            ->where(function($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->latest()
            ->first();
    }

    /**
     * Check if user has active subscription
     */
    public function hasActiveSubscription(): bool
    {
        return $this->activeSubscription() !== null;
    }

    /**
     * Get the user's material access logs
     */
    public function materialAccessLogs()
    {
        return $this->hasMany(MaterialAccessLog::class);
    }

    /**
     * Generate device identifier from request
     */
    public static function generateDeviceIdentifier($request): string
    {
        $userAgent = $request->userAgent() ?? '';
        $ip = $request->ip() ?? '';
        return md5($userAgent . $ip);
    }

    /**
     * Check if device matches current device
     */
    public function isDeviceAllowed($deviceIdentifier): bool
    {
        if (empty($this->device_identifier)) {
            return true; // First login, allow it
        }
        return $this->device_identifier === $deviceIdentifier;
    }

    /**
     * Update device information
     */
    public function updateDeviceInfo($deviceIdentifier, $deviceToken = null): void
    {
        $this->device_identifier = $deviceIdentifier;
        if ($deviceToken) {
            $this->device_token = $deviceToken;
        }
        $this->last_device_login_at = now();
        $this->save();
    }

    /**
     * Get the user's OTPs
     */
    public function otps()
    {
        return $this->hasMany(Otp::class);
    }

    /**
     * Check if user has verified email (MustVerifyEmail contract).
     */
    public function hasVerifiedEmail(): bool
    {
        return $this->email_verified && $this->email_verified_at !== null;
    }

    /**
     * Mark email as verified (MustVerifyEmail contract).
     */
    public function markEmailAsVerified(): void
    {
        $this->email_verified = true;
        $this->email_verified_at = now();
        $this->save();
    }

    /**
     * Send the email verification notification (MustVerifyEmail contract).
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new \Illuminate\Auth\Notifications\VerifyEmail);
    }

    /**
     * Get the user's notifications
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Get unread notifications count
     */
    public function unreadNotificationsCount(): int
    {
        return $this->notifications()->unread()->count();
    }
}

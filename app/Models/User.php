<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
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
     * Check if user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
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
     * Get the user's session access logs
     */
    public function sessionAccessLogs()
    {
        return $this->hasMany(SessionAccessLog::class);
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
     * Check if user has verified email
     */
    public function hasVerifiedEmail(): bool
    {
        return $this->email_verified && $this->email_verified_at !== null;
    }

    /**
     * Mark email as verified
     */
    public function markEmailAsVerified(): void
    {
        $this->email_verified = true;
        $this->email_verified_at = now();
        $this->save();
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

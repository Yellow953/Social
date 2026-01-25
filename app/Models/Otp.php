<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Otp extends Model
{
    protected $fillable = [
        'email',
        'code',
        'type',
        'user_id',
        'expires_at',
        'used',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used' => 'boolean',
    ];

    /**
     * Get the user that owns the OTP
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if OTP is valid and not expired
     */
    public function isValid(): bool
    {
        return !$this->used && $this->expires_at->isFuture();
    }

    /**
     * Mark OTP as used
     */
    public function markAsUsed(): void
    {
        $this->update(['used' => true]);
    }

    /**
     * Generate a random 6-digit OTP code
     */
    public static function generateCode(): string
    {
        return str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Create a new OTP for registration
     */
    public static function createForRegistration(string $email): self
    {
        // Delete any existing registration OTPs for this email
        self::where('email', $email)
            ->where('type', 'registration')
            ->where('used', false)
            ->delete();

        return self::create([
            'email' => $email,
            'code' => self::generateCode(),
            'type' => 'registration',
            'expires_at' => now()->addMinutes(10),
        ]);
    }

    /**
     * Create a new OTP for two-factor authentication
     */
    public static function createForTwoFactor(User $user): self
    {
        // Delete any existing 2FA OTPs for this user
        self::where('user_id', $user->id)
            ->where('type', 'two_factor')
            ->where('used', false)
            ->delete();

        return self::create([
            'email' => $user->email,
            'code' => self::generateCode(),
            'type' => 'two_factor',
            'user_id' => $user->id,
            'expires_at' => now()->addMinutes(5),
        ]);
    }

    /**
     * Verify OTP code
     */
    public static function verify(string $email, string $code, string $type): ?self
    {
        $otp = self::where('email', $email)
            ->where('code', $code)
            ->where('type', $type)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->first();

        if ($otp && $otp->isValid()) {
            return $otp;
        }

        return null;
    }
}

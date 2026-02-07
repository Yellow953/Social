<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'course_id',
        'type', // 'cours', 'tp', 'video_recording'
        'is_locked',
        'watermark_type', // 'none', 'full', 'logo_only', 'username_only'
    ];

    protected $casts = [
        'is_locked' => 'boolean',
    ];

    /**
     * Get the course that owns this material
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the access logs for this material
     */
    public function accessLogs(): HasMany
    {
        return $this->hasMany(MaterialAccessLog::class);
    }

    /**
     * Get the media files for this material
     */
    public function media(): HasMany
    {
        return $this->hasMany(MaterialMedia::class)->orderBy('order');
    }

    /**
     * Check if user can access this material
     */
    public function canBeAccessedBy($user): bool
    {
        if (!$this->is_locked) {
            return true;
        }

        if (!$user || $user->isAdmin()) {
            return true;
        }

        return $user->hasActiveSubscription();
    }
}

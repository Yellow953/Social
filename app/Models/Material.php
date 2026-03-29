<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type', // 'cours', 'tp', 'video_recording'
        'is_locked',
        'watermark_type', // 'none', 'full', 'logo_only', 'username_only'
    ];

    protected $casts = [
        'is_locked' => 'boolean',
    ];

    /**
     * Get the courses this material belongs to
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class);
    }

    /**
     * Convenience accessor — returns the first attached course.
     * Keeps backward-compatible access to $material->course->name in views.
     */
    public function getCourseAttribute(): ?Course
    {
        return $this->courses->first();
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

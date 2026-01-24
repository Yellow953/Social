<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VideoSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'course_id',
        'year',
        'video_url',
        'duration',
        'is_locked',
        'order',
    ];

    protected $casts = [
        'is_locked' => 'boolean',
        'year' => 'integer',
        'duration' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Get the course that owns this session
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the access logs for this session
     */
    public function accessLogs(): HasMany
    {
        return $this->hasMany(SessionAccessLog::class);
    }

    /**
     * Check if user can access this session
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

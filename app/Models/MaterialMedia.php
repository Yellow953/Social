<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialMedia extends Model
{
    use HasFactory;

    protected $table = 'material_media';

    protected $fillable = [
        'material_id',
        'type',
        'file_path',
        'original_filename',
        'mime_type',
        'file_size',
        'order',
        'is_locked',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'order' => 'integer',
        'is_locked' => 'boolean',
    ];

    /**
     * Get the material that owns this media
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * Check if user can access this media (material must be accessible; if media is locked, subscription required).
     */
    public function canBeAccessedBy($user): bool
    {
        $material = $this->material;
        if (!$material || !$material->canBeAccessedBy($user)) {
            return false;
        }
        if (!$this->is_locked) {
            return true;
        }
        if (!$user || $user->isAdmin()) {
            return true;
        }
        return $user->hasActiveSubscription();
    }

    /**
     * Get human readable file size
     */
    public function getFormattedFileSizeAttribute(): string
    {
        if (!$this->file_size) {
            return 'Unknown';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->file_size;
        $unit = 0;

        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }

        return round($size, 2) . ' ' . $units[$unit];
    }
}

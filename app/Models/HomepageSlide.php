<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageSlide extends Model
{
    protected $fillable = [
        'image_path',
        'title',
        'description',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Get the full URL for the slide image (for frontend).
     */
    public function getImageUrlAttribute(): string
    {
        return \Illuminate\Support\Facades\Storage::disk('public')->url($this->image_path);
    }
}

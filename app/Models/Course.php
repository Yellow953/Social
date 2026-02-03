<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'major',
        'year',
    ];

    /**
     * Get the materials for this course
     */
    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }
}

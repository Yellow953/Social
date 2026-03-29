<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'combinations',
    ];

    protected $casts = [
        'combinations' => 'array',
    ];

    // ---------- Backward-compat derived accessors ----------

    /** All unique years across all combinations */
    public function getYearsAttribute(): array
    {
        return collect($this->combinations ?? [])
            ->pluck('year')->unique()->values()->all();
    }

    /** All unique concrete majors across all combinations (excludes '*') */
    public function getMajorsAttribute(): array
    {
        return collect($this->combinations ?? [])
            ->flatMap(fn($c) => $c['majors'] ?? [])
            ->filter(fn($m) => $m !== '*')
            ->unique()->values()->all();
    }

    /** All unique semesters across all combinations */
    public function getSemestersAttribute(): array
    {
        return collect($this->combinations ?? [])
            ->pluck('semester')->unique()->values()->all();
    }

    /** First year (backward compat for singular usage) */
    public function getYearAttribute(): ?string
    {
        return $this->getYearsAttribute()[0] ?? null;
    }

    /** First major (backward compat for singular usage) */
    public function getMajorAttribute(): ?string
    {
        return $this->getMajorsAttribute()[0] ?? null;
    }

    /** First semester (backward compat for singular usage) */
    public function getSemesterAttribute(): ?string
    {
        return $this->getSemestersAttribute()[0] ?? null;
    }

    // ---------- Filtering helper ----------

    /**
     * Whether this course applies to a student with the given year, major, and semester.
     * A combination with majors: ["*"] matches any major.
     */
    public function matchesFilter(string $year, string $major, string $semester): bool
    {
        foreach ($this->combinations ?? [] as $combo) {
            if (($combo['year'] ?? '') !== $year) continue;
            if (($combo['semester'] ?? '') !== $semester) continue;
            $majors = $combo['majors'] ?? [];
            if (\in_array('*', $majors) || \in_array($major, $majors)) {
                return true;
            }
        }
        return false;
    }

    // ---------- Relations ----------

    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class);
    }
}

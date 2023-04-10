<?php

namespace App\Models;

use App\Models\School;
use App\Models\Scopes\AcademicYearScope;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicYear extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_STARTED = "started";

    const STATUS_REGISTRATION   = "registration";

    const STATUS_CLOSED   = "closed";

    protected $guarded = [];

    protected $casts = [
        'year_start' => 'date',
        'year_end'   => 'date',
    ];


    protected static function booted()
    {
        static::addGlobalScope(new AcademicYearScope);
    }


    public function scopeActive(Builder $query): void
    {
        $query->where('status_years', AcademicYear::STATUS_STARTED)->latest();
    }

    public function scopePPDB(Builder $query): void
    {
        $query->where('status_years', AcademicYear::STATUS_PPDB_YEAR)->latest();
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function tutitions(): HasMany
    {
        return $this->hasMany(Tuition::class);
    }

    public function classrooms(): HasMany
    {
        return $this->hasMany(Classroom::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}

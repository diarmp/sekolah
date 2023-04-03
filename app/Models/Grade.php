<?php

namespace App\Models;

use App\Models\School;
use App\Models\Classroom;
use App\Models\Scopes\GradeScope;
use App\Models\StudentTuition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Session;

class Grade extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = 'grades';

    protected static function booted()
    {
        static::addGlobalScope(new GradeScope);
    }

    public function tuitions(): HasMany
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

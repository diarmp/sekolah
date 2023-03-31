<?php

namespace App\Models;

use App\Models\Grade;
use App\Models\School;
use App\Models\TuitionType;
use App\Models\AcademicYear;
use App\Models\Scopes\TuitionScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tuition extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    
    protected static function booted()
    {
        static::addGlobalScope(new TuitionScope);
    }

    public function tuition_type(): BelongsTo
    {
        return $this->belongsTo(TuitionType::class);
    }

    public function academic_year(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}

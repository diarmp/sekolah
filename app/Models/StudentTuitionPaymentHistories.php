<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentTuitionPaymentHistories extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function student_tuitions(): BelongsToMany
    {
        return $this->belongsToMany(StudentTuition::class);
    }
}

<?php

namespace Database\Factories;

use App\Models\AcademicYear;
use App\Models\Grade;
use App\Models\School;
use App\Models\TuitionType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tuition>
 */
class TuitionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $school = School::factory()->create();

        return [
            'school_id' => $school->getKey(),
            'tuition_type_id' => TuitionType::factory()->create(['school_id' => $school->getKey()]),
            'academic_year_id' => AcademicYear::factory()->create(['school_id' => $school->getKey()]),
            'grade_id' => Grade::factory()->create(['school_id' => $school->getKey()]),
            'period' => now(),
            'price' => 100000
        ];
    }
}

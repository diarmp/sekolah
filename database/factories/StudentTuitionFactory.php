<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class StudentTuitionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'school_id' => 1,
            'student_id' => fake()->numberBetween(1, 100),
            'tuition_type_id' => fake()->numberBetween(1, 10),
            'price' => fake()->numberBetween(100000, 500000),
            'price' => fake()->numberBetween(50000, 500000),
            'note' => fake()->word(),
        ];
    }
}

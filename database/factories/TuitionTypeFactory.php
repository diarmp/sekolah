<?php

namespace Database\Factories;

use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TuitionType>
 */
class TuitionTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'school_id' => School::latest()->first(),
            'name' => fake()->name(),
            'generatable' => false,
            'penalty_price' => fake()->numberBetween(100000, 500000),
            'penalty_dates' => '14, 28'
        ];
    }
}

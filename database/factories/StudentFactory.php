<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create('id_ID');
        $gender = $faker->randomElement(['L', 'P']);

        return [
            'school_id' => session('school_id') ?? 2,
            'academic_year_id' => $faker->numberBetween(1, 10),
            'name' => $faker->name($gender),
            'email' => $faker->safeEmail(),
            'gender' => $gender,
            'address' => $faker->address(),
            'dob' => $faker->dateTimeBetween('-20 years', '-18 years'),
            'religion' => 'katolik',
            'phone_number' => $faker->randomNumber(9, true),
            'no_kartu_keluarga' => $faker->randomNumber(9, true),
            'nik' => $faker->randomNumber(9, true),
            'nisn' => $faker->randomNumber(9, true),
            'nis' => $faker->randomNumber(9, true),

            'father_name' => $faker->name('male'),
            'father_work' => $faker->jobTitle(),
            'father_address' => $faker->address(),
            'father_phone_number' => $faker->randomNumber(9, true),

            'mother_name' => $faker->name('female'),
            'mother_work' => $faker->jobTitle(),
            'mother_address' => $faker->address(),
            'mother_phone_number' => $faker->randomNumber(9, true),

            'guardian_name' => $faker->name(),
            'guardian_work' => $faker->jobTitle(),
            'guardian_address' => $faker->address(),
            'guardian_phone_number' => $faker->randomNumber(9, true),
        ];

    }
}

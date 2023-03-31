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
            'school_id' => session('school_id') ?? 1,
            'academic_year_id' => $faker->numberBetween(1, 10),
            'name' => $faker->name($gender),
            'email' => $faker->safeEmail(),
            'gender' => $gender,
            'address' => $faker->address(),
            'dob' => $faker->dateTimeBetween('-20 years', '-18 years'),
            'religion' => 'katolik',
            'phone_number' => $faker->randomNumber(9, true),
            'nik' => $faker->randomNumber(9, true),
            'nisn' => $faker->randomNumber(9, true),
            'nis' => $faker->randomNumber(9, true),
            'father_name' => $faker->name('male'),
            'father_dob' => $faker->dateTimeBetween('-40 years', '-30 years'),
            'father_work' => $faker->jobTitle(),
            'father_education' => "SMA",
            'father_income' => $faker->randomNumber(7, false),
            'mother_name' => $faker->name('female'),
            'mother_dob' => $faker->dateTimeBetween('-40 years', '-30 years'),
            'mother_work' => $faker->jobTitle(),
            'mother_education' => "SMA",
            'mother_income' => $faker->randomNumber(7, false),
            'guardian_name' => $faker->name('female'),
            'guardian_dob' => $faker->dateTimeBetween('-40 years', '-30 years'),
            'guardian_work' => $faker->jobTitle(),
            'guardian_education' => "S1",
            'guardian_income' => $faker->randomNumber(7, false),
        ];

    }
}

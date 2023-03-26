<?php

namespace Database\Seeders;

use App\Models\StudentTuition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentTuitionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StudentTuition::factory()
                ->count(100)
                ->create();
    }
}

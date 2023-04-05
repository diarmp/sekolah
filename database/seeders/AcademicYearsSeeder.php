<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicYearsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AcademicYear::factory()
            ->count(10)
            ->create();


        AcademicYear::factory()->create([
            'status_years' => AcademicYear::STATUS_ACTIVE_YEAR
        ]);
    }
}

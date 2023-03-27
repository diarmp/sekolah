<?php

namespace Database\Seeders;

use App\Models\TuitionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TuitionTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TuitionType::factory()
                ->count(10)
                ->create();
    }
}

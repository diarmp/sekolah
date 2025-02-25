<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Permissions\GradeSeeder;
use Database\Seeders\Permissions\SchoolSeeder;
use Database\Seeders\Permissions\StudentSeeder;
use Database\Seeders\Permissions\TuitionSeeder;
use Database\Seeders\Permissions\ClassroomSeeder;
use Database\Seeders\Permissions\TransactionSeeder;
use Database\Seeders\Permissions\TuitionTypeSeeder;
use Database\Seeders\Permissions\AcademicYearSeeder;
use Database\Seeders\Permissions\MasterConfigSeeder;
use Database\Seeders\Permissions\SchoolConfigSeeder;
use Database\Seeders\Permissions\SchoolSelectorSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\Permissions\AssignClassroomStudentSeeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /***
        // role users documentation
        $super_admin = Role::whereName(User::ROLE_SUPER_ADMIN)->first();
        $ops_admin = Role::whereName(User::ROLE_OPS_ADMIN)->first();
        $admin_sekolah = Role::whereName(User::ROLE_ADMIN_SEKOLAH)->first();
        $admin_yayasan = Role::whereName(User::ROLE_ADMIN_YAYASAN)->first();
        $tata_usaha = Role::whereName(User::ROLE_TATA_USAHA)->first();
        $bendahara = Role::whereName(User::ROLE_BENDAHARA)->first();
        $kepala_sekolah = Role::whereName(User::ROLE_KEPALA_SEKOLAH)->first();
         */

        $this->call([
            SchoolSeeder::class,
            StudentSeeder::class,
            GradeSeeder::class,
            TuitionTypeSeeder::class,
            AcademicYearSeeder::class,
            ClassroomSeeder::class,
            SchoolSelectorSeeder::class,
            MasterConfigSeeder::class,
            SchoolConfigSeeder::class,
            TransactionSeeder::class,
            AssignClassroomStudentSeeder::class,
            TuitionSeeder::class,
        ]);
    }
}

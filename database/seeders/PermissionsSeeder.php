<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\Permissions\GradeSeeder;
use Database\Seeders\Permissions\SchoolSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // role users documentation
        // $super_admin = Role::whereName(User::ROLE_SUPER_ADMIN)->first();
        // $ops_admin = Role::whereName(User::ROLE_OPS_ADMIN)->first();
        // $admin_sekolah = Role::whereName(User::ROLE_ADMIN_SEKOLAH)->first();
        // $admin_yayasan = Role::whereName(User::ROLE_ADMIN_YAYASAN)->first();
        // $tata_usaha = Role::whereName(User::ROLE_TATA_USAHA)->first();
        // $bendahara = Role::whereName(User::ROLE_BENDAHARA)->first();
        // $kepala_sekolah = Role::whereName(User::ROLE_KEPALA_SEKOLAH)->first();

        $this->call([
            SchoolSeeder::class,
            GradeSeeder::class,
        ]);
    }
}

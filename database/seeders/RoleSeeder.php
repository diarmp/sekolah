<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            User::ROLE_SUPER_ADMIN,
            User::ROLE_OPS_ADMIN,
            User::ROLE_ADMIN_SEKOLAH,
            User::ROLE_ADMIN_YAYASAN,
            User::ROLE_TATA_USAHA,
            User::ROLE_BENDAHARA,
            User::ROLE_KEPALA_SEKOLAH,
        ];

        foreach($roles as $role) {
            Role::updateOrCreate([
                'name' => $role,
            ]);
        }
    }
}

<?php

namespace Database\Seeders\Permissions;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // role users
        $super_admin = Role::whereName(User::ROLE_SUPER_ADMIN)->first();
        $ops_admin = Role::whereName(User::ROLE_OPS_ADMIN)->first();

        // schools
        $roles = [
            'create' => 'schools.create',
            'read' => 'schools.index',
            'update' => 'schools.edit',
            'delete' => 'schools.destroy'
        ];

        // create school
        $permission = Permission::firstOrCreate([
            'name' => $roles['create'],
            'guard_name' => 'web'
        ]);
        $permission->syncRoles([$super_admin]);

        // read school
        $permission = Permission::firstOrCreate([
            'name' => $roles['read'],
            'guard_name' => 'web'
        ]);
        $permission->syncRoles([$super_admin, $ops_admin]);

        // update school
        $permission = Permission::firstOrCreate([
            'name' => $roles['update'],
            'guard_name' => 'web'
        ]);
        $permission->syncRoles([$super_admin, $ops_admin]);
        
        // delete school
        $permission = Permission::firstOrCreate([
            'name' => $roles['delete'],
            'guard_name' => 'web'
        ]);
        $permission->syncRoles([$super_admin, $ops_admin]);
    }
}

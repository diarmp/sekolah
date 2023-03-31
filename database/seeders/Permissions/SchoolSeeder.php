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
            'index' => 'schools.index',
            'create' => 'schools.create',
            'store' => 'schools.store',
            'edit' => 'schools.edit',
            'update' => 'schools.update',
            'destroy' => 'schools.destroy'
        ];

        // index
        $permission = Permission::firstOrCreate([
            'name' => $roles['index'],
            'guard_name' => 'web'
        ]);
        $permission->syncRoles([$super_admin, $ops_admin]);

        // create
        $permission = Permission::firstOrCreate([
            'name' => $roles['create'],
            'guard_name' => 'web'
        ]);
        $permission->syncRoles([$super_admin]);
        $permission = Permission::firstOrCreate([
            'name' => $roles['store'],
            'guard_name' => 'web'
        ]);
        $permission->syncRoles([$super_admin]);

        // update
        $permission = Permission::firstOrCreate([
            'name' => $roles['edit'],
            'guard_name' => 'web'
        ]);
        $permission->syncRoles([$super_admin, $ops_admin]);
        $permission = Permission::firstOrCreate([
            'name' => $roles['update'],
            'guard_name' => 'web'
        ]);
        $permission->syncRoles([$super_admin, $ops_admin]);

        // destroy
        $permission = Permission::firstOrCreate([
            'name' => $roles['destroy'],
            'guard_name' => 'web'
        ]);
        $permission->syncRoles([$super_admin]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin
        $user = User::updateOrCreate(
            [
                'email' => 'admin@sempoa.id',
            ],
            [
                'name' => 'Sempoa',
                'password' => bcrypt('password'),
                'email_verified_at' => now()
            ]
        );
        $user->assignRole(User::ROLE_SUPER_ADMIN);

        // local env
        if (app()->environment('local')) {
            // Ops Admin
            $user = User::updateOrCreate(
                [
                    'email' => 'ops@sempoa.id',
                ],
                [
                    'name' => 'Ops Sempoa',
                    'password' => bcrypt('password'),
                    'email_verified_at' => now()
                ]
            );
            $user->assignRole(User::ROLE_OPS_ADMIN);

            // Yayasan
            $yayasan = School::updateOrCreate([
                'name' => 'Yayasan Karmel Malang',
                'type' => School::TYPE_YAYASAN,
            ]);
            $role = User::ROLE_ADMIN_YAYASAN;
            $user = User::updateOrCreate(
                [
                    'email' => str($role)->slug() . '@sekolah.com',
                ],
                [
                    'name' => str($role)->title(),
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                    'school_id' => $yayasan->getKey()
                ]
            );
            $user->assignRole($role);
            $staff = Staff::updateOrCreate(
                [
                    'school_id' => $yayasan->getKey(),
                    'user_id' => $user->getKey(),
                ],
                [
                    'name' => $user->name
                ]
            );
            $yayasan->staff_id = $staff->getKey();
            $yayasan->save();

            // Sekolah
            $sekolah = School::updateOrCreate([
                'name' => 'Sekolah SD Karmel',
                'type' => School::TYPE_SEKOLAH,
                'school_id' => $yayasan->getKey(),
            ]);
            $roles = [
                User::ROLE_ADMIN_SEKOLAH,
                User::ROLE_TATA_USAHA,
                User::ROLE_BENDAHARA,
                User::ROLE_KEPALA_SEKOLAH,
            ];

            foreach($roles as $key => $role) {
                $user = User::updateOrCreate(
                    [
                        'email' => str($role)->slug() . '@sekolah.com',
                    ],
                    [
                        'name' => str($role)->title(),
                        'password' => bcrypt('password'),
                        'email_verified_at' => now(),
                        'school_id' => $sekolah->getKey()
                    ]
                );
                $user->assignRole($role);
                $staff = Staff::updateOrCreate(
                    [
                        'school_id' => $sekolah->getKey(),
                        'user_id' => $user->getKey(),
                    ],
                    [
                        'name' => $user->name
                    ]
                );
                if ($key == 0) {
                    $sekolah->staff_id = $staff->getKey();
                    $sekolah->save();
                }
            }
        }
    }
}

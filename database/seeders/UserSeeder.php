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
        $role = User::ROLE_SUPER_ADMIN;
        $user = User::updateOrCreate(
            [
                'email' => 'admin@sempoa.id',
            ],
            [
                'name' => str($role)->title(),
                'password' => bcrypt('password'),
                'email_verified_at' => now()
            ]
        );
        $user->assignRole($role);

        // local env
        if (true) {
            // Ops Admin
            $role = User::ROLE_OPS_ADMIN;
            $user = User::updateOrCreate(
                [
                    'email' => 'ops@sempoa.id',
                ],
                [
                    'name' => str($role)->title(),
                    'password' => bcrypt('password'),
                    'email_verified_at' => now()
                ]
            );
            $user->assignRole($role);

            // Yayasan
            $yayasan = School::updateOrCreate([
                'school_name' => 'Yayasan Karmel Malang'
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
            // $staff = Staff::updateOrCreate(
            //     [
            //         'school_id' => $yayasan->getKey(),
            //         'user_id' => $user->getKey(),
            //     ],
            //     [
            //         'name' => $user->name
            //     ]
            // );
            // $yayasan->staff_id = $staff->getKey();
            // $yayasan->save();

            // Sekolah
            $sekolah = School::updateOrCreate([
                'school_name' => 'Sekolah SD Karmel',
                'school_id' => $yayasan->getKey(),
            ]);
            $roles = [
                User::ROLE_ADMIN_SEKOLAH,
                User::ROLE_TATA_USAHA,
                User::ROLE_BENDAHARA,
                User::ROLE_KEPALA_SEKOLAH,
            ];

            foreach ($roles as $key => $role) {
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
                // $staff = Staff::updateOrCreate(
                //     [
                //         'school_id' => $sekolah->getKey(),
                //         'user_id' => $user->getKey(),
                //     ],
                //     [
                //         'name' => $user->name
                //     ]
                // );
                // if ($key == 0) {
                //     $sekolah->staff_id = $staff->getKey();
                //     $sekolah->save();
                // }
            }
        }
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;

beforeEach(function () {
    $this->superAdmin = User::role(User::ROLE_SUPER_ADMIN)->first();
    $this->opsAdmin = User::role(User::ROLE_OPS_ADMIN)->first();
    $this->adminYayasan = User::role(User::ROLE_ADMIN_YAYASAN)->first();
    $this->adminSekolah = User::role(User::ROLE_ADMIN_SEKOLAH)->first();
    $this->bendahara = User::role(User::ROLE_BENDAHARA)->first();
    $this->tataUsaha = User::role(User::ROLE_TATA_USAHA)->first();
    $this->kepalaSekolah = User::role(User::ROLE_KEPALA_SEKOLAH)->first();
    $this->murid = User::role(User::ROLE_MURID)->first();
    $this->alumni = User::role(User::ROLE_ALUMNI)->first();
    $this->setupFaker();
});

// Check Page Response
    it('forbid guest to view Student page', function () {
        $this
            ->get(route('students.index'))
            ->assertNotFound();
    });

    // It Will Throw Error because doesn't have school_id
        // it('can render Student index page as Sempoa Staff', function (User $user) {
        //     $response = $this
        //         ->actingAs($user)
        //         ->get(route('students.index'));

        //     $response->assertOk();
        // })->with('sempoa_staff');

    it('can render Student index page as School Staff', function (User $user) {
        $response = $this
            ->actingAs($user)
            ->get(route('students.index'));

        $response->assertOk();
    })->with('school_staff');

    // It Will Throw Error because doesn't have school_id
        // it('can render Student create page as Sempoa Staff', function (User $user) {
        //     $response = $this
        //         ->actingAs($user)
        //         ->get(route('students.create'));

        //     $response->assertOk();
        // })->with('sempoa_staff');

    it('can render Student create page', function (User $user) {
        $response = $this
            ->actingAs($user)
            ->get(route('students.create'));

        $response->assertOk();
    })->with([
        User::ROLE_TATA_USAHA => [fn () => $this->tataUsaha],
        User::ROLE_BENDAHARA => [fn () => $this->bendahara]
    ]);

    it('can not render Student create page', function (User $user) {
        $response = $this
            ->actingAs($user)
            ->get(route('students.create'));

        $response->assertNotFound();
    })->with([
        User::ROLE_ADMIN_YAYASAN => [fn () => $this->adminYayasan],
        User::ROLE_ADMIN_SEKOLAH => [fn () => $this->adminSekolah],
        User::ROLE_KEPALA_SEKOLAH => [fn () => $this->kepalaSekolah],
    ]);

// End Check Page Response
    

            // it('numeric validation on create student', function () {
            //     $this->actingAs($this->tataUsaha)
            //         ->post(route('students.store'), [
            //             'school_id' => 2,
            //             'academic_year_id' => $this->faker->numberBetween(1, 10),
            //             'name' => $this->faker->name(),
            //             'gender' => $this->faker->randomElement(['L', 'P']),
            //             'address' => $this->faker->address(),
            //             'dob' => '2023-03-27 22:29:17',
            //             'religion' => 'Kristen',
            //             'phone_number' => $this->faker->randomNumber(9, true),
            //             'nik' => $this->faker->randomNumber(9, true),
            //             'nisn' => $this->faker->randomNumber(9, true),
            //             'nis' => $this->faker->randomNumber(9, true),
            //             'father_name' => $this->faker->name('male'),
            //             'father_dob' => '2023-03-27 22:29:17',
            //             'father_work' => $this->faker->jobTitle(),
            //             'father_education' => "SMA",
            //             'father_income' => $this->faker->randomNumber(7, false),
            //             'mother_name' => $this->faker->name('female'),
            //             'mother_dob' => '2023-03-27 22:29:17',
            //             'mother_work' => $this->faker->jobTitle(),
            //             'mother_education' => "SMA",
            //             'mother_income' => $this->faker->randomNumber(7, false),
            //             'guardian_name' => $this->faker->name('female'),
            //             'guardian_dob' => '2023-03-27 22:29:17',
            //             'guardian_work' => $this->faker->jobTitle(),
            //             'guardian_education' => "S1",
            //             'guardian_income' => $this->faker->randomNumber(7, false),
            //         ])->assertInvalid(['name' => 'required']);
            // });

    
// Check Store Data
    it('require validation on create student', function () {
        $this->actingAs($this->superAdmin)
            ->post(route('students.store'), [
                'school_id' => 2,
                'academic_year_id' => '',
                'name' => '',
                'gender' => '',
                'address' => '',
                'dob' => '',
                'religion' => '',
                'phone_number' => $this->faker->randomNumber(9, true),
                'nik' => '',
                'nisn' => $this->faker->randomNumber(9, true),
                'nis' => $this->faker->randomNumber(9, true),
                'father_name' => '',
                'father_dob' => '',
                'father_work' => $this->faker->jobTitle(),
                'father_education' => "SMA",
                'father_income' => $this->faker->randomNumber(7, false),
                'mother_name' => '',
                'mother_dob' => '',
                'mother_work' => $this->faker->jobTitle(),
                'mother_education' => "SMA",
                'mother_income' => $this->faker->randomNumber(7, false),
                'guardian_name' => $this->faker->name('female'),
                'guardian_dob' => '2023-03-27 22:29:17',
                'guardian_work' => $this->faker->jobTitle(),
                'guardian_education' => "S1",
                'guardian_income' => $this->faker->randomNumber(7, false),
            ])->assertInvalid([
                'academic_year_id', 
                'name', 
                'gender', 
                'address', 
                'dob', 
                'religion', 
                'nik', 
                'father_name', 
                'father_dob', 
                'mother_name',
                'mother_dob'
            ]);
    });

    it('length validation on create student', function () {
        $this->actingAs($this->superAdmin)
            ->post(route('students.store'), [
                'school_id' => 2,
                'academic_year_id' => 1,
                'name' => $this->faker->name(),
                'gender' => 'Love Live',
                'address' => $this->faker->address(),
                'dob' => '2023-03-27 22:29:17',
                'religion' => 'Kristen',
                'phone_number' => 103945751937593345234,
                'nik' => 10394575193759334523442345645345645634545756757,
                'nisn' => 10394575193759334523442345645345645634545756757,
                'nis' => 10394575193759334523442345645345645634545756757,
                'father_name' => $this->faker->name('male'),
                'father_dob' => '2023-03-27 22:29:17',
                'father_work' => $this->faker->jobTitle(),
                'father_education' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem voluptatibus nisi et nemo deleniti dolorum corporis animi dolorem autem reiciendis suscipit, beatae adipisci deserunt cum magnam culpa perspiciatis facere accusamus.", 
                'father_income' => 10394575193759334523442345645345645634545756757103945751937593345234423456453456456345457567571039457519375933452344234564534564563454575675710394575193759334523442345645345645634545756757,
                'mother_name' => $this->faker->name('female'),
                'mother_dob' => '2023-03-27 22:29:17',
                'mother_work' => $this->faker->jobTitle(),
                'mother_education' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem voluptatibus nisi et nemo deleniti dolorum corporis animi dolorem autem reiciendis suscipit, beatae adipisci deserunt cum magnam culpa perspiciatis facere accusamus.",
                'mother_income' => 10394575193759334523442345645345645634545756757103945751937593345234423456453456456345457567571039457519375933452344234564534564563454575675710394575193759334523442345645345645634545756757,
                'guardian_name' => $this->faker->name('female'),
                'guardian_dob' => '2023-03-27 22:29:17',
                'guardian_work' => $this->faker->jobTitle(),
                'guardian_education' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem voluptatibus nisi et nemo deleniti dolorum corporis animi dolorem autem reiciendis suscipit, beatae adipisci deserunt cum magnam culpa perspiciatis facere accusamus.",
                'guardian_income' => 10394575193759334523442345645345645634545756757103945751937593345234423456453456456345457567571039457519375933452344234564534564563454575675710394575193759334523442345645345645634545756757,
            ])->assertInvalid(['gender', 'phone_number', 'nik', 'nis', 'nisn', 'father_education', 'father_income', 'mother_income', 'mother_education', 'guardian_income', 'guardian_education']);
    });

    it('numeric validation on create student', function () {
        $this->actingAs($this->tataUsaha)
            ->post(route('students.store'), [
                'school_id' => 2,
                'academic_year_id' => $this->faker->numberBetween(1, 10),
                'name' => $this->faker->name(),
                'gender' => $this->faker->randomElement(['L', 'P']),
                'address' => $this->faker->address(),
                'dob' => '2023-03-27 22:29:17',
                'religion' => 'Kristen',
                'phone_number' => $this->faker->randomNumber(9, true),
                'nik' => "string  desu!",
                'nisn' => "string  desu!",
                'nis' => "string  desu!",
                'father_name' => $this->faker->name('male'),
                'father_dob' => '2023-03-27 22:29:17',
                'father_work' => $this->faker->jobTitle(),
                'father_education' => "SMA",
                'father_income' => "string  desu!",
                'mother_name' => $this->faker->name('female'),
                'mother_dob' => '2023-03-27 22:29:17',
                'mother_work' => $this->faker->jobTitle(),
                'mother_education' => "SMA",
                'mother_income' => "string  desu!",
                'guardian_name' => $this->faker->name('female'),
                'guardian_dob' => '2023-03-27 22:29:17',
                'guardian_work' => $this->faker->jobTitle(),
                'guardian_education' => "S1",
                'guardian_income' => "string  desu!",
            ])->assertInvalid(['nik', 'nis', 'nisn', 'father_income', 'mother_income', 'guardian_income']);
    });

    it('array validation on create student', function () {
        $this->actingAs($this->tataUsaha)
            ->post(route('students.store'), [
                'school_id' => 2,
                'academic_year_id' => $this->faker->numberBetween(1, 10),
                'name' => $this->faker->name(),
                'gender' => $this->faker->randomElement(['L', 'P']),
                'address' => $this->faker->address(),
                'dob' => '2023-03-27 22:29:17',
                'religion' => 'Kristen',
                'phone_number' => $this->faker->randomNumber(9, true),
                'nik' => $this->faker->randomNumber(9, true),
                'nisn' => $this->faker->randomNumber(9, true),
                'nis' => $this->faker->randomNumber(9, true),
                'father_name' => $this->faker->name('male'),
                'father_dob' => '2023-03-27 22:29:17',
                'father_work' => $this->faker->jobTitle(),
                'father_education' => "SMA",
                'father_income' => $this->faker->randomNumber(7, false),
                'mother_name' => $this->faker->name('female'),
                'mother_dob' => '2023-03-27 22:29:17',
                'mother_work' => $this->faker->jobTitle(),
                'mother_education' => "SMA",
                'mother_income' => $this->faker->randomNumber(7, false),
                'guardian_name' => $this->faker->name('female'),
                'guardian_dob' => '2023-03-27 22:29:17',
                'guardian_work' => $this->faker->jobTitle(),
                'guardian_education' => "S1",
                'guardian_income' => $this->faker->randomNumber(7, false),
                'tuitions' => 'String Desu!'
            ])->assertInvalid(['tuitions']);
    });

    it('array items validation on create student', function () {
        $this->actingAs($this->tataUsaha)
            ->post(route('students.store'), [
                'school_id' => 2,
                'academic_year_id' => $this->faker->numberBetween(1, 10),
                'name' => $this->faker->name(),
                'gender' => $this->faker->randomElement(['L', 'P']),
                'address' => $this->faker->address(),
                'dob' => '2023-03-27 22:29:17',
                'religion' => 'Kristen',
                'phone_number' => $this->faker->randomNumber(9, true),
                'nik' => $this->faker->randomNumber(9, true),
                'nisn' => $this->faker->randomNumber(9, true),
                'nis' => $this->faker->randomNumber(9, true),
                'father_name' => $this->faker->name('male'),
                'father_dob' => '2023-03-27 22:29:17',
                'father_work' => $this->faker->jobTitle(),
                'father_education' => "SMA",
                'father_income' => $this->faker->randomNumber(7, false),
                'mother_name' => $this->faker->name('female'),
                'mother_dob' => '2023-03-27 22:29:17',
                'mother_work' => $this->faker->jobTitle(),
                'mother_education' => "SMA",
                'mother_income' => $this->faker->randomNumber(7, false),
                'guardian_name' => $this->faker->name('female'),
                'guardian_dob' => '2023-03-27 22:29:17',
                'guardian_work' => $this->faker->jobTitle(),
                'guardian_education' => "S1",
                'guardian_income' => $this->faker->randomNumber(7, false),
                'tuitions' => ['1' => 'Stering Desu~', '2' => 'mata Stering Desu~']
            ])->assertInvalid(['tuitions.1', 'tuitions.2']);
    });

    // it('can create new Yayasan', function () {
    //     $name = $this->faker()->company();
    //     $this->actingAs($this->superAdmin)
    //         ->post(route('schools.store'), [
    //             'school_id' => '',
    //             'name' => $name,
    //             'pic_name' => "PIC $name",
    //             'pic_email' => str($name)->slug() . "@gmail.com"
    //         ])
    //         ->assertRedirect(route('schools.index'));

    //     $this->assertDatabaseHas('schools', [
    //         'name' => $name
    //     ]);

    //     $user = User::firstWhere([
    //         'email' => str($name)->slug() . "@gmail.com"
    //     ]);
    //     expect($user->hasRole(User::ROLE_ADMIN_YAYASAN))->toBeTrue();
    // });

    // it('can create new School', function () {
    //     $yayasan = School::factory()->create();
    //     $name = $this->faker()->company();
    //     $this->actingAs($this->superAdmin)
    //         ->post(route('schools.store'), [
    //             'school_id' => $yayasan->getKey(),
    //             'name' => $name,
    //             'pic_name' => "PIC $name",
    //             'pic_email' => str($name)->slug() . "@gmail.com"
    //         ])
    //         ->assertRedirect(route('schools.index'));

    //     $this->assertDatabaseHas('schools', [
    //         'name' => $name
    //     ]);

    //     $user = User::firstWhere([
    //         'email' => str($name)->slug() . "@gmail.com"
    //     ]);
    //     expect($user->hasRole(User::ROLE_ADMIN_SEKOLAH))->toBeTrue();
    // });
// End Check Store Data


// it('can render School edit page as Sempoa Staff', function (User $user) {
//     $school = School::factory()->create();
//     $_user = User::factory()->create([
//         'school_id' => $school->getKey()
//     ]);
//     $_staff = Staff::factory()->create([
//         'school_id' => $school->getKey(),
//         'user_id' => $_user->getKey()
//     ]);
//     $school->staff_id = $_staff->getKey();
//     $school->save();

//     $response = $this
//         ->actingAs($user)
//         ->get(route('schools.edit', $school->getKey()));

//     $response->assertOk();
// })->with('sempoa_staff');

// it('can not render School edit page as School Staff', function (User $user) {
//     $school = School::factory()->create();
//     $_user = User::factory()->create([
//         'school_id' => $school->getKey()
//     ]);
//     $_staff = Staff::factory()->create([
//         'school_id' => $school->getKey(),
//         'user_id' => $_user->getKey()
//     ]);
//     $school->staff_id = $_staff->getKey();
//     $school->save();

//     $response = $this
//         ->actingAs($user)
//         ->get(route('schools.edit', $school->getKey()));

//     $response->assertNotFound();
// })->with('school_staff');

// it('can edit school', function (User $user) {
//     $school = School::factory()->create();
//     $_user = User::factory()->create([
//         'school_id' => $school->getKey()
//     ]);
//     $_staff = Staff::factory()->create([
//         'school_id' => $school->getKey(),
//         'user_id' => $_user->getKey()
//     ]);
//     $school->staff_id = $_staff->getKey();
//     $school->save();

//     $name = "Yayasan Edited";

//     $this->actingAs($user)
//         ->put(route('schools.update', $school->getKey()), [
//             'name' => $name
//         ])->assertRedirect(route('schools.index'));

//     $this->assertDatabaseHas('schools', [
//         'name' => $name
//     ]);
// })->with('sempoa_staff');

// it('can delete School as Super Admin', function () {
//     $school = School::factory()->create();

//     $this->actingAs($this->superAdmin)
//         ->delete(route('schools.destroy', $school->getKey()))
//         ->assertOk();

//     $this->assertSoftDeleted($school);
// });

// it('can not delete School as Ops Admin', function () {
//     $school = School::factory()->create();

//     $response = $this->actingAs($this->opsAdmin)
//         ->delete(route('schools.destroy', $school->getKey()));

//     $response->assertNotFound();
// });

// it('can not delete School as School staff', function (User $user) {
//     $school = School::factory()->create();

//     $response = $this->actingAs($user)
//         ->delete(route('schools.destroy', $school->getKey()));

//     $response->assertNotFound();
// })->with('school_staff');

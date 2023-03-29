<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\TuitionType;
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
    it('can render Student index page as Sempoa Staff', function (User $user) {
        $response = $this
            ->actingAs($user)
            ->get(route('students.index'));

        $response->assertOk();
    })->with('sempoa_staff');

    it('can render Student index page as School Staff', function (User $user) {
        $response = $this
            ->actingAs($user)
            ->get(route('students.index'));

        $response->assertOk();
    })->with('school_staff');

    // It Will Throw Error because doesn't have school_id
    it('can render Student create page as Sempoa Staff', function (User $user) {
        $response = $this
            ->actingAs($user)
            ->get(route('students.create'));

        $response->assertOk();
    })->with('sempoa_staff');

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

    it('can render Student edit page', function (User $user) {
        $student = Student::factory()->create();
        $response = $this
            ->actingAs($user)
            ->get(route('students.edit', $student->getKey()));

        $response->assertOk();
    })->with([
        User::ROLE_TATA_USAHA => [fn () => $this->tataUsaha],
        User::ROLE_BENDAHARA => [fn () => $this->bendahara]
    ]);

    it('can not render Student edit page', function (User $user) {
        $student = Student::factory()->create();
        $response = $this
            ->actingAs($user)
            ->get(route('students.edit', $student->getKey()));

        $response->assertNotFound();
    })->with([
        User::ROLE_ADMIN_YAYASAN => [fn () => $this->adminYayasan],
        User::ROLE_ADMIN_SEKOLAH => [fn () => $this->adminSekolah],
        User::ROLE_KEPALA_SEKOLAH => [fn () => $this->kepalaSekolah],
    ]);

// End Check Page Response
    
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
                'guardian_dob' => $this->faker->date(),
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
                'dob' => $this->faker->date(),
                'religion' => 'katolik',
                'phone_number' => 103945751937593345234,
                'nik' => 10394575193759334523442345645345645634545756757,
                'nisn' => 10394575193759334523442345645345645634545756757,
                'nis' => 10394575193759334523442345645345645634545756757,
                'father_name' => $this->faker->name('male'),
                'father_dob' => $this->faker->date(),
                'father_work' => $this->faker->jobTitle(),
                'father_education' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem voluptatibus nisi et nemo deleniti dolorum corporis animi dolorem autem reiciendis suscipit, beatae adipisci deserunt cum magnam culpa perspiciatis facere accusamus.", 
                'father_income' => 10394575193759334523442345645345645634545756757103945751937593345234423456453456456345457567571039457519375933452344234564534564563454575675710394575193759334523442345645345645634545756757,
                'mother_name' => $this->faker->name('female'),
                'mother_dob' => $this->faker->date(),
                'mother_work' => $this->faker->jobTitle(),
                'mother_education' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem voluptatibus nisi et nemo deleniti dolorum corporis animi dolorem autem reiciendis suscipit, beatae adipisci deserunt cum magnam culpa perspiciatis facere accusamus.",
                'mother_income' => 10394575193759334523442345645345645634545756757103945751937593345234423456453456456345457567571039457519375933452344234564534564563454575675710394575193759334523442345645345645634545756757,
                'guardian_name' => $this->faker->name('female'),
                'guardian_dob' => $this->faker->date(),
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
                'dob' => $this->faker->date(),
                'religion' => 'katolik',
                'phone_number' => $this->faker->randomNumber(9, true),
                'nik' => "string  desu!",
                'nisn' => "string  desu!",
                'nis' => "string  desu!",
                'father_name' => $this->faker->name('male'),
                'father_dob' => $this->faker->date(),
                'father_work' => $this->faker->jobTitle(),
                'father_education' => "SMA",
                'father_income' => "string  desu!",
                'mother_name' => $this->faker->name('female'),
                'mother_dob' => $this->faker->date(),
                'mother_work' => $this->faker->jobTitle(),
                'mother_education' => "SMA",
                'mother_income' => "string  desu!",
                'guardian_name' => $this->faker->name('female'),
                'guardian_dob' => $this->faker->date(),
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
                'dob' => $this->faker->date(),
                'religion' => 'katolik',
                'phone_number' => $this->faker->randomNumber(9, true),
                'nik' => $this->faker->randomNumber(9, true),
                'nisn' => $this->faker->randomNumber(9, true),
                'nis' => $this->faker->randomNumber(9, true),
                'father_name' => $this->faker->name('male'),
                'father_dob' => $this->faker->date(),
                'father_work' => $this->faker->jobTitle(),
                'father_education' => "SMA",
                'father_income' => $this->faker->randomNumber(7, false),
                'mother_name' => $this->faker->name('female'),
                'mother_dob' => $this->faker->date(),
                'mother_work' => $this->faker->jobTitle(),
                'mother_education' => "SMA",
                'mother_income' => $this->faker->randomNumber(7, false),
                'guardian_name' => $this->faker->name('female'),
                'guardian_dob' => $this->faker->date(),
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
                'dob' => $this->faker->date(),
                'religion' => 'katolik',
                'phone_number' => $this->faker->randomNumber(9, true),
                'nik' => $this->faker->randomNumber(9, true),
                'nisn' => $this->faker->randomNumber(9, true),
                'nis' => $this->faker->randomNumber(9, true),
                'father_name' => $this->faker->name('male'),
                'father_dob' => $this->faker->date(),
                'father_work' => $this->faker->jobTitle(),
                'father_education' => "SMA",
                'father_income' => $this->faker->randomNumber(7, false),
                'mother_name' => $this->faker->name('female'),
                'mother_dob' => $this->faker->date(),
                'mother_work' => $this->faker->jobTitle(),
                'mother_education' => "SMA",
                'mother_income' => $this->faker->randomNumber(7, false),
                'guardian_name' => $this->faker->name('female'),
                'guardian_dob' => $this->faker->date(),
                'guardian_work' => $this->faker->jobTitle(),
                'guardian_education' => "S1",
                'guardian_income' => $this->faker->randomNumber(7, false),
                'tuitions' => ['1' => 'Stering Desu~', '2' => 'mata Stering Desu~']
            ])->assertInvalid(['tuitions.1', 'tuitions.2']);
    });

    it('can create new Student', function (User $user) {
        $school_id = 2;
        $academic_year_id = $this->faker->numberBetween(1, 10);
        $name = $this->faker->name();
        $gender = $this->faker->randomElement(['L', 'P']);
        $address = $this->faker->address();
        $dob = $this->faker->date();
        $religion = 'katolik';
        $phone_number = $this->faker->randomNumber(9, true);
        $nik = $this->faker->randomNumber(9, true);
        $nisn = $this->faker->randomNumber(9, true);
        $nis = $this->faker->randomNumber(9, true);
        $father_name = $this->faker->name('male');
        $father_dob = $this->faker->date();
        $father_work = $this->faker->jobTitle();
        $father_education = "SMA";
        $father_income = $this->faker->randomNumber(7, false);
        $mother_name = $this->faker->name('female');
        $mother_dob = $this->faker->date();
        $mother_work = $this->faker->jobTitle();
        $mother_education = "SMA";
        $mother_income = $this->faker->randomNumber(7, false);
        $guardian_name = $this->faker->name('female');
        $guardian_dob = $this->faker->date();
        $guardian_work = $this->faker->jobTitle();
        $guardian_education = "S1";
        $guardian_income = $this->faker->randomNumber(7, false);

        $this->actingAs($user)
            ->post(route('students.store'), [
                'school_id' => $school_id,
                'academic_year_id' => $academic_year_id,
                'name' => $name,
                'gender' => $gender,
                'address' => $address,
                'dob' => $dob,
                'religion' => $religion,
                'phone_number' => $phone_number,
                'nik' => $nik,
                'nisn' => $nisn,
                'nis' => $nis,
                'father_name' => $father_name,
                'father_dob' => $father_dob,
                'father_work' => $father_work,
                'father_education' => $father_education,
                'father_income' => $father_income,
                'mother_name' => $mother_name,
                'mother_dob' => $mother_dob,
                'mother_work' => $mother_work,
                'mother_education' => $mother_education,
                'mother_income' => $mother_income,
                'guardian_name' => $guardian_name,
                'guardian_dob' => $guardian_dob,
                'guardian_work' => $guardian_work,
                'guardian_education' => $guardian_education,
                'guardian_income' => $guardian_income,
            ])
            ->assertRedirect(route('students.index'));

        $this->assertDatabaseHas('students', [
            'name' => $name,
            'gender' => $gender,
            'address' => $address,
            'dob' => $dob,
            'religion' => $religion,
            'phone_number' => $phone_number,
            'nik' => $nik,
            'nisn' => $nisn,
            'nis' => $nis,
            'father_name' => $father_name,
            'father_dob' => $father_dob,
            'father_work' => $father_work,
            'father_education' => $father_education,
            'father_income' => $father_income,
            'mother_name' => $mother_name,
            'mother_dob' => $mother_dob,
            'mother_work' => $mother_work,
            'mother_education' => $mother_education,
            'mother_income' => $mother_income,
            'guardian_name' => $guardian_name,
            'guardian_dob' => $guardian_dob,
            'guardian_work' => $guardian_work,
            'guardian_education' => $guardian_education,
            'guardian_income' => $guardian_income,
        ]);
    })->with([
        User::ROLE_TATA_USAHA => [fn () => $this->tataUsaha],
        User::ROLE_BENDAHARA => [fn () => $this->bendahara],
        User::ROLE_SUPER_ADMIN => [fn () => $this->superAdmin],
        User::ROLE_OPS_ADMIN => [fn () => $this->opsAdmin],
    ]);

    it('can create new Student With Tuitions', function (User $user) {
        $tuitionType1 = TuitionType::factory()->create();
        $tuitionType2 = TuitionType::factory()->create();

        $school_id = 2;
        $academic_year_id = $this->faker->numberBetween(1, 10);
        $name = $this->faker->name();
        $gender = $this->faker->randomElement(['L', 'P']);
        $address = $this->faker->address();
        $dob = $this->faker->date();
        $religion = 'katolik';
        $phone_number = $this->faker->randomNumber(9, true);
        $nik = $this->faker->randomNumber(9, true);
        $nisn = $this->faker->randomNumber(9, true);
        $nis = $this->faker->randomNumber(9, true);
        $father_name = $this->faker->name('male');
        $father_dob = $this->faker->date();
        $father_work = $this->faker->jobTitle();
        $father_education = "SMA";
        $father_income = $this->faker->randomNumber(7, false);
        $mother_name = $this->faker->name('female');
        $mother_dob = $this->faker->date();
        $mother_work = $this->faker->jobTitle();
        $mother_education = "SMA";
        $mother_income = $this->faker->randomNumber(7, false);
        $guardian_name = $this->faker->name('female');
        $guardian_dob = $this->faker->date();
        $guardian_work = $this->faker->jobTitle();
        $guardian_education = "S1";
        $guardian_income = $this->faker->randomNumber(7, false);

        $this->actingAs($user)
            ->post(route('students.store'), [
                'school_id' => $school_id,
                'academic_year_id' => $academic_year_id,
                'name' => $name,
                'gender' => $gender,
                'address' => $address,
                'dob' => $dob,
                'religion' => $religion,
                'phone_number' => $phone_number,
                'nik' => $nik,
                'nisn' => $nisn,
                'nis' => $nis,
                'father_name' => $father_name,
                'father_dob' => $father_dob,
                'father_work' => $father_work,
                'father_education' => $father_education,
                'father_income' => $father_income,
                'mother_name' => $mother_name,
                'mother_dob' => $mother_dob,
                'mother_work' => $mother_work,
                'mother_education' => $mother_education,
                'mother_income' => $mother_income,
                'guardian_name' => $guardian_name,
                'guardian_dob' => $guardian_dob,
                'guardian_work' => $guardian_work,
                'guardian_education' => $guardian_education,
                'guardian_income' => $guardian_income,
                'tuitions' => [
                    $tuitionType1->getKey() => 23456789,
                    $tuitionType2->getKey() => 23456789
                ],
            ])->assertRedirect(route('students.index'));

        $this->assertDatabaseHas('student_tuitions', [
            'tuition_type_id' => $tuitionType1->getKey(),
            'tuition_type_id' => $tuitionType2->getKey(),
        ]);
    })->with([
        User::ROLE_TATA_USAHA => [fn () => $this->tataUsaha],
        User::ROLE_BENDAHARA => [fn () => $this->bendahara],
        User::ROLE_SUPER_ADMIN => [fn () => $this->superAdmin],
        User::ROLE_OPS_ADMIN => [fn () => $this->opsAdmin],
    ]);

    it('forbid create new Student', function (User $user) {
        $school_id = 2;
        $academic_year_id = $this->faker->numberBetween(1, 10);
        $name = $this->faker->name();
        $gender = $this->faker->randomElement(['L', 'P']);
        $address = $this->faker->address();
        $dob = $this->faker->date();
        $religion = 'katolik';
        $phone_number = $this->faker->randomNumber(9, true);
        $nik = $this->faker->randomNumber(9, true);
        $nisn = $this->faker->randomNumber(9, true);
        $nis = $this->faker->randomNumber(9, true);
        $father_name = $this->faker->name('male');
        $father_dob = $this->faker->date();
        $father_work = $this->faker->jobTitle();
        $father_education = "SMA";
        $father_income = $this->faker->randomNumber(7, false);
        $mother_name = $this->faker->name('female');
        $mother_dob = $this->faker->date();
        $mother_work = $this->faker->jobTitle();
        $mother_education = "SMA";
        $mother_income = $this->faker->randomNumber(7, false);
        $guardian_name = $this->faker->name('female');
        $guardian_dob = $this->faker->date();
        $guardian_work = $this->faker->jobTitle();
        $guardian_education = "S1";
        $guardian_income = $this->faker->randomNumber(7, false);

        $this->actingAs($user)
            ->post(route('students.store'), [
                'school_id' => $school_id,
                'academic_year_id' => $academic_year_id,
                'name' => $name,
                'gender' => $gender,
                'address' => $address,
                'dob' => $dob,
                'religion' => $religion,
                'phone_number' => $phone_number,
                'nik' => $nik,
                'nisn' => $nisn,
                'nis' => $nis,
                'father_name' => $father_name,
                'father_dob' => $father_dob,
                'father_work' => $father_work,
                'father_education' => $father_education,
                'father_income' => $father_income,
                'mother_name' => $mother_name,
                'mother_dob' => $mother_dob,
                'mother_work' => $mother_work,
                'mother_education' => $mother_education,
                'mother_income' => $mother_income,
                'guardian_name' => $guardian_name,
                'guardian_dob' => $guardian_dob,
                'guardian_work' => $guardian_work,
                'guardian_education' => $guardian_education,
                'guardian_income' => $guardian_income,
            ])
            ->assertNotFound();
    })->with([
        User::ROLE_ADMIN_YAYASAN => [fn () => $this->adminYayasan],
        User::ROLE_ADMIN_SEKOLAH => [fn () => $this->adminSekolah],
        User::ROLE_KEPALA_SEKOLAH => [fn () => $this->kepalaSekolah],
        User::ROLE_MURID => [fn () => $this->murid],
    ]);
// End Check Store Data

// Check Delete Data
    it('can delete Student', function (User $user) {
        $student = Student::factory()->create();
        $this->actingAs($user)
            ->delete(route('students.destroy', $student->getKey()))
            ->assertStatus(200);
    })->with([
        User::ROLE_SUPER_ADMIN => [fn () => $this->superAdmin],
        User::ROLE_OPS_ADMIN => [fn () => $this->opsAdmin],
        User::ROLE_TATA_USAHA => [fn () => $this->tataUsaha],
    ]);

    it('forbid delete Student', function (User $user) {
        $student = Student::factory()->create();
        $this->actingAs($user)
            ->delete(route('students.destroy', $student->getKey()))
            ->assertNotFound();
    })->with([
        User::ROLE_ADMIN_YAYASAN => [fn () => $this->adminYayasan],
        User::ROLE_ADMIN_SEKOLAH => [fn () => $this->adminSekolah],
        User::ROLE_KEPALA_SEKOLAH => [fn () => $this->kepalaSekolah],
        User::ROLE_MURID => [fn () => $this->murid],
    ]);
// Check Delete Data

// Check Update Data
    it('require validation on update student', function () {
        $student = Student::factory()->create();
        $this->actingAs($this->tataUsaha)
            ->put(route('students.update', $student->getKey()), [

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
                'guardian_dob' => $this->faker->date(),
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

    it('length validation on update student', function () {
        $student = Student::factory()->create();
        $this->actingAs($this->tataUsaha)
            ->put(route('students.update', $student->getKey()), [

                'academic_year_id' => 1,
                'name' => $this->faker->name(),
                'gender' => 'Love Live',
                'address' => $this->faker->address(),
                'dob' => $this->faker->date(),
                'religion' => 'katolik',
                'phone_number' => 103945751937593345234,
                'nik' => 10394575193759334523442345645345645634545756757,
                'nisn' => 10394575193759334523442345645345645634545756757,
                'nis' => 10394575193759334523442345645345645634545756757,
                'father_name' => $this->faker->name('male'),
                'father_dob' => $this->faker->date(),
                'father_work' => $this->faker->jobTitle(),
                'father_education' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem voluptatibus nisi et nemo deleniti dolorum corporis animi dolorem autem reiciendis suscipit, beatae adipisci deserunt cum magnam culpa perspiciatis facere accusamus.", 
                'father_income' => 10394575193759334523442345645345645634545756757103945751937593345234423456453456456345457567571039457519375933452344234564534564563454575675710394575193759334523442345645345645634545756757,
                'mother_name' => $this->faker->name('female'),
                'mother_dob' => $this->faker->date(),
                'mother_work' => $this->faker->jobTitle(),
                'mother_education' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem voluptatibus nisi et nemo deleniti dolorum corporis animi dolorem autem reiciendis suscipit, beatae adipisci deserunt cum magnam culpa perspiciatis facere accusamus.",
                'mother_income' => 10394575193759334523442345645345645634545756757103945751937593345234423456453456456345457567571039457519375933452344234564534564563454575675710394575193759334523442345645345645634545756757,
                'guardian_name' => $this->faker->name('female'),
                'guardian_dob' => $this->faker->date(),
                'guardian_work' => $this->faker->jobTitle(),
                'guardian_education' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem voluptatibus nisi et nemo deleniti dolorum corporis animi dolorem autem reiciendis suscipit, beatae adipisci deserunt cum magnam culpa perspiciatis facere accusamus.",
                'guardian_income' => 10394575193759334523442345645345645634545756757103945751937593345234423456453456456345457567571039457519375933452344234564534564563454575675710394575193759334523442345645345645634545756757,
            ])->assertInvalid(['gender', 'phone_number', 'nik', 'nis', 'nisn', 'father_education', 'father_income', 'mother_income', 'mother_education', 'guardian_income', 'guardian_education']);
    });

    it('numeric validation on update student', function () {
        $student = Student::factory()->create();
        $this->actingAs($this->tataUsaha)
            ->put(route('students.update', $student->getKey()), [
                'school_id' => 2,
                'academic_year_id' => $this->faker->numberBetween(1, 10),
                'name' => $this->faker->name(),
                'gender' => $this->faker->randomElement(['L', 'P']),
                'address' => $this->faker->address(),
                'dob' => $this->faker->date(),
                'religion' => 'katolik',
                'phone_number' => $this->faker->randomNumber(9, true),
                'nik' => "string  desu!",
                'nisn' => "string  desu!",
                'nis' => "string  desu!",
                'father_name' => $this->faker->name('male'),
                'father_dob' => $this->faker->date(),
                'father_work' => $this->faker->jobTitle(),
                'father_education' => "SMA",
                'father_income' => "string  desu!",
                'mother_name' => $this->faker->name('female'),
                'mother_dob' => $this->faker->date(),
                'mother_work' => $this->faker->jobTitle(),
                'mother_education' => "SMA",
                'mother_income' => "string  desu!",
                'guardian_name' => $this->faker->name('female'),
                'guardian_dob' => $this->faker->date(),
                'guardian_work' => $this->faker->jobTitle(),
                'guardian_education' => "S1",
                'guardian_income' => "string  desu!",
            ])->assertInvalid(['nik', 'nis', 'nisn', 'father_income', 'mother_income', 'guardian_income']);
    });

    it('array validation on update student', function () {
        $student = Student::factory()->create();
        $this->actingAs($this->tataUsaha)
            ->put(route('students.update', $student->getKey()), [
                'school_id' => 2,
                'academic_year_id' => $this->faker->numberBetween(1, 10),
                'name' => $this->faker->name(),
                'gender' => $this->faker->randomElement(['L', 'P']),
                'address' => $this->faker->address(),
                'dob' => $this->faker->date(),
                'religion' => 'katolik',
                'phone_number' => $this->faker->randomNumber(9, true),
                'nik' => $this->faker->randomNumber(9, true),
                'nisn' => $this->faker->randomNumber(9, true),
                'nis' => $this->faker->randomNumber(9, true),
                'father_name' => $this->faker->name('male'),
                'father_dob' => $this->faker->date(),
                'father_work' => $this->faker->jobTitle(),
                'father_education' => "SMA",
                'father_income' => $this->faker->randomNumber(7, false),
                'mother_name' => $this->faker->name('female'),
                'mother_dob' => $this->faker->date(),
                'mother_work' => $this->faker->jobTitle(),
                'mother_education' => "SMA",
                'mother_income' => $this->faker->randomNumber(7, false),
                'guardian_name' => $this->faker->name('female'),
                'guardian_dob' => $this->faker->date(),
                'guardian_work' => $this->faker->jobTitle(),
                'guardian_education' => "S1",
                'guardian_income' => $this->faker->randomNumber(7, false),
                'tuitions' => 'String Desu!',
                'selected_tuitions' => 'String Desu!',
            ])->assertInvalid(['tuitions', 'selected_tuitions']);
    });

    it('array items validation on update student', function () {
        $student = Student::factory()->create();
        $this->actingAs($this->tataUsaha)
            ->put(route('students.update', $student->getKey()), [
                'school_id' => 2,
                'academic_year_id' => $this->faker->numberBetween(1, 10),
                'name' => $this->faker->name(),
                'gender' => $this->faker->randomElement(['L', 'P']),
                'address' => $this->faker->address(),
                'dob' => $this->faker->date(),
                'religion' => 'katolik',
                'phone_number' => $this->faker->randomNumber(9, true),
                'nik' => $this->faker->randomNumber(9, true),
                'nisn' => $this->faker->randomNumber(9, true),
                'nis' => $this->faker->randomNumber(9, true),
                'father_name' => $this->faker->name('male'),
                'father_dob' => $this->faker->date(),
                'father_work' => $this->faker->jobTitle(),
                'father_education' => "SMA",
                'father_income' => $this->faker->randomNumber(7, false),
                'mother_name' => $this->faker->name('female'),
                'mother_dob' => $this->faker->date(),
                'mother_work' => $this->faker->jobTitle(),
                'mother_education' => "SMA",
                'mother_income' => $this->faker->randomNumber(7, false),
                'guardian_name' => $this->faker->name('female'),
                'guardian_dob' => $this->faker->date(),
                'guardian_work' => $this->faker->jobTitle(),
                'guardian_education' => "S1",
                'guardian_income' => $this->faker->randomNumber(7, false),
                'tuitions' => ['1' => 'Stering Desu~', '2' => 'mata Stering Desu~'],
                'selected_tuitions' => ['1' => 'Stering Desu~', '2' => 'mata Stering Desu~']
            ])->assertInvalid(['tuitions.1', 'tuitions.2', 'selected_tuitions.1', 'selected_tuitions.2']);
    });

    it('can update Student', function (User $user) {
        $student = Student::factory()->create();

        $academic_year_id = $this->faker->numberBetween(1, 10);
        $name = $this->faker->name();
        $gender = $this->faker->randomElement(['L', 'P']);
        $address = $this->faker->address();
        $dob = $this->faker->date();
        $religion = 'katolik';
        $phone_number = $this->faker->randomNumber(9, true);
        $nik = $this->faker->randomNumber(9, true);
        $nisn = $this->faker->randomNumber(9, true);
        $nis = $this->faker->randomNumber(9, true);
        $father_name = $this->faker->name('male');
        $father_dob = $this->faker->date();
        $father_work = $this->faker->jobTitle();
        $father_education = "SMA";
        $father_income = $this->faker->randomNumber(7, false);
        $mother_name = $this->faker->name('female');
        $mother_dob = $this->faker->date();
        $mother_work = $this->faker->jobTitle();
        $mother_education = "SMA";
        $mother_income = $this->faker->randomNumber(7, false);
        $guardian_name = $this->faker->name('female');
        $guardian_dob = $this->faker->date();
        $guardian_work = $this->faker->jobTitle();
        $guardian_education = "S1";
        $guardian_income = $this->faker->randomNumber(7, false);

        $this->actingAs($user)
            ->put(route('students.update', $student->getKey()), [
                'academic_year_id' => $academic_year_id,
                'name' => $name,
                'gender' => $gender,
                'address' => $address,
                'dob' => $dob,
                'religion' => $religion,
                'phone_number' => $phone_number,
                'nik' => $nik,
                'nisn' => $nisn,
                'nis' => $nis,
                'father_name' => $father_name,
                'father_dob' => $father_dob,
                'father_work' => $father_work,
                'father_education' => $father_education,
                'father_income' => $father_income,
                'mother_name' => $mother_name,
                'mother_dob' => $mother_dob,
                'mother_work' => $mother_work,
                'mother_education' => $mother_education,
                'mother_income' => $mother_income,
                'guardian_name' => $guardian_name,
                'guardian_dob' => $guardian_dob,
                'guardian_work' => $guardian_work,
                'guardian_education' => $guardian_education,
                'guardian_income' => $guardian_income,
            ])
            ->assertRedirect(route('students.index'));

        $this->assertDatabaseHas('students', [
            'name' => $name,
            'gender' => $gender,
            'address' => $address,
            'dob' => $dob,
            'religion' => $religion,
            'phone_number' => $phone_number,
            'nik' => $nik,
            'nisn' => $nisn,
            'nis' => $nis,
            'father_name' => $father_name,
            'father_dob' => $father_dob,
            'father_work' => $father_work,
            'father_education' => $father_education,
            'father_income' => $father_income,
            'mother_name' => $mother_name,
            'mother_dob' => $mother_dob,
            'mother_work' => $mother_work,
            'mother_education' => $mother_education,
            'mother_income' => $mother_income,
            'guardian_name' => $guardian_name,
            'guardian_dob' => $guardian_dob,
            'guardian_work' => $guardian_work,
            'guardian_education' => $guardian_education,
            'guardian_income' => $guardian_income,
        ]);
    })->with([
        User::ROLE_TATA_USAHA => [fn () => $this->tataUsaha],
        User::ROLE_BENDAHARA => [fn () => $this->bendahara],
        User::ROLE_SUPER_ADMIN => [fn () => $this->superAdmin],
        User::ROLE_OPS_ADMIN => [fn () => $this->opsAdmin],
    ]);

    it('can update Student With Tuitions', function (User $user) {
        $student = Student::factory()->create();
        $tuitionType1 = TuitionType::factory()->create();
        $tuitionType2 = TuitionType::factory()->create();

        $academic_year_id = $this->faker->numberBetween(1, 10);
        $name = $this->faker->name();
        $gender = $this->faker->randomElement(['L', 'P']);
        $address = $this->faker->address();
        $dob = $this->faker->date();
        $religion = 'katolik';
        $phone_number = $this->faker->randomNumber(9, true);
        $nik = $this->faker->randomNumber(9, true);
        $nisn = $this->faker->randomNumber(9, true);
        $nis = $this->faker->randomNumber(9, true);
        $father_name = $this->faker->name('male');
        $father_dob = $this->faker->date();
        $father_work = $this->faker->jobTitle();
        $father_education = "SMA";
        $father_income = $this->faker->randomNumber(7, false);
        $mother_name = $this->faker->name('female');
        $mother_dob = $this->faker->date();
        $mother_work = $this->faker->jobTitle();
        $mother_education = "SMA";
        $mother_income = $this->faker->randomNumber(7, false);
        $guardian_name = $this->faker->name('female');
        $guardian_dob = $this->faker->date();
        $guardian_work = $this->faker->jobTitle();
        $guardian_education = "S1";
        $guardian_income = $this->faker->randomNumber(7, false);

        $this->actingAs($user)
            ->put(route('students.update', $student->getKey()), [
                'academic_year_id' => $academic_year_id,
                'name' => $name,
                'gender' => $gender,
                'address' => $address,
                'dob' => $dob,
                'religion' => $religion,
                'phone_number' => $phone_number,
                'nik' => $nik,
                'nisn' => $nisn,
                'nis' => $nis,
                'father_name' => $father_name,
                'father_dob' => $father_dob,
                'father_work' => $father_work,
                'father_education' => $father_education,
                'father_income' => $father_income,
                'mother_name' => $mother_name,
                'mother_dob' => $mother_dob,
                'mother_work' => $mother_work,
                'mother_education' => $mother_education,
                'mother_income' => $mother_income,
                'guardian_name' => $guardian_name,
                'guardian_dob' => $guardian_dob,
                'guardian_work' => $guardian_work,
                'guardian_education' => $guardian_education,
                'guardian_income' => $guardian_income,
                'tuitions' => [
                    $tuitionType1->getKey() => 23456789,
                    $tuitionType2->getKey() => 23456789
                ],
            ])->assertRedirect(route('students.index'));

        $this->assertDatabaseHas('student_tuitions', [
            'tuition_type_id' => $tuitionType1->getKey(),
            'tuition_type_id' => $tuitionType2->getKey(),
        ]);
    })->with([
        User::ROLE_TATA_USAHA => [fn () => $this->tataUsaha],
        User::ROLE_BENDAHARA => [fn () => $this->bendahara],
        User::ROLE_SUPER_ADMIN => [fn () => $this->superAdmin],
        User::ROLE_OPS_ADMIN => [fn () => $this->opsAdmin],
    ]);

    it('forbid update Student', function (User $user) {
        $student = Student::factory()->create();

        $academic_year_id = $this->faker->numberBetween(1, 10);
        $name = $this->faker->name();
        $gender = $this->faker->randomElement(['L', 'P']);
        $address = $this->faker->address();
        $dob = $this->faker->date();
        $religion = 'katolik';
        $phone_number = $this->faker->randomNumber(9, true);
        $nik = $this->faker->randomNumber(9, true);
        $nisn = $this->faker->randomNumber(9, true);
        $nis = $this->faker->randomNumber(9, true);
        $father_name = $this->faker->name('male');
        $father_dob = $this->faker->date();
        $father_work = $this->faker->jobTitle();
        $father_education = "SMA";
        $father_income = $this->faker->randomNumber(7, false);
        $mother_name = $this->faker->name('female');
        $mother_dob = $this->faker->date();
        $mother_work = $this->faker->jobTitle();
        $mother_education = "SMA";
        $mother_income = $this->faker->randomNumber(7, false);
        $guardian_name = $this->faker->name('female');
        $guardian_dob = $this->faker->date();
        $guardian_work = $this->faker->jobTitle();
        $guardian_education = "S1";
        $guardian_income = $this->faker->randomNumber(7, false);

        $this->actingAs($user)
            ->put(route('students.update', $student->getKey()), [
                'academic_year_id' => $academic_year_id,
                'name' => $name,
                'gender' => $gender,
                'address' => $address,
                'dob' => $dob,
                'religion' => $religion,
                'phone_number' => $phone_number,
                'nik' => $nik,
                'nisn' => $nisn,
                'nis' => $nis,
                'father_name' => $father_name,
                'father_dob' => $father_dob,
                'father_work' => $father_work,
                'father_education' => $father_education,
                'father_income' => $father_income,
                'mother_name' => $mother_name,
                'mother_dob' => $mother_dob,
                'mother_work' => $mother_work,
                'mother_education' => $mother_education,
                'mother_income' => $mother_income,
                'guardian_name' => $guardian_name,
                'guardian_dob' => $guardian_dob,
                'guardian_work' => $guardian_work,
                'guardian_education' => $guardian_education,
                'guardian_income' => $guardian_income,
            ])
            ->assertNotFound();
    })->with([
        User::ROLE_ADMIN_YAYASAN => [fn () => $this->adminYayasan],
        User::ROLE_ADMIN_SEKOLAH => [fn () => $this->adminSekolah],
        User::ROLE_KEPALA_SEKOLAH => [fn () => $this->kepalaSekolah],
        User::ROLE_MURID => [fn () => $this->murid],
    ]);
// End Check Update Data
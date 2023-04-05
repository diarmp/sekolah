<?php

namespace Tests\Feature;

use App\Models\School;
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
    $this->siswa = User::role(User::ROLE_SISWA)->first();
    $this->alumni = User::role(User::ROLE_ALUMNI)->first();
    $this->setupFaker();
});

// Check Page Response
    it('forbid guest to view Student page', function () {
        $this
            ->get(route('students.index'))
            ->assertNotFound();
    });

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
        User::ROLE_BENDAHARA => [fn () => $this->bendahara],
        User::ROLE_SUPER_ADMIN => [fn () => $this->superAdmin],
        User::ROLE_OPS_ADMIN => [fn () => $this->opsAdmin],
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
        $school = School::factory()->create();
        session(['school_id' => $school->getKey()]);
        $student = Student::factory()->create();
        $response = $this
            ->actingAs($user)
            ->get(route('students.edit', $student->getKey()));

        $response->assertOk();
    })->with([
        User::ROLE_TATA_USAHA => [fn () => $this->tataUsaha],
        User::ROLE_BENDAHARA => [fn () => $this->bendahara],
        User::ROLE_SUPER_ADMIN => [fn () => $this->superAdmin],
        User::ROLE_OPS_ADMIN => [fn () => $this->opsAdmin],
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
                'family_card_number' => '',
                'nik' => '',
                'nis' => $this->faker->randomNumber(9, true),
                'nisn' => $this->faker->randomNumber(9, true),

                'father_name' => '',
                'father_address' => $this->faker->address(),
                'father_phone_number' => $this->faker->randomNumber(9, true),

                'mother_name' => '',
                'mother_address' => $this->faker->address(),
                'mother_phone_number' => $this->faker->randomNumber(9, true),

                'guardian_name' => $this->faker->name(),
                'guardian_address' => $this->faker->address(),
                'guardian_phone_number' => $this->faker->randomNumber(9, true),
            ])->assertInvalid([
                'academic_year_id',
                'name',
                'gender',
                'address',
                'dob',
                'religion',
                'family_card_number',
                'nik',
                'father_name',
                'mother_name',
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
                'phone_number' => '10394575193759334523442345645345645634545756757103945751937593345234423456453456456345457567571039457519375933452344234564534564563454575675710394575193759334523442345645345645634545756757',
                'family_card_number' => 10394575193759334523442345645345645634545756757103945751937593345234423456453456456345457567571039457519375933452344234564534564563454575675710394575193759334523442345645345645634545756757,
                'nik' => 1039457519375933452344234564534564563454575675710394575193759334523442345645345645634545756757,
                'nisn' => 1039457519375933452344234564534564563454575675710394575193759334523442345645345645634545756757,
                'nis' => 1039457519375933452344234564534564563454575675710394575193759334523442345645345645634545756757,

                'father_name' => $this->faker->name('male'),
                'father_address' => $this->faker->address(),
                'father_phone_number' => '1039457519375933452344234564534564563454575675710394575193759334523442345645345645634545756757',

                'mother_name' => $this->faker->name('female'),
                'mother_address' => $this->faker->address(),
                'mother_phone_number' => '1039457519375933452344234564534564563454575675710394575193759334523442345645345645634545756757',

                'guardian_name' => $this->faker->name(),
                'guardian_address' => $this->faker->address(),
                'guardian_phone_number' => '1039457519375933452344234564534564563454575675710394575193759334523442345645345645634545756757',
            ])->assertInvalid([
                'gender', 
                'phone_number', 
                'family_card_number', 
                'nik', 
                'nis', 
                'nisn', 
                'father_phone_number', 
                'mother_phone_number', 
                'guardian_phone_number'
            ]);
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
                'family_card_number' => 'string  desu!',
                'nik' => "string  desu!",
                'nisn' => "string  desu!",
                'nis' => "string  desu!",

                'father_name' => $this->faker->name('male'),
                'father_address' => $this->faker->address(),
                'father_phone_number' => 'string  desu!',

                'mother_name' => $this->faker->name('female'),
                'mother_address' => $this->faker->address(),
                'mother_phone_number' => "string  desu!",

                'guardian_name' => $this->faker->name(),
                'guardian_address' => $this->faker->address(),
                'guardian_phone_number' => "string  desu!",
            ])->assertInvalid([
                'family_card_number',
                'nik', 
                'nis', 
                'nisn', 
            ]);
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
                'family_card_number' => $this->faker->randomNumber(9, true),
                'nik' => $this->faker->randomNumber(9, true),
                'nisn' => $this->faker->randomNumber(9, true),
                'nis' => $this->faker->randomNumber(9, true),

                'father_name' => $this->faker->name('male'),
                'father_address' => $this->faker->address(),
                'father_phone_number' => $this->faker->randomNumber(7, false),

                'mother_name' => $this->faker->name('female'),
                'mother_address' => $this->faker->address(),
                'mother_phone_number' => $this->faker->randomNumber(7, false),

                'guardian_name' => $this->faker->name('female'),
                'guardian_address' => $this->faker->address(),
                'guardian_phone_number' => $this->faker->randomNumber(7, false),

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
                'family_card_number' => $this->faker->randomNumber(9, true),
                'nik' => $this->faker->randomNumber(9, true),
                'nisn' => $this->faker->randomNumber(9, true),
                'nis' => $this->faker->randomNumber(9, true),

                'father_name' => $this->faker->name('male'),
                'father_address' => $this->faker->address(),
                'father_phone_number' => $this->faker->randomNumber(7, false),

                'mother_name' => $this->faker->name('female'),
                'mother_address' => $this->faker->address(),
                'mother_phone_number' => $this->faker->randomNumber(7, false),

                'guardian_name' => $this->faker->name('female'),
                'guardian_address' => $this->faker->address(),
                'guardian_phone_number' => $this->faker->randomNumber(7, false),

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
        $family_card_number = $this->faker->randomNumber(9, true);
        $nik = $this->faker->randomNumber(9, true);
        $nisn = $this->faker->randomNumber(9, true);
        $nis = $this->faker->randomNumber(9, true);

        $father_name = $this->faker->name('male');
        $father_address = $this->faker->address();
        $father_phone_number = $this->faker->randomNumber(7, false);

        $mother_name = $this->faker->name('female');
        $mother_address = $this->faker->address();
        $mother_phone_number = $this->faker->randomNumber(7, false);

        $guardian_name = $this->faker->name('female');
        $guardian_address = $this->faker->address();
        $guardian_phone_number = $this->faker->randomNumber(7, false);


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
                'family_card_number' => $family_card_number,
                'nik' => $nik,
                'nisn' => $nisn,
                'nis' => $nis,

                'father_name' => $father_name,
                'father_address' => $father_address,
                'father_phone_number' => $father_phone_number,

                'mother_name' => $mother_name,
                'mother_address' => $mother_address,
                'mother_phone_number' => $mother_phone_number,

                'guardian_name' => $guardian_name,
                'guardian_address' => $guardian_address,
                'guardian_phone_number' => $guardian_phone_number,
            ])
            ->assertRedirect(route('students.index'));

        $this->assertDatabaseHas('students', [
            'name' => $name,
            'gender' => $gender,
            'address' => $address,
            'dob' => $dob,
            'religion' => $religion,
            'phone_number' => $phone_number,
            'family_card_number' => $family_card_number,
            'nik' => $nik,
            'nisn' => $nisn,
            'nis' => $nis,

            'father_name' => $father_name,
            'father_address' => $father_address,
            'father_phone_number' => $father_phone_number,

            'mother_name' => $mother_name,
            'mother_address' => $mother_address,
            'mother_phone_number' => $mother_phone_number,

            'guardian_name' => $guardian_name,
            'guardian_address' => $guardian_address,
            'guardian_phone_number' => $guardian_phone_number,
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
        $family_card_number = $this->faker->randomNumber(9, true);
        $nik = $this->faker->randomNumber(9, true);
        $nisn = $this->faker->randomNumber(9, true);
        $nis = $this->faker->randomNumber(9, true);

        $father_name = $this->faker->name('male');
        $father_address = $this->faker->address();
        $father_phone_number = $this->faker->randomNumber(7, false);

        $mother_name = $this->faker->name('female');
        $mother_address = $this->faker->address();
        $mother_phone_number = $this->faker->randomNumber(7, false);

        $guardian_name = $this->faker->name('female');
        $guardian_address = $this->faker->address();
        $guardian_phone_number = $this->faker->randomNumber(7, false);

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
                'family_card_number' => $family_card_number,
                'nik' => $nik,
                'nisn' => $nisn,
                'nis' => $nis,

                'father_name' => $father_name,
                'father_address' => $father_address,
                'father_phone_number' => $father_phone_number,

                'mother_name' => $mother_name,
                'mother_address' => $mother_address,
                'mother_phone_number' => $mother_phone_number,

                'guardian_name' => $guardian_name,
                'guardian_address' => $guardian_address,
                'guardian_phone_number' => $guardian_phone_number,

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
        $family_card_number = $this->faker->randomNumber(9, true);
        $nik = $this->faker->randomNumber(9, true);
        $nisn = $this->faker->randomNumber(9, true);
        $nis = $this->faker->randomNumber(9, true);

        $father_name = $this->faker->name('male');
        $father_address = $this->faker->address();
        $father_phone_number = $this->faker->randomNumber(7, false);

        $mother_name = $this->faker->name('female');
        $mother_address = $this->faker->address();
        $mother_phone_number = $this->faker->randomNumber(7, false);

        $guardian_name = $this->faker->name('female');
        $guardian_address = $this->faker->address();
        $guardian_phone_number = $this->faker->randomNumber(7, false);

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
                'family_card_number' => $family_card_number,
                'nik' => $nik,
                'nisn' => $nisn,
                'nis' => $nis,

                'father_name' => $father_name,
                'father_address' => $father_address,
                'father_phone_number' => $father_phone_number,

                'mother_name' => $mother_name,
                'mother_address' => $mother_address,
                'mother_phone_number' => $mother_phone_number,

                'guardian_name' => $guardian_name,
                'guardian_address' => $guardian_address,
                'guardian_phone_number' => $guardian_phone_number,
            ])
            ->assertNotFound();
    })->with([
        User::ROLE_ADMIN_YAYASAN => [fn () => $this->adminYayasan],
        User::ROLE_ADMIN_SEKOLAH => [fn () => $this->adminSekolah],
        User::ROLE_KEPALA_SEKOLAH => [fn () => $this->kepalaSekolah],
        User::ROLE_SISWA => [fn () => $this->siswa],
    ]);
// End Check Store Data

// Check Delete Data
    it('can delete Student', function (User $user) {
        $school = School::factory()->create();
        session(['school_id' => $school->getKey()]);
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
        $school = School::factory()->create();
        session(['school_id' => $school->getKey()]);
        $student = Student::factory()->create();
        $this->actingAs($user)
            ->delete(route('students.destroy', $student->getKey()))
            ->assertNotFound();
    })->with([
        User::ROLE_ADMIN_YAYASAN => [fn () => $this->adminYayasan],
        User::ROLE_ADMIN_SEKOLAH => [fn () => $this->adminSekolah],
        User::ROLE_KEPALA_SEKOLAH => [fn () => $this->kepalaSekolah],
        User::ROLE_SISWA => [fn () => $this->siswa],
    ]);
// Check Delete Data

// Check Update Data
    it('require validation on update student', function () {
        $school = School::factory()->create();
        session(['school_id' => $school->getKey()]);
        $student = Student::factory()->create();

        $this->actingAs($this->tataUsaha)
            ->put(route('students.update', $student->getKey()), [
                'school_id' => $school->getKey(),
                'academic_year_id' => '',

                'name' => '',
                'gender' => '',
                'address' => '',
                'dob' => '',
                'religion' => '',
                'phone_number' => $this->faker->randomNumber(9, true),
                'family_card_number' => '',
                'nik' => '',
                'nis' => $this->faker->randomNumber(9, true),
                'nisn' => $this->faker->randomNumber(9, true),

                'father_name' => '',
                'father_address' => $this->faker->address(),
                'father_phone_number' => $this->faker->randomNumber(9, true),

                'mother_name' => '',
                'mother_address' => $this->faker->address(),
                'mother_phone_number' => $this->faker->randomNumber(9, true),

                'guardian_name' => $this->faker->name(),
                'guardian_address' => $this->faker->address(),
                'guardian_phone_number' => $this->faker->randomNumber(9, true),
            ])->assertInvalid([
                'academic_year_id',
                'name',
                'gender',
                'address',
                'dob',
                'religion',
                'family_card_number',
                'nik',
                'father_name',
                'mother_name',
            ]);
    });

    it('length validation on update student', function () {
        $school = School::factory()->create();
        session(['school_id' => $school->getKey()]);
        $student = Student::factory()->create();

        $this->actingAs($this->tataUsaha)
            ->put(route('students.update', $student->getKey()), [
                'school_id' => $school->getKey(),
                'academic_year_id' => 1,

                'name' => $this->faker->name(),
                'gender' => 'Love Live',
                'address' => $this->faker->address(),
                'dob' => $this->faker->date(),
                'religion' => 'katolik',
                'phone_number' => '10394575193759334523442345645345645634545756757103945751937593345234423456453456456345457567571039457519375933452344234564534564563454575675710394575193759334523442345645345645634545756757',
                'family_card_number' => 1039457519375933452344234564534564563454575675710394575193759334523442345645345645634545756757,
                'nik' => 1039457519375933452344234564534564563454575675710394575193759334523442345645345645634545756757,
                'nisn' => 1039457519375933452344234564534564563454575675710394575193759334523442345645345645634545756757,
                'nis' => 1039457519375933452344234564534564563454575675710394575193759334523442345645345645634545756757,

                'father_name' => $this->faker->name('male'),
                'father_address' => $this->faker->address(),
                'father_phone_number' => '1039457519375933452344234564534564563454575675710394575193759334523442345645345645634545756757',

                'mother_name' => $this->faker->name('female'),
                'mother_address' => $this->faker->address(),
                'mother_phone_number' => '1039457519375933452344234564534564563454575675710394575193759334523442345645345645634545756757',

                'guardian_name' => $this->faker->name(),
                'guardian_address' => $this->faker->address(),
                'guardian_phone_number' => '1039457519375933452344234564534564563454575675710394575193759334523442345645345645634545756757',
            ])->assertInvalid([
                'gender', 
                'phone_number', 
                'family_card_number', 
                'nik', 
                'nis', 
                'nisn', 
                'father_phone_number', 
                'mother_phone_number', 
                'guardian_phone_number'
            ]);
    });

    it('numeric validation on update student', function () {
        $school = School::factory()->create();
        session(['school_id' => $school->getKey()]);
        $student = Student::factory()->create();

        $this->actingAs($this->tataUsaha)
            ->put(route('students.update', $student->getKey()), [
                'school_id' => $school->getKey(),
                'academic_year_id' => $this->faker->numberBetween(1, 10),

                'name' => $this->faker->name(),
                'gender' => $this->faker->randomElement(['L', 'P']),
                'address' => $this->faker->address(),
                'dob' => $this->faker->date(),
                'religion' => 'katolik',
                'phone_number' => $this->faker->randomNumber(9, true),
                'family_card_number' => 'string  desu!',
                'nik' => "string  desu!",
                'nisn' => "string  desu!",
                'nis' => "string  desu!",

                'father_name' => $this->faker->name('male'),
                'father_address' => $this->faker->address(),
                'father_phone_number' => 'string  desu!',

                'mother_name' => $this->faker->name('female'),
                'mother_address' => $this->faker->address(),
                'mother_phone_number' => "string  desu!",

                'guardian_name' => $this->faker->name(),
                'guardian_address' => $this->faker->address(),
                'guardian_phone_number' => "string  desu!",
            ])->assertInvalid([
                'family_card_number',
                'nik', 
                'nis', 
                'nisn', 
            ]);
    });

    it('array validation on update student', function () {
        $school = School::factory()->create();
        session(['school_id' => $school->getKey()]);
        $student = Student::factory()->create();

        $this->actingAs($this->tataUsaha)
            ->put(route('students.update', $student->getKey()), [
                'school_id' => $school->getKey(),
                'academic_year_id' => $this->faker->numberBetween(1, 10),

                'name' => $this->faker->name(),
                'gender' => $this->faker->randomElement(['L', 'P']),
                'address' => $this->faker->address(),
                'dob' => $this->faker->date(),
                'religion' => 'katolik',
                'phone_number' => $this->faker->randomNumber(9, true),
                'family_card_number' => $this->faker->randomNumber(9, true),
                'nik' => $this->faker->randomNumber(9, true),
                'nisn' => $this->faker->randomNumber(9, true),
                'nis' => $this->faker->randomNumber(9, true),

                'father_name' => $this->faker->name('male'),
                'father_address' => $this->faker->address(),
                'father_phone_number' => $this->faker->randomNumber(7, false),

                'mother_name' => $this->faker->name('female'),
                'mother_address' => $this->faker->address(),
                'mother_phone_number' => $this->faker->randomNumber(7, false),

                'guardian_name' => $this->faker->name('female'),
                'guardian_address' => $this->faker->address(),
                'guardian_phone_number' => $this->faker->randomNumber(7, false),

                'tuitions' => 'String Desu!',
                'selected_tuitions' => 'String Desu!'
            ])->assertInvalid(['tuitions', 'selected_tuitions']);
    });

    it('array items validation on update student', function () {
        $school = School::factory()->create();
        session(['school_id' => $school->getKey()]);
        $student = Student::factory()->create();

        $this->actingAs($this->tataUsaha)
            ->put(route('students.update', $student->getKey()), [
                'school_id' => $school->getKey(),
                'academic_year_id' => $this->faker->numberBetween(1, 10),

                'name' => $this->faker->name(),
                'gender' => $this->faker->randomElement(['L', 'P']),
                'address' => $this->faker->address(),
                'dob' => $this->faker->date(),
                'religion' => 'katolik',
                'phone_number' => $this->faker->randomNumber(9, true),
                'family_card_number' => $this->faker->randomNumber(9, true),
                'nik' => $this->faker->randomNumber(9, true),
                'nisn' => $this->faker->randomNumber(9, true),
                'nis' => $this->faker->randomNumber(9, true),

                'father_name' => $this->faker->name('male'),
                'father_address' => $this->faker->address(),
                'father_phone_number' => $this->faker->randomNumber(7, false),

                'mother_name' => $this->faker->name('female'),
                'mother_address' => $this->faker->address(),
                'mother_phone_number' => $this->faker->randomNumber(7, false),

                'guardian_name' => $this->faker->name('female'),
                'guardian_address' => $this->faker->address(),
                'guardian_phone_number' => $this->faker->randomNumber(7, false),
                
                'tuitions' => ['1' => 'Stering Desu~', '2' => 'mata Stering Desu~'],
                'selected_tuitions' => ['1' => 'Stering Desu~', '2' => 'mata Stering Desu~']
            ])->assertInvalid([
                'tuitions.1', 
                'tuitions.2', 
                'selected_tuitions.1', 
                'selected_tuitions.2'
            ]);
    });

    it('can update Student', function (User $user) {
        $student = Student::factory()->create();
        session(['school_id' => $user->school_id ?? 2]);
        $academic_year_id = $this->faker->numberBetween(1, 10);

        $name = $this->faker->name();
        $gender = $this->faker->randomElement(['L', 'P']);
        $address = $this->faker->address();
        $dob = $this->faker->date();
        $religion = 'katolik';
        $phone_number = $this->faker->randomNumber(9, true);
        $family_card_number = $this->faker->randomNumber(9, true);
        $nik = $this->faker->randomNumber(9, true);
        $nisn = $this->faker->randomNumber(9, true);
        $nis = $this->faker->randomNumber(9, true);

        $father_name = $this->faker->name('male');
        $father_address = $this->faker->address();
        $father_phone_number = $this->faker->randomNumber(7, false);

        $mother_name = $this->faker->name('female');
        $mother_address = $this->faker->address();
        $mother_phone_number = $this->faker->randomNumber(7, false);

        $guardian_name = $this->faker->name('female');
        $guardian_address = $this->faker->address();
        $guardian_phone_number = $this->faker->randomNumber(7, false);

        $this->actingAs($user)
            ->put(route('students.update', $student->getKey()), [
                'academic_year_id' => $academic_year_id,

                'name' => $name,
                'gender' => $gender,
                'address' => $address,
                'dob' => $dob,
                'religion' => $religion,
                'phone_number' => $phone_number,
                'family_card_number' => $family_card_number,
                'nik' => $nik,
                'nisn' => $nisn,
                'nis' => $nis,

                'father_name' => $father_name,
                'father_address' => $father_address,
                'father_phone_number' => $father_phone_number,

                'mother_name' => $mother_name,
                'mother_address' => $mother_address,
                'mother_phone_number' => $mother_phone_number,

                'guardian_name' => $guardian_name,
                'guardian_address' => $guardian_address,
                'guardian_phone_number' => $guardian_phone_number,
            ])
            ->assertRedirect(route('students.index'));

        $this->assertDatabaseHas('students', [
            'name' => $name,
            'gender' => $gender,
            'address' => $address,
            'dob' => $dob,
            'religion' => $religion,
            'phone_number' => $phone_number,
            'family_card_number' => $family_card_number,
            'nik' => $nik,
            'nisn' => $nisn,
            'nis' => $nis,

            'father_name' => $father_name,
            'father_address' => $father_address,
            'father_phone_number' => $father_phone_number,

            'mother_name' => $mother_name,
            'mother_address' => $mother_address,
            'mother_phone_number' => $mother_phone_number,

            'guardian_name' => $guardian_name,
            'guardian_address' => $guardian_address,
            'guardian_phone_number' => $guardian_phone_number,
        ]);
    })->with([
        User::ROLE_TATA_USAHA => [fn () => $this->tataUsaha],
        User::ROLE_BENDAHARA => [fn () => $this->bendahara],
        User::ROLE_SUPER_ADMIN => [fn () => $this->superAdmin],
        User::ROLE_OPS_ADMIN => [fn () => $this->opsAdmin],
    ]);

    it('can update Student With Tuitions', function (User $user) {
        $student = Student::factory()->create();
        session(['school_id' => $user->school_id ?? 2]);
        $tuitionType1 = TuitionType::factory()->create();
        $tuitionType2 = TuitionType::factory()->create();
        $academic_year_id = $this->faker->numberBetween(1, 10);

        $name = $this->faker->name();
        $gender = $this->faker->randomElement(['L', 'P']);
        $address = $this->faker->address();
        $dob = $this->faker->date();
        $religion = 'katolik';
        $phone_number = $this->faker->randomNumber(9, true);
        $family_card_number = $this->faker->randomNumber(9, true);
        $nik = $this->faker->randomNumber(9, true);
        $nisn = $this->faker->randomNumber(9, true);
        $nis = $this->faker->randomNumber(9, true);

        $father_name = $this->faker->name('male');
        $father_address = $this->faker->address();
        $father_phone_number = $this->faker->randomNumber(7, false);

        $mother_name = $this->faker->name('female');
        $mother_address = $this->faker->address();
        $mother_phone_number = $this->faker->randomNumber(7, false);

        $guardian_name = $this->faker->name('female');
        $guardian_address = $this->faker->address();
        $guardian_phone_number = $this->faker->randomNumber(7, false);

        $this->actingAs($user)
            ->put(route('students.update', $student->getKey()), [
                'academic_year_id' => $academic_year_id,

                'name' => $name,
                'gender' => $gender,
                'address' => $address,
                'dob' => $dob,
                'religion' => $religion,
                'phone_number' => $phone_number,
                'family_card_number' => $family_card_number,
                'nik' => $nik,
                'nisn' => $nisn,
                'nis' => $nis,

                'father_name' => $father_name,
                'father_address' => $father_address,
                'father_phone_number' => $father_phone_number,

                'mother_name' => $mother_name,
                'mother_address' => $mother_address,
                'mother_phone_number' => $mother_phone_number,

                'guardian_name' => $guardian_name,
                'guardian_address' => $guardian_address,
                'guardian_phone_number' => $guardian_phone_number,

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
        $family_card_number = $this->faker->randomNumber(9, true);
        $nik = $this->faker->randomNumber(9, true);
        $nisn = $this->faker->randomNumber(9, true);
        $nis = $this->faker->randomNumber(9, true);

        $father_name = $this->faker->name('male');
        $father_address = $this->faker->address();
        $father_phone_number = $this->faker->randomNumber(7, false);

        $mother_name = $this->faker->name('female');
        $mother_address = $this->faker->address();
        $mother_phone_number = $this->faker->randomNumber(7, false);

        $guardian_name = $this->faker->name('female');
        $guardian_address = $this->faker->address();
        $guardian_phone_number = $this->faker->randomNumber(7, false);

        $this->actingAs($user)
            ->put(route('students.update', $student->getKey()), [
                'academic_year_id' => $academic_year_id,

                'name' => $name,
                'gender' => $gender,
                'address' => $address,
                'dob' => $dob,
                'religion' => $religion,
                'phone_number' => $phone_number,
                'family_card_number' => $family_card_number,
                'nik' => $nik,
                'nisn' => $nisn,
                'nis' => $nis,

                'father_name' => $father_name,
                'father_address' => $father_address,
                'father_phone_number' => $father_phone_number,

                'mother_name' => $mother_name,
                'mother_address' => $mother_address,
                'mother_phone_number' => $mother_phone_number,

                'guardian_name' => $guardian_name,
                'guardian_address' => $guardian_address,
                'guardian_phone_number' => $guardian_phone_number,
            ])
            ->assertNotFound();
    })->with([
        User::ROLE_ADMIN_YAYASAN => [fn () => $this->adminYayasan],
        User::ROLE_ADMIN_SEKOLAH => [fn () => $this->adminSekolah],
        User::ROLE_KEPALA_SEKOLAH => [fn () => $this->kepalaSekolah],
        User::ROLE_SISWA => [fn () => $this->siswa],
    ]);
// End Check Update Data
<?php

use App\Models\AcademicYear;
use App\Models\School;
use App\Models\User;

beforeEach(function () {
    $this->superAdmin = User::role(User::ROLE_SUPER_ADMIN)->first();
    $this->opsAdmin = User::role(User::ROLE_OPS_ADMIN)->first();
    $this->adminYayasan = User::role(User::ROLE_ADMIN_YAYASAN)->first();
    $this->adminSekolah = User::role(User::ROLE_ADMIN_SEKOLAH)->first();
    $this->bendahara = User::role(User::ROLE_BENDAHARA)->first();
    $this->tataUsaha = User::role(User::ROLE_TATA_USAHA)->first();
    $this->kepalaSekolah = User::role(User::ROLE_KEPALA_SEKOLAH)->first();
    $this->setupFaker();
});

it('can render Academy Years index Datatable page as ', function (User $user) {
    $response = $this
        ->actingAs($user)
        ->get(route('datatable.academy-year'));

    $response->assertOk();
})->with([
    User::ROLE_SUPER_ADMIN => [fn () => $this->superAdmin],
    User::ROLE_OPS_ADMIN => [fn () => $this->opsAdmin],
    User::ROLE_BENDAHARA => [fn () => $this->bendahara],
    User::ROLE_ADMIN_YAYASAN => [fn () => $this->adminYayasan],
    User::ROLE_KEPALA_SEKOLAH => [fn () => $this->adminSekolah],
    User::ROLE_KEPALA_SEKOLAH => [fn () => $this->kepalaSekolah],

]);


it('forbid guest to view Academy Years page', function () {
    $this
        ->get(route('academy-year.index'))
        ->assertNotFound();
});


it('can render Academy Years index page as Sempoa Staff', function (User $user) {
    $response = $this
        ->actingAs($user)
        ->get(route('academy-year.index'));

    $response->assertOk();
})->with('sempoa_staff');


it('can render Academy Years index page as School Staff', function (User $user) {
    $response = $this
        ->actingAs($user)
        ->get(route('academy-year.index'));

    $response->assertOk();
})->with('school_staff');



it('can render Academy Years create page as ', function (User $user) {
    $response = $this
        ->actingAs($user)
        ->get(route('academy-year.create'));

    $response->assertOk();
})->with([
    User::ROLE_SUPER_ADMIN => [fn () => $this->superAdmin],
    User::ROLE_OPS_ADMIN => [fn () => $this->opsAdmin],
    User::ROLE_TATA_USAHA => [fn () => $this->tataUsaha],
]);

it("forbid crate page Academy Years page as ", function ($user) {
    $this
        ->get(route('academy-year.create'))
        ->assertNotFound();
})->with([
    User::ROLE_ADMIN_YAYASAN => [fn () => $this->adminYayasan],
    User::ROLE_KEPALA_SEKOLAH => [fn () => $this->adminSekolah],
    User::ROLE_KEPALA_SEKOLAH => [fn () => $this->kepalaSekolah],
]);

it('forbid edit page Academy Years page as ', function (User $user) {
    $tuitionType = AcademicYear::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get(route('academy-year.edit', $tuitionType->getKey()));

    $response->assertNotFound();
})->with([
    User::ROLE_ADMIN_YAYASAN => [fn () => $this->adminYayasan],
    User::ROLE_KEPALA_SEKOLAH => [fn () => $this->adminSekolah],
    User::ROLE_KEPALA_SEKOLAH => [fn () => $this->kepalaSekolah],
]);



it('can render Academy Years Edit page as ', function (User $user) {
    $tuitionType = AcademicYear::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get(route('academy-year.edit', $tuitionType->getKey()));

    $response->assertOk();
})->with([
    User::ROLE_SUPER_ADMIN => [fn () => $this->superAdmin],
    User::ROLE_OPS_ADMIN => [fn () => $this->opsAdmin],
    User::ROLE_TATA_USAHA => [fn () => $this->tataUsaha],
]);



it('can render Academy Years create invalid required school_id and name as ', function (User $user) {
    $this->actingAs($user)
        ->post(route('academy-year.store'), [
            'school_id' => '',
            'name' => '',
        ])
        ->assertInvalid([
            'school_id' => 'required',
            'name' => 'required'
        ]);
})->with([
    User::ROLE_SUPER_ADMIN => [fn () => $this->superAdmin],
    User::ROLE_OPS_ADMIN => [fn () => $this->opsAdmin],
    User::ROLE_TATA_USAHA => [fn () => $this->tataUsaha],
]);


it('can render Academy Years create data as ', function (User $user) {
    $school = School::factory()->create();
    $name = $this->faker()->name();
    $this->actingAs($user)
        ->post(route('academy-year.store'), [
            'school_id' => $school->id,
            'name' => $name,
        ])
        ->assertRedirect(route('academy-year.index'));

    $this->assertDatabaseHas('academic_years', [
        'name' => $name
    ]);
})->with([
    User::ROLE_SUPER_ADMIN => [fn () => $this->superAdmin],
    User::ROLE_OPS_ADMIN => [fn () => $this->opsAdmin],
    User::ROLE_TATA_USAHA => [fn () => $this->tataUsaha],
]);


it('can render Academy Years update invalid required school_id and name as ', function (User $user) {
    $tuitionType = AcademicYear::factory()->create();
    $this->actingAs($user)
        ->put(route('academy-year.update', $tuitionType->getKey()), [
            'school_id' => '',
            'name' => '',
        ])
        ->assertInvalid([
            'school_id' => 'required',
            'name' => 'required'
        ]);
})->with([
    User::ROLE_SUPER_ADMIN => [fn () => $this->superAdmin],
    User::ROLE_OPS_ADMIN => [fn () => $this->opsAdmin],
    User::ROLE_TATA_USAHA => [fn () => $this->tataUsaha],
]);


it('can render Academy Years update data  as ', function (User $user) {
    $tuitionType = AcademicYear::factory()->create();
    $name = $this->faker()->name();
    $this->actingAs($user)
        ->put(route('academy-year.update', $tuitionType->getKey()), [
            'school_id' => $tuitionType->school_id,
            'name' => $name,
        ])
        ->assertRedirect(route('academy-year.index'));
    $this->assertDatabaseHas('academic_years', [
        'name' => $name
    ]);
})->with([
    User::ROLE_SUPER_ADMIN => [fn () => $this->superAdmin],
    User::ROLE_OPS_ADMIN => [fn () => $this->opsAdmin],
    User::ROLE_TATA_USAHA => [fn () => $this->tataUsaha],
]);


it('can render Academy Years delete data  as ', function (User $user) {
    $tuitionType = AcademicYear::factory()->create();
    $name = $this->faker()->name();
    $this->actingAs($user)
        ->delete(route('academy-year.destroy', $tuitionType->getKey()))
        ->assertStatus(200);
})->with([
    User::ROLE_SUPER_ADMIN => [fn () => $this->superAdmin],
    User::ROLE_OPS_ADMIN => [fn () => $this->opsAdmin],
    User::ROLE_TATA_USAHA => [fn () => $this->tataUsaha],
]);

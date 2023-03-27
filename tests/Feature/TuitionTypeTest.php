<?php

use App\Models\School;
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
    $this->setupFaker();
});

it('can render Tuition Type index Datatable page as ', function (User $user) {
    $response = $this
        ->actingAs($user)
        ->get(route('datatable.tuition-type'));

    $response->assertOk();
})->with([
    User::ROLE_SUPER_ADMIN => [fn () => $this->superAdmin],
    User::ROLE_OPS_ADMIN => [fn () => $this->opsAdmin],
    User::ROLE_BENDAHARA => [fn () => $this->bendahara],
    User::ROLE_ADMIN_YAYASAN => [fn () => $this->adminYayasan],
    User::ROLE_ADMIN_SEKOLAH => [fn () => $this->adminSekolah],
    User::ROLE_KEPALA_SEKOLAH => [fn () => $this->kepalaSekolah],

]);


it('forbid guest to view Tuition Type page', function () {
    $this
        ->get(route('tuition-type.index'))
        ->assertNotFound();
});


it('can render Tuition Type index page as Sempoa Staff', function (User $user) {
    $response = $this
        ->actingAs($user)
        ->get(route('tuition-type.index'));

    $response->assertOk();
})->with('sempoa_staff');


it('can render Tuition Type index page as School Staff', function (User $user) {
    $response = $this
        ->actingAs($user)
        ->get(route('tuition-type.index'));

    $response->assertOk();
})->with('school_staff');



it('can render Tuition Type create page as ', function (User $user) {
    $response = $this
        ->actingAs($user)
        ->get(route('tuition-type.create'));

    $response->assertOk();
})->with([
    User::ROLE_SUPER_ADMIN => [fn () => $this->superAdmin],
    User::ROLE_OPS_ADMIN => [fn () => $this->opsAdmin],
    User::ROLE_BENDAHARA => [fn () => $this->bendahara],
]);

it("forbid crate page Tuition Type page as ", function ($user) {
    $this
        ->get(route('tuition-type.create'))
        ->assertNotFound();
})->with([
    User::ROLE_ADMIN_YAYASAN => [fn () => $this->adminYayasan],
    User::ROLE_ADMIN_SEKOLAH => [fn () => $this->adminSekolah],
    User::ROLE_KEPALA_SEKOLAH => [fn () => $this->kepalaSekolah],
]);

it('forbid edit page Tuition Type page as ', function (User $user) {
    $tuitionType = TuitionType::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get(route('tuition-type.edit', $tuitionType->getKey()));

    $response->assertNotFound();
})->with([
    User::ROLE_ADMIN_YAYASAN => [fn () => $this->adminYayasan],
    User::ROLE_ADMIN_SEKOLAH => [fn () => $this->adminSekolah],
    User::ROLE_KEPALA_SEKOLAH => [fn () => $this->kepalaSekolah],
]);



it('can render Tuition Type Edit page as ', function (User $user) {
    $tuitionType = TuitionType::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get(route('tuition-type.edit', $tuitionType->getKey()));

    $response->assertOk();
})->with([
    User::ROLE_SUPER_ADMIN => [fn () => $this->superAdmin],
    User::ROLE_OPS_ADMIN => [fn () => $this->opsAdmin],
    User::ROLE_BENDAHARA => [fn () => $this->bendahara],
]);



it('can render Tuition Type create invalid required school_id and name as ', function (User $user) {
    $this->actingAs($user)
        ->post(route('tuition-type.store'), [
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
    User::ROLE_BENDAHARA => [fn () => $this->bendahara],
]);


it('can render Tuition Type create data as ', function (User $user) {
    $school = School::factory()->create();
    $name = $this->faker()->name();
    $this->actingAs($user)
        ->post(route('tuition-type.store'), [
            'school_id' => $school->id,
            'name' => $name,
        ])
        ->assertRedirect(route('tuition-type.index'));

    $this->assertDatabaseHas('tuition_types', [
        'name' => $name
    ]);
})->with([
    User::ROLE_SUPER_ADMIN => [fn () => $this->superAdmin],
    User::ROLE_OPS_ADMIN => [fn () => $this->opsAdmin],
    User::ROLE_BENDAHARA => [fn () => $this->bendahara],
]);


it('can render Tuition Type update invalid required school_id and name as ', function (User $user) {
    $tuitionType = TuitionType::factory()->create();
    $this->actingAs($user)
        ->put(route('tuition-type.update', $tuitionType->getKey()), [
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
    User::ROLE_BENDAHARA => [fn () => $this->bendahara],
]);


it('can render Tuition Type update data  as ', function (User $user) {
    $tuitionType = TuitionType::factory()->create();
    $this->actingAs($user)
        ->put(route('tuition-type.update', $tuitionType->getKey()), [
            'school_id' => $tuitionType->school_id,
            'name' => $tuitionType->name,
        ])
        ->assertRedirect(route('tuition-type.index'));
    $this->assertDatabaseHas('tuition_types', [
        'name' => $tuitionType->name
    ]);
})->with([
    User::ROLE_SUPER_ADMIN => [fn () => $this->superAdmin],
    User::ROLE_OPS_ADMIN => [fn () => $this->opsAdmin],
    User::ROLE_BENDAHARA => [fn () => $this->bendahara],
]);


it('can render Tuition Type delete data  as ', function (User $user) {
    $tuitionType = TuitionType::factory()->create();
    $name = $this->faker()->name();
    $this->actingAs($user)
        ->delete(route('tuition-type.destroy', $tuitionType->getKey()))
        ->assertStatus(200);
})->with([
    User::ROLE_SUPER_ADMIN => [fn () => $this->superAdmin],
    User::ROLE_OPS_ADMIN => [fn () => $this->opsAdmin],
    User::ROLE_BENDAHARA => [fn () => $this->bendahara],
]);

<?php

use App\Models\School;
use App\Models\Staff;
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

it('forbid guest to view School page', function () {
    $this
        ->get(route('schools.index'))
        ->assertNotFound();
});

it('has Super Admin & Ops Admin role', function () {
    $this
        ->assertDatabaseHas('roles', [
            'name' => User::ROLE_SUPER_ADMIN
        ])
        ->assertDatabaseHas('roles', [
            'name' => User::ROLE_OPS_ADMIN
        ]);
});

it('has Super Admin & Ops Admin users', function () {
    $this
        ->assertDatabaseHas('users', [
            'name' => str(User::ROLE_SUPER_ADMIN)->title()
        ])
        ->assertDatabaseHas('users', [
            'name' => str(User::ROLE_OPS_ADMIN)->title()
        ]);
});

it('can render School create page as Super Admin', function (User $user) {
    $response = $this
        ->actingAs($user)
        ->get(route('schools.create'));

    $response->assertOk();
})->with([
    User::ROLE_SUPER_ADMIN => [fn () => $this->superAdmin]
]);

it('requires the school name', function () {
    $name = $this->faker()->company();
    $this->actingAs($this->superAdmin)
        ->post(route('schools.store'), [
            'school_id' => '',
            'pic_name' => "PIC $name",
            'pic_email' => str($name)->slug() . "@gmail.com"
        ])->assertInvalid(['name' => 'required']);
});

it('requires the PIC name', function () {
    $name = $this->faker()->company();
    $this->actingAs($this->superAdmin)
        ->post(route('schools.store'), [
            'school_id' => '',
            'name' => $name,
            'pic_email' => str($name)->slug() . "@gmail.com"
        ])->assertInvalid(['pic_name' => 'required']);
});

it('requires the PIC email', function () {
    $name = $this->faker()->company();
    $this->actingAs($this->superAdmin)
        ->post(route('schools.store'), [
            'school_id' => '',
            'name' => $name,
            'pic_name' => "PIC $name",
        ])->assertInvalid(['pic_email' => 'required']);
});

it('can create new Yayasan', function () {
    $name = $this->faker()->company();
    $this->actingAs($this->superAdmin)
        ->post(route('schools.store'), [
            'school_id' => '',
            'name' => $name,
            'pic_name' => "PIC $name",
            'pic_email' => str($name)->slug() . "@gmail.com"
        ])
        ->assertRedirect(route('schools.index'));

    $this->assertDatabaseHas('schools', [
        'name' => $name
    ]);

    $user = User::firstWhere([
        'email' => str($name)->slug() . "@gmail.com"
    ]);
    expect($user->hasRole(User::ROLE_ADMIN_YAYASAN))->toBeTrue();
});

it('can create new School', function () {
    $yayasan = School::factory()->create();
    $name = $this->faker()->company();
    $this->actingAs($this->superAdmin)
        ->post(route('schools.store'), [
            'school_id' => $yayasan->getKey(),
            'name' => $name,
            'pic_name' => "PIC $name",
            'pic_email' => str($name)->slug() . "@gmail.com"
        ])
        ->assertRedirect(route('schools.index'));

    $this->assertDatabaseHas('schools', [
        'name' => $name
    ]);

    $user = User::firstWhere([
        'email' => str($name)->slug() . "@gmail.com"
    ]);
    expect($user->hasRole(User::ROLE_ADMIN_SEKOLAH))->toBeTrue();
});

it('can render School index page as Sempoa Staff', function (User $user) {
    $response = $this
        ->actingAs($user)
        ->get(route('schools.index'));

    $response->assertOk();
})->with('sempoa_staff');

it('can render School edit page as Sempoa Staff', function (User $user) {
    $school = School::factory()->create();
    $_user = User::factory()->create([
        'school_id' => $school->getKey()
    ]);
    $_staff = Staff::factory()->create([
        'school_id' => $school->getKey(),
        'user_id' => $_user->getKey()
    ]);
    $school->staff_id = $_staff->getKey();
    $school->save();

    $response = $this
        ->actingAs($user)
        ->get(route('schools.edit', $school->getKey()));

    $response->assertOk();
})->with('sempoa_staff');

it('can edit school', function (User $user) {
    $school = School::factory()->create();
    $_user = User::factory()->create([
        'school_id' => $school->getKey()
    ]);
    $_staff = Staff::factory()->create([
        'school_id' => $school->getKey(),
        'user_id' => $_user->getKey()
    ]);
    $school->staff_id = $_staff->getKey();
    $school->save();

    $name = "Yayasan Edited";

    $this->actingAs($user)
        ->put(route('schools.update', $school->getKey()), [
            'name' => $name
        ])->assertRedirect(route('schools.index'));

    $this->assertDatabaseHas('schools', [
        'name' => $name
    ]);
})->with('sempoa_staff');

it('can delete School as Super Admin', function () {
    $school = School::factory()->create();

    $this->actingAs($this->superAdmin)
        ->delete(route('schools.destroy', $school->getKey()))
        ->assertOk();

    $this->assertSoftDeleted($school);
});

it('can not render School create page as Ops Admin', function (User $user) {
    $response = $this
        ->actingAs($user)
        ->get(route('schools.create'));

    $response->assertNotFound();
})->with([
    User::ROLE_OPS_ADMIN => [fn () => $this->opsAdmin]
]);

it('can not render School create page as School Staff', function (User $user) {
    $response = $this
        ->actingAs($user)
        ->get(route('schools.create'));

    $response->assertNotFound();
})->with('school_staff');

it('can not render School index page as School Staff', function (User $user) {
    $response = $this
        ->actingAs($user)
        ->get(route('schools.index'));

    $response->assertNotFound();
})->with('school_staff');

it('can not render School edit page as School Staff', function (User $user) {
    $school = School::factory()->create();
    $_user = User::factory()->create([
        'school_id' => $school->getKey()
    ]);
    $_staff = Staff::factory()->create([
        'school_id' => $school->getKey(),
        'user_id' => $_user->getKey()
    ]);
    $school->staff_id = $_staff->getKey();
    $school->save();

    $response = $this
        ->actingAs($user)
        ->get(route('schools.edit', $school->getKey()));

    $response->assertNotFound();
})->with('school_staff');

it('can not delete School as Ops Admin', function () {
    $school = School::factory()->create();

    $response = $this->actingAs($this->opsAdmin)
        ->delete(route('schools.destroy', $school->getKey()));

    $response->assertNotFound();
});

it('can not delete School as School staff', function (User $user) {
    $school = School::factory()->create();

    $response = $this->actingAs($user)
        ->delete(route('schools.destroy', $school->getKey()));

    $response->assertNotFound();
})->with('school_staff');

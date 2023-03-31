<?php

use App\Models\AcademicYear;
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

/**
 * DATASET
 */
dataset('staff_can_crud', [
    User::ROLE_SUPER_ADMIN => [fn () => $this->superAdmin],
    User::ROLE_OPS_ADMIN => [fn () => $this->opsAdmin],
    User::ROLE_BENDAHARA => [fn () => $this->bendahara]
]);

dataset('staff_only_read', [
    User::ROLE_SUPER_ADMIN => [fn () => $this->superAdmin],
    User::ROLE_OPS_ADMIN => [fn () => $this->opsAdmin],
    User::ROLE_BENDAHARA => [fn () => $this->bendahara],
    User::ROLE_ADMIN_YAYASAN => [fn () => $this->adminYayasan],
    User::ROLE_ADMIN_SEKOLAH => [fn () => $this->adminSekolah],
    User::ROLE_KEPALA_SEKOLAH => [fn () => $this->kepalaSekolah],
]);

dataset('staff_cannot_crud', [
    User::ROLE_TATA_USAHA => [fn () => $this->tataUsaha],
    User::ROLE_ADMIN_YAYASAN => [fn () => $this->adminYayasan],
    User::ROLE_ADMIN_SEKOLAH => [fn () => $this->adminSekolah],
    User::ROLE_KEPALA_SEKOLAH => [fn () => $this->kepalaSekolah],

]);
/**
 * END DATASET
 */


/**
 * OUTSIDE CRUD
 */
it('forbid guest to view Tuition Type page', function () {
    $this
        ->get(route('tuition-type.index'))
        ->assertNotFound();
});


/**
 * CREATE RENDER PAGE
 */
it('can render Tuition Type create page as ', function (User $user) {
    $response = $this
        ->actingAs($user)
        ->get(route('tuition-type.create'));

    $response->assertOk();
})->with('staff_can_crud');



/**
 * CREATE VALIDATION
 */

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
})->with('staff_can_crud');

/**
 * CREATE
 */
it('can render Tuition Type create data post  as ', function (User $user) {
    $school = School::factory()->create();
    $unique = fake()->unique()->word();
    $name = $unique;
    $this->actingAs($user)
        ->post(route('tuition-type.store'), [
            'school_id' => $school->id,
            'name' => $name,
        ])->assertRedirect(route('tuition-type.index'));
    $this->assertDatabaseHas('tuition_types', [
        'school_id' => $school->id,
        'name' => $name
    ]);
})->with('staff_can_crud');


/**
 * Read
 *
 */

it('can render Tuition Type index Datatable page as ', function (User $user) {
    $response = $this
        ->actingAs($user)
        ->get(route('datatable.tuition-type'));

    $response->assertOk();
})->with('staff_only_read');

it('can render Tuition Type page index page as ', function (User $user) {
    $response = $this
        ->actingAs($user)
        ->get(route('tuition-type.index'));

    $response->assertOk();
})->with('staff_only_read');



/**
 * UPDATE RENDER
 */

it('can render page edit Tuition Type  as ', function (User $user) {
    $tuitionType = TuitionType::factory()->create();
    session(['school_id' => $tuitionType->school_id]);
    $this->actingAs($user)
        ->get(route('tuition-type.edit', ['tuition_type' => $tuitionType->id]))->assertOk();
})->with('staff_can_crud');

/**
 * UPDATE VALIDATION
 */

it('can render Tuition Type update invalid required school_id and name as ', function (User $user) {
    $tuitionType = TuitionType::factory()->create();
    session(['school_id' => $tuitionType->school_id]);
    $this->actingAs($user)
        ->put(route('tuition-type.update', ['tuition_type' => $tuitionType->id]), [
            'school_id' => '',
            'name' => '',
        ])
        ->assertInvalid([
            'school_id' => 'required',
            'name' => 'required'
        ]);
})->with('staff_can_crud');


/**
 * UPDATE
 */

it('can render Tuition Type update data  as ', function (User $user) {
    $tuitionType = TuitionType::factory()->create();
    session(['school_id' => $tuitionType->school_id]);
    $year = fake()->year('-10 years');
    $yearAcademy = $year . "-" . $year + 1;
    $this->actingAs($user)
        ->put(route('tuition-type.update', ['tuition_type' => $tuitionType->id]), [
            'school_id' => $tuitionType->school_id,
            'name' => $yearAcademy,
        ])
        ->assertRedirect(route('tuition-type.index'));
    $this->assertDatabaseHas('tuition_types', ['name' => $yearAcademy]);
})->with('staff_can_crud');

/**
 * DELETE
 */
it('can render Tuition Type delete data  as ', function (User $user) {
    $tuitionType = TuitionType::factory()->create();
    session(['school_id' => $tuitionType->school_id]);
    $this->actingAs($user)
        ->delete(route('tuition-type.destroy', ['tuition_type' => $tuitionType->id]))
        ->assertOk();
})->with('staff_can_crud');


/**
 * NEGATIVE CRUD
 */

it("can't render Tuition Type create page as ", function (User $user) {
    $response = $this
        ->actingAs($user)
        ->get(route('tuition-type.create'));

    $response->assertNotFound();
})->with('staff_cannot_crud');


it("can't render Tuition Type Edit page as ", function (User $user) {
    $tuitionType = TuitionType::factory()->create();
    $response = $this
        ->actingAs($user)
        ->get(route('tuition-type.edit', $tuitionType->getKey()));
    $response->assertNotFound();
})->with('staff_cannot_crud');

it("can't render Tuition Type store  as ", function (User $user) {
    $school = School::factory()->create();
    $this->actingAs($user)
        ->post(route('tuition-type.store'), [
            'school_id' => $school->id,
            'name' => fake()->name(),
        ])->assertNotFound();
})->with('staff_cannot_crud');

it("can't render Tuition Type update  page as ", function (User $user) {
    $tuitionType = AcademicYear::factory()->create();
    $name = $this->faker()->name();
    $this->actingAs($user)
        ->put(route('tuition-type.update', $tuitionType->getKey()), [
            'school_id' => $tuitionType->school_id,
            'name' => $name,
        ])->assertNotFound();
})->with('staff_cannot_crud');

it("can't render Tuition Type delete data  as ", function (User $user) {
    $tuitionType = TuitionType::factory()->create();
    $this->actingAs($user)
        ->delete(route('tuition-type.destroy', ['tuition_type' => $tuitionType->id]))
        ->assertNotFound();
})->with('staff_cannot_crud');

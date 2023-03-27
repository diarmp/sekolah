<?php

use App\Models\Grade;
use App\Models\School;
use App\Models\Classroom;
use App\Models\AcademicYear;
use Faker\Factory as FakerFactory;

it('can create Classroom', function () {
    
    $school = School::factory()->create();
    $academicYear = AcademicYear::factory()->create(['school_id' => $school->id]);
    $grade = Grade::factory()->create(['school_id' => $school->id]);
        
    $classroom = $school->classrooms()->create([
        'school_id' => $school->id,
        'academic_year_id' => $academicYear->id,
        'grade_id' => $grade->id
    ]);

    $this->assertDatabaseHas('classrooms', [
        'id' => $classroom->id,
        'school_id' => $school->id,
        'academic_year_id' => $academicYear->id,
        'grade_id' => $grade->id,
        'name' => $classroom->name
    ]);
});

it('can update Classroom', function () {
    $faker = FakerFactory::create();
    
    $school = School::factory()->create();
    $academicYear = AcademicYear::factory()->create(['school_id' => $school->id]);
    $grade = Grade::factory()->create(['school_id' => $school->id]);
    
    $classroom = $school->classrooms()->create([
        'school_id' => $school->id,
        'academic_year_id' => $academicYear->id,
        'grade_id' => $grade->id,
    ]);
    
    $newClassroom = $faker->randomElement(['1A', '2E', '3B', '4C', '5D']);

    $classroom = $school->classrooms()->update([
        'name' => $newClassroom
    ]);

    $this->assertDatabaseHas('classrooms', [
        'school_id' => $school->id,
        'academic_year_id' => $academicYear->id,
        'grade_id' => $grade->id,
        'name' => $newClassroom
    ]);
});

it('can delete Classroom', function () {
    $faker = FakerFactory::create();
    
    $school = School::factory()->create();
    $academicYear = AcademicYear::factory()->create(['school_id' => $school->id]);
    $grade = Grade::factory()->create(['school_id' => $school->id]);


    $classroom = $school->classrooms()->create([
        'school_id' => $school->id,
        'academic_year_id' => $academicYear->id,
        'grade_id' => $grade->id,
        'name' => $faker->randomElement(['1A', '2E', '3B', '4C', '5D'])
    ]);

    $classroom->delete();

    $this->assertSoftDeleted('classrooms', [
        'id' => $classroom->id
    ]);
});


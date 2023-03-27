<?php

use App\Models\Grade;
use App\Models\School;
use App\Models\AcademicYear;
use Illuminate\Foundation\Testing\WithFaker;


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
    
    $school = School::factory()->create();
    $academicYear = AcademicYear::factory()->create(['school_id' => $school->id]);
    $grade = Grade::factory()->create(['school_id' => $school->id]);
        
    $newClassroom = $this->faker->randomElements(['1B', '2C', '3A', '4E', '5D']);

    $classroom = $school->classrooms()->update([
        'school_id' => $school->id,
        'academic_year_id' => $academicYear->id,
        'grade_id' => $grade->id,
        'name' => $newClassroom
    ]);

    $this->assertDatabaseHas('classrooms', [
        'id' => $classroom->id,
        'school_id' => $school->id,
        'academic_year_id' => $academicYear->id,
        'grade_id' => $grade->id,
        'name' => $newClassroom
    ]);
});

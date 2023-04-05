<?php

namespace Tests\Unit;

use App\Models\Grade;
use App\Models\School;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class GradeTest extends TestCase
{
    
    use RefreshDatabase, WithFaker;

    public function test_Grade_Create(): void
    {

        $school = School::factory()->create();
        
        $grade = $school->grades()->create([
            'school_id' => $school->id,
            'name' => $this->faker->numberBetween(1, 12)
        ]);

        $this->assertDatabaseHas('grades', [
            'id' => $grade->id,
            'school_id' => $school->id,
            'name' => $grade->name
        ]);
    }
    
    public function test_Grade_Update(): void
    {

        $school = School::factory()->create();
        
        $grade = $school->grades()->create([
            'school_id' => $school->id,
            'name' => $this->faker->numberBetween(1, 12)
        ]);

        $newGrade = $this->faker->numberBetween(1, 12);
        
        $grade = $school->grades()->update([
            'name' => $newGrade
        ]);

        $this->assertDatabaseHas('grades', [
            'school_id' => $school->id,
            'name' => $newGrade
        ]);
    }

    public function test_Grade_Delete(): void
    {

        $school = School::factory()->create();
        
        $grade = $school->grades()->create([
            'school_id' => $school->id,
            'name' => $this->faker->numberBetween(1, 12)
        ]);
        
        $grade->delete();

        $this->assertSoftDeleted('grades', [
            'id' => $grade->id,
            'school_id' => $school->id,
            'name' => $grade->name
        ]);
    }
}

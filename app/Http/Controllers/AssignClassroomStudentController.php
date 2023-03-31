<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;

class AssignClassroomStudentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data['title'] = "Tetapkan Kelas";
        $data['grades'] = Grade::all();
        $data['academic_years'] = AcademicYear::all();
        $data['students'] = Student::where('status', Student::STATUS_ACTIVE)->get();
        return view('pages.assign-classroom.index', $data);
    }
}

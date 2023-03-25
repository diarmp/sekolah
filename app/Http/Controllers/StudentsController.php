<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentsRequest;
use App\Models\AcademicYear;
use App\Models\Student;
use App\Models\StudentTuition;
use App\Models\TuitionType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => "Murid"
        ];

        return view('pages.students.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {     
        $data = [
            'academic_years' => AcademicYear::where('school_id', Auth::user()->school_id)->orderByDesc('created_at')->get(),
            'tuition_types' => TuitionType::where('school_id', Auth::user()->school_id)->get(),
            'title' => "Tambah Murid",
        ];

        return view('pages.students.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentsRequest $request)
    {
        try {
            DB::beginTransaction();
            
            // Save Student
                $student                            = new Student;
                $student->school_id                 = $request->school_id ?? Auth::user()->school_id;
                $student->academic_year_id          = $request->academic_year_id;

                $student->name                      = $request->name;
                $student->gender                    = $request->gender;
                $student->address                   = $request->address;
                $student->dob                       = $request->dob;
                $student->religion                  = $request->religion;
                $student->phone_number              = $request->phone_number;
                $student->nik                       = $request->nik;
                $student->nis                       = $request->nis ?? null;
                $student->nisn                      = $request->nisn ?? null;
                $student->father_name               = $request->father_name;
                $student->father_dob                = $request->father_dob;
                $student->father_work               = $request->father_work;
                $student->father_education          = $request->father_education;
                $student->father_income             = $request->father_income;
                $student->mother_name               = $request->mother_name;
                $student->mother_dob                = $request->mother_dob;
                $student->mother_work               = $request->mother_work;
                $student->mother_education          = $request->mother_education;
                $student->mother_income             = $request->mother_income;
                $student->guardian_name             = $request->guardian_name;
                $student->guardian_dob              = $request->guardian_dob;
                $student->guardian_work             = $request->guardian_work;
                $student->guardian_education        = $request->guardian_education;
                $student->guardian_income           = $request->guardian_income;
                $student->save();
            // End Save Student

            // Save User
                $user               = new User;
                $user->school_id    = $request->school_id ?? Auth::user()->school_id;
                $user->name         = $student->name;
                $user->email        = Str::slug($student->name, '-').'@gmail.com';
                $user->password     = bcrypt('password');
                $user->save();
            // End Save User

            // update Student's user_id
                $student->user_id = $user->id;
                $student->save();
            // End update Student's user_id

            // If Has Unique Tuitions
                if ($request->has('tuitions')) {
                    foreach ($request->tuitions as $key => $value) {
                        if ($value) {
                            $studentTuitions = new StudentTuition;

                            $studentTuitions->school_id = $request->school_id ?? Auth::user()->school_id;
                            $studentTuitions->student_id = $student->id;

                            $studentTuitions->tuition_type_id = $key;
                            $studentTuitions->price = $value > 0 ? $value : 0 ;
                            $studentTuitions->save();
                        }
                    };
                };
            // End If Has Unique Tuitions

            DB::commit();

            return redirect()->route('students.index')->withToastSuccess('Berhasil menambahkan data murid!');
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            return redirect()->back()->withInput()->withToastError('Ops, ada kesalahan saat menambahkan data murid!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        try {
            $student->status = Student::STATUS_INACTIVE;
            $student->save();
            $student->delete();

            return response()->json([
                'msg' => 'Berhasil menghapus data murid!'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'msg' => 'Gagal menghapus data murid!'
            ], 400);
        }
    }
}

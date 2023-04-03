<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentsRequest;
use App\Imports\StudentsImport;
use App\Models\AcademicYear;
use App\Models\Student;
use App\Models\StudentTuition;
use App\Models\TuitionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Excel;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => "Siswa"
        ];

        return view('pages.students.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'academic_years' => AcademicYear::where('school_id', session('school_id'))->orderByDesc('created_at')->get(),
            'tuition_types' => TuitionType::where('school_id', session('school_id'))->get(),
            'title' => "Tambah Siswa",
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
                $student->school_id                 = session('school_id');
                $student->academic_year_id          = $request->academic_year_id;

                $student->name                      = $request->name;
                $student->email                     = $request->email;
                $student->gender                    = $request->gender;
                $student->address                   = $request->address;
                $student->dob                       = $request->dob;
                $student->religion                  = $request->religion;
                $student->phone_number              = $request->phone_number;
                $student->family_card_number        = $request->family_card_number;
                $student->nik                       = $request->nik;
                $student->nis                       = $request->nis;
                $student->nisn                      = $request->nisn;

                $student->father_name               = $request->father_name;
                $student->father_work               = $request->father_work;
                $student->father_phone_number       = $request->father_phone_number;
                $student->father_address            = $request->father_address;

                $student->mother_name               = $request->mother_name;
                $student->mother_work               = $request->mother_work;
                $student->mother_phone_number       = $request->mother_phone_number;
                $student->mother_address            = $request->mother_address;

                $student->guardian_name             = $request->guardian_name;
                $student->guardian_work             = $request->guardian_work;
                $student->guardian_phone_number     = $request->guardian_phone_number;
                $student->guardian_address          = $request->guardian_address;

                $student->save();
            // End Save Student

            // If Has Unique Tuitions
                if ($request->has('tuitions')) {
                    foreach ($request->tuitions as $key => $value) {
                        if ($value) {
                            $studentTuitions = new StudentTuition;

                            $studentTuitions->school_id = session('school_id');
                            $studentTuitions->student_id = $student->id;

                            $studentTuitions->tuition_type_id = $key;
                            $studentTuitions->price = $value > 0 ? $value : 0;
                            $studentTuitions->note = $value->note ?? null;
                            
                            $studentTuitions->save();
                        }
                    };
                };
            // End If Has Unique Tuitions

            DB::commit();

            return redirect()->route('students.index')->withToastSuccess('Berhasil menambahkan data siswa!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->withToastError('Ops, ada kesalahan saat menambahkan data siswa!');
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
    public function edit(Student $student)
    {
        $studentTuitions = StudentTuition::with('tuition_type')
                                            ->where('school_id', session('school_id'))
                                            ->where('student_id', $student->id)
                                            ->get();

        $tuitions = collect(TuitionType::where('school_id', session('school_id'))->get())
                    ->reject(function($tuitions) use($studentTuitions){
                        foreach ($studentTuitions as $studentTuition) {
                            if ($tuitions->id == $studentTuition->tuition_type_id) {
                                // Remove if has same id with studentTuition
                                return $tuitions;
                            }
                        }
                    });

        $data = [
            'student' => $student,
            'academic_years' => AcademicYear::where('school_id', session('school_id'))->orderByDesc('created_at')->get(),
            'student_tuitions' => $studentTuitions,
            'tuition_types' => $tuitions,
            'title' => "Ubah Data Siswa",
        ];

        return view('pages.students.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentsRequest $request, Student $student)
    {
        try {
            DB::beginTransaction();
            
            // Update Student
                $student->academic_year_id          = $request->academic_year_id;

                $student->name                      = $request->name;
                $student->email                     = $request->email;
                $student->gender                    = $request->gender;
                $student->address                   = $request->address;
                $student->dob                       = $request->dob;
                $student->religion                  = $request->religion;
                $student->phone_number              = $request->phone_number;
                $student->family_card_number        = $request->family_card_number;
                $student->nik                       = $request->nik;
                $student->nis                       = $request->nis;
                $student->nisn                      = $request->nisn;

                $student->father_name               = $request->father_name;
                $student->father_work               = $request->father_work;
                $student->father_phone_number       = $request->father_phone_number;
                $student->father_address            = $request->father_address;

                $student->mother_name               = $request->mother_name;
                $student->mother_work               = $request->mother_work;
                $student->mother_phone_number       = $request->mother_phone_number;
                $student->mother_address            = $request->mother_address;

                $student->guardian_name             = $request->guardian_name;
                $student->guardian_work             = $request->guardian_work;
                $student->guardian_phone_number     = $request->guardian_phone_number;
                $student->guardian_address          = $request->guardian_address;
                
                $student->save();
            // End Update Student

            // Update Student Tuitions
                if ($request->has('selected_tuitions')) {
                    foreach ($request->selected_tuitions as $key => $value) {

                        // Get Student Tuitions Data
                        $selectedStudentTuition = StudentTuition::findOrFail($key);

                        if ($value > 0) {
                            $selectedStudentTuition->price = $value;
                            $selectedStudentTuition->note = $value->note ?? null;
                            $selectedStudentTuition->save();
                        } else {
                            $selectedStudentTuition->forceDelete();
                        }
                    };
                };
            // Update Student Tuitions

            // If Has New Added Tuitions
                if ($request->has('tuitions')) {
                    foreach ($request->tuitions as $key => $value) {
                        if ($value) {
                            $studentTuition = new StudentTuition;

                            $studentTuition->school_id = session('school_id');
                            $studentTuition->student_id = $student->id;

                            $studentTuition->tuition_type_id = $key;
                            $studentTuition->price = $value > 0 ? $value : 0;
                            $studentTuition->note = $value->note ?? null;
                            $studentTuition->save();
                        }
                    };
                };
            // End If Has New Added Tuitions

            DB::commit();

            return redirect()->route('students.index')->withToastSuccess('Berhasil mengubah data siswa!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->withToastError('Ops, ada kesalahan saat mengubah data siswa!');
        }
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
                'msg' => 'Berhasil menghapus data siswa!'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'msg' => 'Gagal menghapus data siswa!'
            ], 400);
        }
    }

    public function importStudent()
    {
        try {
            $excel = Excel::import(new StudentsImport(1, 1), public_path('excel_import_template/students_import.xlsx'));
            return redirect()->route('students.index')->withToastSuccess('Berhasil mengimpor data siswa!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            if (count($failures) > 0) {
                $row = $failures[0]->row(); // row that went wrong
                $column = $failures[0]->attribute(); // either heading key (if using heading row concern) or column index
                $error = $failures[0]->errors(); // Actual error messages from Laravel validator
                // $value = $failures[0]->values(); // The values of the row that has failed.
                
                return redirect()->route('students.index')->withToastError("Terjadi kesalahan pada Baris $row, Kolom $column, dengan pesan $error[0]");
            }
        } catch (\Throwable $th) {
            return redirect()->route('students.index')->withToastSuccess('Berhasil mengimpor data siswa!');
        }
    }

    public function importStudentByExcel(Request $request)
    {
        try {
            $excel = Excel::import(new StudentsImport(session('school_id'), $request->academic_year_id), $request->file('excel'));
            return redirect()->route('students.index')->withToastSuccess('Berhasil mengimpor data siswa!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            if (count($failures) > 0) {
                $row = $failures[0]->row(); // row that went wrong
                $column = $failures[0]->attribute(); // either heading key (if using heading row concern) or column index
                $error = $failures[0]->errors(); // Actual error messages from Laravel validator
                // $value = $failures[0]->values(); // The values of the row that has failed.
                
                return redirect()->route('students.index')->withToastError("Terjadi kesalahan pada Baris $row, Kolom $column, dengan pesan $error[0]");
            }
        } catch (\Throwable $th) {
            return redirect()->route('students.index')->withToastSuccess('Berhasil mengimpor data siswa!');
        }
    }
}

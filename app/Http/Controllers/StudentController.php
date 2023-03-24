<?php

namespace App\Http\Controllers;

use App\Http\Requests\Students\StudentCreateRequest;
use App\Models\Student;
use Illuminate\Http\Request;

use Yajra\DataTables\DataTables;

class StudentController extends Controller
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
            'title' => "Tambah Murid"
        ];

        return view('pages.students.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentCreateRequest $request)
    {
        try {
            $student                            = new Student;
            $student->name                      = $request->name;
            $student->gender                    = $request->gender;
            $student->address                   = $request->address;
            $student->dob                       = $request->dob;
            $student->religion                  = $request->religion;
            $student->phone_number              = $request->phone_number;
            $student->nik                       = $request->nik;
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

        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->withToastError('Ops, ada kesalahan saat menambahkan data murid!');
        }

        return redirect()->route('students.index')->withToastSuccess('Berhasil menambahkan data murid!');
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

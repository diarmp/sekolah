<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\School;
use App\Models\Tuition;
use App\Models\TuitionType;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TuitionRequest;

class TuitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $title = "Biaya";
        return view('pages.tuition.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $title = "Tambah Biaya";
        $schools = School::all();
        $tuitionTypes = TuitionType::all();
        $academicYears = AcademicYear::all();
        $grades = Grade::all();
        return view('pages.tuition.create', compact('schools', 'tuitionTypes', 'academicYears', 'grades', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TuitionRequest $request)
    {
        //
        DB::beginTransaction();
        try {
            
            $tuition                    = new Tuition();
            $tuition->school_id         = session('school_id');
            $tuition->tuition_type_id   = $request->tuition_type_id;
            $tuition->academic_year_id  = $request->academic_year_id;
            $tuition->grade_id          = $request->grade_id;
            $tuition->period            = $request->period;
            $tuition->price             = $request->price;
            $tuition->save();

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('tuition.index')->withToastError('Eror Simpan Biaya!');
        }
        
        return redirect()->route('tuition.index')->withToastSuccess('Berhasil Simpan Biaya!');
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
    public function edit(Tuition $tuition)
    {
        $title = 'Ubah Biaya';
        $schools = School::all();
        $tuitionTypes = TuitionType::all();
        $academicYears = AcademicYear::all();
        $grades = Grade::all();
        return view('pages.tuition.edit', compact('schools', 'tuitionTypes', 'tuition', 'academicYears', 'grades', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TuitionRequest $request, Tuition $tuition)
    {
        //
        DB::beginTransaction();
        try {
            
            $tuition->school_id             = session('school_id');
            $tuition->tuition_type_id       = $request->tuition_type_id;
            $tuition->academic_year_id      = $request->academic_year_id;
            $tuition->grade_id              = $request->grade_id;
            $tuition->period                = $request->period;
            $tuition->price                 = $request->price;
            $tuition->save();

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('tuition.index')->withToastError('Eror Simpan Biaya!');
        }
        
        return redirect()->route('tuition.index')->withToastSuccess('Berhasil Simpan Biaya!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tuition $tuition)
    {
        DB::beginTransaction();
        try {
            
            $tuition->delete();
            DB::commit();

            return response()->json([
                'msg' => 'Berhasil Hapus Biaya!'
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'msg' => 'Eror Hapus Biaya!'
            ]);
        }
    }
}

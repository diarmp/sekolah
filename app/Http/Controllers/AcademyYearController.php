<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\School;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AcademyYearRequest;

class AcademyYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $title = "Tahun Akademik";
        return view('pages.academy-year.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Tambah Tahun Akademik";
        $schools = School::all();
        return view('pages.academy-year.create', compact('schools', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AcademyYearRequest $request)
    {

        DB::beginTransaction();
        try {

            $academyYear            = new AcademicYear();
            $academyYear->school_id = $request->school_id;
            $academyYear->name      = $request->name;
            $academyYear->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('academy-year.index')->withToastError('Ops Gagal Tambah  Tahun Akademik !');
        }

        return redirect()->route('academy-year.index')->withToastSuccess('Tambah Tahun Akademik  Berhasil!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademicYear $academyYear)
    {

        $schools = School::all();
        $title = "Ubah Tahun Akademik";
        return view('pages.academy-year.edit', compact('schools', 'academyYear', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AcademyYearRequest $request, AcademicYear $academyYear)
    {

        DB::beginTransaction();
        try {

            $academyYear->school_id = $request->school_id;
            $academyYear->name      = $request->name;
            $academyYear->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('academy-year.index')->withToastError('Ops Gagal ubah Tahun Akademik !');
        }


        return redirect()->route('academy-year.index')->withToastSuccess('ubah Tahun Akademik  Berhasil!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicYear $academyYear)
    {

        DB::beginTransaction();
        try {

            $academyYear->delete();
            DB::commit();
            return response()->json([
                'msg' => 'Berhasil Hapus Tahun Akademik'
            ], 200);
        } catch (\Throwable $th) {

            DB::rollback();
            return response()->json([
                'msg' => 'Ops Gagal Hapus Tahun Akademik!'
            ], 400);
        }
    }
}

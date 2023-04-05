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
    private $title = "Tahun Akademik";
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $title = "{$this->title}";
        return view('pages.academy-year.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $academyYearStatus = [
            AcademicYear::STATUS_ACTIVE_YEAR => 'Berjalan',
            AcademicYear::STATUS_PPDB_YEAR => 'PPDB'
        ];
        $title = "Tambah {$this->title}";
        return view('pages.academy-year.create', compact('title', 'academyYearStatus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AcademyYearRequest $request)
    {

        DB::beginTransaction();
        try {

            $academyYear               = new AcademicYear();
            $academyYear->school_id    = $request->school_id;
            $academyYear->name         = $request->name;
            $academyYear->status_years = $request->status_years ?? null;
            $academyYear->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('academy-year.index')->withToastError("Ops Gagal Tambah  {$this->title} !");
        }

        return redirect()->route('academy-year.index')->withToastSuccess("Tambah {$this->title}  Berhasil!");
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademicYear $academyYear)
    {
        $title = "Ubah {$this->title}";
        $academyYearStatus = [
            AcademicYear::STATUS_ACTIVE_YEAR => 'Berjalan',
            AcademicYear::STATUS_PPDB_YEAR => 'PPDB'
        ];
        return view('pages.academy-year.edit', compact('academyYear', 'title', 'academyYearStatus'));
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
            $academyYear->status_years = $request->status_years ?? null;
            $academyYear->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('academy-year.index')->withToastError("Ops Gagal ubah {$this->title} !");
        }


        return redirect()->route('academy-year.index')->withToastSuccess("ubah {$this->title}  Berhasil!");
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
                'msg' => "Berhasil Hapus {$this->title}"
            ], 200);
        } catch (\Throwable $th) {

            DB::rollback();
            return response()->json([
                'msg' => "Ops Gagal Hapus {$this->title}!"
            ], 400);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AcademyYearRequest;
use RealRashid\SweetAlert\Facades\Alert;

class AcademyYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $title = "Academic Years";
        return view('pages.academy-year.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create Academic Year";
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
            Alert::toast('Save Academy Years Success ', 'success');
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::toast('Ops Error Save Academy Years', 'error');
        }

        return redirect()->route('academic-years.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademicYear $academic_year)
    {

        $schools = School::all();
        $title = "Edit Academic Year";
        return view('pages.academy-year.edit', compact('schools', 'academic_year', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AcademyYearRequest $request, AcademicYear $academic_year)
    {

        DB::beginTransaction();
        try {

            $academic_year->school_id = $request->school_id;
            $academic_year->name      = $request->name;
            $academic_year->save();

            DB::commit();
            Alert::toast('Save Academy Years Success ', 'success');
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::toast('Ops Error Save Academy Years', 'error');
        }

        return redirect()->route('academic-years.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicYear $academic_year)
    {

        DB::beginTransaction();
        try {

            $academic_year->delete();

            Alert::toast('Delete Academy Years Success ', 'success');
            DB::commit();
        } catch (\Throwable $th) {
            Alert::toast('Ops Error Delete Academy Years', 'error');
            DB::rollback();
        }

        return redirect()->route('academic-years.index');
    }
}

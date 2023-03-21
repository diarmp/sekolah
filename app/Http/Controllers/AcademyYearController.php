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

        return view('pages.academy-year.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schools = School::all();
        return view('pages.academy-year.create', compact('schools'));
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

        return redirect()->route('academy-year.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademicYear $academyYear)
    {

        $schools = School::all();
        return view('pages.academy-year.edit', compact('schools', 'academyYear'));
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
            Alert::toast('Save Academy Years Success ', 'success');
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::toast('Ops Error Save Academy Years', 'error');
        }

        return redirect()->route('academy-year.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicYear $academyYear)
    {

        DB::beginTransaction();
        try {

            $academyYear->delete();

            Alert::toast('Delete Academy Years Success ', 'success');
            DB::commit();
        } catch (\Throwable $th) {
            Alert::toast('Ops Error Delete Academy Years', 'error');
            DB::rollback();
        }

        return redirect()->route('academy-year.index');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\TuitionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TuitionTypeRequest;

class TuitionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $title = "Tuition Types";
        return view('pages.tuition-type.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create Tuition Type";
        $schools = School::all();
        return view('pages.tuition-type.create', compact('schools', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TuitionTypeRequest $request)
    {

        DB::beginTransaction();
        try {

            $tuitionType            = new TuitionType();
            $tuitionType->school_id = $request->school_id;
            $tuitionType->name      = $request->name;
            $tuitionType->generatable = $request->generatable;
            $tuitionType->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('tuition-type.index')->withToastError('Ops Error Save Tuition Type!');
        }

        return redirect()->route('tuition-type.index')->withToastSuccess('Save Tuition Type Success!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TuitionType $tuitionType)
    {

        $schools = School::all();
        $title = "Update Tuition Type";
        return view('pages.tuition-type.edit', compact('schools', 'tuitionType', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TuitionTypeRequest $request, TuitionType $tuitionType)
    {

        DB::beginTransaction();
        try {

            $tuitionType->school_id = $request->school_id;
            $tuitionType->name      = $request->name;
            $tuitionType->generatable = $request->generatable;
            $tuitionType->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('tuition-type.index')->withToastError('Ops Error Save Tuition Type!');
        }


        return redirect()->route('tuition-type.index')->withToastSuccess('Save Tuition Type Success!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TuitionType $tuitionType)
    {

        DB::beginTransaction();
        try {

            $tuitionType->delete();
            DB::commit();
            return response()->json([
                'msg' => 'Success Deleted Tuition Type'
            ], 200);
        } catch (\Throwable $th) {

            DB::rollback();
            return response()->json([
                'msg' => 'Ops Deleted Tuition Type !'
            ], 400);
        }
    }
}

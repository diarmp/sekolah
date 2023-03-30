<?php

namespace App\Http\Controllers;

use App\Models\Tuition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublishTuitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Terbit Biaya';
        $tuitions = Tuition::all();
        return view('pages.publish-tuition.index', compact('title', 'tuitions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            
            foreach ($request->periods as $key => $value) {
                foreach()
            }

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('publish-tuition.index')->withToastError('Eror Terbitkan Biaya!');
        }

        return redirect()->route('publish-tuition.index')->withToastSuccess('Berhasil Terbitkan Biaya!');
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
    public function destroy(string $id)
    {
        //
    }
}

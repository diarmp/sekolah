<?php

namespace App\Http\Controllers;

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
        $students = Student::get();

        $data = [
            'students' => $students
        ];

        return view('pages.students.index', $data);
    }

    public function studentsDatatable(Request $request)
    {
        // if ($request->ajax()) {
        //     // $query = Student::get();
        //     // return DataTables::of($query)
        //     //     ->addIndexColumn()
        //     //     ->addColumn('action', function($row){
        //     //         $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
        //     //         return $actionBtn;
        //     //     })
        //     //     ->rawColumns(['action'])
        //     //     ->make(true);

        //     $query = Student::get();
 
        //     return DataTables::eloquent($query)
        //                 ->addColumn('intro', 'Hi {{$name}}!')
        //                 ->make(true);
        // }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $data = [
            // 'students' => $students
        ];

        return view('pages.students.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

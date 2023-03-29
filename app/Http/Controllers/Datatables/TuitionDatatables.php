<?php

namespace App\Http\Controllers\Datatables;

use App\Models\Tuition;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class TuitionDatatables extends Controller
{
    //

    public function index()
    {
        $tuition = Tuition::with('school', 'tuition_type', 'academic_year', 'grade');
        return DataTables::of($tuition)
            ->editColumn('tuition_type', function ($row) {
                return $row->tuition_type ? $row->tuition_type->name : '-' ; 
            })
            ->editColumn('academic_year', function ($row) {
                return $row->academic_year ? $row->academic_year->name : '-' ;
            })
            ->editColumn('grade', function ($row) {
                return $row->grade ? $row->grade->name : '-' ;
            })
            ->editColumn('price', function ($row) {
                return 'Rp. ' . number_format($row->price, 0, ',', '.');
            })
            ->addColumn('action', function (Tuition $row) {
                $data = [
                    'edit_url'     => route('tuition.edit', ['tuition' => $row->id]),
                    'delete_url'   => route('tuition.destroy', ['tuition' => $row->id]),
                    'redirect_url' => route('tuition.index')
                ];
                return view('components.datatable-action', $data);
            })->toJson();
    }
}

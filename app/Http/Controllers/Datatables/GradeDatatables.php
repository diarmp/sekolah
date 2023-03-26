<?php

namespace App\Http\Controllers\Datatables;

use App\Models\Grade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class GradeDatatables extends Controller
{
    //
    public function index()
    {
        $grade = Grade::with('school');
        return DataTables::of($grade)
            ->addColumn('action', function (Grade $row) {
                $data = [
                    'edit_url'     => route('grade.edit', ['grade' => $row->id]),
                    'delete_url'   => route('grade.destroy', ['grade' => $row->id]),
                    'redirect_url' => route('grade.index')
                ];
                return view('components.datatable-action', $data);
            })->toJson();
    }
}

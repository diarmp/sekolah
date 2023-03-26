<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SchoolsDatatables extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $academyYear = School::with('parent');
        return DataTables::of($academyYear)
            ->addColumn('action', function (School $row) {
                $data = [
                    'edit_url'     => route('schools.edit', ['school' => $row->id]),
                    'delete_url'   => route('schools.destroy', ['school' => $row->id]),
                    'redirect_url' => route('schools.index')
                ];
                return view('components.datatable-action', $data);
            })
            ->editColumn('type', function ($row) {
                return str($row->type)->title();
            })
            ->editColumn('induk', function ($row) {
                return $row->parent ? $row->parent->name : "-";
            })
            ->toJson();
    }
}

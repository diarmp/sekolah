<?php

namespace App\Http\Controllers\Datatables;

use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class AcademyYearDatatables extends Controller
{
    //
    public function index()
    {
        $academyYear = AcademicYear::with('school');
        return DataTables::of($academyYear)
            ->addColumn('action', function (AcademicYear $row) {
                $data = [
                    'edit_url'     => route('academy-year.edit', ['academy_year' => $row->id]),
                    'delete_url'   => route('academy-year.destroy', ['academy_year' => $row->id]),
                    'redirect_url' => route('academy-year.index')
                ];
                return view('components.datatable-action', $data);
            })->toJson();
    }
}

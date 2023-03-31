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
            ->editColumn('status_years', function ($row) {
                $academyYearStatus = [
                    AcademicYear::STATUS_ACTIVE_YEAR => 'Berjalan',
                    AcademicYear::STATUS_PPDB_YEAR => 'PPDB'
                ];
                return in_array($row->status_years, array_keys($academyYearStatus)) ? $academyYearStatus[$row->status_years] : '-';
            })
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

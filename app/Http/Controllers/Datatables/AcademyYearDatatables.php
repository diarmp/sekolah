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
                return view('pages.academy-year.action', compact('row'));
            })->toJson();
    }
}

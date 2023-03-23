<?php

namespace App\Http\Controllers\Datatables;

use App\Models\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class MasterConfigDatatables extends Controller
{
    //
    public function index()
    {
        $config = Config::all();
        return DataTables::of($config)
            ->addColumn('action', function (Config $row) {
                return view('pages.config.action', compact('row'));
            })->toJson();
    }
}

<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Datatables;




Route::get('academic-years', [App\Http\Controllers\Datatables\AcademyYearDatatables::class, 'index'])->name('academic-years');

<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Datatables;




Route::get('academy-years', [App\Http\Controllers\Datatables\AcademyYearDatatables::class, 'index'])->name('academy-year');

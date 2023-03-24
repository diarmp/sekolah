<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Datatables;
use App\Http\Controllers\Datatables\SchoolsDatatables;
use App\Http\Controllers\Datatables\StudentDatatables;

Route::get('academy-years', [App\Http\Controllers\Datatables\AcademyYearDatatables::class, 'index'])->name('academy-year');
Route::get('schools', SchoolsDatatables::class)->name('schools');
Route::get('grade', [App\Http\Controllers\Datatables\GradeDatatables::class, 'index'])->name('grade');

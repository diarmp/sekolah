<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Datatables;




Route::get('academy-years', [App\Http\Controllers\Datatables\AcademyYearDatatables::class, 'index'])->name('academy-year');
Route::get('tuition-type', [App\Http\Controllers\Datatables\TuitionTypeDatatables::class, 'index'])->name('tuition-type');
Route::get('grade', [App\Http\Controllers\Datatables\GradeDatatables::class, 'index'])->name('grade');

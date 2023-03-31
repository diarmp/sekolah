<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Datatables\StudentDatatables;
use App\Http\Controllers\Datatables\SchoolsDatatables;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('academy-years', [App\Http\Controllers\Datatables\AcademyYearDatatables::class, 'index'])->name('academy-year');

    Route::get('schools', SchoolsDatatables::class)->name('schools');

    Route::get('students', [StudentDatatables::class, 'index'])->name('students');


    Route::get('academic-years', [App\Http\Controllers\Datatables\AcademyYearDatatables::class, 'index'])->name('academic-years');

    Route::get('master-configs', [App\Http\Controllers\Datatables\MasterConfigDatatables::class, 'index'])->name('master-configs');

    Route::get('grade', [App\Http\Controllers\Datatables\GradeDatatables::class, 'index'])->name('grade');
    Route::get('students', [StudentDatatables::class, 'index'])->name('students');

    Route::get('classroom', [App\Http\Controllers\Datatables\ClassroomDatatables::class, 'index'])->name('classroom');

    Route::get('tuition-type', [App\Http\Controllers\Datatables\TuitionTypeDatatables::class, 'index'])->name('tuition-type');
    
    Route::get('tuition', [App\Http\Controllers\Datatables\TuitionDatatables::class, 'index'])->name('tuition');
});




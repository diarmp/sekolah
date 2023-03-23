<?php

use App\Http\Controllers\AcademyYearController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TuitionTypeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GradeController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('pages.home');
})->name('home')->middleware(['auth']);
Route::group([], function () {
    Route::resource("academy-year", AcademyYearController::class)->except(['show']);
    Route::resource("tuition-type", TuitionTypeController::class)->except(['show']);

    // Grade
    Route::resource("grade", GradeController::class)->except(['show']);
});

Route::resource('/students', StudentController::class);
Route::get('/students/datatable', [StudentController::class, 'studentsDatatable'])->name('students.datatable');

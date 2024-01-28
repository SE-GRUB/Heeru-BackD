<?php

use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ReportCategoryController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Doctrine\DBAL\Schema\Index;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('backend.index');
});

//user route
Route::get('/checkuser', [UserController::class, 'checkuser'])->name('user.checkuser');
Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/user', [UserController::class, 'store'])->name('user.store');
Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
Route::delete('/user//{user}/destroy', [UserController::class, 'destroy'])->name('user.destroy');

// Progam route
Route::get('/program', [ProgramController::class, 'index'])->name('program.index');
Route::get('/program/create', [ProgramController::class, 'create'])->name('program.create');
Route::post('/program', [ProgramController::class, 'store'])->name('program.store');
Route::get('/program/{program}/edit', [ProgramController::class, 'edit'])->name('program.edit');
Route::put('/program/{program}/update', [ProgramController::class, 'update'])->name('program.update');
Route::delete('/program/{program}/destroy', [ProgramController::class, 'destroy'])->name('program.destroy');

//Report route
Route::get('/report', [ReportController::class, 'index'])->name('report.index');
Route::get('/report/create', [ReportController::class, 'create'])->name('report.create');
Route::post('/report', [ReportController::class, 'store'])->name('report.store');
Route::get('/report/{report}/edit', [ReportController::class, 'edit'])->name('report.edit');
Route::put('/report/{report}', [ReportController::class, 'update'])->name('report.update');
Route::delete('/report//{report}/destroy', [ReportController::class, 'destroy'])->name('report.destroy');

//Report route categories
Route::get('/reportCategories', [ReportCategoryController::class, 'index'])->name('reportCategories.index');
Route::get('/reportCategories/create', [ReportCategoryController::class, 'create'])->name('reportCategories.create');
Route::post('/reportCategories', [ReportCategoryController::class, 'store'])->name('reportCategories.store');
Route::get('/reportCategories/{reportCategories}/edit', [ReportCategoryController::class, 'edit'])->name('reportCategories.edit');
Route::put('/reportCategories/{reportCategories}/update', [ReportCategoryController::class, 'update'])->name('reportCategories.update');
Route::delete('/reportCategories//{reportCategories}/destroy', [ReportCategoryController::class, 'destroy'])->name('reportCategories.destroy');


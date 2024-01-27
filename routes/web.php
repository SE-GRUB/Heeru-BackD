<?php

use App\Http\Controllers\ProgramController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
Route::get('/user/{user}/editStudent', [UserController::class, 'editStudent'])->name('user.editStudent');
Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
Route::delete('/user/destroy', [UserController::class, 'destroy'])->name('user.destroy');

// Progam route
Route::get('/program', [ProgramController::class, 'index'])->name('program.index');
Route::get('/program/create', [ProgramController::class, 'create'])->name('program.create');
Route::post('/program', [ProgramController::class, 'store'])->name('program.store');
Route::get('/program/{program}/edit', [ProgramController::class, 'edit'])->name('program.edit');
Route::put('/program/{program}/update', [ProgramController::class, 'update'])->name('program.update');
Route::delete('/program/{program}/destroy', [ProgramController::class, 'destroy'])->name('program.destroy');
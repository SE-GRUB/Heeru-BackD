<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\InfographicController;
use App\Http\Controllers\InfographicImageController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ReportCategoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatController;

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
Route::delete('/report/{report}/destroy', [ReportController::class, 'destroy'])->name('report.destroy');

//Report categories route
Route::get('/report_category', [ReportCategoryController::class, 'index'])->name('report_category.index');
Route::get('/report_category/create', [ReportCategoryController::class, 'create'])->name('report_category.create');
Route::post('/report_category', [ReportCategoryController::class, 'store'])->name('report_category.store');
Route::get('/report_category/{report_category}/edit', [ReportCategoryController::class, 'edit'])->name('report_category.edit');
Route::put('/report_category/{report_category}/update', [ReportCategoryController::class, 'update'])->name('report_category.update');
Route::delete('/report_category/{report_category}/destroy', [ReportCategoryController::class, 'destroy'])->name('report_category.destroy');

// Post route
Route::get('/post', [PostController::class, 'index'])->name('post.index');
Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
Route::post('/post', [PostController::class, 'store'])->name('post.store');
Route::get('/post/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
Route::put('/post/{post}/update', [PostController::class, 'update'])->name('post.update');
Route::delete('/post/{post}/destroy', [PostController::class, 'destroy'])->name('post.destroy');

// Post infographic route
Route::get('/infographic', [InfographicController::class, 'index'])->name('infographic.index');
Route::get('/infographic/create', [InfographicController::class, 'create'])->name('infographic.create');
Route::post('/infographic', [InfographicController::class, 'store'])->name('infographic.store');
Route::get('/infographic/{infographic}/edit', [InfographicController::class, 'edit'])->name('infographic.edit');
Route::put('/infographic/{infographic}/update', [InfographicController::class, 'update'])->name('infographic.update');
Route::delete('/infographic/{infographic}/destroy', [InfographicController::class, 'destroy'])->name('infographic.destroy');

// Like route
Route::get('/like', [LikeController::class, 'store'])->name('like.store');
Route::get('/like/{like}/destroy', [LikeController::class, 'destroy'])->name('like.destroy');

// // Infographic image route
// Route::get('/infographic_image', [InfographicImageController::class, 'store'])->name('infographic_image.store');
// Route::get('/infographic_image/{infographic_image}/destroy', [InfographicImageController::class, 'destroy'])->name('infographic_image.destroy');


// for chat route
Route::get('/chat/up', [ChatController::class, 'patup'])->name('chat.save');
Route::get('/chat/get', [ChatController::class, 'patdown'])->name('chat.get');

// custem Agus
Route::get('/infographic/iddel', [InfographicController::class, 'delpo'])->name('infographic.delpo');

// Comment route
Route::get('/comment/{post}/', [CommentController::class, 'index'])->name('comment.index');
Route::get('/comment/{post}/create', [CommentController::class, 'create'])->name('comment.create');
Route::post('/comment/{post}/', [CommentController::class, 'store'])->name('comment.store');
Route::delete('/comment/{comment}/{post}/destroy', [CommentController::class, 'destroy'])->name('comment.destroy');

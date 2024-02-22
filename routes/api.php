<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ReportCategoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/checkuser', [UserController::class, 'checkuser'])->name('user.checkuser');
Route::post('/updateProfile', [UserController::class,'updateProfile'])->name('profile.update');
Route::get('/checkPass', [UserController::class,'checkPass'])->name('pass.check');
Route::get('/categoryName', [ReportCategoryController::class, 'show'])->name('categoryName.show');
Route::post('/makereport', [ReportController::class, 'create_report'])->name('report.makereport');
Route::get('/counselorList', [UserController::class, 'showCounselor'])->name('counselor.show');
Route::get('/postList', [PostController::class, 'showPost'])->name('post.show');



<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentReplyController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\ConsultationResultController;
use App\Http\Controllers\InfographicController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReportCategoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use App\Models\comment_reply;
use App\Models\consultation_result;
use App\Models\infographic;
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
Route::get('/changePass', [UserController::class,'changePasss'])->name('pass.change');
Route::get('/changePassword', [UserController::class,'changePassword'])->name('password.change');
Route::get('/categoryName', [ReportCategoryController::class, 'show'])->name('categoryName.show');
Route::post('/makereport', [ReportController::class, 'create_report'])->name('report.makereport');
Route::get('/riwayatOngoing', [ReportController::class, 'riwayatOngoing'])->name('report.ongoing');
Route::get('/riwayatDone', [ReportController::class, 'riwayatDone'])->name('report.done');
Route::get('/counselorList', [UserController::class, 'showCounselor'])->name('counselor.show');
Route::get('/postList', [PostController::class, 'showPost'])->name('post.show');
Route::get('/counselorShow', [UserController::class, 'showCons'])->name('cons.show');
Route::get('/counSlot', [ConsultationController::class, 'getSche'])->name('couns.sche');
Route::get('/konsulOngoing', [ConsultationController::class, 'konsulOngoing'])->name('couns.ongoing');
Route::get('/konsulDone', [ConsultationController::class, 'konsulDone'])->name('couns.done');
Route::post('/createPost', [PostController::class, 'createPost'])->name('post.createPost');
Route::get('/showInfografis', [InfographicController::class, 'showInfografis'])->name('infografis.showInfografis');
Route::get('/userProfile', [UserController::class, 'getUserProfile'])->name('user.profile');
Route::get('/pponly', [UserController::class, 'getPP'])->name('user.pp');
Route::get('/getResult', [ConsultationController::class, 'getResult'])->name('consultation.result');
Route::post('/createRating', [RatingController::class, 'createRating'])->name('rating.createRating');
Route::get('/createComment', [CommentController::class, 'createComment'])->name('comment.createComment');
Route::get('/createReply', [CommentReplyController::class, 'createReply'])->name('create_reply.createReply');
Route::get('/like', [LikeController::class, 'like'])->name('like.liking');
Route::get('/riwayatDetail', [ReportController::class, 'riwayatDetail'])->name('report.detail');
Route::get('/statusDetail', [StatusController::class, 'showStatus'])->name('status.detail');
Route::get('/showComment', [CommentController::class, 'showComment'])->name('comment.showComment');
Route::get('/showReply', [CommentReplyController::class, 'showReply'])->name('reply.showReply');
Route::get('/checkusername', [UserController::class, 'checkUsername']);
Route::get('/otp', [UserController::class, 'otp'])->name('otp');
Route::get('/tag', [UserController::class, 'tag'])->name('tag');



<?php

use App\Http\Controllers\PaymentMethodController;
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
use App\Http\Controllers\CommentReplyController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\ConsultationResultController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StatusController;
use UniSharp\LaravelFilemanager\Lfm;

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

//Dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/dashboard/view/{program_id}/{report_category}', [DashboardController::class, 'view'])->name('dashboard.view');
Route::get('/dashboard/detail/{report}', [DashboardController::class, 'detail'])->name('dashboard.detail');

//user route

Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/user', [UserController::class, 'store'])->name('user.store');
Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
Route::delete('/user/{user}/destroy', [UserController::class, 'destroy'])->name('user.destroy');



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
Route::delete('/infographic_image/{infographic_image}/destroy', [InfographicImageController::class, 'destroy'])->name('infographic_image.destroy');


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

//Reply route
Route::get('/comment_reply/{comment}/', [CommentReplyController::class, 'index'])->name('comment_reply.index');
Route::get('/comment_reply/{comment}/create', [CommentReplyController::class, 'create'])->name('comment_reply.create');
Route::post('/comment_reply/{comment}/', [CommentReplyController::class, 'store'])->name('comment_reply.store');
Route::delete('/comment_reply/{comment_reply}/{comment}/destroy', [CommentReplyController::class, 'destroy'])->name('comment_reply.destroy');

// Consultation route
Route::get('/consultation', [ConsultationController::class, 'index'])->name('consultation.index');
Route::get('/consultation/create', [ConsultationController::class, 'create'])->name('consultation.create');
Route::post('/consultation', [ConsultationController::class, 'store'])->name('consultation.store');
Route::delete('/consultation/{consultation}/destroy', [ConsultationController::class, 'destroy'])->name('consultation.destroy');

//Consultation note route
Route::get('/consultation_result/{consultation}/', [ConsultationResultController::class, 'index'])->name('consultation_result.index');
Route::get('/consultation_result/{consultation}/create', [ConsultationResultController::class, 'create'])->name('consultation_result.create');
Route::post('/consultation_result/{consultation}/', [ConsultationResultController::class, 'store'])->name('consultation_result.store');
Route::get('/consultation_result/{consultation_result}/{consultation}/edit', [ConsultationResultController::class, 'edit'])->name('consultation_result.edit');
Route::put('/consultation_result/{consultation_result}/{consultation}/update', [ConsultationResultController::class, 'update'])->name('consultation_result.update');
Route::delete('/consultation_result/{consultation_result}/{consultation}/destroy', [ConsultationResultController::class, 'destroy'])->name('consultation_result.destroy');

// Payment method route
Route::get('/payment_method', [PaymentMethodController::class, 'index'])->name('payment_method.index');
Route::get('/payment_method/create', [PaymentMethodController::class, 'create'])->name('payment_method.create');
Route::post('/payment_method', [PaymentMethodController::class, 'store'])->name('payment_method.store');
Route::get('/payment_method/{payment_method}/edit', [PaymentMethodController::class, 'edit'])->name('payment_method.edit');
Route::put('/payment_method/{payment_method}/update', [PaymentMethodController::class, 'update'])->name('payment_method.update');
Route::delete('/payment_method/{payment_method}/destroy', [PaymentMethodController::class, 'destroy'])->name('payment_method.destroy');

// Payment route
Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
Route::get('/payment/{consultation}/create', [PaymentController::class, 'create'])->name('payment.create');
Route::post('/payment/{consultation}/', [PaymentController::class, 'store'])->name('payment.store');
Route::get('/payment/{payment}/edit', [PaymentController::class, 'edit'])->name('payment.edit');
Route::put('/payment/{payment}/update', [PaymentController::class, 'update'])->name('payment.update');
Route::delete('/payment/{payment}/destroy', [PaymentController::class, 'destroy'])->name('payment.destroy');

//Status route
Route::get('/status', [StatusController::class, 'index'])->name('status.index');
Route::get('/status/create', [StatusController::class, 'create'])->name('status.create');
Route::post('/status', [StatusController::class, 'store'])->name('status.store');
Route::get('/status/{status}/edit', [StatusController::class, 'edit'])->name('status.edit');
Route::put('/status/{status}/update', [StatusController::class, 'update'])->name('status.update');
Route::delete('/status/{status}/destroy', [StatusController::class, 'destroy'])->name('status.destroy');

// Update photo profile
Route::get('/updateProfile', [UserController::class, 'drivepoin'])->name('drivepoin');

Route::get('/wd', function () {
    return view('evidence.evidence');
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web']], function () {
    Lfm::routes();
});



//Make Report API
// Route::post('/makereport', [ReportController::class, 'create_report'])->name('report.makereport');
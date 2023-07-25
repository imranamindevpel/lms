<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoogleDriveController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\LoggedInUserController;
use App\Http\Controllers\LogController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('/dashboard', DashboardController::class);
    Route::resource('/lectures', GoogleDriveController::class);
    Route::resource('/users', UserController::class);
    Route::resource('/courses', CourseController::class);
    Route::resource('/quizzes', QuizController::class);
    Route::resource('/logged_in_users', LoggedInUserController::class);
    Route::resource('/logs', LogController::class);
    Route::post('quizzes/handleUpload', [QuizController::class, 'handleUpload'])->name('quizzes.handleUpload');
    Route::post('quizzes/clock_in_out', [QuizController::class, 'clock_in_out'])->name('quizzes.clock_in_out');
    Route::get('/quizzes/{id}/start', [QuizController::class, 'startQuiz'])->name('quizzes.start_quiz');
    Route::post('/get_course_users', [QuizController::class, 'get_course_users'])->name('get_course_users');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

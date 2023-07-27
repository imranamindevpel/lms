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
    Route::get('/lectures/{id}/folder_id', [GoogleDriveController::class, 'getCourseByFolderId'])->name('lectures.folder_id');
    Route::post('quizzes/handleUpload', [QuizController::class, 'handleUpload'])->name('quizzes.handleUpload');
    Route::post('quizzes/submit_quiz', [QuizController::class, 'submit_quiz'])->name('quizzes.submit_quiz');
    Route::get('/quizzes/{id}/start', [QuizController::class, 'startQuiz'])->name('quizzes.start_quiz');
    Route::post('/get_course_users', [QuizController::class, 'get_course_users'])->name('get_course_users');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

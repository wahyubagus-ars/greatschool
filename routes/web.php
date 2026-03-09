<?php

use App\Http\Controllers\Student\BullyingReportController;
use App\Http\Controllers\Student\FacilityReportController;
use App\Http\Controllers\Student\LiteracyController;
use App\Http\Controllers\Student\QuizController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\StudentLoginController;
use Illuminate\Support\Facades\Route;

// Public student routes (only accessible when NOT logged in as student)
Route::middleware('guest:student')->group(function () {
    Route::get('/student/login', [StudentLoginController::class, 'showLoginForm'])->name('student.login');
    Route::post('/student/login', [StudentLoginController::class, 'login'])->name('login');
});

// Student logout (publicly accessible - doesn't require auth)
Route::post('/student/logout', [StudentLoginController::class, 'logout'])->name('student.logout');

// Protected student routes (require auth:student)
Route::middleware('auth:student')->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

    // Bullying Reports
    Route::resource('bullying-reports', BullyingReportController::class)
        ->only(['index', 'create', 'store', 'show']);

    // Facility Reports
    Route::resource('facility-reports', FacilityReportController::class)
        ->only(['index', 'create', 'store', 'show']);

    // Literacy
    Route::get('/literacy', [LiteracyController::class, 'index'])->name('literacy.index');
    Route::get('/literacy/{literacyContent}', [LiteracyController::class, 'show'])->name('literacy.show');
    Route::get('/literacy/redirect', [LiteracyController::class, 'redirect'])->name('literacy.redirect');

    // Quizzes
    Route::resource('quizzes', QuizController::class)->only(['index', 'show']);

    Route::prefix('quizzes')->name('quizzes.')->group(function () {
        Route::post('{quiz}/start', [QuizController::class, 'start'])->name('start');
        Route::get('{quiz}/take', [QuizController::class, 'take'])->name('take');
        Route::post('{quiz}/answer', [QuizController::class, 'storeAnswer'])->name('store-answer');
        Route::post('{quiz}/submit', [QuizController::class, 'submit'])->name('submit');
        Route::get('{quiz}/result', [QuizController::class, 'result'])->name('result');
        Route::post('{quiz}/navigate', [QuizController::class, 'navigate'])->name('navigate'); // Fixed route name
    });
});

<?php

use App\Http\Controllers\Student\BullyingReportController;
use App\Http\Controllers\Student\FacilityReportController;
use App\Http\Controllers\Student\LiteracyController;
use App\Http\Controllers\Student\QuizController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\StudentLoginController;
use Illuminate\Support\Facades\Route;

// Public student login routes
Route::get('/student/login', [StudentLoginController::class, 'showLoginForm'])->name('student.login');
Route::post('/student/login', [StudentLoginController::class, 'login']);
Route::post('/student/logout', [StudentLoginController::class, 'logout'])->name('student.logout');

// Protected student routes
Route::middleware('auth:student')->prefix('student')->name('student.')->group(function () {
    // Dashboard
// Replace the closure route with a proper controller method
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

    // Bullying Reports (only actions students need)
    Route::resource('bullying-reports', BullyingReportController::class)
        ->only(['index', 'create', 'store', 'show']);

    // Facility Reports
    Route::resource('facility-reports', FacilityReportController::class)
        ->only(['index', 'create', 'store', 'show']);

    // Literacy & Quizzes (placeholders)
    Route::get('/literacy', [LiteracyController::class, 'index'])->name('literacy.index');
    Route::get('/literacy/redirect', [LiteracyController::class, 'redirect'])->name('literacy.redirect');

    // Inside the auth:student group
    Route::resource('quizzes', QuizController::class)->only(['index', 'show']);

    // Custom quiz routes
    Route::prefix('quizzes')->name('quizzes.')->group(function () {
        Route::post('{quiz}/start', [QuizController::class, 'start'])->name('start');
        Route::get('{quiz}/take', [QuizController::class, 'take'])->name('take');
        Route::post('{quiz}/answer', [QuizController::class, 'storeAnswer'])->name('store-answer');
        Route::post('{quiz}/submit', [QuizController::class, 'submit'])->name('submit');
        Route::get('{quiz}/result', [QuizController::class, 'result'])->name('result');
    });

    // Literacy viewing with progress tracking
    Route::get('/literacy/{literacyContent}', [LiteracyController::class, 'show'])->name('literacy.show');
    Route::post('quizzes/{quiz}/navigate', [QuizController::class, 'navigate'])->name('quizzes.navigate');
});

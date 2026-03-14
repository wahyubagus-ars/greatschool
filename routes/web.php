<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\BullyingReportManagementController;
use App\Http\Controllers\Admin\FacilityReportManagementController;
use App\Http\Controllers\Admin\LiteracyContentController;
use App\Http\Controllers\Admin\QuizManagementController;
use App\Http\Controllers\Admin\StudentManagementController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\Student\BullyingReportController;
use App\Http\Controllers\Student\FacilityReportController;
use App\Http\Controllers\Student\LiteracyController;
use App\Http\Controllers\Student\QuizController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\StudentLoginController;
use App\Models\BullyingReport;
use App\Models\FacilityReport;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

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


Route::middleware('guest:admin')->group(function () {
    Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
});

Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    Route::prefix('bullying-reports')->name('bullying-reports.')->group(function () {
        Route::get('/', [BullyingReportManagementController::class, 'index'])->name('index');
        Route::get('/{bullyingReport}', [BullyingReportManagementController::class, 'show'])->name('show');
        Route::post('/{bullyingReport}/verify', [BullyingReportManagementController::class, 'verify'])->name('verify');
        Route::post('/{bullyingReport}/reject', [BullyingReportManagementController::class, 'reject'])->name('reject');
    });

    Route::prefix('facility-reports')->name('facility-reports.')->group(function () {
        Route::get('/', [FacilityReportManagementController::class, 'index'])->name('index');
        Route::get('/{facilityReport}', [FacilityReportManagementController::class, 'show'])->name('show');
        Route::post('/{facilityReport}/verify', [FacilityReportManagementController::class, 'verify'])->name('verify');
        Route::post('/{facilityReport}/reject', [FacilityReportManagementController::class, 'reject'])->name('reject');
    });

    Route::prefix('students')->name('students.')->group(function () {
        Route::get('/', [StudentManagementController::class, 'index'])->name('index');
        Route::get('/{student}', [StudentManagementController::class, 'show'])->name('show');
        Route::post('/{student}/reset-password', [StudentManagementController::class, 'resetPassword'])->name('reset-password');
        Route::post('/{student}/add-points', [StudentManagementController::class, 'addPoints'])->name('add-points');
    });

    Route::resource('quizzes', QuizManagementController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::resource('literacy-contents', LiteracyContentController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']);
});


View::composer('layouts.admin', function ($view) {
    $view->with('pendingBullyingReports', BullyingReport::where('status', 'pending')->count());
    $view->with('pendingFacilityReports', FacilityReport::where('status', 'pending')->count());
});

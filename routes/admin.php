<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\LeadController as AdminLeadController;
use App\Http\Controllers\Admin\CounselorController as AdminCounselorController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here are the routes specifically for admin users.
| All routes are protected by 'auth' and 'admin' middleware.
|
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // User Management Routes (Future implementation)
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::get('/create', [AdminUserController::class, 'create'])->name('create');
        Route::post('/', [AdminUserController::class, 'store'])->name('store');
        Route::get('/{user}', [AdminUserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [AdminUserController::class, 'update'])->name('update');
        Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('destroy');
        Route::post('/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('toggle-status');
    });
    
    // Lead Management Routes (Future implementation)
    Route::prefix('leads')->name('leads.')->group(function () {
        Route::get('/', [AdminLeadController::class, 'index'])->name('index');
        Route::get('/{lead}', [AdminLeadController::class, 'show'])->name('show');
        Route::get('/{lead}/edit', [AdminLeadController::class, 'edit'])->name('edit');
        Route::put('/{lead}', [AdminLeadController::class, 'update'])->name('update');
        Route::delete('/{lead}', [AdminLeadController::class, 'destroy'])->name('destroy');
        Route::post('/{lead}/assign', [AdminLeadController::class, 'assignCounselor'])->name('assign');
        Route::post('/bulk-assign', [AdminLeadController::class, 'bulkAssign'])->name('bulk-assign');
        Route::post('/bulk-delete', [AdminLeadController::class, 'bulkDelete'])->name('bulk-delete');
    });
    
    // Counselor Management Routes (Future implementation)
    Route::prefix('counselors')->name('counselors.')->group(function () {
        Route::get('/', [AdminCounselorController::class, 'index'])->name('index');
        Route::get('/create', [AdminCounselorController::class, 'create'])->name('create');
        Route::post('/', [AdminCounselorController::class, 'store'])->name('store');
        Route::get('/{counselor}', [AdminCounselorController::class, 'show'])->name('show');
        Route::get('/{counselor}/edit', [AdminCounselorController::class, 'edit'])->name('edit');
        Route::put('/{counselor}', [AdminCounselorController::class, 'update'])->name('update');
        Route::delete('/{counselor}', [AdminCounselorController::class, 'destroy'])->name('destroy');
        Route::get('/{counselor}/leads', [AdminCounselorController::class, 'leads'])->name('leads');
        Route::post('/{counselor}/toggle-status', [AdminCounselorController::class, 'toggleStatus'])->name('toggle-status');
    });
    
    // Reports Routes (Future implementation)
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [AdminReportController::class, 'index'])->name('index');
        Route::get('/leads', [AdminReportController::class, 'leadsReport'])->name('leads');
        Route::get('/counselors', [AdminReportController::class, 'counselorsReport'])->name('counselors');
        Route::get('/performance', [AdminReportController::class, 'performanceReport'])->name('performance');
        Route::post('/export', [AdminReportController::class, 'export'])->name('export');
    });
    
    // Settings Routes (Future implementation)
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', function () {
            return response()->json(['message' => 'Settings page - Coming soon']);
        })->name('index');
    });
    
});
<?php

use App\Http\Controllers\Counselor\DashboardController as CounselorDashboardController;
use App\Http\Controllers\Counselor\LeadController as CounselorLeadController;
use App\Http\Controllers\Counselor\FollowUpController as CounselorFollowUpController;
use App\Http\Controllers\Counselor\ProfileController as CounselorProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Counselor Routes
|--------------------------------------------------------------------------
|
| Here are the routes specifically for counselor users.
| All routes are protected by 'auth' and 'counselor' middleware.
|
*/

Route::middleware(['auth', 'counselor'])->prefix('counselor')->name('counselor.')->group(function () {
    
    // Counselor Dashboard
    Route::get('/dashboard', [CounselorDashboardController::class, 'index'])->name('dashboard');
    
    // Lead Management Routes (Future implementation)
    Route::prefix('leads')->name('leads.')->group(function () {
        Route::get('/', [CounselorLeadController::class, 'index'])->name('index');
        Route::get('/assigned', [CounselorLeadController::class, 'assigned'])->name('assigned');
        Route::get('/new', [CounselorLeadController::class, 'newLeads'])->name('new');
        Route::get('/contacted', [CounselorLeadController::class, 'contacted'])->name('contacted');
        Route::get('/interested', [CounselorLeadController::class, 'interested'])->name('interested');
        Route::get('/enrolled', [CounselorLeadController::class, 'enrolled'])->name('enrolled');
        Route::get('/{lead}', [CounselorLeadController::class, 'show'])->name('show');
        Route::get('/{lead}/edit', [CounselorLeadController::class, 'edit'])->name('edit');
        Route::put('/{lead}', [CounselorLeadController::class, 'update'])->name('update');
        Route::post('/{lead}/update-status', [CounselorLeadController::class, 'updateStatus'])->name('update-status');
        Route::post('/{lead}/add-note', [CounselorLeadController::class, 'addNote'])->name('add-note');
    });
    
    // Follow-up Management Routes (Future implementation)
    Route::prefix('follow-ups')->name('follow-ups.')->group(function () {
        Route::get('/', [CounselorFollowUpController::class, 'index'])->name('index');
        Route::get('/today', [CounselorFollowUpController::class, 'today'])->name('today');
        Route::get('/overdue', [CounselorFollowUpController::class, 'overdue'])->name('overdue');
        Route::get('/upcoming', [CounselorFollowUpController::class, 'upcoming'])->name('upcoming');
        Route::post('/{lead}/schedule', [CounselorFollowUpController::class, 'schedule'])->name('schedule');
        Route::post('/{lead}/complete', [CounselorFollowUpController::class, 'complete'])->name('complete');
        Route::post('/{lead}/reschedule', [CounselorFollowUpController::class, 'reschedule'])->name('reschedule');
    });
    
    // Personal Stats Routes (Future implementation)
    Route::prefix('stats')->name('stats.')->group(function () {
        Route::get('/', function () {
            return response()->json(['message' => 'Statistics page - Coming soon']);
        })->name('index');
        Route::get('/performance', function () {
            return response()->json(['message' => 'Performance stats - Coming soon']);
        })->name('performance');
        Route::get('/leads-summary', function () {
            return response()->json(['message' => 'Leads summary - Coming soon']);
        })->name('leads-summary');
    });
    
    // Profile Management Routes (Future implementation)
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [CounselorProfileController::class, 'show'])->name('show');
        Route::get('/edit', [CounselorProfileController::class, 'edit'])->name('edit');
        Route::put('/', [CounselorProfileController::class, 'update'])->name('update');
        Route::post('/change-password', [CounselorProfileController::class, 'changePassword'])->name('change-password');
    });
    
});
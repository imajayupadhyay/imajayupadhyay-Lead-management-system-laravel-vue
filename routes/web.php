<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

// Public Enquiry Form Routes (No Authentication Required)
Route::get('/', [PublicController::class, 'index'])->name('enquiry.form');
Route::post('/enquiry', [PublicController::class, 'store'])->name('enquiry.store');
Route::get('/thank-you', [PublicController::class, 'success'])->name('enquiry.success');

// Main Dashboard Route with Role-based Redirection
Route::get('/dashboard', function () {
    // Check if user is authenticated as counselor
    if (auth()->guard('counselor')->check()) {
        return redirect()->route('counselor.dashboard');
    }

    // Check if user is authenticated as admin
    if (auth()->guard('web')->check()) {
        $user = auth()->guard('web')->user();

        // Redirect based on user role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
    }

    // Not authenticated or invalid role
    return redirect()->route('login')->with('error', 'Please login to continue.');
})->name('dashboard');

// Profile Routes (Common for both admin and counselor)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Custom login redirection
// Route::post('/login', [AuthenticatedSessionController::class, 'store'])
//     ->middleware('guest')
//     ->name('login.store');

// Authentication Routes
require __DIR__.'/auth.php';

// Include role-specific route files
require __DIR__.'/admin.php';
require __DIR__.'/counselor.php';
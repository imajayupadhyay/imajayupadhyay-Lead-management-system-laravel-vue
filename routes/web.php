<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public Enquiry Form Routes (No Authentication Required)
Route::get('/', [PublicController::class, 'index'])->name('enquiry.form');
Route::post('/enquiry', [PublicController::class, 'store'])->name('enquiry.store');
Route::get('/thank-you', [PublicController::class, 'success'])->name('enquiry.success');

// Authenticated Routes
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
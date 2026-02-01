<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KeuzedeelController;
use App\Http\Controllers\Admin\AdminController;

// Home page - shows welcome for guests, redirects for authenticated users
Route::get('/', [HomeController::class, 'index'])->name('home');

// Keuzedeel routes (require authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/keuzedelen', [KeuzedeelController::class, 'index'])->name('keuzedelen.index');
    Route::get('/keuzedelen/{keuzedeel}', [KeuzedeelController::class, 'show'])->name('keuzedelen.show');
    Route::post('/keuzedelen/{keuzedeel}/enroll', [KeuzedeelController::class, 'enroll'])->name('keuzedelen.enroll');
    Route::post('/keuzedelen/{keuzdeel}/cancel', [KeuzedeelController::class, 'cancel'])->name('keuzedelen.cancel');
});

// Admin routes (require authentication and admin role)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    Route::post('/delete-all-keuzedelen', [AdminController::class, 'deleteAllKeuzedelen'])->name('delete-all-keuzedelen');
});

// SLB routes (require authentication and slber role)
Route::middleware(['auth', 'role:slber'])->prefix('slb')->name('slb.')->group(function () {
    Route::get('/dashboard', function () {
        return view('slb.dashboard');
    })->name('dashboard');
});

// Authentication routes
Auth::routes();

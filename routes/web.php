<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KeuzedeelController;
use App\Http\Controllers\Admin\AdminController;

// Home page - shows welcome for guests, redirects for authenticated users
Route::get('/', [HomeController::class, 'index'])->name('home');

// Handle GET logout requests gracefully
Route::get('/logout', function() {
    return redirect('/')->with('info', 'Please use the logout button to log out safely.');
});

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/keuzedelen', [KeuzedeelController::class, 'index'])->name('keuzedelen.index');
    Route::get('/keuzedelen/{keuzedeel}', [KeuzedeelController::class, 'show'])->name('keuzedelen.show');
    Route::post('/keuzedelen/{keuzedeel}/enroll', [KeuzedeelController::class, 'enroll'])->name('keuzedelen.enroll');
    Route::post('/keuzedelen/{keuzedeel}/cancel', [KeuzedeelController::class, 'cancel'])->name('keuzedelen.cancel');
});

// Admin routes (require authentication and admin role)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Keuzedelen management
    Route::get('/keuzedelen', [AdminController::class, 'keuzedelenIndex'])->name('keuzedelen.index');
    Route::get('/keuzedelen/create', [AdminController::class, 'keuzedelenCreate'])->name('keuzedelen.create');
    Route::post('/keuzedelen', [AdminController::class, 'keuzedelenStore'])->name('keuzedelen.store');
    Route::get('/keuzedelen/{keuzedeel}/edit', [AdminController::class, 'keuzedelenEdit'])->name('keuzedelen.edit');
    Route::put('/keuzedelen/{keuzedeel}', [AdminController::class, 'keuzedelenUpdate'])->name('keuzedelen.update');
    Route::post('/keuzedelen/{keuzedeel}/toggle-status', [AdminController::class, 'toggleKeuzedeelStatus'])->name('keuzedelen.toggle-status');
    Route::delete('/keuzedelen/{keuzedeel}', [AdminController::class, 'keuzedelenDestroy'])->name('keuzedelen.destroy');
    
    // Periods management
    Route::get('/periods', [AdminController::class, 'periodsIndex'])->name('periods.index');
    Route::get('/periods/create', [AdminController::class, 'periodsCreate'])->name('periods.create');
    Route::post('/periods', [AdminController::class, 'periodsStore'])->name('periods.store');
    Route::get('/periods/{period}/edit', [AdminController::class, 'periodsEdit'])->name('periods.edit');
    Route::put('/periods/{period}', [AdminController::class, 'periodsUpdate'])->name('periods.update');
    Route::post('/periods/{period}/toggle-enrollment', [AdminController::class, 'toggleEnrollmentStatus'])->name('periods.toggle-enrollment');
    Route::delete('/periods/{period}', [AdminController::class, 'periodsDestroy'])->name('periods.destroy');
    
    // Users management
    Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');
    Route::get('/users/{user}/edit', [AdminController::class, 'usersEdit'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'usersUpdate'])->name('users.update');
    
    // Statistics
    Route::get('/statistics', [AdminController::class, 'statistics'])->name('statistics');
    
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

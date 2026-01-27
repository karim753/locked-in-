<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KeuzedeelController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/keuzedelen', [KeuzedeelController::class, 'index'])->name('keuzedelen.index');
    Route::get('/keuzedelen/{keuzedeel}', [KeuzedeelController::class, 'show'])->name('keuzedelen.show');
    Route::post('/keuzedelen/{keuzedeel}/enroll', [KeuzedeelController::class, 'enroll'])->name('keuzedelen.enroll');
    Route::post('/keuzedelen/{keuzdeel}/cancel', [KeuzedeelController::class, 'cancel'])->name('keuzedelen.cancel');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

Route::middleware(['auth', 'role:slber'])->prefix('slb')->name('slb.')->group(function () {
    Route::get('/dashboard', function () {
        return view('slb.dashboard');
    })->name('dashboard');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

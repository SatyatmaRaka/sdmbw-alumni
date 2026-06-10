<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Alumni\DashboardController as AlumniDashboard;
use App\Http\Controllers\Alumni\ProfileController;
use App\Http\Controllers\Public\AlumniPublicController;

/*
|--------------------------------------------------------------------------
| Kepala Sekolah Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'kepala_sekolah'])
    ->prefix('kepala-sekolah')
    ->name('kepala_sekolah.')
    ->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\KepalaSekolah\KepalaSekolahController::class, 'dashboard'])->name('dashboard');
    });

/*
|--------------------------------------------------------------------------
| Alumni Routes (Role: alumni)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'alumni', 'alumni.onboarding'])
    ->prefix('alumni')
    ->name('alumni.')
    ->group(function () {
        // Dashboard Alumni
        Route::get('/dashboard', [AlumniDashboard::class, 'index'])->name('dashboard');

        // Profile Management
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

        // Testimonial — Wajib diisi setelah profil lengkap
        Route::get('/testimonial', [ProfileController::class, 'testimonialForm'])->name('testimonial.form');
        Route::post('/testimonial', [ProfileController::class, 'storeTestimonial'])->name('testimonial.store');

        // Direktori Alumni (Unified with Public Controller)
        Route::prefix('direktori')->name('direktori.')->group(function () {
            Route::get('/', [AlumniPublicController::class, 'direktori'])->name('index');
            Route::get('/{alumni}', [AlumniPublicController::class, 'show'])->name('show');
        });
    });

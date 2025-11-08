<?php

use Illuminate\Support\Facades\Route;

// ===== FRONT CONTROLLERS =====
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProgramController;

// ===== DONOR CONTROLLERS =====
use App\Http\Controllers\Donor\DonationController as DonorDonationController;
use App\Http\Controllers\Donor\DashboardController;

// ===== ADMIN CONTROLLERS =====
use App\Http\Controllers\Admin\ProgramController as AdminProgramController;
use App\Http\Controllers\Admin\ProgramMediaController as AdminProgramMediaController;
use App\Http\Controllers\Admin\DonationController as AdminDonationController;
use App\Http\Controllers\Admin\BeneficiaryController as AdminBeneficiaryController;
use App\Http\Controllers\Admin\MilestoneController as AdminMilestoneController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Front\DonationController;
use App\Http\Controllers\Front\EventController as FrontEventController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =======================
// 🌍 FRONTEND (Publik)
// =======================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/programs', [ProgramController::class, 'index'])->name('programs.index');
Route::get('/programs/{program:slug}', [ProgramController::class, 'show'])->name('programs.show');

Route::get('/events', [FrontEventController::class, 'index'])->name('events.index');
Route::get('/events/{event:slug}', [FrontEventController::class, 'show'])->name('events.show');


// =======================
// 🧍‍♂️ AUTH & PROFILE
// =======================
Route::middleware(['auth'])->group(function () {

    Route::post('/like/event/{event}', [LikeController::class, 'toggleEventLike'])
     ->name('events.like');
     Route::post('/comment/event/{event}', [CommentController::class, 'storeEventComment']) // <-- TAMBAKAN INI
     ->name('events.comment');

    // Profil user
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // =======================
    // 💝 DONOR PANEL
    // =======================
    // Rute Publik untuk Events (yang baru)
    
        Route::prefix('donor')->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::get('/donations', [DashboardController::class, 'donations'])->name('donations');
            Route::post('/donations', [DonationController::class, 'store'])->name('donations.store');
            Route::get('/donation/confirmation/{donation}', [DonationController::class, 'confirmation'])->name('donations.confirmation');
        });
    });

// =======================
// 🧰 ADMIN PANEL (Spatie Protected)
// =======================
Route::middleware(['auth', 'role:Superadmin|Program Manager|Finance'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // ===== CATEGORY MANAGEMENT =====
        Route::resource('categories', AdminCategoryController::class)
            ->middleware('permission:manage programs');

        // ===== PROGRAM MANAGEMENT =====

        Route::resource('events', EventController::class);

        Route::resource('programs', AdminProgramController::class)
            ->middleware('permission:manage programs');

        // ===== PROGRAM MEDIA MANAGEMENT =====
        Route::delete('programsmedia/{media}', [AdminProgramMediaController::class, 'destroy'])
            ->name('programsmedia.destroy')
            ->middleware('permission:manage programs');

        Route::resource('programsmedia', AdminProgramMediaController::class)
            ->middleware('permission:manage programs');

        // ===== MILESTONE MANAGEMENT =====
        Route::resource('milestones', AdminMilestoneController::class)
            ->middleware('permission:manage programs');

        // ===== DONATION MANAGEMENT =====
        Route::resource('donations', AdminDonationController::class)
            ->only(['index', 'show', 'update', 'destroy'])
            ->middleware('permission:verify donations');

        // ===== BENEFICIARY MANAGEMENT =====
        Route::resource('beneficiaries', AdminBeneficiaryController::class)
            ->middleware('permission:manage programs');
    });

// ===== AUTH ROUTES (Breeze/Jetstream) =====
require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Route;

// FRONT CONTROLLERS
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProgramController;
use App\Http\Controllers\Front\EventController as FrontEventController;
use App\Http\Controllers\Front\DonationController;

// ADMIN CONTROLLERS
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProgramController as AdminProgramController;
use App\Http\Controllers\Admin\ProgramMediaController as AdminProgramMediaController;
use App\Http\Controllers\Admin\DonationController as AdminDonationController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\EventCategoryController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\MitraController;
use App\Http\Controllers\Admin\ProgramUseController;
use App\Http\Controllers\Admin\ProgramUseExportController;

// GENERAL
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;

// =======================
// 🌍 FRONTEND (Publik)
// =======================
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/programs', [ProgramController::class, 'index'])->name('programs.index');
Route::get('/programs/{program:slug}', [ProgramController::class, 'show'])->name('programs.show');

Route::get('/events', [FrontEventController::class, 'index'])->name('events.index');
Route::get('/events/{event:slug}', [FrontEventController::class, 'show'])->name('events.show');

Route::get('/mitra', [MitraController::class, 'showAll'])->name('mitra.index');
Route::get('/sejarah', [HomeController::class, 'sejarah'])->name('sejarah');
Route::get('/tentang-kami', [HomeController::class, 'tentangKami'])->name('tentang');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');

// =======================
// 💝 DONASI / MIDTRANS
// =======================

// ✅ Form donasi & pemrosesan transaksi (publik)
Route::prefix('donor')->group(function () {
    Route::post('/donations/{program:slug}', [DonationController::class, 'store'])->name('donations.store');
    Route::get('/donation/confirmation/{donation}', [DonationController::class, 'confirmation'])->name('donations.confirmation');
});

    // ✅ Callback / Notifikasi Midtrans (Wajib pakai HTTPS)
    Route::get('/payment/success/{donation}', [DonationController::class, 'success'])->name('payment.success');
    Route::get('/payment/pending/{donation}', [DonationController::class, 'pending'])->name('payment.pending');
    Route::get('/payment/failed', [DonationController::class, 'failed'])->name('payment.failed');
    Route::post('/midtrans/callback', [DonationController::class, 'midtransCallback'])->name('midtrans.callback');
    Route::get('/midtrans/test', [DonationController::class, 'testConnection'])->name('midtrans.test');
    
    Route::get('/api/donations/status/{donation}', function (App\Models\Donation $donation) {
        return response()->json(['status' => $donation->status]);
    });




// =======================
// 🧍‍♂️ AUTH & PROFILE
// =======================
Route::middleware(['auth'])->group(function () {

    // Event Likes & Comments
    Route::post('/like/event/{event}', [LikeController::class, 'toggleEventLike'])->name('events.like');
    Route::post('/comment/event/{event}', [CommentController::class, 'storeEventComment'])->name('events.comment');

    // Profil user
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard user (opsional)
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

// =======================
// 🛠️ ADMIN AREA
// =======================
Route::middleware(['auth', 'role:Superadmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Kategori & Program
        Route::resource('categories', AdminCategoryController::class)->middleware('permission:manage programs');
        Route::resource('programs', AdminProgramController::class)->middleware('permission:manage programs');

        // Media Program
        Route::delete('programsmedia/{media}', [AdminProgramMediaController::class, 'destroy'])
            ->name('programsmedia.destroy')
            ->middleware('permission:manage programs');
        Route::resource('programsmedia', AdminProgramMediaController::class)->middleware('permission:manage programs');

        // Event & Mitra
        Route::resource('categoriesevents', EventCategoryController::class);
        Route::resource('events', EventController::class);
        Route::resource('mitras', MitraController::class);

        // Penggunaan Dana
        Route::resource('program_uses', ProgramUseController::class);
        Route::get('program-uses/export/pdf', [ProgramUseExportController::class, 'exportPdf'])->name('program_uses.export.pdf');
        Route::get('program-uses/export/excel', [ProgramUseExportController::class, 'exportExcel'])->name('program_uses.export.excel');

        // Donasi (admin)
        Route::resource('donations', AdminDonationController::class)->only(['index', 'show', 'update', 'destroy'])->middleware('permission:verify donations');
    });

require __DIR__ . '/auth.php';

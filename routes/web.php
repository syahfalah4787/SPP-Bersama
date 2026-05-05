<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaAuthController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SiswaDashboardController;
use App\Http\Controllers\SppController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Root redirect
Route::get('/', function () {
    if (Auth::guard('siswa')->check()) {
        return redirect()->route('siswa.dashboard');
    }
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('siswa.login');
});
// ===== STUDENT ROUTES =====
Route::prefix('siswa')->group(function () {
    Route::get('/login', [SiswaAuthController::class, 'showLoginForm'])->name('siswa.login');
    Route::post('/login', [SiswaAuthController::class, 'login'])->name('siswa.login.submit');
    Route::post('/logout', [SiswaAuthController::class, 'logout'])->name('siswa.logout');

    Route::middleware('auth:siswa')->group(function () {
        Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('siswa.dashboard');
        Route::get('/history', [SiswaDashboardController::class, 'history'])->name('siswa.history');
    });
});

// ===== ADMIN & OFFICER ROUTES =====
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Payment Entry (Admin & Petugas)
    Route::resource('pembayaran', PembayaranController::class)->except(['edit', 'update']);
    Route::get('/api/siswa-data', [PembayaranController::class, 'getSiswaData'])->name('api.siswa-data');
    Route::get('/api/siswa-by-kelas', [PembayaranController::class, 'getSiswaByKelas'])->name('api.siswa-by-kelas');
    
    // Detail Siswa (accessible by Admin & Petugas)
    Route::get('/siswa/{siswa}', [SiswaController::class, 'show'])->name('siswa.show');

    // Admin-only routes
    Route::middleware('role:admin')->group(function () {
        Route::resource('kelas', KelasController::class)->except(['create', 'show', 'edit']);
        Route::resource('spp', SppController::class)->except(['create', 'show', 'edit']);
        Route::resource('siswa', SiswaController::class)->except(['create', 'show', 'edit']);
        Route::resource('petugas', PetugasController::class)->except(['create', 'show', 'edit']);

        // Reports
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/print', [LaporanController::class, 'print'])->name('laporan.print');
    });
});



require __DIR__.'/auth.php';

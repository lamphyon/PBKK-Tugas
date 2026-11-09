<?php

use App\Http\Controllers\Auth\DemoLoginController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// ─────────────────────────────────────────────────────────────
// Tiga rute utama tugas — semua melalui PageController
// ─────────────────────────────────────────────────────────────

// Beranda — menangani Tantangan 2: ?user=Nama
Route::get('/', [PageController::class, 'home'])->name('home');

// Profil Mahasiswa
Route::get('/profil-mahasiswa', [PageController::class, 'profil'])->name('profil');

// Ide-Riset (Agentic AI Platform)
Route::get('/ide-agent', [PageController::class, 'ideAgent'])->name('ide-agent');

// ─────────────────────────────────────────────────────────────
// Rute warisan / pendukung (masih dipertahankan)
// ─────────────────────────────────────────────────────────────

// Rute lama agent dengan parameter tema (biarkan tetap berfungsi)
Route::get('/agent/{tema?}', [PageController::class, 'agent'])->name('agent.idea');

// Kalkulator IPK
Route::get('/hitung-ipk/{ip1}/{ip2}', [CalculatorController::class, 'hitungIpk']);

// Dashboard group (warisan)
Route::prefix('dashboard')->name('dashboard.')->middleware(['auth', 'verified', 'permission:lihat dashboard'])->group(function () {
    Route::get('/about', [PageController::class, 'about'])->name('about');
    Route::get('/mahasiswa/{nrp}', [PageController::class, 'mahasiswaDetail'])
        ->where('nrp', '[0-9]{10}') // validasi format NRP
        ->name('mahasiswa.detail');
});

// Backoffice: autentikasi Breeze, verifikasi email, lalu permission controller.
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('mahasiswa', MahasiswaController::class)->except('show');
    });
});

Route::post('/demo-login/{account}', DemoLoginController::class)
    ->whereIn('account', ['admin', 'staf'])
    ->middleware(['guest', 'throttle:6,1'])
    ->name('demo.login');

require __DIR__.'/auth.php';

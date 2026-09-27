<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

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
Route::get('/hitung-ipk/{ip1}/{ip2}', [App\Http\Controllers\CalculatorController::class, 'hitungIpk']);

// Dashboard group (warisan)
Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/about', [PageController::class, 'about'])->name('about');
    Route::get('/mahasiswa/{nrp}', [PageController::class, 'mahasiswaDetail'])
        ->where('nrp', '[0-9]{10}') // validasi format NRP
        ->name('mahasiswa.detail');
});

// Fallback 404
Route::fallback(function () {
    return view('errors.404');
});

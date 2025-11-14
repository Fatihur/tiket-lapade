<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\WisataController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboard;
use App\Http\Controllers\Petugas\ScanController;
use App\Http\Controllers\Bendahara\DashboardController as BendaharaDashboard;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboard;

// Landing Page (Public)
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/wisata/{id}', [LandingController::class, 'detail'])->name('wisata.detail');

// Pemesanan (Public)
Route::get('/pemesanan', [PemesananController::class, 'create'])->name('pemesanan.create');
Route::post('/pemesanan', [PemesananController::class, 'store'])->name('pemesanan.store');
Route::get('/pemesanan/sukses/{id}', [PemesananController::class, 'sukses'])->name('pemesanan.sukses');

// Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    
    // Wisata (Single wisata system - hanya edit)
    Route::get('wisata', [WisataController::class, 'index'])->name('wisata.index');
    Route::get('wisata/{id}/edit', [WisataController::class, 'edit'])->name('wisata.edit');
    Route::put('wisata/{id}', [WisataController::class, 'update'])->name('wisata.update');
    
    // Transaksi
    Route::get('transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::post('transaksi/{id}/validasi', [TransaksiController::class, 'validasi'])->name('transaksi.validasi');
    
    // Laporan
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan/cetak-pdf', [LaporanController::class, 'cetakPdf'])->name('laporan.cetak-pdf');
    
    // User Management
    Route::resource('user', UserController::class);
});

// Petugas Routes
Route::prefix('petugas')->name('petugas.')->middleware(['auth', 'role:Petugas'])->group(function () {
    Route::get('/dashboard', [PetugasDashboard::class, 'index'])->name('dashboard');
    Route::get('/scan', [ScanController::class, 'index'])->name('scan');
    Route::post('/scan', [ScanController::class, 'scan'])->name('scan.process');
    Route::get('/riwayat', [ScanController::class, 'riwayat'])->name('riwayat');
});

// Bendahara Routes
Route::prefix('bendahara')->name('bendahara.')->middleware(['auth', 'role:Bendahara'])->group(function () {
    Route::get('/dashboard', [BendaharaDashboard::class, 'index'])->name('dashboard');
    Route::get('/laporan', [\App\Http\Controllers\Bendahara\LaporanController::class, 'index'])->name('laporan');
    Route::get('/laporan/cetak-pdf', [\App\Http\Controllers\Bendahara\LaporanController::class, 'cetakPdf'])->name('laporan.cetak-pdf');
    Route::post('/laporan/verifikasi/{id}', [\App\Http\Controllers\Bendahara\LaporanController::class, 'verifikasi'])->name('laporan.verifikasi');
    Route::post('/laporan/bulk-verifikasi', [\App\Http\Controllers\Bendahara\LaporanController::class, 'bulkVerifikasi'])->name('laporan.bulk-verifikasi');
    Route::post('/laporan/batal-verifikasi/{id}', [\App\Http\Controllers\Bendahara\LaporanController::class, 'batalVerifikasi'])->name('laporan.batal-verifikasi');
});

// Owner Routes
Route::prefix('owner')->name('owner.')->middleware(['auth', 'role:Owner'])->group(function () {
    Route::get('/dashboard', [OwnerDashboard::class, 'index'])->name('dashboard');
});

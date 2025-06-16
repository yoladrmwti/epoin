<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\PelanggarController;
use App\Http\Controllers\DetailPelanggaranController;


// Rute untuk halaman utama
Route::get('/', function () {
    return view('/auth/login');
});

// Group routes untuk tamu (guest)
Route::middleware('guest')->group(function () {
    // Route::get('/register', [LoginRegisterController::class, 'register'])->name('register');
    Route::post('/store', [LoginRegisterController::class, 'store'])->name('store');
    Route::get('/login', [LoginRegisterController::class, 'login'])->name('login');
    Route::post('/authenticate', [LoginRegisterController::class, 'authenticate'])->name('authenticate');
});

// Group routes untuk yang sudah login dan role admin
Route::middleware(['auth', 'admin'])->group(function () {
     Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('/admin/siswa', SiswaController::class);
    Route::resource('/admin/akun', LoginRegisterController::class);
    Route::put('/updateEmail/{akun}', [LoginRegisterController::class, 'updateEmail'])->name('updateEmail');
    Route::put('/updatePassword/{akun}', [LoginRegisterController::class, 'updatePassword'])->name('updatePassword');
    Route::resource('/admin/pelanggaran', PelanggaranController::class);
    //Route::get('admin/pelanggaran', [PelanggaranController::class, 'index'])->name('pelanggaran');
    Route::get('/pelanggaran/{id}/edit', [PelanggaranController::class, 'edit'])->name('pelanggaran.edit');
    Route::resource('/admin/pelanggar', PelanggarController::class);
    Route::post('/admin/pelanggar/storePelanggaran', [PelanggarController::class, 'storePelanggaran'])->name('pelanggar.storePelanggaran');
    Route::put('/admin/pelanggar/statusTindak/{akun}', [PelanggarController::class, 'statusTindak'])->name('pelanggar.statusTindak');
    Route::resource('/admin/detailPelanggar', DetailPelanggaranController::class);
    Route::post('/logout', [LoginRegisterController::class, 'logout'])->name('logout');
});

// Rute untuk Dashboard (user yang sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
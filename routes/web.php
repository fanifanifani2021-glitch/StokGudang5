<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\BarangMasukController;
use App\Http\Controllers\Admin\BarangKeluarController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Manajer\DashboardController as ManajerDashboardController;
use App\Http\Controllers\Manajer\ProfileController as ManajerProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('landing');

// ─── Auth Routes ───────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ─── Admin Routes ──────────────────────────────────────────────────────────────
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Kategori CRUD
        Route::resource('kategoris', KategoriController::class);

        // Barang CRUD
        Route::resource('barangs', BarangController::class);

        // Supplier CRUD
        Route::resource('suppliers', SupplierController::class);

        // Barang Masuk CRUD
        Route::resource('barang-masuks', BarangMasukController::class);

        // Barang Keluar CRUD
        Route::resource('barang-keluars', BarangKeluarController::class);

        // Profile Admin
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });

// ─── Manajer Routes ────────────────────────────────────────────────────────────
Route::prefix('manajer')
    ->name('manajer.')
    ->middleware(['auth', 'role:manajer'])
    ->group(function () {

        // Dashboard Laporan Stok (read-only)
        Route::get('/dashboard', [ManajerDashboardController::class, 'index'])->name('dashboard');

        // Profile Manajer
        Route::get('/profile', [ManajerProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [ManajerProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ManajerProfileController::class, 'update'])->name('profile.update');
    });

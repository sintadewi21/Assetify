<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Halaman Dashboard terhubung ke DashboardController
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'role:Admin,Staff,Manager'])
    ->name('dashboard');

// 1. Grup Hak Akses Admin & Staff: Mengelola Kategori, Produk, dan membuat transaksi pinjam baru
Route::middleware(['auth', 'role:Admin,Staff'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);

    // Pencatatan & pengembalian peminjaman barang
    Route::get('/loans/create', [LoanController::class, 'create'])->name('loans.create');
    Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
    Route::patch('/loans/{loan}/return', [LoanController::class, 'returnItems'])->name('loans.return');
});

// 2. Grup Hak Akses Admin, Staff, & Manager: Melihat Log/Laporan Peminjaman
Route::middleware(['auth', 'role:Admin,Staff,Manager'])->group(function () {
    Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');

    // Bonus Ekspor Laporan
    Route::get('/loans/export/excel', [LoanController::class, 'exportExcel'])->name('loans.export.excel');
    Route::get('/loans/export/pdf', [LoanController::class, 'exportPdf'])->name('loans.export.pdf');
});

// 3. Grup Hak Akses Admin & Manager: Rute Approval (Persetujuan / Penolakan Peminjaman)
Route::middleware(['auth', 'role:Admin,Manager'])->group(function () {
    Route::patch('/loans/{loan}/approve', [LoanController::class, 'approve'])->name('loans.approve');
    Route::patch('/loans/{loan}/reject', [LoanController::class, 'reject'])->name('loans.reject');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifications Route
    Route::post('/notifications/read', [NotificationController::class, 'markAllAsRead'])->name('notifications.read');
});

require __DIR__.'/auth.php';

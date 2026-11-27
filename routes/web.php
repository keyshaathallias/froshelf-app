<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuidanceController;
use App\Http\Controllers\PlaceholderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    if ($request->user()) {
        return $request->user()->isPemilik()
            ? redirect()->route('dashboard')
            : redirect()->route('transactions.index');
    }

    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/guidance', [GuidanceController::class, 'index'])->name('guidance.index');

    // Transaksi (Kevin) - jangan dihapus
    Route::get('/transactions', [PlaceholderController::class, 'show'])
        ->defaults('module', 'transactions')
        ->name('transactions.index');

    Route::middleware('role:pemilik')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // F-03: CRUD 4 Data Master (Vany)
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('customers', CustomerController::class);

        // Laporan (Afif) - jangan dihapus
        Route::get('/reports', [PlaceholderController::class, 'show'])
            ->defaults('module', 'reports')
            ->name('reports.index');
    });
});

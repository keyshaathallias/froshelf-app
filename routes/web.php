<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuidanceController;
use App\Http\Controllers\PlaceholderController;
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

    // FR-00: Panduan Pengguna Interaktif (Pemilik & Staf)
    Route::get('/guidance', [GuidanceController::class, 'index'])->name('guidance.index');

    // Placeholder menu operasional (dapat diakses Pemilik & Staf; siap disambungkan dengan branch Kevin & Vany)
    Route::get('/transactions', [PlaceholderController::class, 'show'])
        ->defaults('module', 'transactions')
        ->name('transactions.index');

    Route::get('/products', [PlaceholderController::class, 'show'])
        ->defaults('module', 'products')
        ->name('products.index');

    // Rute khusus Pemilik (Staf diblokir 403 melalui RoleMiddleware)
    Route::middleware('role:pemilik')->group(function () {
        // F-09: Dashboard Ringkas Pemilik
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Placeholder Master Data & Laporan (siap disambungkan dengan branch Vany & Afif)
        Route::get('/categories', [PlaceholderController::class, 'show'])
            ->defaults('module', 'categories')
            ->name('categories.index');

        Route::get('/suppliers', [PlaceholderController::class, 'show'])
            ->defaults('module', 'suppliers')
            ->name('suppliers.index');

        Route::get('/customers', [PlaceholderController::class, 'show'])
            ->defaults('module', 'customers')
            ->name('customers.index');

        Route::get('/reports', [PlaceholderController::class, 'show'])
            ->defaults('module', 'reports')
            ->name('reports.index');
    });
});

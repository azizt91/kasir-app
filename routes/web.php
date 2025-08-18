<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::get('/pos/products/search', [PosController::class, 'searchProducts'])->name('pos.products.search');
    Route::get('/pos/categories', [PosController::class, 'getCategories'])->name('pos.categories');
    Route::post('/pos/search', [PosController::class, 'searchProducts'])->name('pos.search');
    Route::post('/pos/transaction', [PosController::class, 'store'])->name('pos.transaction');



    // Admin only routes
    Route::middleware('admin')->group(function () {
        Route::resource('products', ProductController::class);
        Route::get('/products/barcodes/print', [App\Http\Controllers\ProductController::class, 'printBarcodes'])->name('products.print_barcodes');
        Route::resource('categories', CategoryController::class);
        Route::resource('users', UserController::class);
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
        Route::get('/reports/products', [ReportController::class, 'products'])->name('reports.products');
        Route::get('/reports/stock', [ReportController::class, 'stock'])->name('reports.stock');
        Route::get('/reports/sales/export-pdf', [ReportController::class, 'exportSalesPdf'])->name('reports.sales.pdf');
        Route::get('/reports/sales/export-excel', [ReportController::class, 'exportSalesExcel'])->name('reports.sales.excel');
        Route::get('/reports/products/export-pdf', [ReportController::class, 'exportProductsPdf'])->name('reports.products.pdf');
        Route::get('/reports/products/export-excel', [ReportController::class, 'exportProductsExcel'])->name('reports.products.excel');
        Route::get('/reports/stock/export-pdf', [ReportController::class, 'exportStockPdf'])->name('reports.stock.pdf');
        Route::get('/reports/stock/export-excel', [ReportController::class, 'exportStockExcel'])->name('reports.stock.excel');
    });
});

require __DIR__.'/auth.php';

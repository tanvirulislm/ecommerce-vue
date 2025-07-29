<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VariationController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\InvoiceController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';


Route::middleware(['auth', 'verified',])->group(function () {

    // All GET URLs
    Route::get('/category', [CategoryController::class, 'Categorypage'])->name('category');
    Route::get('/brand', [BrandController::class, 'BrandPage'])->name('brand');
    Route::get('/product', [ProductController::class, 'ProductPage'])->name('product');
    Route::get('/variation', [VariationController::class, 'VariationPage'])->name('variation');
    Route::get('/customer', [PartyController::class, 'CustomerPage'])->name('customer');
    Route::get('/supplier', [PartyController::class, 'SupplierPage'])->name('supplier');
    Route::get('/sales-invoice', [InvoiceController::class, 'SalesInvoicePage'])->name('sales-invoice');
    Route::get('/purchase-invoice', [InvoiceController::class, 'PurchaseInvoicePage'])->name('purchase-invoice');

    // All POST URLs
    Route::post('/category', [CategoryController::class, 'CreateCategory'])->name('create-category');

    // All DELETE URLs
    Route::delete('/delete-category/{id}', [CategoryController::class, 'DeleteCategory'])->name('delete-category');
});

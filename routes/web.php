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
    Route::post('/update-category/{id}', [CategoryController::class, 'UpdateCategory'])->name('update-category');

    Route::post('/brand', [BrandController::class, 'CreateBrand'])->name('create-brand');
    Route::post('/update-brand/{id}', [BrandController::class, 'UpdateBrand'])->name('update-brand');

    Route::post('/party', [PartyController::class, 'CreateParty'])->name('create-party');
    Route::post('/update-party/{id}', [PartyController::class, 'UpdateParty'])->name('update-party');

    // All DELETE URLs
    Route::delete('/delete-category/{id}', [CategoryController::class, 'DeleteCategory'])->name('delete-category');
    Route::delete('/delete-brand/{id}', [BrandController::class, 'DeleteBrand'])->name('delete-brand');
    Route::delete('/delete-party/{id}', [BrandController::class, 'DeleteParty'])->name('delete-party');
});

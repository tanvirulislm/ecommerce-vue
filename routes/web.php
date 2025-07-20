<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VariationController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';


Route::middleware(['auth', 'verified',])->group(function () {
    Route::get('/category', [CategoryController::class, 'Categorypage'])->name('category');
    Route::get('/brand', [BrandController::class, 'BrandPage'])->name('brand');
    Route::get('/product', [ProductController::class, 'ProductPage'])->name('product');
    Route::get('/variation', [VariationController::class, 'VariationPage'])->name('variation');
});

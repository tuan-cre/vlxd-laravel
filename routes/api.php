<?php

use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('api.products.index');
    Route::get('/products/{slug}', [ProductController::class, 'show'])->name('api.products.show');
    Route::get('/categories', [ProductController::class, 'categories'])->name('api.categories');
    Route::get('/brands', [ProductController::class, 'brands'])->name('api.brands');
});

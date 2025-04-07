<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('product')->group(function () {
    Route::post('/', [ProductController::class, 'createProduct']);
    Route::put('/{id}', [ProductController::class, 'updateProduct']);
    Route::delete('/{id}', [ProductController::class, 'deleteProduct']);
    Route::get('/list', [ProductController::class, 'getProductList']);
    Route::get('/{id}', [ProductController::class, 'getProduct']);
    Route::get('/{id}/price-changes', [ProductController::class, 'getProductPriceChanges']);
});

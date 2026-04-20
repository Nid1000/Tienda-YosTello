<?php

use App\Http\Controllers\Api\StorefrontController;
use Illuminate\Support\Facades\Route;

Route::prefix('storefront')->group(function (): void {
    Route::get('/overview', [StorefrontController::class, 'overview']);
    Route::get('/products', [StorefrontController::class, 'products']);
});

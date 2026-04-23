<?php

use App\Http\Controllers\Api\Auth\AdminAuthController;
use App\Http\Controllers\Api\Auth\ClientAuthController;
use App\Http\Controllers\Api\PeruIdentityController;
use App\Http\Controllers\Api\StorefrontController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    Route::prefix('peru')->group(function (): void {
        Route::post('/dni', [PeruIdentityController::class, 'dni']);
        Route::post('/ruc', [PeruIdentityController::class, 'ruc']);
    });

    Route::prefix('auth')->group(function (): void {
        Route::post('/login', [ClientAuthController::class, 'login']);
        Route::middleware('checkJwt:customer')->group(function (): void {
            Route::get('/me', [ClientAuthController::class, 'me']);
            Route::post('/logout', [ClientAuthController::class, 'logout']);
        });
    });

    Route::prefix('admin/auth')->group(function (): void {
        Route::post('/login', [AdminAuthController::class, 'login']);
        Route::middleware('checkJwt:admin')->group(function (): void {
            Route::get('/me', [AdminAuthController::class, 'me']);
            Route::post('/logout', [AdminAuthController::class, 'logout']);
        });
    });
});

Route::prefix('storefront')->group(function (): void {
    Route::get('/overview', [StorefrontController::class, 'overview']);
    Route::get('/products', [StorefrontController::class, 'products']);
});

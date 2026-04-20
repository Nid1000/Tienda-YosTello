<?php

use App\Http\Controllers\Admin\AdminAuthenticatedSessionController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminPromotionController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CartBridgeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/app.css', function () {
    return response()->file(resource_path('css/app.css'), [
        'Content-Type' => 'text/css; charset=UTF-8',
        'Cache-Control' => 'no-cache, no-store, must-revalidate',
    ]);
})->name('app.css');

Route::get('/app.js', function () {
    return response()->file(resource_path('js/fallback.js'), [
        'Content-Type' => 'application/javascript; charset=UTF-8',
        'Cache-Control' => 'no-cache, no-store, must-revalidate',
    ]);
})->name('app.js');

Route::middleware('customer')->group(function () {
    Route::view('/', 'storefront')->name('home');
    Route::get('/productos', [ProductController::class, 'index'])->name('products.index');
    Route::get('/productos/{product:slug}', [ProductController::class, 'show'])->name('products.show');

    Route::post('/bridge/cart', [CartBridgeController::class, 'store'])->name('bridge.cart');
});

Route::middleware('guest')->group(function () {
    Route::get('/registro', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/registro', [RegisteredUserController::class, 'store']);
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::middleware('customer')->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');

        Route::get('/carrito', [CartController::class, 'index'])->name('cart.index');
        Route::post('/carrito', [CartController::class, 'store'])->name('cart.store');
        Route::patch('/carrito/{product}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/carrito/{product}', [CartController::class, 'destroy'])->name('cart.destroy');

        Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
        Route::post('/checkout/dni', [CheckoutController::class, 'lookupDni'])->name('checkout.lookup-dni');

        Route::get('/pedidos', [OrderController::class, 'index'])->name('orders.index');
    });
});

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('login', [AdminAuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AdminAuthenticatedSessionController::class, 'store'])->name('login.store');

        Route::middleware('admin')->group(function () {
            Route::post('logout', [AdminAuthenticatedSessionController::class, 'destroy'])->name('logout');
            Route::get('/', AdminDashboardController::class)->name('index');
            Route::resource('categorias', AdminCategoryController::class)->except(['show']);
            Route::resource('productos', AdminProductController::class)->except(['show']);
            Route::resource('promociones', AdminPromotionController::class)->except(['show']);
            Route::get('pedidos', [AdminOrderController::class, 'index'])->name('pedidos.index');
            Route::get('usuarios', [AdminUserController::class, 'index'])->name('usuarios.index');
        });
    });

<?php

use App\Http\Controllers\Admin\AdminAuthenticatedSessionController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminPromotionController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\CartBridgeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
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

Route::middleware('checkAuthClient')->group(function () {
    Route::view('/', 'storefront')->name('home');
    Route::get('/productos', [ProductController::class, 'index'])->name('products.index');
    Route::get('/productos/{product:slug}', [ProductController::class, 'show'])->name('products.show');
    Route::post('/bridge/cart', [CartBridgeController::class, 'store'])->name('bridge.cart');
});

Route::redirect('/registro', '/register');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('checkAuthClient')->group(function () {
        Route::get('/carrito', [CartController::class, 'index'])->name('cart.index');
        Route::post('/carrito', [CartController::class, 'store'])->name('cart.store');
        Route::patch('/carrito/{product}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/carrito/{product}', [CartController::class, 'destroy'])->name('cart.destroy');

        Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
        Route::post('/checkout/dni', [CheckoutController::class, 'lookupDni'])->name('checkout.lookup-dni');
        Route::post('/checkout/ruc', [CheckoutController::class, 'lookupRuc'])->name('checkout.lookup-ruc');

        Route::get('/pedidos', [OrderController::class, 'index'])->name('orders.index');
    });
});

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('login', [AdminAuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AdminAuthenticatedSessionController::class, 'store'])->name('login.store');

        Route::middleware('checkAuthAdmin')->group(function () {
            Route::post('logout', [AdminAuthenticatedSessionController::class, 'destroy'])->name('logout');
            Route::get('/', AdminDashboardController::class)->name('index');
            Route::resource('categorias', AdminCategoryController::class)->except(['show']);
            Route::resource('productos', AdminProductController::class)->except(['show']);
            Route::resource('promociones', AdminPromotionController::class)->except(['show']);
            Route::get('pedidos', [AdminOrderController::class, 'index'])->name('pedidos.index');
            Route::patch('pedidos/{order}', [AdminOrderController::class, 'update'])->name('pedidos.update');
            Route::resource('usuarios', AdminUserController::class)->except(['show']);
        });
    });

require __DIR__.'/auth.php';

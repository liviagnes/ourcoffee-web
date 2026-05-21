<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProductController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/menu', [ProductController::class, 'index']);

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [\App\Http\Controllers\ResetPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [\App\Http\Controllers\ResetPasswordController::class, 'resetInstant'])->name('password.instant');

Route::get('/payment-success/{id}', [\App\Http\Controllers\PaymentController::class, 'localSuccess'])->name('payment.success');

// Customer Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index']);
    Route::get('/cart/add/{product_id}', [CartController::class, 'add']);
    Route::get('/cart/update/{cart_id}/{type}', [CartController::class, 'updateQty']);
    Route::get('/cart/decrease/{product_id}', [CartController::class, 'decreaseProduct']);
    Route::get('/cart/delete/{cart_id}', [CartController::class, 'delete']);
    Route::get('/cart/clear', [CartController::class, 'clear']);

    Route::get('/checkout', [OrderController::class, 'checkoutView']);
    Route::post('/checkout/process', [OrderController::class, 'process']);
    Route::get('/order_success', [OrderController::class, 'success']);
    Route::get('/history', [OrderController::class, 'history']);
    Route::get('/history/cancel', [OrderController::class, 'cancel']);
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/product', [AdminProductController::class, 'index']);
    Route::get('/product/create', [AdminProductController::class, 'create']);
    Route::post('/product/store', [AdminProductController::class, 'store']);
    Route::get('/product/edit/{id}', [AdminProductController::class, 'edit']);
    Route::post('/product/update/{id}', [AdminProductController::class, 'update']);
    Route::get('/product/delete/{id}', [AdminProductController::class, 'destroy']);
});

// Kasir Routes (Basic example)
Route::middleware(['auth', 'kasir'])->prefix('kasir')->group(function () {
    Route::get('/dashboard', function() {
        return "Dashboard Kasir - Fitur akan datang";
    });
});

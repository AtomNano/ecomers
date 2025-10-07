<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\Owner\CustomerController as OwnerCustomerController;

// Rute Frontend
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [FrontendProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [FrontendProductController::class, 'show'])->name('products.show');
Route::get('/about', [PageController::class, 'about'])->name('about');

// Rute yang memerlukan otentikasi
Route::middleware('auth')->group(function () {
    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::post('/checkout/upload-proof', [CheckoutController::class, 'uploadProof'])->name('checkout.uploadProof');


    // Rute Admin
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('products', AdminProductController::class);
        Route::resource('categories', AdminCategoryController::class);
        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::post('orders/{order}/accept', [AdminOrderController::class, 'acceptPayment'])->name('orders.accept');
        Route::post('orders/{order}/reject', [AdminOrderController::class, 'rejectPayment'])->name('orders.reject');
        Route::get('reports', [AdminReportController::class, 'index'])->name('reports.index');
    });

    // Rute Owner
    Route::middleware('role:owner')->prefix('owner')->name('owner.')->group(function () {
        Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');
        // Rute owner mirip admin bisa ditambahkan di sini
        Route::resource('customers', OwnerCustomerController::class);
    });
});

require __DIR__.'/auth.php';

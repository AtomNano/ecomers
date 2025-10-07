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
Route::get('/produk', [FrontendProductController::class, 'index'])->name('products.index');
Route::get('/produk/cari', [FrontendProductController::class, 'search'])->name('products.search');
Route::get('/produk/{product:slug}', [FrontendProductController::class, 'show'])->name('products.show');

// Cart routes
Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
Route::post('/keranjang/tambah', [CartController::class, 'add'])->name('cart.add');
Route::post('/keranjang/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/keranjang/hapus/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/keranjang/kosongkan', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/keranjang/count', [CartController::class, 'getCount'])->name('cart.count');

// Checkout routes (moved to auth middleware)
Route::get('/kategori', [PageController::class, 'categories'])->name('categories.index');
Route::get('/tentang', [PageController::class, 'about'])->name('about');
Route::get('/kontak', [PageController::class, 'contact'])->name('contact');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/pengiriman', [PageController::class, 'shipping'])->name('shipping');
Route::get('/pembayaran', [PageController::class, 'payment'])->name('payment');
Route::get('/retur', [PageController::class, 'return'])->name('return');
Route::get('/privasi', [PageController::class, 'privacy'])->name('privacy');
Route::get('/profil', [PageController::class, 'profile'])->name('profile');

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
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/payment/{id}', [CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::get('/checkout/manual-payment/{id}', [CheckoutController::class, 'manualPayment'])->name('checkout.manual-payment');
    Route::get('/checkout/success/{id}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::post('/checkout/upload-proof/{id}', [CheckoutController::class, 'uploadProof'])->name('checkout.upload-proof');


    // Rute Admin
    Route::middleware('role:admin,owner')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('products', AdminProductController::class);
        Route::resource('categories', AdminCategoryController::class);
        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::post('orders/{order}/accept', [AdminOrderController::class, 'acceptPayment'])->name('orders.accept');
        Route::post('orders/{order}/reject', [AdminOrderController::class, 'rejectPayment'])->name('orders.reject');
        Route::patch('orders/{order}', [AdminOrderController::class, 'updateStatus'])->name('orders.update');
        Route::get('reports', [AdminReportController::class, 'index'])->name('reports.index');
    });

    // Rute Owner
    Route::middleware('role:owner')->prefix('owner')->name('owner.')->group(function () {
        Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');
        Route::resource('customers', OwnerCustomerController::class);
    });
});

require __DIR__.'/auth.php';

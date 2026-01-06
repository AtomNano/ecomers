<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Customer\HomeController as CustomerHomeController;
use App\Http\Controllers\Customer\ProductController as CustomerProductController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\Owner\CustomerController;
use App\Http\Controllers\Owner\ReportController as OwnerReportController;
use App\Http\Controllers\Owner\SettingController as OwnerSettingController;

// Public Routes
Route::get('/', [CustomerHomeController::class, 'index'])->name('home');
Route::get('/about', [CustomerHomeController::class, 'about'])->name('about');
Route::get('/contact', [CustomerHomeController::class, 'contact'])->name('contact');

// Public Products - Dapat diakses tanpa login
Route::get('/products', [CustomerProductController::class, 'publicIndex'])->name('products.index');
Route::get('/products/{product}', [CustomerProductController::class, 'publicShow'])->name('products.show');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('forgot-password');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendReset'])->name('forgot-password-send');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showReset'])->name('reset-password');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('reset-password-submit');
    
    // Google OAuth Routes
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Public Order/Payment Routes (No auth required for display, but checks order ownership)
Route::get('/orders/{invoice_number}/payment', [OrderController::class, 'showPayment'])->name('orders.payment');
Route::post('/orders/{id}/upload-proof', [OrderController::class, 'uploadProof'])->name('orders.upload');
Route::get('/orders/{invoice_number}/success', [OrderController::class, 'showSuccess'])->name('orders.success');

// Customer Routes
Route::middleware(['auth', 'customer'])->prefix('customer')->group(function () {
    Route::get('/dashboard', [CustomerHomeController::class, 'dashboard'])->name('customer.dashboard');
    Route::get('/products', [CustomerProductController::class, 'index'])->name('customer.products.index');
    Route::get('/products/{product}', [CustomerProductController::class, 'show'])->name('customer.products.show');
    
    // Cart Routes
    Route::post('/cart/{product}', [CartController::class, 'add'])->name('customer.cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('customer.cart.index');
    Route::put('/cart/{cart}', [CartController::class, 'update'])->name('customer.cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('customer.cart.remove');
    Route::delete('/cart-clear', [CartController::class, 'clear'])->name('customer.cart.clear');
    
    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('customer.checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('customer.checkout.store');
    
    // Payment Routes
    Route::get('/payment/{payment}', [PaymentController::class, 'show'])->name('customer.payment.show');
    Route::post('/payment/{payment}/upload', [PaymentController::class, 'uploadProof'])->name('customer.payment.uploadProof');
    Route::get('/payment/{payment}/status', [PaymentController::class, 'status'])->name('customer.payment.status');
    
    // Order History
    Route::get('/orders', [CustomerHomeController::class, 'orders'])->name('customer.orders');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // Product Management
    Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{product}', [AdminProductController::class, 'show'])->name('admin.products.show');
    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
    
    // Order Management
    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::get('/orders/{id}/verify', [OrderController::class, 'verify'])->name('admin.orders.verify');
    Route::post('/orders/{id}/approve', [OrderController::class, 'approve'])->name('admin.orders.approve');
    Route::post('/orders/{id}/reject', [OrderController::class, 'reject'])->name('admin.orders.reject');
    Route::post('/orders/{order}/ship', [OrderController::class, 'ship'])->name('admin.orders.ship');
    Route::post('/orders/{order}/complete', [OrderController::class, 'complete'])->name('admin.orders.complete');
    
    // Financial Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/reports/financial', [ReportController::class, 'financialReport'])->name('admin.reports.financial');
});

// Owner Routes
Route::middleware(['auth', 'owner'])->prefix('owner')->group(function () {
    Route::get('/', [OwnerDashboardController::class, 'index'])->name('owner.dashboard');
    
    // Customer Management
    Route::get('/customers', [CustomerController::class, 'index'])->name('owner.customers.index');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('owner.customers.create');
    Route::post('/customers', [CustomerController::class, 'store'])->name('owner.customers.store');
    Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('owner.customers.edit');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('owner.customers.update');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('owner.customers.destroy');
    
    // Reports
    Route::get('/reports', [OwnerReportController::class, 'index'])->name('owner.reports.index');
    Route::get('/reports/export', [OwnerReportController::class, 'exportCsv'])->name('owner.reports.export');
    Route::get('/reports/customers', [OwnerReportController::class, 'customerReport'])->name('owner.reports.customers');

    // Settings (Payment & Store Info)
    Route::get('/settings', [OwnerSettingController::class, 'edit'])->name('owner.settings.edit');
    Route::put('/settings', [OwnerSettingController::class, 'update'])->name('owner.settings.update');
});


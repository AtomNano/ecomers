<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/luthfinaldi', function () {
    return view('welcome');
});


Route::get('/home', [HomeController::class, 'index'])->name('home');

// Grup rute yang hanya bisa diakses oleh pengguna yang sudah login
Route::middleware('auth')->group(function () {
    // Rute untuk admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/products', function () {
            return '<h1>Halaman Kelola Produk (Khusus Admin)</h1>';
        })->name('admin.products');
    });

    // Rute untuk owner
    Route::middleware('role:owner')->group(function () {
        Route::get('/owner/settings', function () {
            return '<h1>Halaman Pengaturan (Khusus Owner)</h1>';
        })->name('owner.settings');
    });

    // Rute untuk admin dan owner
    Route::middleware('role:admin,owner')->group(function () {
        Route::get('/panel/dashboard', function () {
            return '<h1>Halaman Panel (Khusus Admin & Owner)</h1>';
        })->name('panel.dashboard');
    });
});
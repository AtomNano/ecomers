@extends('layouts.admin.app')

@section('title', 'Laporan Lanjutan - Grosir Berkat Ibu')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-neutral-900">Laporan Lanjutan</h1>
        <p class="text-neutral-600 mt-2">Analisis mendalam untuk pengambilan keputusan bisnis</p>
    </div>

    <!-- Report Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Sales Report -->
        <div class="bg-white rounded-lg shadow-soft p-6 hover:shadow-medium transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <span class="badge badge-success">Aktif</span>
            </div>
            <h3 class="text-xl font-semibold text-neutral-900 mb-2">Laporan Penjualan</h3>
            <p class="text-neutral-600 mb-4">Analisis penjualan harian, kategori, dan produk terlaris dengan filter tanggal dan ekspor data.</p>
            <div class="flex space-x-2">
                <a href="{{ route('owner.reports.sales') }}" class="btn-primary flex-1 text-center">
                    Lihat Laporan
                </a>
            </div>
        </div>

        <!-- Products Report -->
        <div class="bg-white rounded-lg shadow-soft p-6 hover:shadow-medium transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <span class="badge badge-success">Aktif</span>
            </div>
            <h3 class="text-xl font-semibold text-neutral-900 mb-2">Laporan Produk</h3>
            <p class="text-neutral-600 mb-4">Analisis performa produk, stok rendah, dan produk yang belum pernah terjual.</p>
            <div class="flex space-x-2">
                <a href="{{ route('owner.reports.products') }}" class="btn-primary flex-1 text-center">
                    Lihat Laporan
                </a>
            </div>
        </div>

        <!-- Customers Report -->
        <div class="bg-white rounded-lg shadow-soft p-6 hover:shadow-medium transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <span class="badge badge-success">Aktif</span>
            </div>
            <h3 class="text-xl font-semibold text-neutral-900 mb-2">Laporan Pelanggan</h3>
            <p class="text-neutral-600 mb-4">Analisis segmentasi pelanggan, top customers, dan customer acquisition.</p>
            <div class="flex space-x-2">
                <a href="{{ route('owner.reports.customers') }}" class="btn-primary flex-1 text-center">
                    Lihat Laporan
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-soft p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-neutral-600">Total Penjualan Bulan Ini</p>
                    <p class="text-2xl font-bold text-green-600">Rp 0</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-soft p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-neutral-600">Produk Terlaris</p>
                    <p class="text-2xl font-bold text-blue-600">-</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-soft p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-neutral-600">Pelanggan Aktif</p>
                    <p class="text-2xl font-bold text-purple-600">0</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-soft p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-neutral-600">Rata-rata Order</p>
                    <p class="text-2xl font-bold text-orange-600">Rp 0</p>
                </div>
                <div class="p-3 bg-orange-100 rounded-full">
                    <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow-soft p-6">
        <h3 class="text-lg font-semibold text-neutral-900 mb-4">Aktivitas Terbaru</h3>
        <div class="space-y-4">
            <div class="flex items-center space-x-3 p-3 bg-neutral-50 rounded-lg">
                <div class="p-2 bg-green-100 rounded-full">
                    <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm text-neutral-900">Sistem laporan lanjutan telah diaktifkan</p>
                    <p class="text-xs text-neutral-500">Baru saja</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-3 p-3 bg-neutral-50 rounded-lg">
                <div class="p-2 bg-blue-100 rounded-full">
                    <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm text-neutral-900">Fitur ekspor data ke CSV telah tersedia</p>
                    <p class="text-xs text-neutral-500">Baru saja</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




@extends('layouts.admin-layout')

@section('title', 'Dashboard Admin')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Dashboard Admin</h1>
            <p class="text-gray-500 mt-1">Selamat datang kembali! Berikut ringkasan toko Anda.</p>
        </div>
        <div class="flex items-center gap-2 text-sm text-gray-500 bg-white px-4 py-2 rounded-xl shadow-sm">
            <i class="fas fa-calendar-alt text-emerald-500"></i>
            <span>{{ now()->translatedFormat('l, d F Y') }}</span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-5 text-white transform hover:scale-105 hover:shadow-xl transition-all cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-xs lg:text-sm font-medium">Total Pesanan</p>
                    <p class="text-2xl lg:text-3xl font-bold mt-1">{{ $totalOrders }}</p>
                </div>
                <div class="bg-blue-400/30 p-2 lg:p-3 rounded-xl">
                    <i class="fas fa-shopping-bag text-xl lg:text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl shadow-lg p-5 text-white transform hover:scale-105 hover:shadow-xl transition-all cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-amber-100 text-xs lg:text-sm font-medium">Menunggu Verifikasi</p>
                    <p class="text-2xl lg:text-3xl font-bold mt-1">{{ $pendingPayments }}</p>
                </div>
                <div class="bg-amber-400/30 p-2 lg:p-3 rounded-xl">
                    <i class="fas fa-clock text-xl lg:text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-5 text-white transform hover:scale-105 hover:shadow-xl transition-all cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-xs lg:text-sm font-medium">Dalam Pengiriman</p>
                    <p class="text-2xl lg:text-3xl font-bold mt-1">{{ $shippedOrders }}</p>
                </div>
                <div class="bg-purple-400/30 p-2 lg:p-3 rounded-xl">
                    <i class="fas fa-truck text-xl lg:text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl shadow-lg p-5 text-white transform hover:scale-105 hover:shadow-xl transition-all cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-100 text-xs lg:text-sm font-medium">Selesai</p>
                    <p class="text-2xl lg:text-3xl font-bold mt-1">{{ $completedOrders }}</p>
                </div>
                <div class="bg-emerald-400/30 p-2 lg:p-3 rounded-xl">
                    <i class="fas fa-check-circle text-xl lg:text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-red-500 to-rose-600 rounded-2xl shadow-lg p-5 text-white transform hover:scale-105 hover:shadow-xl transition-all cursor-pointer col-span-2 lg:col-span-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-xs lg:text-sm font-medium">Stok Rendah</p>
                    <p class="text-2xl lg:text-3xl font-bold mt-1">{{ $lowStockProducts }}</p>
                </div>
                <div class="bg-red-400/30 p-2 lg:p-3 rounded-xl">
                    <i class="fas fa-exclamation-triangle text-xl lg:text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Revenue Card -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-emerald-500">
            <div class="flex items-center gap-3 mb-6">
                <div class="bg-emerald-100 p-3 rounded-xl">
                    <i class="fas fa-chart-line text-emerald-600 text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Total Penjualan</h2>
                    <p class="text-gray-500 text-xs">Dari pesanan yang telah selesai</p>
                </div>
            </div>
            <p class="text-3xl lg:text-4xl font-bold text-emerald-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            <div class="mt-4 flex items-center gap-2 text-sm">
                <span class="inline-flex items-center gap-1 text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg">
                    <i class="fas fa-arrow-up"></i> {{ $completedOrders }} pesanan
                </span>
                <span class="text-gray-400">selesai bulan ini</span>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="bg-blue-100 p-3 rounded-xl">
                    <i class="fas fa-bolt text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Aksi Cepat</h2>
                    <p class="text-gray-500 text-xs">Navigasi ke halaman yang sering diakses</p>
                </div>
            </div>
            <div class="space-y-3">
                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-3 rounded-xl hover:from-blue-600 hover:to-blue-700 transition shadow-md hover:shadow-lg">
                    <i class="fas fa-boxes w-5"></i>
                    <span class="font-medium">Kelola Produk</span>
                    <i class="fas fa-arrow-right ml-auto"></i>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white px-4 py-3 rounded-xl hover:from-amber-600 hover:to-orange-600 transition shadow-md hover:shadow-lg">
                    <i class="fas fa-clipboard-list w-5"></i>
                    <span class="font-medium">Kelola Pesanan</span>
                    @if($pendingPayments > 0)
                    <span class="ml-auto bg-white/20 px-3 py-1 rounded-full text-xs font-bold">{{ $pendingPayments }} baru</span>
                    @else
                    <i class="fas fa-arrow-right ml-auto"></i>
                    @endif
                </a>
                <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white px-4 py-3 rounded-xl hover:from-purple-600 hover:to-purple-700 transition shadow-md hover:shadow-lg">
                    <i class="fas fa-chart-bar w-5"></i>
                    <span class="font-medium">Lihat Laporan</span>
                    <i class="fas fa-arrow-right ml-auto"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-gray-100 p-3 rounded-xl">
                        <i class="fas fa-history text-gray-600 text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Pesanan Terbaru</h2>
                        <p class="text-gray-500 text-xs">10 pesanan terakhir yang masuk</p>
                    </div>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium flex items-center gap-1">
                    Lihat Semua <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        
        @if($recentOrders->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No. Pesanan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pelanggan</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Pembayaran</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($recentOrders as $order)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <span class="font-bold text-gray-800">#{{ $order->id }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                </div>
                                <span class="text-gray-700">{{ $order->user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right font-semibold text-gray-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                @if($order->status === 'pending') bg-yellow-100 text-yellow-700
                                @elseif($order->status === 'processing') bg-blue-100 text-blue-700
                                @elseif($order->status === 'shipped') bg-purple-100 text-purple-700
                                @elseif($order->status === 'completed') bg-green-100 text-green-700
                                @else bg-red-100 text-red-700
                                @endif">
                                <i class="fas fa-circle text-[6px] mr-1.5"></i>
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                @if($order->payment->status === 'pending') bg-yellow-100 text-yellow-700
                                @elseif($order->payment->status === 'verified') bg-green-100 text-green-700
                                @else bg-red-100 text-red-700
                                @endif">
                                {{ ucfirst($order->payment->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center gap-1 text-emerald-600 hover:text-emerald-700 font-medium text-sm">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-inbox text-gray-400 text-2xl"></i>
            </div>
            <p class="text-gray-500">Belum ada pesanan</p>
        </div>
        @endif
    </div>
</div>
@endsection

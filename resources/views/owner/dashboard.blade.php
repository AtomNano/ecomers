@extends('layouts.admin-layout')

@section('title', 'Dashboard Owner')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Dashboard Owner</h1>
            <p class="text-gray-500 mt-1">Selamat datang kembali! Berikut ringkasan bisnis Anda.</p>
        </div>
        <div class="flex items-center gap-2 text-sm text-gray-500 bg-white px-4 py-2 rounded-xl shadow-sm">
            <i class="fas fa-calendar-alt text-emerald-500"></i>
            <span>{{ now()->translatedFormat('l, d F Y') }}</span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-5 text-white transform hover:scale-105 hover:shadow-xl transition-all cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-xs lg:text-sm font-medium">Total Pelanggan</p>
                    <p class="text-2xl lg:text-3xl font-bold mt-1">{{ $totalCustomers }}</p>
                </div>
                <div class="bg-blue-400/30 p-2 lg:p-3 rounded-xl">
                    <i class="fas fa-users text-xl lg:text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl shadow-lg p-5 text-white transform hover:scale-105 hover:shadow-xl transition-all cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-amber-100 text-xs lg:text-sm font-medium">Total Pesanan</p>
                    <p class="text-2xl lg:text-3xl font-bold mt-1">{{ $totalOrders }}</p>
                </div>
                <div class="bg-amber-400/30 p-2 lg:p-3 rounded-xl">
                    <i class="fas fa-shopping-bag text-xl lg:text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl shadow-lg p-5 text-white transform hover:scale-105 hover:shadow-xl transition-all cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-100 text-xs lg:text-sm font-medium">Total Penjualan</p>
                    <p class="text-lg lg:text-2xl font-bold mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="bg-emerald-400/30 p-2 lg:p-3 rounded-xl">
                    <i class="fas fa-chart-line text-xl lg:text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-red-500 to-rose-600 rounded-2xl shadow-lg p-5 text-white transform hover:scale-105 hover:shadow-xl transition-all cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-xs lg:text-sm font-medium">Menunggu Verifikasi</p>
                    <p class="text-2xl lg:text-3xl font-bold mt-1">{{ $pendingPayments }}</p>
                </div>
                <div class="bg-red-400/30 p-2 lg:p-3 rounded-xl">
                    <i class="fas fa-clock text-xl lg:text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Info -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="bg-blue-100 p-3 rounded-xl">
                    <i class="fas fa-bolt text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Aksi Cepat</h2>
                    <p class="text-gray-500 text-xs">Menu navigasi utama</p>
                </div>
            </div>
            <div class="space-y-3">
                <a href="{{ route('owner.customers.index') }}" class="flex items-center gap-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-3 rounded-xl hover:from-blue-600 hover:to-blue-700 transition shadow-md hover:shadow-lg">
                    <i class="fas fa-users w-5"></i>
                    <span class="font-medium">Kelola Pelanggan</span>
                    <i class="fas fa-arrow-right ml-auto"></i>
                </a>
                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-4 py-3 rounded-xl hover:from-emerald-600 hover:to-teal-700 transition shadow-md hover:shadow-lg">
                    <i class="fas fa-boxes w-5"></i>
                    <span class="font-medium">Kelola Produk</span>
                    <i class="fas fa-arrow-right ml-auto"></i>
                </a>
                <a href="{{ route('owner.reports.index') }}" class="flex items-center gap-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white px-4 py-3 rounded-xl hover:from-purple-600 hover:to-purple-700 transition shadow-md hover:shadow-lg">
                    <i class="fas fa-chart-bar w-5"></i>
                    <span class="font-medium">Laporan Penjualan</span>
                    <i class="fas fa-arrow-right ml-auto"></i>
                </a>
            </div>
        </div>

        <!-- Recent Customers -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-center gap-3 mb-6">
                <div class="bg-blue-100 p-3 rounded-xl">
                    <i class="fas fa-user-plus text-blue-600"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Pelanggan Terbaru</h2>
                    <p class="text-gray-500 text-xs">5 pelanggan terakhir</p>
                </div>
            </div>
            <div class="space-y-3">
                @forelse($recentCustomers as $customer)
                    <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold shadow">
                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-800 truncate">{{ $customer->name }}</p>
                            <p class="text-gray-500 text-xs truncate">{{ $customer->email }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-400">
                        <i class="fas fa-user-slash text-3xl mb-2"></i>
                        <p class="text-sm">Belum ada pelanggan baru</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Orders (Actionable) -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6 border-t-4 border-amber-500">
            <div class="flex items-center justify-between gap-3 mb-6">
                <div class="flex items-center gap-3">
                    <div class="bg-amber-100 p-3 rounded-xl">
                        <i class="fas fa-shopping-cart text-amber-600"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Pesanan Terbaru</h2>
                        <p class="text-gray-500 text-xs">Perlu tindakan Anda</p>
                    </div>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-amber-600 hover:text-amber-700">Lihat Semua</a>
            </div>
            
            <div class="space-y-4">
                @forelse($recentOrders as $order)
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 border border-gray-100 rounded-xl hover:border-amber-200 hover:shadow-sm transition gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center text-gray-400 font-bold border border-gray-200">
                                #{{ $order->id }}
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <p class="font-bold text-gray-800">{{ $order->user->name }}</p>
                                    <span class="text-xs text-gray-400">• {{ $order->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide
                                        @if($order->status == 'pending') bg-yellow-100 text-yellow-700
                                        @elseif($order->status == 'processing') bg-blue-100 text-blue-700
                                        @elseif($order->status == 'shipped') bg-purple-100 text-purple-700
                                        @elseif($order->status == 'completed') bg-green-100 text-green-700
                                        @else bg-red-100 text-red-700 @endif">
                                        {{ $order->status }}
                                    </span>
                                    <span class="text-sm font-semibold text-gray-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            @if($order->status == 'pending' || $order->payment_status == 'pending')
                                <a href="{{ route('admin.orders.show', $order) }}" class="flex-1 sm:flex-none px-4 py-2 bg-amber-500 text-white text-sm font-bold rounded-lg hover:bg-amber-600 transition shadow-sm hover:shadow-amber-500/30">
                                    Proses Pesanan
                                </a>
                            @else
                                <a href="{{ route('admin.orders.show', $order) }}" class="flex-1 sm:flex-none px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                                    Detail
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 text-gray-400 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                        <i class="fas fa-check-circle text-4xl mb-3 text-gray-300"></i>
                         <p class="font-medium">Tidak ada pesanan baru</p>
                        <p class="text-xs">Semua aman terkendali!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Top Selling Products -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="bg-amber-100 p-3 rounded-xl">
                    <i class="fas fa-trophy text-amber-600 text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800">5 Produk Terlaris</h2>
                    <p class="text-gray-500 text-xs">Produk dengan penjualan tertinggi</p>
                </div>
            </div>
        </div>
        <div class="p-6 space-y-4">
            @forelse($topProducts as $item)
            <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl border-l-4 border-amber-400 hover:shadow-md transition">
                <!-- Ranking Badge -->
                <span class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-amber-400 to-orange-500 text-white font-bold rounded-xl flex items-center justify-center text-lg shadow">
                    #{{ $loop->iteration }}
                </span>
                
                <!-- Product Info -->
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-gray-800 truncate">{{ $item->product->name }}</p>
                    <p class="text-xs text-gray-500">Kategori: {{ $item->product->category->name }}</p>
                </div>

                <!-- Sales Stats -->
                <div class="flex-shrink-0 text-right">
                    <p class="text-2xl font-bold text-blue-600">{{ $item->total_sold }}</p>
                    <p class="text-xs text-gray-500">{{ $item->product->unit ?? 'pcs' }} terjual</p>
                </div>
            </div>
            @empty
            <div class="text-center py-12 text-gray-400">
                <i class="fas fa-box-open text-4xl mb-3"></i>
                <p>Belum ada data produk terjual</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Owner Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Owner Dashboard</h1>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-blue-100 rounded shadow p-6 text-center">
            <p class="text-blue-600 text-3xl font-bold">{{ $totalCustomers }}</p>
            <p class="text-blue-700 font-semibold">Total Pelanggan</p>
        </div>
        <div class="bg-yellow-100 rounded shadow p-6 text-center">
            <p class="text-yellow-600 text-3xl font-bold">{{ $totalOrders }}</p>
            <p class="text-yellow-700 font-semibold">Total Pesanan</p>
        </div>
        <div class="bg-green-100 rounded shadow p-6 text-center">
            <p class="text-green-600 text-3xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            <p class="text-green-700 font-semibold text-sm">Total Penjualan</p>
        </div>
        <div class="bg-red-100 rounded shadow p-6 text-center">
            <p class="text-red-600 text-3xl font-bold">{{ $pendingPayments }}</p>
            <p class="text-red-700 font-semibold">Pembayaran Menunggu</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <div class="bg-white rounded shadow p-6">
            <h2 class="text-xl font-bold mb-4">Quick Links</h2>
            <div class="space-y-2">
                <a href="{{ route('owner.customers.index') }}" class="block bg-blue-600 text-white px-4 py-2 rounded text-center hover:bg-blue-700">
                    Kelola Pelanggan
                </a>
                <a href="{{ route('owner.reports.index') }}" class="block bg-purple-600 text-white px-4 py-2 rounded text-center hover:bg-purple-700">
                    Laporan Penjualan
                </a>
            </div>
        </div>

        <!-- Recent Customers -->
        <div class="bg-white rounded shadow p-6">
            <h2 class="text-lg font-bold mb-3">Pelanggan Terbaru</h2>
            <div class="space-y-2">
                @foreach($recentCustomers as $customer)
                    <div class="text-sm">
                        <p class="font-semibold">{{ $customer->name }}</p>
                        <p class="text-gray-600">{{ $customer->email }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-white rounded shadow p-6">
            <h2 class="text-lg font-bold mb-3">Pesanan Terbaru</h2>
            <div class="space-y-2">
                @foreach($recentOrders as $order)
                    <div class="text-sm flex justify-between">
                        <div>
                            <p class="font-semibold">#{{ $order->id }}</p>
                            <p class="text-gray-600">{{ $order->user->name }}</p>
                        </div>
                        <p class="font-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Top Selling Products -->
    <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-yellow-500">
        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            <span class="text-2xl">🏆</span> 5 Barang Paling Laris
        </h2>
        <div class="space-y-3">
            @forelse($topProducts as $item)
            <div class="flex items-center justify-between py-3 px-4 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-lg border-l-4 border-yellow-400 hover:shadow-md transition">
                <div class="flex items-center gap-4 flex-1">
                    <!-- Ranking Badge -->
                    <span class="flex-shrink-0 w-10 h-10 bg-yellow-400 text-white font-bold rounded-full flex items-center justify-center text-lg">
                        #{{ $loop->iteration }}
                    </span>
                    
                    <!-- Product Info -->
                    <div class="flex-1">
                        <p class="font-bold text-gray-900">{{ $item->product->name }}</p>
                        <p class="text-xs text-gray-600">Kategori: {{ $item->product->category->name }}</p>
                    </div>
                </div>

                <!-- Sales Stats -->
                <div class="flex-shrink-0 text-right">
                    <p class="text-2xl font-bold text-blue-600">{{ $item->total_sold }}</p>
                    <p class="text-xs text-gray-600">{{ $item->product->unit ?? 'pcs' }} terjual</p>
                </div>
            </div>
            @empty
            <div class="text-center py-8 text-gray-500">
                <p>Belum ada data barang terjual</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

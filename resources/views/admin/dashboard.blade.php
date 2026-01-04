@extends('layouts.app')

@section('title', 'Admin Dashboard - Grosir Berkat Ibu')

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        <div class="bg-blue-100 rounded shadow p-6 text-center">
            <p class="text-blue-600 text-3xl font-bold">{{ $totalOrders }}</p>
            <p class="text-blue-700 font-semibold">Total Pesanan</p>
        </div>
        <div class="bg-yellow-100 rounded shadow p-6 text-center">
            <p class="text-yellow-600 text-3xl font-bold">{{ $pendingPayments }}</p>
            <p class="text-yellow-700 font-semibold">Pembayaran Menunggu</p>
        </div>
        <div class="bg-purple-100 rounded shadow p-6 text-center">
            <p class="text-purple-600 text-3xl font-bold">{{ $shippedOrders }}</p>
            <p class="text-purple-700 font-semibold">Dikirim</p>
        </div>
        <div class="bg-green-100 rounded shadow p-6 text-center">
            <p class="text-green-600 text-3xl font-bold">{{ $completedOrders }}</p>
            <p class="text-green-700 font-semibold">Selesai</p>
        </div>
        <div class="bg-red-100 rounded shadow p-6 text-center">
            <p class="text-red-600 text-3xl font-bold">{{ $lowStockProducts }}</p>
            <p class="text-red-700 font-semibold">Stock Rendah</p>
        </div>
    </div>

    <!-- Revenue & Recent Orders -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Revenue -->
        <div class="bg-white rounded shadow p-6">
            <h2 class="text-xl font-bold mb-4">Total Penjualan</h2>
            <p class="text-3xl font-bold text-green-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            <p class="text-gray-600 text-sm mt-2">Dari pesanan yang telah selesai</p>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded shadow p-6">
            <h2 class="text-xl font-bold mb-4">Quick Links</h2>
            <div class="space-y-2">
                <a href="{{ route('admin.products.index') }}" class="block bg-blue-600 text-white px-4 py-2 rounded text-center hover:bg-blue-700">
                    Kelola Produk
                </a>
                <a href="{{ route('admin.orders.index') }}" class="block bg-yellow-600 text-white px-4 py-2 rounded text-center hover:bg-yellow-700">
                    Kelola Pesanan
                </a>
                <a href="{{ route('admin.reports.index') }}" class="block bg-purple-600 text-white px-4 py-2 rounded text-center hover:bg-purple-700">
                    Laporan Keuangan
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded shadow p-6 mt-8">
        <h2 class="text-xl font-bold mb-4">Pesanan Terbaru</h2>
        
        @if($recentOrders->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-4 py-3 text-left">No. Pesanan</th>
                            <th class="px-4 py-3 text-left">Pelanggan</th>
                            <th class="px-4 py-3 text-right">Total</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-center">Pembayaran</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3 font-bold">#{{ $order->id }}</td>
                                <td class="px-4 py-3">{{ $order->user->name }}</td>
                                <td class="px-4 py-3 text-right">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-bold
                                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                                        @elseif($order->status === 'completed') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-bold
                                        @if($order->payment->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->payment->status === 'verified') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($order->payment->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-700 text-sm">Lihat</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-600">Tidak ada pesanan</p>
        @endif
    </div>
</div>
@endsection

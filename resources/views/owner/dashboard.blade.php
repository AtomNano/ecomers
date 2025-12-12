@extends('layouts.admin.app')

@section('title', 'Dashboard Owner - Grosir Berkat Ibu')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-neutral-900">Dashboard Owner</h1>
        <p class="text-neutral-600 mt-2">Selamat datang di panel owner Grosir Berkat Ibu</p>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Pelanggan -->
        <div class="bg-white rounded-lg shadow-soft p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-neutral-600">Total Pelanggan</p>
                    <p class="text-3xl font-bold text-primary-600">{{ number_format($totalCustomers) }}</p>
                </div>
                <div class="p-3 bg-primary-100 rounded-full">
                    <svg class="h-6 w-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Admin -->
        <div class="bg-white rounded-lg shadow-soft p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-neutral-600">Total Admin</p>
                    <p class="text-3xl font-bold text-secondary-600">{{ number_format($totalAdmins) }}</p>
                </div>
                <div class="p-3 bg-secondary-100 rounded-full">
                    <svg class="h-6 w-6 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Produk -->
        <div class="bg-white rounded-lg shadow-soft p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-neutral-600">Total Produk</p>
                    <p class="text-3xl font-bold text-green-600">{{ number_format($totalProducts) }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Kategori -->
        <div class="bg-white rounded-lg shadow-soft p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-neutral-600">Total Kategori</p>
                    <p class="text-3xl font-bold text-purple-600">{{ number_format($totalCategories) }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Pesanan -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-soft p-6">
            <div class="text-center">
                <p class="text-sm font-medium text-neutral-600">Total Pesanan</p>
                <p class="text-2xl font-bold text-neutral-900">{{ number_format($totalOrders) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-soft p-6">
            <div class="text-center">
                <p class="text-sm font-medium text-neutral-600">Menunggu Pembayaran</p>
                <p class="text-2xl font-bold text-yellow-600">{{ number_format($pendingOrders) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-soft p-6">
            <div class="text-center">
                <p class="text-sm font-medium text-neutral-600">Sedang Diproses</p>
                <p class="text-2xl font-bold text-blue-600">{{ number_format($processingOrders) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-soft p-6">
            <div class="text-center">
                <p class="text-sm font-medium text-neutral-600">Dikirim</p>
                <p class="text-2xl font-bold text-indigo-600">{{ number_format($shippedOrders) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-soft p-6">
            <div class="text-center">
                <p class="text-sm font-medium text-neutral-600">Selesai</p>
                <p class="text-2xl font-bold text-green-600">{{ number_format($completedOrders) }}</p>
            </div>
        </div>
    </div>

    <!-- Pendapatan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-soft p-6">
            <div class="text-center">
                <p class="text-sm font-medium text-neutral-600">Pendapatan Hari Ini</p>
                <p class="text-2xl font-bold text-green-600">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-soft p-6">
            <div class="text-center">
                <p class="text-sm font-medium text-neutral-600">Pendapatan Bulan Ini</p>
                <p class="text-2xl font-bold text-primary-600">Rp {{ number_format($thisMonthRevenue, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-soft p-6">
            <div class="text-center">
                <p class="text-sm font-medium text-neutral-600">Pendapatan Bulan Lalu</p>
                <p class="text-2xl font-bold text-neutral-600">Rp {{ number_format($lastMonthRevenue, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Grafik dan Tabel -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Grafik Pendapatan 7 Hari -->
        <div class="bg-white rounded-lg shadow-soft p-6">
            <h3 class="text-lg font-semibold text-neutral-900 mb-4">Pendapatan 7 Hari Terakhir</h3>
            <canvas id="revenueChart" width="400" height="200"></canvas>
        </div>

        <!-- Grafik Pendapatan 12 Bulan -->
        <div class="bg-white rounded-lg shadow-soft p-6">
            <h3 class="text-lg font-semibold text-neutral-900 mb-4">Pendapatan 12 Bulan Terakhir</h3>
            <canvas id="monthlyRevenueChart" width="400" height="200"></canvas>
        </div>
    </div>

    <!-- Produk Terlaris dan Stok Rendah -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Produk Terlaris -->
        <div class="bg-white rounded-lg shadow-soft p-6">
            <h3 class="text-lg font-semibold text-neutral-900 mb-4">Produk Terlaris</h3>
            <div class="space-y-4">
                @forelse($bestSellingProducts as $product)
                <div class="flex items-center justify-between p-3 bg-neutral-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder-product.jpg') }}" 
                             alt="{{ $product->name }}" class="w-10 h-10 object-cover rounded">
                        <div>
                            <p class="font-medium text-neutral-900">{{ $product->name }}</p>
                            <p class="text-sm text-neutral-600">{{ $product->category->name }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-primary-600">{{ number_format($product->sales_count) }}</p>
                        <p class="text-xs text-neutral-500">terjual</p>
                    </div>
                </div>
                @empty
                <p class="text-neutral-500 text-center py-4">Belum ada data penjualan</p>
                @endforelse
            </div>
        </div>

        <!-- Produk Stok Rendah -->
        <div class="bg-white rounded-lg shadow-soft p-6">
            <h3 class="text-lg font-semibold text-neutral-900 mb-4">Produk Stok Rendah</h3>
            <div class="space-y-4">
                @forelse($lowStockProducts as $product)
                <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder-product.jpg') }}" 
                             alt="{{ $product->name }}" class="w-10 h-10 object-cover rounded">
                        <div>
                            <p class="font-medium text-neutral-900">{{ $product->name }}</p>
                            <p class="text-sm text-neutral-600">{{ $product->category->name }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-red-600">{{ number_format($product->stock) }}</p>
                        <p class="text-xs text-neutral-500">stok tersisa</p>
                    </div>
                </div>
                @empty
                <p class="text-neutral-500 text-center py-4">Semua produk memiliki stok yang cukup</p>
                @endforelse
            </div>
                            </div>
                            </div>

    <!-- Pelanggan Terbaik dan Aktivitas Terbaru -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Pelanggan Terbaik -->
        <div class="bg-white rounded-lg shadow-soft p-6">
            <h3 class="text-lg font-semibold text-neutral-900 mb-4">Pelanggan Terbaik</h3>
            <div class="space-y-4">
                @forelse($topCustomers as $customer)
                <div class="flex items-center justify-between p-3 bg-neutral-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                            <span class="text-primary-600 font-semibold">{{ substr($customer->name, 0, 1) }}</span>
                            </div>
                        <div>
                            <p class="font-medium text-neutral-900">{{ $customer->name }}</p>
                            <p class="text-sm text-neutral-600">{{ $customer->email }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-primary-600">Rp {{ number_format($customer->orders_sum_total_amount ?? 0, 0, ',', '.') }}</p>
                        <p class="text-xs text-neutral-500">total belanja</p>
                    </div>
                </div>
                @empty
                <p class="text-neutral-500 text-center py-4">Belum ada data pelanggan</p>
                @endforelse
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="bg-white rounded-lg shadow-soft p-6">
            <h3 class="text-lg font-semibold text-neutral-900 mb-4">Aktivitas Terbaru</h3>
            <div class="space-y-4">
                @forelse($recentActivities as $activity)
                <div class="flex items-start space-x-3 p-3 bg-neutral-50 rounded-lg">
                    <div class="p-2 bg-{{ $activity['color'] }}-100 rounded-full">
                        @if($activity['icon'] === 'shopping-cart')
                        <svg class="h-4 w-4 text-{{ $activity['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                        </svg>
                        @elseif($activity['icon'] === 'package')
                        <svg class="h-4 w-4 text-{{ $activity['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        @elseif($activity['icon'] === 'user')
                        <svg class="h-4 w-4 text-{{ $activity['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        @endif
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-neutral-900">{{ $activity['message'] }}</p>
                        <p class="text-xs text-neutral-500">{{ $activity['time']->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <p class="text-neutral-500 text-center py-4">Belum ada aktivitas</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Statistik Kategori -->
    <div class="bg-white rounded-lg shadow-soft p-6">
        <h3 class="text-lg font-semibold text-neutral-900 mb-4">Statistik Kategori</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200">
                <thead class="bg-neutral-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Jumlah Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Total Terjual</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Persentase</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-neutral-200">
                    @forelse($categoryStats as $category)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="text-sm font-medium text-neutral-900">{{ $category->name }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-neutral-900">{{ number_format($category->products_count) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-neutral-900">{{ number_format($category->products_sum_sales_count ?? 0) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-neutral-900">
                                @php
                                    $totalSales = $categoryStats->sum('products_sum_sales_count');
                                    $percentage = $totalSales > 0 ? ($category->products_sum_sales_count / $totalSales) * 100 : 0;
                                @endphp
                                {{ number_format($percentage, 1) }}%
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-neutral-500">Belum ada data kategori</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Grafik Pendapatan 7 Hari
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode(collect($revenueChart)->pluck('date')) !!},
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: {!! json_encode(collect($revenueChart)->pluck('revenue')) !!},
            borderColor: 'rgb(59, 130, 246)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        }
    }
});

// Grafik Pendapatan 12 Bulan
const monthlyRevenueCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
const monthlyRevenueChart = new Chart(monthlyRevenueCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode(collect($monthlyRevenueChart)->pluck('month')) !!},
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: {!! json_encode(collect($monthlyRevenueChart)->pluck('revenue')) !!},
            backgroundColor: 'rgba(34, 197, 94, 0.8)',
            borderColor: 'rgb(34, 197, 94)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        }
    }
});
</script>
@endsection
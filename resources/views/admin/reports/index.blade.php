@extends('layouts.admin.app')

@section('title', 'Laporan - Grosir Berkat Ibu')
@section('page-title', 'Laporan')
@section('page-description', 'Analisis penjualan dan kinerja bisnis')

@section('content')
<!-- Date Range Filter -->
<div class="card p-6 mb-6">
    <h3 class="text-lg font-semibold text-neutral-900 mb-4">Filter Periode</h3>
    <form method="GET" action="{{ route('admin.reports.index') }}" class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-64">
            <label class="block text-sm font-medium text-neutral-700 mb-2">Dari Tanggal</label>
            <input 
                type="date" 
                name="start_date" 
                value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}"
                class="input-field"
            >
        </div>
        <div class="flex-1 min-w-64">
            <label class="block text-sm font-medium text-neutral-700 mb-2">Sampai Tanggal</label>
            <input 
                type="date" 
                name="end_date" 
                value="{{ request('end_date', now()->format('Y-m-d')) }}"
                class="input-field"
            >
        </div>
        <div class="flex items-end">
            <button type="submit" class="btn-primary">
                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Generate Laporan
            </button>
        </div>
    </form>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-neutral-600">Total Pendapatan</p>
                <p class="text-2xl font-bold text-neutral-900">Rp {{ number_format($summary['total_revenue'] ?? 0) }}</p>
            </div>
        </div>
    </div>

    <div class="card p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-neutral-600">Total Pesanan</p>
                <p class="text-2xl font-bold text-neutral-900">{{ $summary['total_orders'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="card p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-neutral-600">Pelanggan Baru</p>
                <p class="text-2xl font-bold text-neutral-900">{{ $summary['new_customers'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="card p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-neutral-600">Produk Terjual</p>
                <p class="text-2xl font-bold text-neutral-900">{{ $summary['products_sold'] ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Revenue Chart -->
    <div class="card p-6">
        <h3 class="text-lg font-semibold text-neutral-900 mb-4">Grafik Pendapatan</h3>
        <canvas id="revenueChart" width="400" height="200"></canvas>
    </div>

    <!-- Orders Chart -->
    <div class="card p-6">
        <h3 class="text-lg font-semibold text-neutral-900 mb-4">Grafik Pesanan</h3>
        <canvas id="ordersChart" width="400" height="200"></canvas>
    </div>
</div>

<!-- Top Products -->
<div class="card p-6 mb-8">
    <h3 class="text-lg font-semibold text-neutral-900 mb-4">Produk Terlaris</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-neutral-200">
            <thead class="bg-neutral-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Produk</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Terjual</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Pendapatan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Stok</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-neutral-200">
                @forelse($topProducts as $product)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <img 
                                src="{{ $product->image ? asset('storage/products/' . $product->image) : 'https://placehold.co/40x40/f3f4f6/374151?text=P' }}" 
                                alt="{{ $product->name }}"
                                class="w-10 h-10 object-cover rounded-lg mr-3"
                            >
                            <div>
                                <div class="text-sm font-medium text-neutral-900">{{ $product->name }}</div>
                                <div class="text-sm text-neutral-500">{{ $product->category->name ?? 'Kategori' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">{{ $product->sales_count }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">Rp {{ number_format($product->sales_count * $product->price_per_piece) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm text-neutral-900">{{ $product->stock }}</span>
                        @if($product->stock < 5)
                        <span class="ml-2 badge-warning text-xs">Rendah</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-neutral-500">Tidak ada data produk</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Recent Orders -->
<div class="card p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-neutral-900">Pesanan Terbaru</h3>
        <a href="{{ route('admin.orders.index') }}" class="text-sm text-primary-600 hover:text-primary-700">Lihat Semua</a>
    </div>
    
    <div class="space-y-4">
        @forelse($recentOrders as $order)
        <div class="flex items-center justify-between p-3 bg-neutral-50 rounded-lg">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                    <span class="text-primary-600 font-medium text-sm">#{{ $order->id }}</span>
                </div>
                <div>
                    <p class="text-sm font-medium text-neutral-900">{{ $order->user->name ?? 'Guest' }}</p>
                    <p class="text-xs text-neutral-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-sm font-semibold text-neutral-900">Rp {{ number_format($order->total_price) }}</p>
                <span class="badge {{ 
                    $order->status === 'pending' ? 'badge-warning' : 
                    ($order->status === 'completed' ? 'badge-success' : 'badge-primary')
                }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>
        @empty
        <p class="text-neutral-500 text-center py-4">Tidak ada pesanan terbaru</p>
        @endforelse
    </div>
</div>

<script>
// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: @json($chartData['labels'] ?? []),
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: @json($chartData['revenue'] ?? []),
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

// Orders Chart
const ordersCtx = document.getElementById('ordersChart').getContext('2d');
new Chart(ordersCtx, {
    type: 'bar',
    data: {
        labels: @json($chartData['labels'] ?? []),
        datasets: [{
            label: 'Jumlah Pesanan',
            data: @json($chartData['orders'] ?? []),
            backgroundColor: 'rgba(16, 185, 129, 0.8)',
            borderColor: 'rgb(16, 185, 129)',
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
                beginAtZero: true
            }
        }
    }
});
</script>
@endsection

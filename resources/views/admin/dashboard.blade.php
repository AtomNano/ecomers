@extends('layouts.admin.app')

@section('title', 'Dashboard Admin - Grosir Berkat Ibu')
@section('page-title', 'Dashboard')
@section('page-description', 'Ringkasan statistik dan aktivitas terbaru')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- New Orders -->
    <div class="card p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-neutral-600">Pesanan Baru</p>
                <p class="text-2xl font-bold text-neutral-900">{{ $stats['new_orders'] ?? 0 }}</p>
                <p class="text-xs text-green-600">+12% dari kemarin</p>
            </div>
        </div>
    </div>

    <!-- Today's Revenue -->
    <div class="card p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-neutral-600">Pendapatan Hari Ini</p>
                <p class="text-2xl font-bold text-neutral-900">Rp {{ number_format($stats['today_revenue'] ?? 0) }}</p>
                <p class="text-xs text-green-600">+8% dari kemarin</p>
            </div>
        </div>
    </div>

    <!-- Total Customers -->
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
                <p class="text-sm font-medium text-neutral-600">Total Pelanggan</p>
                <p class="text-2xl font-bold text-neutral-900">{{ $stats['total_customers'] ?? 0 }}</p>
                <p class="text-xs text-green-600">+5% dari bulan lalu</p>
            </div>
        </div>
    </div>

    <!-- Low Stock Products -->
    <div class="card p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-neutral-600">Produk Stok Rendah</p>
                <p class="text-2xl font-bold text-neutral-900">{{ $stats['low_stock_products'] ?? 0 }}</p>
                <p class="text-xs text-yellow-600">Perlu restock</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Revenue Chart -->
    <div class="card p-6">
        <h3 class="text-lg font-semibold text-neutral-900 mb-4">Pendapatan 7 Hari Terakhir</h3>
        <canvas id="revenueChart" width="400" height="200"></canvas>
    </div>

    <!-- Order Status Chart -->
    <div class="card p-6">
        <h3 class="text-lg font-semibold text-neutral-900 mb-4">Status Pesanan</h3>
        <canvas id="orderStatusChart" width="400" height="200"></canvas>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
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
                    <span class="badge {{ $order->status === 'pending' ? 'badge-warning' : ($order->status === 'completed' ? 'badge-success' : 'badge-primary') }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>
            @empty
            <p class="text-neutral-500 text-center py-4">Tidak ada pesanan terbaru</p>
            @endforelse
        </div>
    </div>

    <!-- Top Products -->
    <div class="card p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-neutral-900">Produk Terlaris</h3>
            <a href="{{ route('admin.products.index') }}" class="text-sm text-primary-600 hover:text-primary-700">Lihat Semua</a>
        </div>
        <div class="space-y-4">
            @forelse($topProducts as $product)
            <div class="flex items-center space-x-3">
                <img 
                    src="{{ $product->image ? asset('storage/products/' . $product->image) : 'https://placehold.co/60x60/f3f4f6/374151?text=P' }}" 
                    alt="{{ $product->name }}"
                    class="w-12 h-12 object-cover rounded-lg"
                >
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-neutral-900 truncate">{{ $product->name }}</p>
                    <p class="text-xs text-neutral-500">{{ $product->sales_count }} terjual</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-semibold text-neutral-900">Rp {{ number_format($product->price_per_piece) }}</p>
                </div>
            </div>
            @empty
            <p class="text-neutral-500 text-center py-4">Tidak ada data produk</p>
            @endforelse
        </div>
    </div>
</div>

<script>
// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: [1200000, 1900000, 3000000, 5000000, 2000000, 3000000, 4500000],
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

// Order Status Chart
const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
new Chart(orderStatusCtx, {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'Diproses', 'Dikirim', 'Selesai'],
        datasets: [{
            data: [12, 19, 3, 5],
            backgroundColor: [
                'rgb(251, 191, 36)',
                'rgb(59, 130, 246)',
                'rgb(16, 185, 129)',
                'rgb(34, 197, 94)'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>
@endsection
@extends('layouts.admin.app')

@section('title', 'Dashboard Owner - Grosir Berkat Ibu')
@section('page-title', 'Dashboard Owner')
@section('page-description', 'Ringkasan bisnis dan manajemen sistem')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Revenue -->
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
                <p class="text-sm font-medium text-neutral-600">Total Pendapatan</p>
                <p class="text-2xl font-bold text-neutral-900">Rp {{ number_format($stats['total_revenue'] ?? 0) }}</p>
                <p class="text-xs text-green-600">+12% dari bulan lalu</p>
            </div>
        </div>
    </div>

    <!-- Total Customers -->
    <div class="card p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-neutral-600">Total Pelanggan</p>
                <p class="text-2xl font-bold text-neutral-900">{{ $stats['total_customers'] ?? 0 }}</p>
                <p class="text-xs text-green-600">+8% dari bulan lalu</p>
            </div>
        </div>
    </div>

    <!-- Total Products -->
    <div class="card p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-neutral-600">Total Produk</p>
                <p class="text-2xl font-bold text-neutral-900">{{ $stats['total_products'] ?? 0 }}</p>
                <p class="text-xs text-green-600">+5% dari bulan lalu</p>
            </div>
        </div>
    </div>

    <!-- Total Orders -->
    <div class="card p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-neutral-600">Total Pesanan</p>
                <p class="text-2xl font-bold text-neutral-900">{{ $stats['total_orders'] ?? 0 }}</p>
                <p class="text-xs text-green-600">+15% dari bulan lalu</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Revenue Chart -->
    <div class="card p-6">
        <h3 class="text-lg font-semibold text-neutral-900 mb-4">Pendapatan 30 Hari Terakhir</h3>
        <canvas id="revenueChart" width="400" height="200"></canvas>
    </div>

    <!-- Customer Growth Chart -->
    <div class="card p-6">
        <h3 class="text-lg font-semibold text-neutral-900 mb-4">Pertumbuhan Pelanggan</h3>
        <canvas id="customerChart" width="400" height="200"></canvas>
    </div>
</div>

<!-- Management Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <!-- Customer Management -->
    <div class="card p-6">
        <div class="flex items-center mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-neutral-900">Manajemen Pelanggan</h3>
                <p class="text-sm text-neutral-600">Kelola data pelanggan dan grup</p>
            </div>
        </div>
        <div class="space-y-2">
            <a href="{{ route('owner.customers.index') }}" class="btn-primary w-full text-center">
                Lihat Pelanggan
            </a>
            <button onclick="openCreateCustomerModal()" class="btn-outline w-full">
                Tambah Pelanggan
            </button>
        </div>
    </div>

    <!-- Product Management -->
    <div class="card p-6">
        <div class="flex items-center mb-4">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-neutral-900">Manajemen Produk</h3>
                <p class="text-sm text-neutral-600">Kelola produk dan harga bertingkat</p>
            </div>
        </div>
        <div class="space-y-2">
            <a href="{{ route('admin.products.index') }}" class="btn-primary w-full text-center">
                Lihat Produk
            </a>
            <a href="{{ route('admin.products.create') }}" class="btn-outline w-full text-center">
                Tambah Produk
            </a>
        </div>
    </div>

    <!-- Order Management -->
    <div class="card p-6">
        <div class="flex items-center mb-4">
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-neutral-900">Manajemen Pesanan</h3>
                <p class="text-sm text-neutral-600">Kelola pesanan dan status pembayaran</p>
            </div>
        </div>
        <div class="space-y-2">
            <a href="{{ route('admin.orders.index') }}" class="btn-primary w-full text-center">
                Lihat Pesanan
            </a>
            <a href="{{ route('admin.reports.index') }}" class="btn-outline w-full text-center">
                Lihat Laporan
            </a>
        </div>
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

    <!-- Top Customers -->
    <div class="card p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-neutral-900">Pelanggan Terbaik</h3>
            <a href="{{ route('owner.customers.index') }}" class="text-sm text-primary-600 hover:text-primary-700">Lihat Semua</a>
        </div>
        <div class="space-y-4">
            @forelse($topCustomers as $customer)
            <div class="flex items-center justify-between p-3 bg-neutral-50 rounded-lg">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                        <span class="text-primary-600 font-medium text-sm">{{ substr($customer->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-neutral-900">{{ $customer->name }}</p>
                        <p class="text-xs text-neutral-500">{{ $customer->orders_count ?? 0 }} pesanan</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-semibold text-neutral-900">Rp {{ number_format($customer->total_spent ?? 0) }}</p>
                    @if($customer->customerGroup)
                    <span class="badge-primary text-xs">{{ $customer->customerGroup->name }}</span>
                    @endif
                </div>
            </div>
            @empty
            <p class="text-neutral-500 text-center py-4">Tidak ada data pelanggan</p>
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

// Customer Chart
const customerCtx = document.getElementById('customerChart').getContext('2d');
new Chart(customerCtx, {
    type: 'bar',
    data: {
        labels: @json($chartData['labels'] ?? []),
        datasets: [{
            label: 'Pelanggan Baru',
            data: @json($chartData['customers'] ?? []),
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
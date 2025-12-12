@extends('layouts.admin.app')

@section('title', 'Dashboard Admin - Grosir Berkat Ibu')

@section('content')
<div class="flex flex-col gap-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-neutral-900">Selamat Datang Kembali, {{ Auth::user()->name }}!</h1>
            <p class="text-neutral-600 mt-1">Berikut adalah ringkasan aktivitas toko Anda hari ini.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Produk
            </a>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-outline">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                </svg>
                Tambah Kategori
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-neutral-600">Pendapatan Hari Ini</p>
                    <p class="text-3xl font-bold text-neutral-900 mt-1">Rp {{ number_format($stats['today_revenue'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="h-7 w-7 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01"></path></svg>
                </div>
            </div>
            <p class="text-xs text-green-600 mt-2">+8% dari kemarin</p>
        </div>
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-neutral-600">Pesanan Baru</p>
                    <p class="text-3xl font-bold text-neutral-900 mt-1">{{ $stats['new_orders'] ?? 0 }}</p>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="h-7 w-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 9h3m-3 3h3m-6-3h.01M9 12h.01"></path></svg>
                </div>
            </div>
            <p class="text-xs text-green-600 mt-2">+12% dari kemarin</p>
        </div>
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-neutral-600">Total Pelanggan</p>
                    <p class="text-3xl font-bold text-neutral-900 mt-1">{{ $stats['total_customers'] ?? 0 }}</p>
                </div>
                <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center">
                    <svg class="h-7 w-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path></svg>
                </div>
            </div>
            <p class="text-xs text-green-600 mt-2">+5% dari bulan lalu</p>
        </div>
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-neutral-600">Stok Rendah</p>
                    <p class="text-3xl font-bold text-neutral-900 mt-1">{{ $stats['low_stock_products'] ?? 0 }}</p>
                </div>
                <div class="w-14 h-14 bg-yellow-100 rounded-full flex items-center justify-center">
                    <svg class="h-7 w-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                </div>
            </div>
            <p class="text-xs text-yellow-600 mt-2">Perlu segera di-restock</p>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
        <div class="lg:col-span-3 card p-6">
            <h3 class="text-lg font-semibold text-neutral-900 mb-4">Grafik Pendapatan (7 Hari Terakhir)</h3>
            <div style="height: 300px;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
        <div class="lg:col-span-2 card p-6">
            <h3 class="text-lg font-semibold text-neutral-900 mb-4">Komposisi Pesanan</h3>
            <div style="height: 300px;">
                <canvas id="orderStatusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="card">
            <div class="p-6 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-neutral-900">Pesanan Terbaru</h3>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr class="border-t border-neutral-200">
                            <td class="p-4">
                                <p class="font-semibold text-neutral-900">#{{ $order->id }}</p>
                                <p class="text-sm text-neutral-600">{{ $order->user->name ?? 'Guest User' }}</p>
                            </td>
                            <td class="p-4 text-right">
                                <p class="font-semibold text-neutral-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                <p class="text-sm text-neutral-600">{{ $order->created_at->diffForHumans() }}</p>
                            </td>
                            <td class="p-4 text-right">
                                <span class="badge {{ $order->status === 'pending' ? 'badge-warning' : ($order->status === 'completed' ? 'badge-success' : 'badge-primary') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="p-4 text-center text-neutral-500">Tidak ada pesanan terbaru.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
             <div class="p-6 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-neutral-900">Produk Terlaris</h3>
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <tbody>
                        @forelse($topProducts as $product)
                        <tr class="border-t border-neutral-200">
                            <td class="p-4">
                                <div class="flex items-center gap-4">
                                    <img 
                                        src="{{ $product->image ? asset('storage/products/' . $product->image) : 'https://placehold.co/100x100/f3f4f6/374151?text=Img' }}" 
                                        alt="{{ $product->name }}"
                                        class="w-10 h-10 object-cover rounded-md"
                                    >
                                    <div>
                                        <p class="font-semibold text-neutral-900 truncate max-w-xs">{{ $product->name }}</p>
                                        <p class="text-sm text-neutral-600">{{ $product->category->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 text-right">
                                <p class="font-semibold text-neutral-900">{{ $product->sales_count }}</p>
                                <p class="text-sm text-neutral-600">Terjual</p>
                            </td>
                        </tr>
                        @empty
                         <tr>
                            <td colspan="2" class="p-4 text-center text-neutral-500">Belum ada produk yang terjual.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const revenueLabels = JSON.parse('{!! addslashes(json_encode($stats['revenue_chart']['labels'] ?? ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'])) !!}');
    const revenueData = JSON.parse('{!! addslashes(json_encode($stats['revenue_chart']['data'] ?? [120, 190, 300, 500, 230, 300, 450])) !!}');
    const orderStatusLabels = JSON.parse('{!! addslashes(json_encode($stats['order_status_chart']['labels'] ?? ['Pending', 'Diproses', 'Selesai'])) !!}');
    const orderStatusData = JSON.parse('{!! addslashes(json_encode($stats['order_status_chart']['data'] ?? [12, 19, 5])) !!}');

    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx) {
        new Chart(revenueCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: revenueLabels,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: revenueData,
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'rgb(59, 130, 246)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(59, 130, 246)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: (value) => 'Rp ' + (value * 1000).toLocaleString('id-ID'),
                            font: { family: "'Poppins', sans-serif" }
                        },
                        grid: { drawBorder: false }
                    },
                    x: {
                        ticks: { font: { family: "'Poppins', sans-serif" } },
                        grid: { display: false }
                    }
                }
            }
        });
    }

    // Order Status Chart
    const orderStatusCtx = document.getElementById('orderStatusChart');
    if (orderStatusCtx) {
        new Chart(orderStatusCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: orderStatusLabels,
                datasets: [{
                    data: orderStatusData,
                    backgroundColor: [
                        'rgb(251, 191, 36)', // Yellow
                        'rgb(59, 130, 246)',  // Blue
                        'rgb(34, 197, 94)'   // Green
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { font: { family: "'Poppins', sans-serif" } }
                    }
                }
            }
        });
    }
});
</script>
@endsection
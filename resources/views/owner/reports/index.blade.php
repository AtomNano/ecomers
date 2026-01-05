@extends('layouts.admin-layout')

@section('title', 'Laporan Keuangan Owner')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">📊 Laporan Performa Bisnis</h1>
            <p class="text-gray-500 text-sm mt-1">Pantau pendapatan dan penjualan secara realtime.</p>
        </div>
        
        <form action="{{ route('owner.reports.index') }}" method="GET" class="flex items-center gap-2 bg-white p-3 rounded-lg shadow border border-gray-200">
            <span class="text-gray-600 text-sm font-bold">Tahun:</span>
            <select name="year" class="border-none focus:ring-0 text-gray-800 font-bold cursor-pointer bg-white" onchange="this.form.submit()">
                @for($i = date('Y'); $i >= 2024; $i--)
                    <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
            <a href="{{ route('owner.reports.export', ['year' => $year]) }}" class="ml-4 bg-green-600 text-white px-3 py-2 rounded-lg hover:bg-green-700 font-semibold text-sm whitespace-nowrap">
                📥 Export CSV
            </a>
        </form>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Omset -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl shadow-lg border-l-4 border-green-500">
            <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">💰 Total Omset {{ $year }}</p>
            <h3 class="text-3xl font-bold text-green-700 mt-2">Rp {{ number_format($revenue['total_revenue'], 0, ',', '.') }}</h3>
            <p class="text-xs text-gray-600 mt-2">Dari pesanan yang sudah selesai</p>
        </div>

        <!-- Total Pesanan -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl shadow-lg border-l-4 border-blue-500">
            <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">📦 Total Pesanan Selesai</p>
            <h3 class="text-3xl font-bold text-blue-700 mt-2">{{ array_sum($revenue['order_data']) }} Pesanan</h3>
            <p class="text-xs text-gray-600 mt-2">Tahun {{ $year }}</p>
        </div>

        <!-- Rata-rata Order -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-xl shadow-lg border-l-4 border-purple-500">
            <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">📈 Rata-rata per Order</p>
            <h3 class="text-3xl font-bold text-purple-700 mt-2">
                Rp {{ array_sum($revenue['order_data']) > 0 ? number_format($revenue['total_revenue'] / array_sum($revenue['order_data']), 0, ',', '.') : '0' }}
            </h3>
            <p class="text-xs text-gray-600 mt-2">Nilai transaksi</p>
        </div>
    </div>

    <!-- Grafik Pendapatan Bulanan -->
    <div class="bg-white p-8 rounded-xl shadow-lg mb-8 border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-800">📈 Grafik Pendapatan Bulanan</h3>
            <span class="text-sm text-gray-500">Tahun {{ $year }}</span>
        </div>
        <div class="relative h-96 w-full">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Grafik Jumlah Order -->
    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-800">📊 Grafik Jumlah Pesanan Bulanan</h3>
            <span class="text-sm text-gray-500">Tahun {{ $year }}</span>
        </div>
        <div class="relative h-96 w-full">
            <canvas id="ordersChart"></canvas>
        </div>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    // Format Rupiah
    const formatRupiah = (value) => {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(value);
    };

    // ===== GRAFIK PENDAPATAN =====
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($revenue['labels']) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($revenue['revenue_data']) !!},
                borderColor: 'rgb(34, 197, 94)', // Hijau
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                borderWidth: 3,
                tension: 0.4, // Garis melengkung
                fill: true,
                pointRadius: 5,
                pointBackgroundColor: 'rgb(34, 197, 94)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { 
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    padding: 12,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 },
                    callbacks: {
                        label: function(context) {
                            return formatRupiah(context.raw);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            if (value >= 1000000) {
                                return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                            } else if (value >= 1000) {
                                return 'Rp ' + (value / 1000).toFixed(0) + 'K';
                            }
                            return 'Rp ' + value;
                        },
                        font: { size: 11 }
                    },
                    grid: {
                        drawBorder: false,
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: { size: 11 }
                    }
                }
            }
        }
    });

    // ===== GRAFIK JUMLAH ORDER =====
    const ordersCtx = document.getElementById('ordersChart').getContext('2d');
    const ordersChart = new Chart(ordersCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($revenue['labels']) !!},
            datasets: [{
                label: 'Jumlah Pesanan',
                data: {!! json_encode($revenue['order_data']) !!},
                backgroundColor: 'rgba(59, 130, 246, 0.8)', // Biru
                borderColor: 'rgb(59, 130, 246)',
                borderWidth: 2,
                borderRadius: 5,
                hoverBackgroundColor: 'rgba(59, 130, 246, 1)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { 
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return context.raw + ' pesanan';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: { size: 11 }
                    },
                    grid: {
                        drawBorder: false,
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: { size: 11 }
                    }
                }
            }
        }
    });
</script>
@endsection

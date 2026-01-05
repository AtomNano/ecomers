@extends('layouts.admin-layout')

@section('title', 'Kelola Pesanan')
@section('breadcrumb', 'Pesanan')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header & Search -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Daftar Pesanan</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola semua pesanan pelanggan Anda di sini.</p>
        </div>
        <form action="{{ route('admin.orders.index') }}" method="GET" class="relative">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari invoice atau nama..." 
                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent w-full md:w-64 text-sm">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
        </form>
    </div>

    <!-- Status Tabs -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-1 mb-6 flex overflow-x-auto no-scrollbar">
        <a href="{{ route('admin.orders.index', ['status' => 'all']) }}" 
           class="flex-1 text-center px-4 py-3 rounded-lg text-sm font-medium transition whitespace-nowrap {{ !request('status') || request('status') == 'all' ? 'bg-emerald-50 text-emerald-700' : 'text-gray-500 hover:bg-gray-50' }}">
            Semua Pesanan
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'pending_payment']) }}" 
           class="flex-1 text-center px-4 py-3 rounded-lg text-sm font-medium transition whitespace-nowrap {{ request('status') == 'pending_payment' ? 'bg-emerald-50 text-emerald-700' : 'text-gray-500 hover:bg-gray-50' }}">
            ⏳ Menunggu Pembayaran
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" 
           class="flex-1 text-center px-4 py-3 rounded-lg text-sm font-medium transition whitespace-nowrap {{ request('status') == 'processing' ? 'bg-emerald-50 text-emerald-700' : 'text-gray-500 hover:bg-gray-50' }}">
            ⚙️ Diproses
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}" 
           class="flex-1 text-center px-4 py-3 rounded-lg text-sm font-medium transition whitespace-nowrap {{ request('status') == 'completed' ? 'bg-emerald-50 text-emerald-700' : 'text-gray-500 hover:bg-gray-50' }}">
            ✅ Selesai
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" 
           class="flex-1 text-center px-4 py-3 rounded-lg text-sm font-medium transition whitespace-nowrap {{ request('status') == 'cancelled' ? 'bg-emerald-50 text-emerald-700' : 'text-gray-500 hover:bg-gray-50' }}">
            ❌ Dibatalkan
        </a>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        @if($orders->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                        <th class="px-6 py-4 font-semibold">Invoice & Tanggal</th>
                        <th class="px-6 py-4 font-semibold">Pelanggan</th>
                        <th class="px-6 py-4 font-semibold text-right">Total Belanja</th>
                        <th class="px-6 py-4 font-semibold text-center">Status Pesanan</th>
                        <th class="px-6 py-4 font-semibold text-center">Pembayaran</th>
                        <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($orders as $order)
                    <tr class="hover:bg-gray-50 transition group">
                        <!-- Invoice -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                                    <i class="fas fa-file-invoice"></i>
                                </div>
                                <div>
                                    <span class="block font-bold text-gray-800 text-sm">{{ $order->invoice_number }}</span>
                                    <span class="text-xs text-gray-500">{{ $order->created_at->translatedFormat('d M Y, H:i') }}</span>
                                </div>
                            </div>
                        </td>

                        <!-- Pelanggan -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">
                                    {{ substr($order->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">{{ $order->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $order->user->phone ?? '-' }}</p>
                                </div>
                            </div>
                        </td>

                        <!-- Total -->
                        <td class="px-6 py-4 text-right">
                            <span class="font-bold text-gray-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </td>

                        <!-- Status Pesanan -->
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border
                                @if($order->status == 'pending') bg-yellow-50 text-yellow-700 border-yellow-200
                                @elseif($order->status == 'processing' || $order->status == 'payment_verified') bg-blue-50 text-blue-700 border-blue-200
                                @elseif($order->status == 'shipped') bg-purple-50 text-purple-700 border-purple-200
                                @elseif($order->status == 'completed') bg-green-50 text-green-700 border-green-200
                                @else bg-red-50 text-red-700 border-red-200 @endif">
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </td>

                        <!-- Pembayaran -->
                        <td class="px-6 py-4 text-center">
                            @if($order->payment)
                                @if($order->payment->status == 'verified')
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-check-circle text-green-500 text-lg"></i>
                                        <span class="text-[10px] lowercase text-gray-500">lunas</span>
                                    </div>
                                @elseif($order->payment->status == 'rejected')
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-times-circle text-red-500 text-lg"></i>
                                        <span class="text-[10px] lowercase text-gray-500">ditolak</span>
                                    </div>
                                @else
                                    <div class="flex flex-col items-center animate-pulse">
                                        <i class="fas fa-clock text-orange-500 text-lg"></i>
                                        <span class="text-[10px] lowercase text-gray-500">cek bukti</span>
                                    </div>
                                @endif
                            @else
                                <span class="text-xs text-gray-400">Belum bayar</span>
                            @endif
                        </td>

                        <!-- Aksi -->
                        <td class="px-6 py-4 text-center">
                            @if($order->status == 'pending' && $order->payment && $order->payment->status == 'pending')
                                <a href="{{ route('admin.orders.verify', $order->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-500 text-white text-xs font-bold rounded-lg hover:bg-emerald-600 transition shadow-sm hover:shadow-emerald-200">
                                    Verifikasi
                                </a>
                            @else
                                <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-gray-200 text-gray-500 hover:text-emerald-600 hover:border-emerald-200 hover:bg-emerald-50 transition">
                                    <i class="fas fa-eye"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($orders->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $orders->appends(request()->query())->links() }}
        </div>
        @endif

        @else
        <div class="flex flex-col items-center justify-center py-16 text-center">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-clipboard-list text-3xl text-gray-300"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800">Tidak ada pesanan</h3>
            <p class="text-gray-500 text-sm mt-1">Belum ada pesanan yang sesuai dengan filter ini.</p>
        </div>
        @endif
    </div>
</div>
@endsection

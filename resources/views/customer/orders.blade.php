@extends('layouts.app')

@section('title', 'Daftar Pesanan Saya - Grosir Berkat Ibu')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4 max-w-5xl">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Riwayat Pesanan</h1>
                <p class="text-gray-500">Kelola dan pantau status semua pesanan Anda</p>
            </div>
            <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm border border-gray-200 hover:bg-gray-50 transition font-medium">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>

        @if($orders->count() > 0)
            <div class="space-y-6">
                @foreach($orders as $order)
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition duration-200 group">
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row justify-between gap-6">
                            <!-- Left: Icon & Info -->
                            <div class="flex gap-4">
                                <div class="hidden sm:flex flex-shrink-0 w-20 h-20 bg-white rounded-2xl items-center justify-center border border-gray-100 overflow-hidden relative">
                                    @php $firstItem = $order->items->first(); @endphp
                                    @if($firstItem && $firstItem->product->image)
                                        <img src="{{ \Illuminate\Support\Str::startsWith($firstItem->product->image, 'http') ? $firstItem->product->image : asset('storage/' . $firstItem->product->image) }}" class="w-full h-full object-cover">
                                        @if($order->items->count() > 1)
                                            <div class="absolute bottom-0 right-0 bg-black/50 text-white text-[10px] px-1.5 py-0.5 rounded-tl-lg backdrop-blur-sm">
                                                +{{ $order->items->count() - 1 }}
                                            </div>
                                        @endif
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-red-50 to-orange-50 flex items-center justify-center">
                                            <i class="fas fa-shopping-bag text-2xl text-red-500"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-bold text-lg text-gray-800">#{{ $order->invoice_number ?? $order->id }}</span>
                                        <span class="text-gray-300">|</span>
                                        <span class="text-sm text-gray-500">{{ $order->created_at->format('d F Y, H:i') }}</span>
                                    </div>
                                    <div class="flex items-center gap-3 text-sm text-gray-600 mb-3">
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-box"></i> {{ $order->items->count() }} Produk
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-truck"></i> {{ ucfirst($order->shipping_method) }}
                                        </span>
                                    </div>
                                    
                                    <div class="flex items-center gap-2">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold
                                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800 border border-yellow-200
                                            @elseif($order->status === 'payment_verified') bg-blue-100 text-blue-800 border border-blue-200
                                            @elseif($order->status === 'shipped') bg-purple-100 text-purple-800 border border-purple-200
                                            @elseif($order->status === 'completed') bg-green-100 text-green-800 border border-green-200
                                            @else bg-red-100 text-red-800 border border-red-200
                                            @endif">
                                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                        
                                        @if($order->status === 'pending' && !$order->payment_proof)
                                        <span class="px-3 py-1 bg-red-50 text-red-600 rounded-full text-xs font-bold border border-red-100 animate-pulse">
                                            <i class="fas fa-exclamation-circle mr-1"></i> Perlu Bayar
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Total & Action -->
                            <div class="flex flex-col items-start md:items-end justify-between gap-4">
                                <div class="text-left md:text-right">
                                    <p class="text-xs text-gray-500 mb-1">Total Belanja</p>
                                    <p class="text-xl font-bold text-gray-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                </div>
                                <div class="flex items-center gap-3 w-full md:w-auto">
                                    @if($order->status == 'pending')
                                        <a href="{{ route('customer.payment.show', $order->id) }}" class="flex-1 md:flex-none inline-flex justify-center items-center gap-2 px-6 py-2.5 bg-red-500 text-white font-medium rounded-xl hover:bg-red-600 transition shadow-lg shadow-red-500/20">
                                            <i class="fas fa-credit-card"></i> Bayar
                                        </a>
                                    @endif
                                    
                                    <a href="{{ route('orders.success', $order->invoice_number ?? $order->id) }}" class="flex-1 md:flex-none inline-flex justify-center items-center gap-2 px-6 py-2.5 bg-white border border-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-50 hover:border-gray-300 transition shadow-sm">
                                        Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Items Preview removed per user request -->
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-3xl shadow-sm p-12 text-center border border-gray-100">
                <div class="w-32 h-32 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-shopping-basket text-5xl text-red-300"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Pesanan</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">Riwayat pesanan Anda akan muncul di sini. Yuk mulai penuhi kebutuhan warung Anda dengan harga grosir terbaik!</p>
                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-red-500 text-white font-bold rounded-xl hover:bg-red-600 transition shadow-lg hover:shadow-red-500/30 transform hover:-translate-y-1">
                    <i class="fas fa-shopping-bag"></i> Mulai Belanja
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

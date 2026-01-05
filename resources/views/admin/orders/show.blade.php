@extends('layouts.admin-layout')

@section('title', 'Detail Pesanan - #' . $order->invoice_number)

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-4xl font-bold text-gray-800">Pesanan #{{ $order->invoice_number }}</h1>
                <p class="text-gray-600 mt-1">Tanggal: {{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold">
                &larr; Kembali
            </a>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <!-- Status Timeline -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">📊 Status Pesanan</h2>
            <div class="flex justify-between items-center relative">
                <!-- Timeline Line -->
                <div class="absolute top-6 left-0 right-0 h-1 bg-gray-200"></div>
                
                <!-- Status 1: Pending -->
                <div class="relative z-10 text-center">
                    <div class="w-12 h-12 mx-auto rounded-full flex items-center justify-center text-white font-bold text-lg
                        @if(in_array($order->status, ['pending', 'payment_verified', 'shipped', 'completed']))
                            bg-green-500
                        @else
                            bg-gray-300
                        @endif">
                        1
                    </div>
                    <p class="text-xs font-semibold mt-2 text-gray-700">Pending</p>
                </div>

                <!-- Status 2: Payment Verified -->
                <div class="relative z-10 text-center">
                    <div class="w-12 h-12 mx-auto rounded-full flex items-center justify-center text-white font-bold text-lg
                        @if(in_array($order->status, ['payment_verified', 'shipped', 'completed']))
                            bg-green-500
                        @else
                            bg-gray-300
                        @endif">
                        2
                    </div>
                    <p class="text-xs font-semibold mt-2 text-gray-700">Pembayaran<br>Verified</p>
                </div>

                <!-- Status 3: Shipped -->
                <div class="relative z-10 text-center">
                    <div class="w-12 h-12 mx-auto rounded-full flex items-center justify-center text-white font-bold text-lg
                        @if(in_array($order->status, ['shipped', 'completed']))
                            bg-green-500
                        @else
                            bg-gray-300
                        @endif">
                        3
                    </div>
                    <p class="text-xs font-semibold mt-2 text-gray-700">Dikirim</p>
                </div>

                <!-- Status 4: Completed -->
                <div class="relative z-10 text-center">
                    <div class="w-12 h-12 mx-auto rounded-full flex items-center justify-center text-white font-bold text-lg
                        @if($order->status === 'completed')
                            bg-green-500
                        @else
                            bg-gray-300
                        @endif">
                        4
                    </div>
                    <p class="text-xs font-semibold mt-2 text-gray-700">Selesai</p>
                </div>
            </div>

            <!-- Current Status Badge -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600 mb-2">Status Saat Ini:</p>
                <span class="px-4 py-2 rounded-full font-bold text-white text-lg
                    @if($order->status === 'pending') bg-yellow-500
                    @elseif($order->status === 'payment_verified') bg-blue-500
                    @elseif($order->status === 'shipped') bg-purple-500
                    @elseif($order->status === 'completed') bg-green-500
                    @else bg-red-500
                    @endif">
                    @if($order->status === 'pending')
                        ⏳ Menunggu Pembayaran
                    @elseif($order->status === 'payment_verified')
                        ✅ Pembayaran Terverifikasi
                    @elseif($order->status === 'shipped')
                        📦 Sedang Dikirim
                    @elseif($order->status === 'completed')
                        ✅ Selesai
                    @else
                        ❌ Dibatalkan
                    @endif
                </span>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left: Customer & Items Info -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Customer Information -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <span>👤</span> Informasi Pelanggan
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Nama</p>
                            <p class="text-lg font-bold text-gray-900">{{ $order->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">No. HP</p>
                            <p class="text-lg font-bold text-blue-600">{{ $order->user->phone ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-600 font-semibold">Alamat Pengiriman</p>
                            <p class="text-gray-800 mt-1">{{ $order->shipping_address }}</p>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <span>🛒</span> Rincian Barang
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100 border-b-2 border-gray-300">
                                <tr>
                                    <th class="px-4 py-3 text-left font-bold">Produk</th>
                                    <th class="px-4 py-3 text-center font-bold">Qty</th>
                                    <th class="px-4 py-3 text-right font-bold">Harga</th>
                                    <th class="px-4 py-3 text-right font-bold">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        <div class="font-semibold text-gray-900">{{ $item->product->name }}</div>
                                        <div class="text-xs text-blue-600">{{ ucfirst($item->price_type) }} Tier</div>
                                    </td>
                                    <td class="px-4 py-3 text-center font-bold">{{ $item->quantity }}</td>
                                    <td class="px-4 py-3 text-right">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right font-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-blue-50 border-t-2 border-blue-300">
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-right font-bold">Total:</td>
                                    <td class="px-4 py-3 text-right font-bold text-blue-700 text-lg">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Payment Information -->
                @if($order->payment)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <span>💳</span> Informasi Pembayaran
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Metode Pembayaran</p>
                            <p class="text-lg font-bold text-gray-900 capitalize">{{ $order->payment->payment_method }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Status Pembayaran</p>
                            <span class="px-3 py-1 rounded-full font-bold text-sm
                                @if($order->payment->status === 'verified') bg-green-100 text-green-800
                                @elseif($order->payment->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($order->payment->status) }}
                            </span>
                        </div>
                        @if($order->payment->paid_at)
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-600 font-semibold">Waktu Bayar</p>
                            <p class="text-gray-900">{{ $order->payment->paid_at->format('d M Y, H:i') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- Right: Actions -->
            <div class="space-y-4">
                
                <!-- Action Buttons -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">⚙️ Tindakan</h2>
                    
                    <div class="space-y-3">
                        <!-- Verify Payment Button -->
                        @if($order->status === 'pending')
                            <a href="{{ route('admin.orders.verify', $order->id) }}" class="block w-full text-center bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition">
                                🔍 Verifikasi Pembayaran
                            </a>
                        @endif

                        <!-- Ship Button -->
                        @if($order->status === 'payment_verified')
                            <form action="{{ route('admin.orders.ship', $order) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" onclick="return confirm('Tandai pesanan ini sebagai DIKIRIM?')" 
                                        class="w-full bg-purple-600 text-white font-bold py-3 rounded-lg hover:bg-purple-700 transition">
                                    📦 Tandai Sebagai Dikirim
                                </button>
                            </form>

                            <a href="{{ route('admin.orders.verify', $order->id) }}" class="block text-center bg-gray-300 text-gray-800 font-bold py-2 rounded-lg hover:bg-gray-400 transition text-sm">
                                Kembali ke Verifikasi
                            </a>
                        @endif

                        <!-- Complete Button -->
                        @if($order->status === 'shipped')
                            <form action="{{ route('admin.orders.complete', $order) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" onclick="return confirm('Tandai pesanan ini sebagai SELESAI?\n\nCustomer akan mendapat notif WhatsApp bahwa pesanannya sudah diterima.')" 
                                        class="w-full bg-green-600 text-white font-bold py-3 rounded-lg hover:bg-green-700 transition">
                                    ✅ Tandai Sebagai Selesai
                                </button>
                            </form>
                        @endif

                        <!-- Completed Status -->
                        @if($order->status === 'completed')
                            <div class="bg-green-100 border-2 border-green-500 p-4 rounded-lg text-center">
                                <p class="text-2xl">✅</p>
                                <p class="font-bold text-green-800 mt-2">Pesanan Selesai</p>
                                <p class="text-sm text-green-700">Semua proses telah selesai</p>
                            </div>
                        @endif

                        <!-- Cancelled Status -->
                        @if($order->status === 'cancelled')
                            <div class="bg-red-100 border-2 border-red-500 p-4 rounded-lg text-center">
                                <p class="text-2xl">❌</p>
                                <p class="font-bold text-red-800 mt-2">Pesanan Dibatalkan</p>
                                <p class="text-sm text-red-700">Pembayaran ditolak oleh admin</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Timeline Info -->
                <div class="bg-blue-50 rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                    <h3 class="font-bold text-gray-800 mb-3">📝 Tahapan Pesanan:</h3>
                    <ol class="text-sm text-gray-700 space-y-2 list-decimal list-inside">
                        <li>💰 Customer upload bukti bayar</li>
                        <li>✅ Admin verifikasi pembayaran</li>
                        <li>📦 Tandai sebagai DIKIRIM</li>
                        <li>✅ Tandai sebagai SELESAI (saat barang sampai)</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

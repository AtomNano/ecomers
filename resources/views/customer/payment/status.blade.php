@extends('layouts.app')

@section('title', 'Status Pembayaran - Grosir Berkat Ibu')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Status Pembayaran</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Details -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded shadow p-6 mb-6">
                <h2 class="text-xl font-bold mb-4">📦 Detail Pesanan</h2>
                
                <div class="space-y-4">
                    <div class="flex justify-between pb-4 border-b">
                        <span class="text-gray-600">Nomor Invoice:</span>
                        <span class="font-bold">{{ $order->invoice_number }}</span>
                    </div>
                    
                    <div class="flex justify-between pb-4 border-b">
                        <span class="text-gray-600">Tanggal Pesanan:</span>
                        <span class="font-bold">{{ $order->created_at->format('d M Y H:i') }}</span>
                    </div>
                    
                    <div class="flex justify-between pb-4 border-b">
                        <span class="text-gray-600">Status Pesanan:</span>
                        <span class="font-bold">
                            @if($order->status === 'pending')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded">Menunggu Pembayaran</span>
                            @elseif($order->status === 'confirmed')
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded">Pembayaran Dikonfirmasi</span>
                            @elseif($order->status === 'shipped')
                                <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded">Pengiriman</span>
                            @elseif($order->status === 'completed')
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded">Selesai</span>
                            @elseif($order->status === 'rejected')
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded">Ditolak</span>
                            @endif
                        </span>
                    </div>

                    <div class="flex justify-between pb-4 border-b">
                        <span class="text-gray-600">Total Pesanan:</span>
                        <span class="font-bold text-green-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded shadow p-6">
                <h2 class="text-xl font-bold mb-4">🛍️ Items Pesanan</h2>
                
                <table class="w-full">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-4 py-3 text-left">Produk</th>
                            <th class="px-4 py-3 text-center">Jumlah</th>
                            <th class="px-4 py-3 text-right">Harga</th>
                            <th class="px-4 py-3 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($order->items as $item)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $item->product->name }}</td>
                                <td class="px-4 py-3 text-center">{{ $item->quantity }}</td>
                                <td class="px-4 py-3 text-right">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-right font-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-center text-gray-600">Tidak ada items</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Payment Status Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded shadow p-6 sticky top-4">
                <h3 class="text-lg font-bold mb-4">💳 Status Pembayaran</h3>
                
                @if($order->payment)
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Status:</p>
                            <p class="font-bold">
                                @if($order->payment->status === 'pending')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded text-sm">Menunggu Verifikasi</span>
                                @elseif($order->payment->status === 'confirmed')
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded text-sm">✓ Terkonfirmasi</span>
                                @elseif($order->payment->status === 'rejected')
                                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded text-sm">✗ Ditolak</span>
                                @endif
                            </p>
                        </div>

                        @if($order->payment->paid_at)
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Waktu Pembayaran:</p>
                                <p class="font-bold">{{ $order->payment->paid_at->format('d M Y H:i') }}</p>
                            </div>
                        @endif

                        @if($order->payment->proof_image)
                            <div>
                                <p class="text-sm text-gray-600 mb-2">Bukti Pembayaran:</p>
                                <img src="{{ asset('storage/' . $order->payment->proof_image) }}" alt="Bukti Pembayaran" class="w-full rounded border">
                            </div>
                        @endif

                        @if($order->payment->status === 'rejected' && $order->payment->rejection_reason)
                            <div class="bg-red-50 border border-red-200 rounded p-3">
                                <p class="text-sm text-gray-600 mb-1">Alasan Penolakan:</p>
                                <p class="text-sm text-red-700">{{ $order->payment->rejection_reason }}</p>
                            </div>
                        @endif
                    </div>
                @else
                    <p class="text-gray-600 text-sm">Belum ada pembayaran</p>
                @endif

                <div class="mt-6 pt-6 border-t space-y-2">
                    <a href="{{ route('customer.payment.show', $order->id) }}" class="block w-full bg-green-600 text-white py-2 rounded text-center hover:bg-green-700 font-bold">
                        ← Kembali
                    </a>
                    <a href="{{ route('customer.orders') }}" class="block w-full bg-gray-600 text-white py-2 rounded text-center hover:bg-gray-700">
                        Daftar Pesanan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

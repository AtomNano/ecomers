@extends('layouts.app')

@section('title', 'Daftar Pesanan - Grosir Berkat Ibu')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Daftar Pesanan Saya</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if($orders->count() > 0)
        <div class="bg-white rounded shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-bold">Invoice</th>
                        <th class="px-6 py-3 text-left text-sm font-bold">Tanggal</th>
                        <th class="px-6 py-3 text-center text-sm font-bold">Items</th>
                        <th class="px-6 py-3 text-right text-sm font-bold">Total</th>
                        <th class="px-6 py-3 text-center text-sm font-bold">Status</th>
                        <th class="px-6 py-3 text-center text-sm font-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <a href="{{ route('customer.payment.show', $order->id) }}" class="text-green-600 hover:text-green-700 font-bold">
                                    {{ $order->invoice_number }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $order->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-center text-sm">
                                {{ $order->items->count() }} item{{ $order->items->count() > 1 ? 's' : '' }}
                            </td>
                            <td class="px-6 py-4 text-right font-bold text-green-600">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($order->status === 'pending')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-bold">Menunggu</span>
                                @elseif($order->status === 'confirmed')
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded text-xs font-bold">Dikonfirmasi</span>
                                @elseif($order->status === 'shipped')
                                    <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded text-xs font-bold">Pengiriman</span>
                                @elseif($order->status === 'completed')
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded text-xs font-bold">✓ Selesai</span>
                                @elseif($order->status === 'rejected')
                                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded text-xs font-bold">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex gap-2 justify-center">
                                    <a href="{{ route('customer.payment.show', $order->id) }}" class="px-3 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700">
                                        Lihat
                                    </a>
                                    <a href="{{ route('customer.payment.status', $order->id) }}" class="px-3 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700">
                                        Status
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $orders->links() }}
            </div>
        @endif
    @else
        <div class="bg-white rounded shadow p-8 text-center">
            <p class="text-gray-600 mb-4 text-lg">Anda belum memiliki pesanan</p>
            <a href="{{ route('customer.products.index') }}" class="inline-block bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700 font-bold">
                Mulai Belanja
            </a>
        </div>
    @endif

    <!-- Back Button -->
    <div class="mt-6">
        <a href="{{ route('customer.dashboard') }}" class="text-gray-600 hover:text-gray-700">
            ← Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection

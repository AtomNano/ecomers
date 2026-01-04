@extends('layouts.app')

@section('title', 'Dashboard - Grosir Berkat Ibu')

@section('content')
<div class="max-w-5xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Dashboard Saya</h1>

    <!-- User Info -->
    <div class="bg-white rounded shadow p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">Informasi Akun</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600">Nama</p>
                <p class="font-bold">{{ auth()->user()->name }}</p>
            </div>
            <div>
                <p class="text-gray-600">Email</p>
                <p class="font-bold">{{ auth()->user()->email }}</p>
            </div>
            <div>
                <p class="text-gray-600">Telepon</p>
                <p class="font-bold">{{ auth()->user()->phone }}</p>
            </div>
            <div>
                <p class="text-gray-600">Alamat</p>
                <p class="font-bold">{{ auth()->user()->address }}</p>
            </div>
        </div>
    </div>

    <!-- Orders -->
    <div class="bg-white rounded shadow p-6">
        <h2 class="text-xl font-bold mb-4">Pesanan Saya</h2>
        
        @if($orders->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-4 py-3 text-left">No. Pesanan</th>
                            <th class="px-4 py-3 text-right">Total</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-center">Pembayaran</th>
                            <th class="px-4 py-3 text-left">Tanggal</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3 font-bold">#{{ $order->id }}</td>
                                <td class="px-4 py-3 text-right">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-3 py-1 rounded text-sm font-bold
                                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                                        @elseif($order->status === 'completed') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-3 py-1 rounded text-sm font-bold
                                        @if($order->payment->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->payment->status === 'verified') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($order->payment->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('customer.payment.show', $order->payment) }}" class="text-blue-600 hover:text-blue-700 text-sm">
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-600">Anda belum memiliki pesanan</p>
        @endif
    </div>
</div>
@endsection

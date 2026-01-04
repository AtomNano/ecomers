@extends('layouts.app')

@section('title', 'Kelola Pesanan - Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">📋 Kelola Pesanan</h1>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
            <p class="font-semibold">✅ {{ session('success') }}</p>
        </div>
    @endif

    @if(session('info'))
        <div class="mb-6 p-4 bg-blue-100 border-l-4 border-blue-500 text-blue-700 rounded">
            <p class="font-semibold">ℹ️ {{ session('info') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
            <p class="font-semibold">❌ {{ session('error') }}</p>
        </div>
    @endif

    <!-- WhatsApp Auto-Open Script -->
    @if(session('wa_link'))
    <script>
        // Membuka WA otomatis di tab baru setelah Admin klik Terima/Tolak
        setTimeout(function() {
            window.open("{{ session('wa_link') }}", '_blank');
        }, 1500); // Delay 1.5 detik biar notif success muncul dulu
    </script>
    @endif

    @if($orders->count() > 0)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <table class="w-full text-sm">
                <thead class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                    <tr>
                        <th class="px-4 py-4 text-left font-bold">Invoice</th>
                        <th class="px-4 py-4 text-left font-bold">Pelanggan</th>
                        <th class="px-4 py-4 text-right font-bold">Total</th>
                        <th class="px-4 py-4 text-center font-bold">Status</th>
                        <th class="px-4 py-4 text-center font-bold">Pembayaran</th>
                        <th class="px-4 py-4 text-left font-bold">Tanggal</th>
                        <th class="px-4 py-4 text-center font-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-bold text-blue-600">{{ $order->invoice_number }}</td>
                            <td class="px-4 py-3">
                                <div class="font-semibold text-gray-900">{{ $order->user->name }}</div>
                                <div class="text-xs text-gray-600">{{ $order->user->phone ?? '-' }}</div>
                            </td>
                            <td class="px-4 py-3 text-right font-bold text-gray-900">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-bold
                                    @if($order->status === 'waiting_verification') bg-yellow-100 text-yellow-800
                                    @elseif($order->status === 'paid') bg-blue-100 text-blue-800
                                    @elseif($order->status === 'processing') bg-indigo-100 text-indigo-800
                                    @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                                    @elseif($order->status === 'completed') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($order->payment)
                                    @if($order->payment->status === 'verified')
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                            ✅ Terverifikasi
                                        </span>
                                    @elseif($order->payment->status === 'rejected')
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                            ❌ Ditolak
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-800">
                                            📸 Menunggu Verifikasi
                                        </span>
                                    @endif
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800">
                                        ⏳ Belum Bayar
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $order->created_at->format('d M Y H:i') }}</td>
                            <td class="px-4 py-3 text-center space-x-2 flex justify-center flex-wrap gap-2">
                                @if($order->status === 'pending')
                                    <a href="{{ route('admin.orders.verify', $order->id) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold text-xs whitespace-nowrap">
                                        <span>🔍</span> Verifikasi
                                    </a>
                                @elseif($order->status === 'payment_verified')
                                    <form action="{{ route('admin.orders.ship', $order) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Tandai pesanan ini sebagai DIKIRIM?')" 
                                                class="inline-flex items-center gap-1 px-3 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold text-xs whitespace-nowrap">
                                            <span>📦</span> Kirim
                                        </button>
                                    </form>
                                @elseif($order->status === 'shipped')
                                    <form action="{{ route('admin.orders.complete', $order) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Tandai pesanan ini sebagai SELESAI?')" 
                                                class="inline-flex items-center gap-1 px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold text-xs whitespace-nowrap">
                                            <span>✅</span> Selesai
                                        </button>
                                    </form>
                                @elseif($order->status === 'completed')
                                    <span class="inline-flex items-center gap-1 px-3 py-2 bg-green-100 text-green-800 rounded-lg font-semibold text-xs">
                                        <span>✅</span> Selesai
                                    </span>
                                @elseif($order->status === 'cancelled')
                                    <span class="inline-flex items-center gap-1 px-3 py-2 bg-red-100 text-red-800 rounded-lg font-semibold text-xs">
                                        <span>❌</span> Dibatalkan
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @endif
    @else
        <div class="bg-white rounded-xl shadow-lg p-12 text-center border border-gray-200">
            <p class="text-gray-600 text-lg">📭 Tidak ada pesanan</p>
        </div>
    @endif
</div>
@endsection

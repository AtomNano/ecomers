@extends('layouts.admin-layout')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Verifikasi Pesanan #{{ $order->invoice_number }}</h1>
            <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold">
                &larr; Kembali ke Daftar
            </a>
        </div>

        <!-- Alert Messages -->
        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Main Split Screen Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- LEFT: Bukti Bayar -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <span class="text-2xl">📷</span> Bukti Transfer Customer
                    </h2>
                </div>

                <div class="p-6">
                    <!-- Foto Bukti Bayar - Zoomable -->
                    <div class="relative group mb-6">
                        @if($order->payment_proof)
                            <img src="{{ asset('storage/' . $order->payment_proof) }}" 
                                 alt="Bukti Bayar" 
                                 class="w-full h-auto rounded-lg border-4 border-gray-200 cursor-zoom-in transition-transform duration-300 transform group-hover:scale-105 shadow-md"
                                 onclick="window.open(this.src, '_blank')">
                            
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition pointer-events-none bg-black bg-opacity-20 rounded-lg">
                                <span class="bg-black bg-opacity-70 text-white px-4 py-2 rounded-lg text-sm font-semibold">🔍 Klik untuk Zoom</span>
                            </div>
                        @else
                            <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                                <p class="text-gray-500">Bukti pembayaran belum diupload</p>
                            </div>
                        @endif
                    </div>

                    <!-- Info Customer -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-5 rounded-lg border border-blue-200">
                        <p class="font-bold text-gray-800 mb-3 text-sm uppercase tracking-wide">📋 Data Customer</p>
                        
                        <div class="space-y-2 text-sm">
                            <div>
                                <span class="text-gray-600 font-semibold">Nama:</span>
                                <p class="text-gray-900 font-bold">{{ $order->user->name }}</p>
                            </div>
                            
                            <div>
                                <span class="text-gray-600 font-semibold">No. HP:</span>
                                <p class="font-mono text-blue-600 font-bold">{{ $order->user->phone ?? '-' }}</p>
                            </div>
                            
                            <div>
                                <span class="text-gray-600 font-semibold">Email:</span>
                                <p class="text-gray-700 break-all">{{ $order->user->email }}</p>
                            </div>

                            <div class="pt-2 border-t border-blue-200">
                                <span class="text-gray-600 font-semibold">Alamat Kirim:</span>
                                <p class="text-gray-700 text-xs leading-relaxed">{{ $order->shipping_address }}</p>
                            </div>

                            <div class="pt-2 border-t border-blue-200">
                                <span class="text-gray-600 font-semibold">Tgl. Order:</span>
                                <p class="text-gray-700">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Rincian & Keputusan -->
            <div class="flex flex-col gap-6">
                
                <!-- Rincian Belanja -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                    <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                        <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <span class="text-2xl">🛒</span> Rincian Belanja
                        </h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-4 py-3 text-left font-bold">Barang</th>
                                    <th class="px-4 py-3 text-center font-bold w-16">Qty</th>
                                    <th class="px-4 py-3 text-right font-bold w-28">Harga (@)</th>
                                    <th class="px-4 py-3 text-right font-bold w-32">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    <td class="px-4 py-3">
                                        <div class="font-semibold text-gray-900">{{ $item->product->name }}</div>
                                        <div class="text-xs text-blue-600 font-semibold">
                                            📊 {{ ucfirst($item->price_type) }} Tier
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center font-bold">{{ $item->quantity }}</td>
                                    <td class="px-4 py-3 text-right font-semibold text-gray-900">
                                        Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right font-bold text-blue-600">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-gradient-to-r from-blue-100 to-indigo-100 border-t-2 border-blue-300">
                                    <td colspan="3" class="px-4 py-4 font-bold text-right text-gray-800 uppercase text-sm">
                                        💰 Total Harus Dibayar:
                                    </td>
                                    <td class="px-4 py-4 font-bold text-right text-2xl text-blue-700">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Status & Keputusan Admin -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-t-4 border-blue-500">
                    <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-blue-100">
                        <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <span class="text-2xl">⚖️</span> Keputusan Admin
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Pastikan jumlah bukti transfer sama dengan total di atas sebelum approve</p>
                    </div>

                    <div class="p-6 space-y-4">
                        <!-- Status Info -->
                        <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                            <p class="text-sm">
                                <span class="font-bold text-gray-800">Status Saat Ini:</span>
                                <span class="ml-2 px-3 py-1 bg-yellow-200 text-yellow-800 rounded-full font-bold text-xs">
                                    ⏳ {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </p>
                        </div>

                        <!-- Action Buttons -->
                        @if($order->status === 'pending')
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Tombol Tolak -->
                            <button onclick="openRejectModal()" 
                                    class="px-6 py-3 bg-red-100 text-red-700 font-bold rounded-lg hover:bg-red-200 transition shadow-md flex items-center justify-center gap-2 border-2 border-red-300">
                                <span class="text-xl">❌</span> Tolak Bukti
                            </button>

                            <!-- Tombol Terima & Proses -->
                            <form action="{{ route('admin.orders.approve', $order->id) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" 
                                        onclick="return confirm('Yakin ingin menerima pembayaran ini? Stok akan berkurang.')"
                                        class="w-full px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold rounded-lg hover:from-green-600 hover:to-emerald-700 transition shadow-md flex items-center justify-center gap-2 border-2 border-green-600">
                                    <span class="text-xl">✅</span> Terima & Proses
                                </button>
                            </form>
                        </div>
                        @else
                        <div class="p-4 bg-gray-100 rounded text-center text-gray-500 font-semibold border-2 border-dashed border-gray-300">
                            Aksi tidak tersedia (Status: {{ ucfirst($order->status) }})
                        </div>
                        @endif

                        <!-- Info Stok -->
                        <div class="p-4 bg-blue-50 rounded-lg border border-blue-200 text-sm">
                            <p class="font-bold text-blue-900 mb-2">📦 Cek Stok Barang:</p>
                            <div class="space-y-1 text-blue-800">
                                @foreach($order->items as $item)
                                    <div class="flex justify-between">
                                        <span>{{ $item->product->name }}:</span>
                                        <span class="font-bold">
                                            @if($item->product->stock >= $item->quantity)
                                                <span class="text-green-600">✅ {{ $item->product->stock }} pcs (Cukup)</span>
                                            @else
                                                <span class="text-red-600">❌ {{ $item->product->stock }} pcs (KURANG! Butuh {{ $item->quantity }})</span>
                                            @endif
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Penolakan -->
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md transform transition">
        <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-red-50 to-orange-50">
            <h3 class="font-bold text-lg text-gray-800 flex items-center gap-2">
                <span class="text-2xl">❌</span> Tolak Pembayaran
            </h3>
        </div>

        <form action="{{ route('admin.orders.reject', $order->id) }}" method="POST" class="p-6 space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Alasan Penolakan *</label>
                <textarea name="reason" 
                          rows="4" 
                          class="w-full border-2 border-gray-300 rounded-lg p-3 focus:border-red-500 focus:outline-none resize-none text-sm"
                          placeholder="Contoh:
- Bukti buram/tidak jelas
- Nominal kurang Rp 50.000
- Tanggal transfer sudah lewat
- Foto tidak sesuai instruksi"
                          required></textarea>
                @error('admin_note')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-yellow-50 p-3 rounded border border-yellow-200 text-sm text-yellow-800">
                <p class="font-semibold">⚠️ Penting:</p>
                <p>Customer akan menerima notif WhatsApp otomatis berisi alasan penolakan ini.</p>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <button type="button" 
                        onclick="closeRejectModal()"
                        class="px-4 py-2 text-gray-700 font-semibold border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition">
                    Kirim Penolakan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openRejectModal() {
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}

// Close modal jika klik area gelap
document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRejectModal();
    }
});
</script>
@endsection

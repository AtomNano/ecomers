@extends('layouts.app')

@section('title', 'Pembayaran - Grosir Berkat Ibu')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Verifikasi Pembayaran</h1>

    <div class="bg-white rounded shadow p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">Detail Pesanan</h2>
        <div class="space-y-3">
            <div class="flex justify-between">
                <span>No. Pesanan:</span>
                <span class="font-bold">#{{ $payment->order->id }}</span>
            </div>
            <div class="flex justify-between">
                <span>Total:</span>
                <span class="font-bold">Rp {{ number_format($payment->order->total_amount, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Status Pembayaran:</span>
                <span class="px-3 py-1 rounded text-sm font-bold
                    @if($payment->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($payment->status === 'verified') bg-green-100 text-green-800
                    @else bg-red-100 text-red-800
                    @endif">
                    {{ ucfirst($payment->status) }}
                </span>
            </div>
        </div>
    </div>

    @if($payment->status === 'pending')
        <div class="bg-blue-50 border border-blue-200 rounded p-6 mb-6">
            <h3 class="font-bold text-lg mb-3 text-blue-900">Petunjuk Pembayaran</h3>
            <ol class="list-decimal list-inside space-y-2 text-blue-900">
                <li>Transfer ke rekening yang sudah disediakan</li>
                <li>Upload bukti pembayaran di bawah ini</li>
                <li>Admin akan memverifikasi dalam 24 jam</li>
            </ol>
        </div>

        <form action="{{ route('customer.payment.uploadProof', $payment) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded shadow p-6">
            @csrf
            <h3 class="font-bold text-lg mb-4">Upload Bukti Pembayaran</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold mb-2">Bukti Transfer (Foto/Screenshot)</label>
                    <input type="file" name="proof_image" accept="image/*" class="w-full border rounded px-3 py-2" required>
                    @error('proof_image')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold mb-2">Metode Pembayaran</label>
                    <select name="payment_method" class="w-full border rounded px-3 py-2" required>
                        <option value="">Pilih Metode</option>
                        <option value="transfer_bank">Transfer Bank</option>
                        <option value="e_wallet">E-Wallet</option>
                        <option value="other">Lainnya</option>
                    </select>
                    @error('payment_method')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold mb-2">Catatan (Opsional)</label>
                    <textarea name="notes" class="w-full border rounded px-3 py-2" rows="3"></textarea>
                </div>

                <button type="submit" class="w-full bg-green-600 text-white py-3 rounded font-bold hover:bg-green-700">
                    Upload Bukti Pembayaran
                </button>
            </div>
        </form>
    @elseif($payment->status === 'verified')
        <div class="bg-green-50 border border-green-200 rounded p-6">
            <h3 class="font-bold text-lg text-green-900 mb-2">✓ Pembayaran Terverifikasi</h3>
            <p class="text-green-900">Terima kasih telah melakukan pembayaran. Pesanan Anda akan segera diproses dan dikirim.</p>
            <a href="{{ route('customer.dashboard') }}" class="mt-4 inline-block bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                Kembali ke Dashboard
            </a>
        </div>
    @else
        <div class="bg-red-50 border border-red-200 rounded p-6">
            <h3 class="font-bold text-lg text-red-900 mb-2">✗ Pembayaran Ditolak</h3>
            <p class="text-red-900 mb-3">{{ $payment->notes }}</p>
            <a href="{{ route('customer.payment.show', $payment) }}" class="inline-block bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">
                Coba Lagi
            </a>
        </div>
    @endif
</div>
@endsection

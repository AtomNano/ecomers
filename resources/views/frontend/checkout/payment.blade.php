@extends('layouts.frontend.app')

@section('title', 'Pembayaran - Grosir Berkat Ibu')
@section('description', 'Selesaikan pembayaran untuk pesanan Anda.')

@section('content')
<div class="bg-white">
    <div class="container-custom section-padding">
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-neutral-900 mb-6">Pembayaran</h1>
            <p class="text-xl text-neutral-600 max-w-3xl mx-auto">
                Selesaikan pembayaran untuk pesanan Anda menggunakan metode yang dipilih
            </p>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Payment Information -->
                <div class="space-y-8">
                    <!-- Order Summary -->
                    <div class="card p-8">
                        <h2 class="text-2xl font-semibold text-neutral-900 mb-6">Ringkasan Pesanan</h2>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span class="text-neutral-600">Nomor Pesanan</span>
                                <span class="font-semibold text-neutral-900">{{ $order->order_number }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-neutral-600">Total Pembayaran</span>
                                <span class="font-semibold text-primary-600 text-xl">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-neutral-600">Metode Pembayaran</span>
                                <span class="font-semibold text-neutral-900">
                                    @switch($order->payment_method)
                                        @case('virtual_account')
                                            Virtual Account
                                            @break
                                        @case('qris')
                                            QRIS
                                            @break
                                        @default
                                            {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                                    @endswitch
                                </span>
                            </div>
                        </div>
                    </div>

                    @if($order->payment_method === 'virtual_account')
                    <!-- Virtual Account Payment -->
                    <div class="card p-8">
                        <h2 class="text-2xl font-semibold text-neutral-900 mb-6">Virtual Account</h2>
                        
                        <div class="space-y-6">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-start">
                                    <svg class="h-5 w-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <h3 class="font-medium text-blue-800">Instruksi Pembayaran</h3>
                                        <p class="text-sm text-blue-700 mt-1">
                                            Gunakan nomor Virtual Account di bawah ini untuk melakukan pembayaran melalui ATM, Mobile Banking, atau Internet Banking.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="text-center">
                                    <h3 class="font-semibold text-neutral-900 mb-2">Nomor Virtual Account</h3>
                                    <div class="bg-neutral-100 rounded-lg p-4">
                                        <div class="font-mono text-2xl font-bold text-neutral-900" id="va-number">
                                            {{ $order->order_number }}
                                        </div>
                                        <button onclick="copyVANumber()" class="mt-2 text-sm text-primary-600 hover:text-primary-700">
                                            <svg class="h-4 w-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            </svg>
                                            Salin Nomor
                                        </button>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <h3 class="font-semibold text-neutral-900 mb-2">Jumlah Pembayaran</h3>
                                    <div class="bg-primary-50 border border-primary-200 rounded-lg p-4">
                                        <div class="text-2xl font-bold text-primary-600">
                                            Rp {{ number_format($order->total, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <h3 class="font-semibold text-neutral-900">Cara Pembayaran</h3>
                                
                                <div class="space-y-2">
                                    <div class="flex items-start space-x-3">
                                        <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <span class="text-xs font-medium text-primary-600">1</span>
                                        </div>
                                        <p class="text-sm text-neutral-600">Pilih menu "Transfer" di ATM atau Mobile Banking</p>
                                    </div>
                                    <div class="flex items-start space-x-3">
                                        <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <span class="text-xs font-medium text-primary-600">2</span>
                                        </div>
                                        <p class="text-sm text-neutral-600">Pilih "Transfer ke Virtual Account"</p>
                                    </div>
                                    <div class="flex items-start space-x-3">
                                        <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <span class="text-xs font-medium text-primary-600">3</span>
                                        </div>
                                        <p class="text-sm text-neutral-600">Masukkan nomor Virtual Account dan jumlah yang tertera</p>
                                    </div>
                                    <div class="flex items-start space-x-3">
                                        <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <span class="text-xs font-medium text-primary-600">4</span>
                                        </div>
                                        <p class="text-sm text-neutral-600">Konfirmasi dan selesaikan pembayaran</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($order->payment_method === 'qris')
                    <!-- QRIS Payment -->
                    <div class="card p-8">
                        <h2 class="text-2xl font-semibold text-neutral-900 mb-6">QRIS</h2>
                        
                        <div class="space-y-6">
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex items-start">
                                    <svg class="h-5 w-5 text-green-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <h3 class="font-medium text-green-800">Instruksi Pembayaran</h3>
                                        <p class="text-sm text-green-700 mt-1">
                                            Scan QR Code di bawah ini menggunakan aplikasi e-wallet favorit Anda (GoPay, OVO, DANA, dll).
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <h3 class="font-semibold text-neutral-900 mb-4">QR Code Pembayaran</h3>
                                <div class="bg-white border-2 border-neutral-200 rounded-lg p-8 inline-block">
                                    <!-- Placeholder QR Code -->
                                    <div class="w-48 h-48 bg-neutral-100 rounded-lg flex items-center justify-center">
                                        <div class="text-center">
                                            <svg class="h-16 w-16 text-neutral-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-4v4m0-4h4m-4 0V9a2 2 0 012-2h2a2 2 0 012 2v2m-6 0h4"></path>
                                            </svg>
                                            <p class="text-sm text-neutral-500">QR Code</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <div class="text-lg font-semibold text-neutral-900">
                                        Rp {{ number_format($order->total, 0, ',', '.') }}
                                    </div>
                                    <p class="text-sm text-neutral-600">Jumlah yang harus dibayar</p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <h3 class="font-semibold text-neutral-900">Cara Pembayaran</h3>
                                
                                <div class="space-y-2">
                                    <div class="flex items-start space-x-3">
                                        <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <span class="text-xs font-medium text-primary-600">1</span>
                                        </div>
                                        <p class="text-sm text-neutral-600">Buka aplikasi e-wallet favorit Anda</p>
                                    </div>
                                    <div class="flex items-start space-x-3">
                                        <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <span class="text-xs font-medium text-primary-600">2</span>
                                        </div>
                                        <p class="text-sm text-neutral-600">Pilih menu "Scan QR" atau "QRIS"</p>
                                    </div>
                                    <div class="flex items-start space-x-3">
                                        <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <span class="text-xs font-medium text-primary-600">3</span>
                                        </div>
                                        <p class="text-sm text-neutral-600">Scan QR Code di atas</p>
                                    </div>
                                    <div class="flex items-start space-x-3">
                                        <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <span class="text-xs font-medium text-primary-600">4</span>
                                        </div>
                                        <p class="text-sm text-neutral-600">Konfirmasi dan selesaikan pembayaran</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Order Details -->
                <div class="space-y-8">
                    <!-- Order Items -->
                    <div class="card p-6">
                        <h2 class="text-xl font-semibold text-neutral-900 mb-6">Detail Produk</h2>
                        
                        <div class="space-y-4">
                            @foreach($order->orderItems as $item)
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-neutral-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    @if($item->product->image)
                                        <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <svg class="h-6 w-6 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-medium text-neutral-900 text-sm">{{ $item->product->name }}</h3>
                                    <p class="text-xs text-neutral-600">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <div class="font-semibold text-neutral-900 text-sm">
                                    Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-6 pt-6 border-t border-neutral-200">
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-neutral-600">Subtotal</span>
                                    <span class="font-medium">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-neutral-600">Biaya Pengiriman</span>
                                    <span class="font-medium">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                                </div>
                                <hr class="border-neutral-200">
                                <div class="flex justify-between text-lg font-semibold">
                                    <span>Total</span>
                                    <span class="text-primary-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Status -->
                    <div class="card p-6">
                        <h2 class="text-xl font-semibold text-neutral-900 mb-6">Status Pembayaran</h2>
                        
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full animate-pulse"></div>
                            <span class="text-neutral-900 font-medium">Menunggu Pembayaran</span>
                        </div>
                        
                        <p class="text-sm text-neutral-600 mb-4">
                            Status pembayaran akan otomatis diperbarui setelah pembayaran berhasil.
                        </p>

                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <div>
                                    <h3 class="font-medium text-blue-800">Penting!</h3>
                                    <p class="text-sm text-blue-700 mt-1">
                                        Jangan tutup halaman ini sampai pembayaran selesai. 
                                        Anda akan diarahkan ke halaman konfirmasi setelah pembayaran berhasil.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Help -->
                    <div class="card p-6 bg-primary-50 border-primary-200">
                        <h2 class="text-xl font-semibold text-primary-900 mb-4">Butuh Bantuan?</h2>
                        
                        <div class="space-y-3 text-sm text-primary-800">
                            <div class="flex items-center space-x-2">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span>Telepon: +62 21 1234 5678</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span>Email: info@grosirberkatibu.com</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyVANumber() {
    const vaNumber = document.getElementById('va-number').textContent;
    navigator.clipboard.writeText(vaNumber).then(function() {
        // Show success message
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = `
            <svg class="h-4 w-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Tersalin!
        `;
        button.classList.add('text-green-600');
        
        setTimeout(() => {
            button.innerHTML = originalText;
            button.classList.remove('text-green-600');
        }, 2000);
    });
}

// Auto refresh payment status every 30 seconds
setInterval(function() {
    // In a real implementation, you would make an AJAX call to check payment status
    // For now, we'll just show a placeholder
}, 30000);
</script>
@endsection

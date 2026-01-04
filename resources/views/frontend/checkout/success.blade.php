@extends('layouts.frontend.app')

@section('title', 'Pesanan Berhasil - Grosir Berkat Ibu')
@section('description', 'Pesanan Anda telah berhasil dibuat.')

@section('content')
<div class="bg-white">
    <div class="container-custom section-padding">
        <!-- Success Message -->
        <div class="text-center mb-16">
            <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="h-12 w-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-neutral-900 mb-6">Pesanan Berhasil Dibuat!</h1>
            <p class="text-xl text-neutral-600 max-w-3xl mx-auto">
                Terima kasih atas kepercayaan Anda. Pesanan Anda sedang diproses.
            </p>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Order Information -->
                <div class="card p-8">
                    <h2 class="text-2xl font-semibold text-neutral-900 mb-6">Informasi Pesanan</h2>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-neutral-600">Nomor Pesanan</span>
                            <span class="font-semibold text-neutral-900">{{ $order->order_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-neutral-600">Tanggal Pesanan</span>
                            <span class="font-semibold text-neutral-900">{{ $order->created_at->format('d F Y, H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-neutral-600">Status</span>
                            <span class="badge bg-yellow-100 text-yellow-800">
                                @switch($order->status)
                                    @case('pending_payment')
                                        Menunggu Pembayaran
                                        @break
                                    @case('payment_verification')
                                        Verifikasi Pembayaran
                                        @break
                                    @case('processing')
                                        Diproses
                                        @break
                                    @case('shipped')
                                        Dikirim
                                        @break
                                    @case('completed')
                                        Selesai
                                        @break
                                    @case('cancelled')
                                        Dibatalkan
                                        @break
                                    @default
                                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                @endswitch
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-neutral-600">Total Pembayaran</span>
                            <span class="font-semibold text-primary-600 text-xl">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Next Steps -->
                <div class="card p-8">
                    <h2 class="text-2xl font-semibold text-neutral-900 mb-6">Langkah Selanjutnya</h2>
                    
                    <div class="space-y-4">
                        @if($order->status === 'pending_payment')
                        <div class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="text-xs font-medium text-primary-600">1</span>
                            </div>
                            <div>
                                <h3 class="font-medium text-neutral-900">Selesaikan Pembayaran</h3>
                                <p class="text-sm text-neutral-600">Lakukan pembayaran sesuai dengan metode yang dipilih</p>
                            </div>
                        </div>
                        @endif

                        @if(in_array($order->status, ['pending_payment', 'payment_verification']))
                        <div class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="text-xs font-medium text-primary-600">2</span>
                            </div>
                            <div>
                                <h3 class="font-medium text-neutral-900">Tunggu Verifikasi</h3>
                                <p class="text-sm text-neutral-600">Tim kami akan memverifikasi pembayaran dalam 24 jam</p>
                            </div>
                        </div>
                        @endif

                        @if(in_array($order->status, ['processing', 'shipped', 'completed']))
                        <div class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="h-3 w-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-medium text-neutral-900">Pesanan Diproses</h3>
                                <p class="text-sm text-neutral-600">Pesanan Anda sedang disiapkan untuk pengiriman</p>
                            </div>
                        </div>
                        @endif

                        <div class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="text-xs font-medium text-primary-600">3</span>
                            </div>
                            <div>
                                <h3 class="font-medium text-neutral-900">Pantau Status</h3>
                                <p class="text-sm text-neutral-600">Anda akan menerima notifikasi email setiap ada perubahan status</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card p-8 mt-8">
                <h2 class="text-2xl font-semibold text-neutral-900 mb-6">Detail Produk</h2>
                
                <div class="space-y-4">
                    @foreach($order->orderItems as $item)
                    <div class="flex items-center space-x-4 py-4 border-b border-neutral-200 last:border-b-0">
                        <div class="w-16 h-16 bg-neutral-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            @if($item->product->image)
                                <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded-lg">
                            @else
                                <svg class="h-8 w-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-neutral-900">{{ $item->product->name }}</h3>
                            <p class="text-sm text-neutral-600">{{ $item->product->category->name }}</p>
                        </div>
                        <div class="text-right">
                            <div class="font-semibold text-neutral-900">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                            <div class="text-sm text-neutral-600">= Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
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

            <!-- Action Buttons -->
            <div class="text-center mt-8 space-y-4">
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('profile') }}" class="btn-primary">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Lihat Profil Saya
                    </a>
                    
                    <a href="{{ route('products.index') }}" class="btn-outline">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Lanjutkan Belanja
                    </a>
                </div>

                @if($order->status === 'pending_payment' && $order->payment_method === 'bank_transfer')
                <div class="mt-6">
                    <a href="{{ route('checkout.manual-payment', $order->id) }}" class="btn-primary">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        Upload Bukti Pembayaran
                    </a>
                </div>
                @endif
            </div>

            <!-- Contact Information -->
            <div class="mt-12 text-center">
                <h3 class="text-lg font-semibold text-neutral-900 mb-4">Butuh Bantuan?</h3>
                <p class="text-neutral-600 mb-6">
                    Jika Anda memiliki pertanyaan tentang pesanan ini, jangan ragu untuk menghubungi kami
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="tel:+622112345678" class="btn-outline">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        +62 21 1234 5678
                    </a>
                    
                    <a href="mailto:info@grosirberkatibu.com" class="btn-outline">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        info@grosirberkatibu.com
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
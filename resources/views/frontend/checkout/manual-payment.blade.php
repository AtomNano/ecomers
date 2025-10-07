@extends('layouts.frontend.app')

@section('title', 'Instruksi Pembayaran - Grosir Berkat Ibu')
@section('description', 'Instruksi pembayaran manual untuk pesanan Anda.')

@section('content')
<div class="bg-white">
    <div class="container-custom section-padding">
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-neutral-900 mb-6">Instruksi Pembayaran</h1>
            <p class="text-xl text-neutral-600 max-w-3xl mx-auto">
                Selesaikan pembayaran sesuai dengan instruksi di bawah ini
            </p>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Payment Instructions -->
                <div class="space-y-8">
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
                                <span class="text-neutral-600">Total Pembayaran</span>
                                <span class="font-semibold text-primary-600 text-xl">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Transfer Instructions -->
                    <div class="card p-8">
                        <h2 class="text-2xl font-semibold text-neutral-900 mb-6">Transfer Bank Manual</h2>
                        
                        <div class="space-y-6">
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <div class="flex items-start">
                                    <svg class="h-5 w-5 text-yellow-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <h3 class="font-medium text-yellow-800">Penting!</h3>
                                        <p class="text-sm text-yellow-700 mt-1">
                                            Pastikan nominal transfer sesuai persis dengan total pembayaran. 
                                            Transfer dengan nominal berbeda akan ditolak.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <h3 class="font-semibold text-neutral-900">Rekening Tujuan</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="border border-neutral-200 rounded-lg p-4">
                                        <div class="flex items-center mb-3">
                                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-sm font-bold text-blue-600">BCA</span>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-neutral-900">Bank Central Asia</h4>
                                            </div>
                                        </div>
                                        <div class="space-y-1 text-sm">
                                            <p><strong>No. Rekening:</strong> 1234567890</p>
                                            <p><strong>Atas Nama:</strong> Grosir Berkat Ibu</p>
                                        </div>
                                    </div>

                                    <div class="border border-neutral-200 rounded-lg p-4">
                                        <div class="flex items-center mb-3">
                                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-sm font-bold text-red-600">MDR</span>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-neutral-900">Bank Mandiri</h4>
                                            </div>
                                        </div>
                                        <div class="space-y-1 text-sm">
                                            <p><strong>No. Rekening:</strong> 0987654321</p>
                                            <p><strong>Atas Nama:</strong> Grosir Berkat Ibu</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <h3 class="font-semibold text-neutral-900">Langkah Pembayaran</h3>
                                
                                <div class="space-y-3">
                                    <div class="flex items-start space-x-3">
                                        <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <span class="text-xs font-medium text-primary-600">1</span>
                                        </div>
                                        <p class="text-neutral-600">Transfer ke salah satu rekening di atas dengan nominal <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></p>
                                    </div>
                                    <div class="flex items-start space-x-3">
                                        <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <span class="text-xs font-medium text-primary-600">2</span>
                                        </div>
                                        <p class="text-neutral-600">Simpan bukti transfer (screenshot atau foto)</p>
                                    </div>
                                    <div class="flex items-start space-x-3">
                                        <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <span class="text-xs font-medium text-primary-600">3</span>
                                        </div>
                                        <p class="text-neutral-600">Upload bukti transfer di halaman ini</p>
                                    </div>
                                    <div class="flex items-start space-x-3">
                                        <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <span class="text-xs font-medium text-primary-600">4</span>
                                        </div>
                                        <p class="text-neutral-600">Tunggu konfirmasi dari admin (maksimal 24 jam)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Proof -->
                    <div class="card p-8">
                        <h2 class="text-2xl font-semibold text-neutral-900 mb-6">Upload Bukti Transfer</h2>
                        
                        <form action="{{ route('checkout.upload-proof', $order->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 mb-2">Pilih File Bukti Transfer</label>
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-neutral-300 border-dashed rounded-md hover:border-primary-400 transition-colors">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-neutral-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-neutral-600">
                                                <label for="payment_proof" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                                    <span>Upload bukti transfer</span>
                                                    <input id="payment_proof" name="payment_proof" type="file" class="sr-only" accept="image/*" required>
                                                </label>
                                                <p class="pl-1">atau drag and drop</p>
                                            </div>
                                            <p class="text-xs text-neutral-500">PNG, JPG, JPEG hingga 5MB</p>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 mb-2">Catatan (Opsional)</label>
                                    <textarea 
                                        name="notes" 
                                        rows="3"
                                        class="input-field"
                                        placeholder="Tambahkan catatan jika diperlukan..."
                                    ></textarea>
                                </div>

                                <button type="submit" class="btn-primary w-full">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    Upload Bukti Transfer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="space-y-8">
                    <!-- Order Details -->
                    <div class="card p-6">
                        <h2 class="text-xl font-semibold text-neutral-900 mb-6">Detail Pesanan</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <h3 class="font-medium text-neutral-900 mb-2">Produk</h3>
                                <div class="space-y-2">
                                    @foreach($order->orderItems as $item)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-neutral-600">{{ $item->product->name }} x {{ $item->quantity }}</span>
                                        <span class="font-medium">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <hr class="border-neutral-200">

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

                    <!-- Shipping Information -->
                    <div class="card p-6">
                        <h2 class="text-xl font-semibold text-neutral-900 mb-6">Informasi Pengiriman</h2>
                        
                        <div class="space-y-3 text-sm">
                            <div>
                                <span class="font-medium text-neutral-900">Penerima:</span>
                                <span class="text-neutral-600">{{ $order->customer_name }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-neutral-900">Telepon:</span>
                                <span class="text-neutral-600">{{ $order->customer_phone }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-neutral-900">Alamat:</span>
                                <span class="text-neutral-600">{{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_province }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-neutral-900">Metode:</span>
                                <span class="text-neutral-600">
                                    @switch($order->shipping_method)
                                        @case('gosend')
                                            GoSend
                                            @break
                                        @case('pickup')
                                            Ambil Sendiri
                                            @break
                                        @case('courier')
                                            Kurir Eksternal
                                            @break
                                    @endswitch
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="card p-6">
                        <h2 class="text-xl font-semibold text-neutral-900 mb-6">Status Pesanan</h2>
                        
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                            <span class="text-neutral-900 font-medium">Menunggu Pembayaran</span>
                        </div>
                        
                        <p class="text-sm text-neutral-600 mt-2">
                            Upload bukti transfer untuk mempercepat proses verifikasi.
                        </p>
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
@endsection

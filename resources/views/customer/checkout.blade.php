@extends('layouts.app')

@section('title', 'Checkout - Grosir Berkat Ibu')

@section('content')
<div class="max-w-6xl mx-auto pb-24 md:pb-12" x-data="{ 
    shippingMethod: '{{ old('shipping_method', 'gosend') }}', 
    paymentMethod: '{{ old('payment_method', 'transfer') }}',
    subtotal: {{ $subtotal }},
    shippingCost: {{ old('shipping_method', 'gosend') == 'gosend' ? 15000 : 0 }}
}"
x-init="$watch('shippingMethod', value => shippingCost = value === 'gosend' ? 15000 : 0)">
    
    <div class="flex items-center gap-4 mb-8 pt-4">
        <a href="{{ route('customer.cart.index') }}" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-gray-600 hover:text-red-500 shadow-sm transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Checkout Pesanan</h1>
            <p class="text-gray-500 text-sm">Selesaikan pesanan Anda</p>
        </div>
    </div>

    @if(isset($cartItems) && count($cartItems) > 0)
        <form id="checkoutForm" action="{{ route('customer.checkout.store') }}" method="POST">
             @csrf
             
             <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Forms -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- 1. Review Produk -->
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center text-red-500 text-sm font-bold">1</div>
                            Review Pesanan
                        </h2>
                        <div class="space-y-4">
                            @foreach($cartItems as $item)
                                <div class="flex flex-col sm:flex-row gap-4 p-4 border border-gray-100 rounded-xl hover:bg-gray-50 transition">
                                    <div class="w-full sm:w-20 h-20 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden">
                                        @if($item->product->image)
                                            <img src="{{ \Illuminate\Support\Str::startsWith($item->product->image, 'http') ? $item->product->image : asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-300"><i class="fas fa-image"></i></div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="font-bold text-gray-800">{{ $item->product->name }}</h3>
                                                <p class="text-xs text-gray-500 mb-2">{{ $item->product->category->name ?? 'Umum' }}</p>
                                            </div>
                                            <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded text-xs font-bold whitespace-nowrap">
                                                {{ ucfirst($item->priceInfo['price_type']) }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between items-center text-sm mt-2">
                                            <p class="text-gray-600">{{ $item->quantity }} x Rp {{ number_format($item->priceInfo['effective_price'], 0, ',', '.') }}</p>
                                            <p class="font-bold text-gray-800">Rp {{ number_format($item->priceInfo['total_price'], 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- 2. Pengiriman -->
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center text-red-500 text-sm font-bold">2</div>
                            Metode Pengiriman
                        </h2>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                            <label class="relative border-2 rounded-xl p-4 cursor-pointer hover:bg-gray-50 transition select-none"
                                   :class="shippingMethod === 'gosend' ? 'border-red-500 bg-red-50/30' : 'border-gray-200'">
                                <input type="radio" name="shipping_method" value="gosend" x-model="shippingMethod" class="absolute top-4 right-4 text-red-500 focus:ring-red-500">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="p-2 bg-green-100 rounded-lg text-green-600">
                                        <i class="fas fa-motorcycle"></i>
                                    </div>
                                    <span class="font-bold text-gray-700">GoSend Instant</span>
                                </div>
                                <p class="text-sm text-gray-500 mb-1">Dikirim langsung ke alamat Anda</p>
                                <p class="text-red-600 font-bold">Rp 15.000</p>
                            </label>
                            
                            <label class="relative border-2 rounded-xl p-4 cursor-pointer hover:bg-gray-50 transition select-none"
                                   :class="shippingMethod === 'pickup' ? 'border-red-500 bg-red-50/30' : 'border-gray-200'">
                                <input type="radio" name="shipping_method" value="pickup" x-model="shippingMethod" class="absolute top-4 right-4 text-red-500 focus:ring-red-500">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="p-2 bg-orange-100 rounded-lg text-orange-600">
                                        <i class="fas fa-store"></i>
                                    </div>
                                    <span class="font-bold text-gray-700">Ambil Sendiri</span>
                                </div>
                                <p class="text-sm text-gray-500 mb-1">Ambil di toko kami (Gratis)</p>
                                <p class="text-green-600 font-bold">Rp 0</p>
                            </label>
                        </div>

                        <!-- Address Form (Dynamic) -->
                        <div x-show="shippingMethod === 'gosend'" x-transition 
                             class="space-y-4 border-t border-gray-100 pt-6">
                            <h3 class="font-bold text-gray-700 mb-2">Alamat Pengiriman</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penerima</label>
                                    <input type="text" name="customer_name" value="{{ old('customer_name', $user->name) }}" class="w-full border-gray-200 rounded-xl focus:ring-red-500 focus:border-red-500 transition" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                                    <input type="tel" name="customer_phone" value="{{ old('customer_phone', $user->phone) }}" class="w-full border-gray-200 rounded-xl focus:ring-red-500 focus:border-red-500 transition" required>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                                    <textarea name="customer_address" rows="3" class="w-full border-gray-200 rounded-xl focus:ring-red-500 focus:border-red-500 transition" required placeholder="Jl. Contoh No. 123, Kelurahan, Kecamatan...">{{ old('customer_address', $user->address) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Default Inputs for Pickup (Hidden but Required) -->
                        <div x-show="shippingMethod === 'pickup'" x-data class="hidden">
                            <!-- We still need basic info for identification even for pickup -->
                             <input type="hidden" name="customer_name_pickup" :value="'{{ $user->name }}'">
                             <input type="hidden" name="customer_phone_pickup" :value="'{{ $user->phone }}'">
                             <input type="hidden" name="customer_address_pickup" value="Ambil Sendiri di Toko">
                        </div>
                    </div>

                    <!-- 3. Pembayaran -->
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center text-red-500 text-sm font-bold">3</div>
                            Metode Pembayaran
                        </h2>

                         <div class="space-y-4">
                            <!-- Transfer Option -->
                            <div>
                                <label class="flex items-center justify-between border-2 rounded-xl p-4 cursor-pointer hover:bg-gray-50 transition select-none"
                                       :class="paymentMethod === 'transfer' ? 'border-red-500 bg-red-50/30' : 'border-gray-200'">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="transfer" x-model="paymentMethod" class="text-red-500 focus:ring-red-500">
                                        <div>
                                            <span class="font-bold text-gray-700 block">Transfer Bank</span>
                                            <span class="text-xs text-gray-500">Cek manual oleh admin</span>
                                        </div>
                                    </div>
                                    <i class="fas fa-university text-gray-400 text-xl"></i>
                                </label>
                                
                                <!-- Transfer Info Preview -->
                                <div x-show="paymentMethod === 'transfer'" x-transition class="mt-3 ml-2 md:ml-8 p-4 bg-blue-50 rounded-xl border border-blue-100 text-sm">
                                    <p class="text-blue-800 mb-3 font-medium flex items-center gap-2">
                                        <i class="fas fa-info-circle"></i> Info Rekening:
                                    </p>
                                    <div class="bg-white p-3 rounded-lg border border-blue-100 shadow-sm">
                                        <div class="flex items-center gap-3 mb-2 pb-2 border-b border-gray-100">
                                            <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 font-bold">
                                                <i class="fas fa-university"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500">Bank Tujuan</p>
                                                <p class="font-bold text-gray-800">{{ $storeSetting->bank_name ?? 'Hubungi Admin' }}</p>
                                            </div>
                                        </div>
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-gray-500 text-xs">Nomor Rekening</span>
                                            <span class="font-mono font-bold text-gray-800 text-base" onclick="navigator.clipboard.writeText('{{ $storeSetting->bank_account_number ?? '' }}'); alert('Disalin!');" class="cursor-pointer">{{ $storeSetting->bank_account_number ?? '-' }} <i class="far fa-copy ml-1"></i></span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-500 text-xs">Atas Nama</span>
                                            <span class="font-bold text-gray-800">{{ $storeSetting->bank_account_holder ?? '-' }}</span>
                                        </div>
                                    </div>
                                    <p class="text-xs text-blue-600 mt-2">*Mohon upload bukti transfer setelah checkout.</p>
                                </div>
                            </div>

                            <!-- QRIS Option -->
                            <div>
                                <label class="flex items-center justify-between border-2 rounded-xl p-4 cursor-pointer hover:bg-gray-50 transition select-none"
                                       :class="paymentMethod === 'qris' ? 'border-red-500 bg-red-50/30' : 'border-gray-200'">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="qris" x-model="paymentMethod" class="text-red-500 focus:ring-red-500">
                                        <div>
                                            <span class="font-bold text-gray-700 block">QRIS</span>
                                            <span class="text-xs text-gray-500">Scan barcode instan</span>
                                        </div>
                                    </div>
                                    <i class="fas fa-qrcode text-gray-400 text-xl"></i>
                                </label>

                                 <!-- QRIS Preview -->
                                <div x-show="paymentMethod === 'qris'" x-transition class="mt-3 ml-2 md:ml-8 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                    @if($storeSetting && $storeSetting->qris_image)
                                        <p class="text-sm text-gray-600 mb-3 font-medium">Scan QR code berikut:</p>
                                        <div class="bg-white p-3 rounded-xl border inline-block shadow-sm">
                                            <img src="{{ asset('storage/' . $storeSetting->qris_image) }}" class="w-48 h-auto rounded-lg">
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2">Dukung Gopay, OVO, Dana, ShopeePay, BCA Mobile, dll.</p>
                                    @else
                                        <div class="flex items-center gap-2 text-red-500 bg-red-50 p-3 rounded-lg">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <span class="text-sm font-medium">QRIS belum tersedia saat ini.</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                         </div>
                    </div>
                </div>

                <!-- Right Column: Summary -->
                <div class="lg:col-span-1">
                     <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-24 border border-gray-100">
                        <h3 class="font-bold text-lg mb-4 text-gray-800">Ringkasan Belanja</h3>
                        
                        <div class="space-y-3 pb-4 border-b border-dashed border-gray-200">
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Total Harga ({{ count($cartItems) }} barang)</span>
                                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Ongkos Kirim</span>
                                <span class="font-medium" :class="shippingCost > 0 ? 'text-gray-800' : 'text-green-600'" 
                                      x-text="shippingCost > 0 ? 'Rp ' + shippingCost.toLocaleString('id-ID') : 'Gratis'"></span>
                            </div>
                        </div>

                        <div class="pt-4 mt-2">
                             <div class="flex justify-between items-center mb-6">
                                <span class="font-bold text-gray-800">Total Tagihan</span>
                                <span class="text-2xl font-bold text-red-500" x-text="'Rp ' + (subtotal + shippingCost).toLocaleString('id-ID')"></span>
                            </div>
                            
                            <!-- Hidden Submit for Desktop logic handled by Mobile bar too -->
                            <button type="submit" class="hidden lg:block w-full py-4 bg-gradient-to-r from-red-500 to-orange-500 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:scale-[1.02] transition transform">
                                Buat Pesanan <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                            
                            <p class="text-xs text-gray-400 mt-4 text-center">
                                Dengan membuat pesanan, Anda menyetujui Syarat & Ketentuan kami.
                            </p>
                        </div>
                     </div>
                </div>
             </div>
        </form>

        <!-- Mobile Sticky Bottom Bar (Improved "Murah Digapai") -->
        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 lg:hidden z-50 shadow-[0_-5px_15px_rgba(0,0,0,0.1)] pb-safe">
            <div class="flex items-center gap-4 container mx-auto">
                <div class="flex-1">
                    <p class="text-xs text-gray-500">Total Tagihan</p>
                    <p class="text-xl font-bold text-red-500" x-text="'Rp ' + (subtotal + shippingCost).toLocaleString('id-ID')"></p>
                </div>
                <!-- Large, Easy to Tap Button -->
                <button onclick="document.getElementById('checkoutForm').submit()" class="flex-none px-8 py-3 bg-red-500 text-white font-bold rounded-xl shadow-lg active:scale-95 transition w-1/2">
                    Buat Pesanan
                </button>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-sm p-12 text-center max-w-lg mx-auto mt-12">
            <div class="w-24 h-24 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-shopping-cart text-4xl text-red-300"></i>
            </div>
            <h2 class="text-xl font-bold text-gray-800 mb-2">Keranjang Kosong</h2>
            <p class="text-gray-500 mb-8">Anda belum menambahkan produk apapun.</p>
            <a href="{{ route('customer.products.index') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-red-500 text-white font-medium rounded-xl hover:bg-red-600 transition">
                Mulai Belanja
            </a>
        </div>
    @endif
</div>
@endsection

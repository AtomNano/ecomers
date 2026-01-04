@extends('layouts.app')

@section('title', 'Checkout - Grosir Berkat Ibu')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Checkout</h1>

    @if(isset($cartItems) && count($cartItems) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Order Review -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded shadow p-6 mb-6">
                    <h2 class="text-xl font-bold mb-4">📋 Review Pesanan Anda</h2>
                    <div class="space-y-4">
                        @foreach($cartItems as $item)
                            <div class="border rounded-lg p-4 hover:bg-gray-50 transition">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="font-bold text-lg">{{ $item->product->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $item->product->description ?? 'Produk berkualitas' }}</p>
                                    </div>
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded text-sm font-bold">
                                        {{ ucfirst($item->priceInfo['price_type']) }}
                                    </span>
                                </div>
                                
                                <div class="grid grid-cols-3 gap-4 text-sm mb-2 bg-gray-50 p-3 rounded">
                                    <div>
                                        <p class="text-gray-600">Jumlah</p>
                                        <p class="font-bold">{{ $item->quantity }} {{ $item->product->unit }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">Harga Satuan</p>
                                        <p class="font-bold">Rp {{ number_format($item->priceInfo['effective_price'], 0, ',', '.') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-gray-600">Subtotal</p>
                                        <p class="font-bold text-green-600">Rp {{ number_format($item->priceInfo['total_price'], 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                
                                <p class="text-xs text-gray-500 italic">{{ $item->priceInfo['description'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Checkout Form -->
                <form action="{{ route('customer.checkout.store') }}" method="POST" class="bg-white rounded shadow p-6">
                    @csrf
                    
                    <h2 class="text-xl font-bold mb-4">📦 Alamat Pengiriman</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold mb-2">Nama Penerima</label>
                            <input type="text" name="customer_name" value="{{ auth()->user()->name }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-green-500" required>
                            @error('customer_name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold mb-2">Telepon</label>
                            <input type="tel" name="customer_phone" value="{{ auth()->user()->phone }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-green-500" required>
                            @error('customer_phone')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold mb-2">Alamat Lengkap</label>
                            <textarea name="customer_address" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-green-500" rows="3" required>{{ auth()->user()->address }}</textarea>
                            @error('customer_address')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold mb-2">Metode Pengiriman</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="shipping_method" value="gosend" checked class="mr-2"> 
                                    <span>GoSend (Rp 15.000)</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="shipping_method" value="pickup" class="mr-2"> 
                                    <span>Ambil Sendiri (Gratis)</span>
                                </label>
                            </div>
                            @error('shipping_method')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold mb-2">Metode Pembayaran</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="payment_method" value="transfer" checked class="mr-2"> 
                                    <span>Transfer Bank</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="payment_method" value="qris" class="mr-2"> 
                                    <span>QRIS</span>
                                </label>
                            </div>
                            @error('payment_method')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex gap-4">
                        <a href="{{ route('customer.cart.index') }}" class="flex-1 bg-gray-600 text-white py-3 rounded text-center hover:bg-gray-700 font-bold">
                            ← Kembali ke Keranjang
                        </a>
                        <button type="submit" class="flex-1 bg-green-600 text-white py-3 rounded hover:bg-green-700 font-bold text-lg">
                            Lanjut ke Pembayaran →
                        </button>
                    </div>
                </form>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-green-50 rounded-lg shadow p-6 sticky top-4 border-2 border-green-200">
                    <h3 class="text-lg font-bold mb-4">💵 Ringkasan Pesanan</h3>
                    
                    <div class="space-y-3 pb-4 border-b-2 border-green-200">
                        @php $subtotal = 0; @endphp
                        @foreach($cartItems as $item)
                            @php $subtotal += $item->priceInfo['total_price']; @endphp
                            <div class="flex justify-between text-sm">
                                <span>{{ $item->product->name }} ({{ $item->quantity }}x)</span>
                                <span class="font-bold">Rp {{ number_format($item->priceInfo['total_price'], 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm" id="shippingDisplay">
                            <span>Ongkir (GoSend)</span>
                            <span>Rp 15.000</span>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t-2 border-green-200 flex justify-between text-lg font-bold text-green-600">
                        <span>Total:</span>
                        <span id="totalDisplay">Rp {{ number_format($subtotal + 15000, 0, ',', '.') }}</span>
                    </div>
                    
                    <p class="text-xs text-gray-600 mt-4 italic">
                        ℹ️ Harga sudah termasuk diskon otomatis sesuai jumlah pembelian
                    </p>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded shadow p-8 text-center">
            <p class="text-gray-600 mb-4">Keranjang belanja Anda kosong</p>
            <a href="{{ route('customer.products.index') }}" class="inline-block bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                Kembali Belanja
            </a>
        </div>
    @endif
</div>

<script>
    // Update shipping cost based on selection
    document.querySelectorAll('input[name="shipping_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const shippingCost = this.value === 'gosend' ? 15000 : 0;
            const subtotal = @php echo $subtotal ?? 0; @endphp;
            const total = subtotal + shippingCost;
            
            document.getElementById('shippingDisplay').innerHTML = `
                <span>${this.value === 'gosend' ? 'Ongkir (GoSend)' : 'Ambil Sendiri'}</span>
                <span>Rp ${shippingCost.toLocaleString('id-ID')}</span>
            `;
            
            document.getElementById('totalDisplay').textContent = 'Rp ' + total.toLocaleString('id-ID');
        });
    });
</script>
@endsection

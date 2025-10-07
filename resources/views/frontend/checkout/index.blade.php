@extends('layouts.frontend.app')

@section('title', 'Checkout - Grosir Berkat Ibu')
@section('description', 'Selesaikan pembayaran untuk pesanan Anda di Grosir Berkat Ibu.')

@section('content')
<div class="bg-white">
    <div class="container-custom section-padding">
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-neutral-900 mb-6">Checkout</h1>
            <p class="text-xl text-neutral-600 max-w-3xl mx-auto">
                Lengkapi informasi pengiriman dan pembayaran untuk menyelesaikan pesanan Anda
            </p>
        </div>

        <div class="max-w-6xl mx-auto">
            <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Checkout Form -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Customer Information -->
                        <div class="card p-8">
                            <h2 class="text-2xl font-semibold text-neutral-900 mb-6">Informasi Penerima</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 mb-2">Nama Lengkap *</label>
                                    <input 
                                        type="text" 
                                        name="customer_name"
                                        class="input-field"
                                        value="{{ auth()->user()->name ?? '' }}"
                                        required
                                    >
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 mb-2">Nomor Telepon *</label>
                                    <input 
                                        type="tel" 
                                        name="customer_phone"
                                        class="input-field"
                                        value="{{ auth()->user()->phone_number ?? '' }}"
                                        required
                                    >
                                </div>
                            </div>

                            <div class="mt-6">
                                <label class="block text-sm font-medium text-neutral-700 mb-2">Email *</label>
                                <input 
                                    type="email" 
                                    name="customer_email"
                                    class="input-field"
                                    value="{{ auth()->user()->email ?? '' }}"
                                    required
                                >
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div class="card p-8">
                            <h2 class="text-2xl font-semibold text-neutral-900 mb-6">Alamat Pengiriman</h2>
                            
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-neutral-700 mb-2">Alamat Lengkap *</label>
                                <textarea 
                                    name="shipping_address" 
                                    rows="3"
                                    class="input-field"
                                    placeholder="Masukkan alamat lengkap pengiriman"
                                    required
                                >{{ auth()->user()->address ?? '' }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 mb-2">Provinsi *</label>
                                    <select name="shipping_province" class="input-field" required>
                                        <option value="">Pilih Provinsi</option>
                                        <option value="DKI Jakarta" {{ auth()->user()->province == 'DKI Jakarta' ? 'selected' : '' }}>DKI Jakarta</option>
                                        <option value="Jawa Barat" {{ auth()->user()->province == 'Jawa Barat' ? 'selected' : '' }}>Jawa Barat</option>
                                        <option value="Jawa Tengah" {{ auth()->user()->province == 'Jawa Tengah' ? 'selected' : '' }}>Jawa Tengah</option>
                                        <option value="Jawa Timur" {{ auth()->user()->province == 'Jawa Timur' ? 'selected' : '' }}>Jawa Timur</option>
                                        <option value="Banten" {{ auth()->user()->province == 'Banten' ? 'selected' : '' }}>Banten</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 mb-2">Kota *</label>
                                    <input 
                                        type="text" 
                                        name="shipping_city"
                                        class="input-field"
                                        value="{{ auth()->user()->city ?? '' }}"
                                        required
                                    >
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 mb-2">Kecamatan *</label>
                                    <input 
                                        type="text" 
                                        name="shipping_district"
                                        class="input-field"
                                        value="{{ auth()->user()->district ?? '' }}"
                                        required
                                    >
                                </div>
                            </div>

                            <div class="mt-6">
                                <label class="block text-sm font-medium text-neutral-700 mb-2">Kode Pos</label>
                                <input 
                                    type="text" 
                                    name="shipping_postal_code"
                                    class="input-field"
                                    placeholder="12345"
                                >
                            </div>
                        </div>

                        <!-- Shipping Method -->
                        <div class="card p-8">
                            <h2 class="text-2xl font-semibold text-neutral-900 mb-6">Metode Pengiriman</h2>
                            
                            <div class="space-y-4">
                                <label class="shipping-option">
                                    <input type="radio" name="shipping_method" value="gosend" class="shipping-radio" checked>
                                    <div class="shipping-option-content">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <h3 class="font-semibold text-neutral-900">GoSend</h3>
                                                <p class="text-sm text-neutral-600">Pengiriman same-day untuk area Jakarta</p>
                                            </div>
                                            <div class="text-right">
                                                <div class="font-semibold text-neutral-900">Rp 15.000</div>
                                                <div class="text-sm text-neutral-600">1-2 hari kerja</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                                <label class="shipping-option">
                                    <input type="radio" name="shipping_method" value="pickup" class="shipping-radio">
                                    <div class="shipping-option-content">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <h3 class="font-semibold text-neutral-900">Ambil Sendiri</h3>
                                                <p class="text-sm text-neutral-600">Ambil langsung di gudang kami</p>
                                            </div>
                                            <div class="text-right">
                                                <div class="font-semibold text-neutral-900">Gratis</div>
                                                <div class="text-sm text-neutral-600">Sesuai jam kerja</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                                <label class="shipping-option">
                                    <input type="radio" name="shipping_method" value="courier" class="shipping-radio">
                                    <div class="shipping-option-content">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <h3 class="font-semibold text-neutral-900">Kurir Eksternal</h3>
                                                <p class="text-sm text-neutral-600">JNE, TIKI, Pos Indonesia</p>
                                            </div>
                                            <div class="text-right">
                                                <div class="font-semibold text-neutral-900">Rp 20.000</div>
                                                <div class="text-sm text-neutral-600">3-7 hari kerja</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="card p-8">
                            <h2 class="text-2xl font-semibold text-neutral-900 mb-6">Metode Pembayaran</h2>
                            
                            <div class="space-y-4">
                                <label class="payment-option">
                                    <input type="radio" name="payment_method" value="virtual_account" class="payment-radio" checked>
                                    <div class="payment-option-content">
                                        <div class="flex items-center">
                                            <div class="w-12 h-8 bg-blue-100 rounded flex items-center justify-center mr-4">
                                                <span class="text-xs font-bold text-blue-600">VA</span>
                                            </div>
                                            <div>
                                                <h3 class="font-semibold text-neutral-900">Virtual Account</h3>
                                                <p class="text-sm text-neutral-600">BCA, Mandiri, BRI - Transfer otomatis</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                                <label class="payment-option">
                                    <input type="radio" name="payment_method" value="qris" class="payment-radio">
                                    <div class="payment-option-content">
                                        <div class="flex items-center">
                                            <div class="w-12 h-8 bg-green-100 rounded flex items-center justify-center mr-4">
                                                <span class="text-xs font-bold text-green-600">QR</span>
                                            </div>
                                            <div>
                                                <h3 class="font-semibold text-neutral-900">QRIS</h3>
                                                <p class="text-sm text-neutral-600">GoPay, OVO, DANA - Scan QR Code</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                                <label class="payment-option">
                                    <input type="radio" name="payment_method" value="bank_transfer" class="payment-radio">
                                    <div class="payment-option-content">
                                        <div class="flex items-center">
                                            <div class="w-12 h-8 bg-purple-100 rounded flex items-center justify-center mr-4">
                                                <span class="text-xs font-bold text-purple-600">TF</span>
                                            </div>
                                            <div>
                                                <h3 class="font-semibold text-neutral-900">Transfer Bank Manual</h3>
                                                <p class="text-sm text-neutral-600">Transfer manual ke rekening tujuan</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Order Notes -->
                        <div class="card p-8">
                            <h2 class="text-2xl font-semibold text-neutral-900 mb-6">Catatan Pesanan</h2>
                            
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 mb-2">Catatan untuk Penjual (Opsional)</label>
                                <textarea 
                                    name="order_notes" 
                                    rows="3"
                                    class="input-field"
                                    placeholder="Masukkan catatan khusus untuk pesanan Anda..."
                                ></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="card p-6 sticky top-6">
                            <h2 class="text-xl font-semibold text-neutral-900 mb-6">Ringkasan Pesanan</h2>
                            
                            <!-- Order Items -->
                            <div class="space-y-4 mb-6">
                                @if($cartItems && $cartItems->count() > 0)
                                    @foreach($cartItems as $item)
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
                                            <p class="text-xs text-neutral-600">{{ $item->quantity }} x Rp {{ number_format($item->product->getPriceForQuantity($item->quantity), 0, ',', '.') }}</p>
                                        </div>
                                        <div class="font-semibold text-neutral-900 text-sm">
                                            Rp {{ number_format($item->product->getPriceForQuantity($item->quantity) * $item->quantity, 0, ',', '.') }}
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>

                            <!-- Order Summary -->
                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between">
                                    <span class="text-neutral-600">Subtotal</span>
                                    <span class="font-medium" id="subtotal">Rp {{ number_format($cartItems->sum(function($item) { return $item->product->getPriceForQuantity($item->quantity) * $item->quantity; }), 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-neutral-600">Biaya Pengiriman</span>
                                    <span class="font-medium" id="shipping-cost">Rp 15.000</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-neutral-600">Diskon</span>
                                    <span class="font-medium text-green-600">- Rp 0</span>
                                </div>
                                <hr class="border-neutral-200">
                                <div class="flex justify-between text-lg font-semibold">
                                    <span>Total</span>
                                    <span id="total">Rp {{ number_format($cartItems->sum(function($item) { return $item->product->getPriceForQuantity($item->quantity) * $item->quantity; }) + 15000, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="mb-6">
                                <label class="flex items-start">
                                    <input type="checkbox" name="terms_accepted" class="mt-1" required>
                                    <span class="ml-2 text-sm text-neutral-600">
                                        Saya menyetujui <a href="#" class="text-primary-600 hover:text-primary-700">syarat dan ketentuan</a> serta <a href="#" class="text-primary-600 hover:text-primary-700">kebijakan privasi</a>
                                    </span>
                                </label>
                            </div>

                            <!-- Place Order Button -->
                            <button type="submit" class="btn-primary w-full mb-4" id="place-order-btn">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                                </svg>
                                Buat Pesanan
                            </button>

                            <!-- Security Badge -->
                            <div class="text-center">
                                <div class="flex items-center justify-center space-x-2 text-sm text-neutral-600">
                                    <svg class="h-4 w-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Pembayaran 100% Aman</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.shipping-option {
    @apply block cursor-pointer;
}

.shipping-radio {
    @apply sr-only;
}

.shipping-option-content {
    @apply p-4 border border-neutral-200 rounded-lg hover:border-primary-300 transition-colors duration-200;
}

.shipping-radio:checked + .shipping-option-content {
    @apply border-primary-500 bg-primary-50;
}

.payment-option {
    @apply block cursor-pointer;
}

.payment-radio {
    @apply sr-only;
}

.payment-option-content {
    @apply p-4 border border-neutral-200 rounded-lg hover:border-primary-300 transition-colors duration-200;
}

.payment-radio:checked + .payment-option-content {
    @apply border-primary-500 bg-primary-50;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Shipping method change
    const shippingRadios = document.querySelectorAll('.shipping-radio');
    
    shippingRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            updateShippingCost(this.value);
        });
    });

    // Update shipping cost
    function updateShippingCost(method) {
        const costs = {
            'gosend': 15000,
            'pickup': 0,
            'courier': 20000
        };
        
        const cost = costs[method] || 0;
        document.getElementById('shipping-cost').textContent = `Rp ${cost.toLocaleString('id-ID')}`;
        
        updateTotal();
    }

    // Update total
    function updateTotal() {
        const subtotalText = document.getElementById('subtotal').textContent;
        const subtotal = parseInt(subtotalText.replace(/[^\d]/g, '')) || 0;
        
        const shippingCostText = document.getElementById('shipping-cost').textContent;
        const shippingCost = parseInt(shippingCostText.replace(/[^\d]/g, '')) || 0;
        
        const total = subtotal + shippingCost;
        document.getElementById('total').textContent = `Rp ${total.toLocaleString('id-ID')}`;
    }

    // Form submission
    const checkoutForm = document.getElementById('checkout-form');
    const placeOrderBtn = document.getElementById('place-order-btn');
    
    checkoutForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Disable button to prevent double submission
        placeOrderBtn.disabled = true;
        placeOrderBtn.innerHTML = `
            <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Memproses...
        `;
        
        // Submit form
        this.submit();
    });
});
</script>
@endsection
@extends('layouts.frontend.app')

@section('title', 'Keranjang Belanja - Grosir Berkat Ibu')
@section('description', 'Kelola produk di keranjang belanja Anda sebelum checkout.')

@section('content')
<div class="bg-white">
    <div class="container-custom section-padding">
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-neutral-900 mb-6">Keranjang Belanja</h1>
            <p class="text-xl text-neutral-600 max-w-3xl mx-auto">
                Periksa produk yang telah Anda pilih sebelum melanjutkan ke checkout
            </p>
        </div>

        <div class="max-w-6xl mx-auto">
            @if($cartItems && $cartItems->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="card p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-semibold text-neutral-900">
                                Produk di Keranjang ({{ $cartItems->count() }})
                            </h2>
                            <button class="text-red-600 hover:text-red-700 text-sm font-medium">
                                <svg class="h-4 w-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Hapus Semua
                            </button>
                        </div>

                        <div class="space-y-4">
                            @foreach($cartItems as $item)
                            <div class="cart-item border border-neutral-200 rounded-lg p-4">
                                <div class="flex items-center space-x-4">
                                    <!-- Product Image -->
                                    <div class="w-20 h-20 bg-neutral-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        @if($item->product->image)
                                            <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded-lg">
                                        @else
                                            <svg class="h-8 w-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                        @endif
                                    </div>

                                    <!-- Product Info -->
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-neutral-900 mb-1">{{ $item->product->name }}</h3>
                                        <p class="text-sm text-neutral-600 mb-2">{{ $item->product->category->name }}</p>
                                        
                                        <!-- Tier Pricing Info -->
                                        <div class="text-sm text-neutral-600">
                                            @if($item->quantity >= 12 && $item->product->price_per_dozen)
                                                <span class="text-green-600 font-medium">Harga Kartonan (≥12 pcs)</span>
                                            @elseif($item->quantity >= 4 && $item->product->price_per_four)
                                                <span class="text-blue-600 font-medium">Harga Grosir (≥4 pcs)</span>
                                            @else
                                                <span class="text-neutral-600">Harga Eceran</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Quantity Controls -->
                                    <div class="flex items-center space-x-3">
                                        <button class="quantity-btn" data-action="decrease" data-item-id="{{ $item->id }}">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                            </svg>
                                        </button>
                                        <span class="quantity-display w-12 text-center font-medium">{{ $item->quantity }}</span>
                                        <button class="quantity-btn" data-action="increase" data-item-id="{{ $item->id }}">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Price -->
                                    <div class="text-right">
                                        <div class="font-semibold text-neutral-900">
                                            Rp {{ number_format($item->product->getPriceForQuantity($item->quantity) * $item->quantity, 0, ',', '.') }}
                                        </div>
                                        <div class="text-sm text-neutral-600">
                                            Rp {{ number_format($item->product->getPriceForQuantity($item->quantity), 0, ',', '.') }}/pcs
                                        </div>
                                    </div>

                                    <!-- Remove Button -->
                                    <button class="remove-item text-red-600 hover:text-red-700" data-item-id="{{ $item->id }}">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Continue Shopping -->
                    <div class="mt-6">
                        <a href="{{ route('products.index') }}" class="btn-outline">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Lanjutkan Belanja
                        </a>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="card p-6 sticky top-6">
                        <h2 class="text-xl font-semibold text-neutral-900 mb-6">Ringkasan Pesanan</h2>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between">
                                <span class="text-neutral-600">Subtotal</span>
                                <span class="font-medium" id="subtotal">Rp {{ number_format($cartItems->sum(function($item) { return $item->product->getPriceForQuantity($item->quantity) * $item->quantity; }), 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-neutral-600">Biaya Pengiriman</span>
                                <span class="font-medium" id="shipping-cost">Rp 0</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-neutral-600">Diskon</span>
                                <span class="font-medium text-green-600" id="discount">- Rp 0</span>
                            </div>
                            <hr class="border-neutral-200">
                            <div class="flex justify-between text-lg font-semibold">
                                <span>Total</span>
                                <span id="total">Rp {{ number_format($cartItems->sum(function($item) { return $item->product->getPriceForQuantity($item->quantity) * $item->quantity; }), 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Shipping Options -->
                        <div class="mb-6">
                            <h3 class="font-medium text-neutral-900 mb-3">Pilihan Pengiriman</h3>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="shipping" value="gosend" class="shipping-option" checked>
                                    <span class="ml-2 text-sm">GoSend (Same Day) - Rp 15.000</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="shipping" value="pickup" class="shipping-option">
                                    <span class="ml-2 text-sm">Ambil Sendiri - Gratis</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="shipping" value="courier" class="shipping-option">
                                    <span class="ml-2 text-sm">Kurir Eksternal - Rp 20.000</span>
                                </label>
                            </div>
                        </div>

                        <!-- Checkout Button -->
                        <a href="{{ route('checkout.index') }}" class="btn-primary w-full mb-4 text-center block" id="checkout-btn">
                            <svg class="h-5 w-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                            </svg>
                            Lanjut ke Checkout
                        </a>

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
            @else
            <!-- Empty Cart -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-neutral-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="h-12 w-12 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-neutral-900 mb-4">Keranjang Kosong</h2>
                <p class="text-neutral-600 mb-8 max-w-md mx-auto">
                    Belum ada produk di keranjang Anda. Mulai berbelanja untuk menambahkan produk ke keranjang.
                </p>
                <a href="{{ route('products.index') }}" class="btn-primary">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Mulai Berbelanja
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.quantity-btn {
    @apply w-8 h-8 rounded-full border border-neutral-300 flex items-center justify-center hover:bg-neutral-50 transition-colors duration-200;
}

.cart-item {
    @apply transition-all duration-200;
}

.cart-item:hover {
    @apply shadow-sm;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quantity Controls
    const quantityBtns = document.querySelectorAll('.quantity-btn');
    
    quantityBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const action = this.dataset.action;
            const itemId = this.dataset.itemId;
            const quantityDisplay = this.parentElement.querySelector('.quantity-display');
            let currentQuantity = parseInt(quantityDisplay.textContent);
            
            if (action === 'increase') {
                currentQuantity += 1;
            } else if (action === 'decrease' && currentQuantity > 1) {
                currentQuantity -= 1;
            }
            
            // Update quantity display
            quantityDisplay.textContent = currentQuantity;
            
            // Update cart via AJAX
            updateCartItem(itemId, currentQuantity);
        });
    });

    // Remove Item
    const removeBtns = document.querySelectorAll('.remove-item');
    
    removeBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            
            if (confirm('Apakah Anda yakin ingin menghapus produk ini dari keranjang?')) {
                removeCartItem(itemId);
            }
        });
    });

    // Shipping Options
    const shippingOptions = document.querySelectorAll('.shipping-option');
    
    shippingOptions.forEach(option => {
        option.addEventListener('change', function() {
            updateShippingCost(this.value);
        });
    });

    // Functions
    function updateCartItem(itemId, quantity) {
        // AJAX call to update cart item
        fetch(`/cart/update/${itemId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateOrderSummary();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function removeCartItem(itemId) {
        // AJAX call to remove cart item
        fetch(`/cart/remove/${itemId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function updateShippingCost(shippingMethod) {
        const shippingCosts = {
            'gosend': 15000,
            'pickup': 0,
            'courier': 20000
        };
        
        const cost = shippingCosts[shippingMethod] || 0;
        document.getElementById('shipping-cost').textContent = `Rp ${cost.toLocaleString('id-ID')}`;
        
        updateOrderSummary();
    }

    function updateOrderSummary() {
        // Calculate subtotal from all cart items
        let subtotal = 0;
        document.querySelectorAll('.cart-item').forEach(item => {
            const quantity = parseInt(item.querySelector('.quantity-display').textContent);
            const priceText = item.querySelector('.text-right .font-semibold').textContent;
            const price = parseInt(priceText.replace(/[^\d]/g, ''));
            subtotal += price;
        });
        
        // Get shipping cost
        const shippingCostText = document.getElementById('shipping-cost').textContent;
        const shippingCost = parseInt(shippingCostText.replace(/[^\d]/g, '')) || 0;
        
        // Calculate total
        const total = subtotal + shippingCost;
        
        // Update display
        document.getElementById('subtotal').textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
        document.getElementById('total').textContent = `Rp ${total.toLocaleString('id-ID')}`;
    }
});
</script>
@endsection
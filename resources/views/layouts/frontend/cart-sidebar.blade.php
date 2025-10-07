<!-- Cart Sidebar -->
<div 
    x-show="$store.cart.isOpen" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 overflow-hidden"
    style="display: none;"
>
    <!-- Backdrop -->
    <div 
        @click="$store.cart.toggle()"
        class="absolute inset-0 bg-black bg-opacity-50"
    ></div>

    <!-- Sidebar -->
    <div 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="transform translate-x-full"
        x-transition:enter-end="transform translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="transform translate-x-0"
        x-transition:leave-end="transform translate-x-full"
        class="absolute right-0 top-0 h-full w-full max-w-md bg-white shadow-strong flex flex-col"
    >
        <!-- Header -->
        <div class="flex items-center justify-between p-4 border-b border-neutral-200">
            <h3 class="text-lg font-semibold text-neutral-900">Keranjang Belanja</h3>
            <button 
                @click="$store.cart.toggle()"
                class="p-2 text-neutral-400 hover:text-neutral-600 transition-colors"
            >
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Cart Items -->
        <div class="flex-1 overflow-y-auto p-4">
            <div x-show="cart.items.length === 0" class="text-center py-8">
                <svg class="h-16 w-16 text-neutral-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                </svg>
                <p class="text-neutral-500 mb-4">Keranjang Anda kosong</p>
                <a href="{{ route('products.index') }}" class="btn-primary">Mulai Belanja</a>
            </div>

            <div x-show="cart.items.length > 0" class="space-y-4">
                <!-- Cart Item Template -->
                <template x-for="item in cart.items" :key="item.id">
                    <div class="flex items-center space-x-3 p-3 bg-neutral-50 rounded-lg">
                        <img 
                            :src="item.image" 
                            :alt="item.name"
                            class="w-16 h-16 object-cover rounded-lg"
                        >
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-medium text-neutral-900 truncate" x-text="item.name"></h4>
                            <p class="text-sm text-neutral-500" x-text="item.category"></p>
                            <div class="flex items-center justify-between mt-1">
                                <span class="text-sm font-semibold text-primary-600" x-text="'Rp ' + item.price.toLocaleString()"></span>
                                <div class="flex items-center space-x-2">
                                    <button 
                                        @click="cart.update(item.id, item.quantity - 1)"
                                        class="w-6 h-6 rounded-full bg-neutral-200 flex items-center justify-center text-neutral-600 hover:bg-neutral-300 transition-colors"
                                    >
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                        </svg>
                                    </button>
                                    <span class="text-sm font-medium w-8 text-center" x-text="item.quantity"></span>
                                    <button 
                                        @click="cart.update(item.id, item.quantity + 1)"
                                        class="w-6 h-6 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 hover:bg-primary-200 transition-colors"
                                    >
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button 
                            @click="cart.remove(item.id)"
                            class="p-1 text-neutral-400 hover:text-red-600 transition-colors"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </template>
            </div>
        </div>

        <!-- Footer -->
        <div x-show="cart.items.length > 0" class="border-t border-neutral-200 p-4 space-y-4">
            <div class="flex justify-between items-center">
                <span class="text-lg font-semibold text-neutral-900">Total:</span>
                <span class="text-xl font-bold text-primary-600" x-text="'Rp ' + cart.total.toLocaleString()"></span>
            </div>
            <div class="space-y-2">
                <a href="{{ route('cart.index') }}" class="btn-outline w-full text-center block">
                    Lihat Keranjang
                </a>
                <a href="{{ route('checkout.index') }}" class="btn-primary w-full text-center block">
                    Checkout
                </a>
            </div>
        </div>
    </div>
</div>

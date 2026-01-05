@extends('layouts.guest')

@section('title', $product->name . ' - Grosir Berkat Ibu')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-red-500 transition">Home</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <a href="{{ route('products.index') }}" class="hover:text-red-500 transition">Produk</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-gray-800">{{ $product->name }}</span>
        </nav>
        
        <!-- Product Detail Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                <!-- Product Image -->
                <div class="relative bg-gray-100 lg:sticky lg:top-24 lg:self-start">
                    <div class="aspect-square">
                        @if($product->image)
                            <img src="{{ \Illuminate\Support\Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <i class="fas fa-image text-8xl"></i>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Discount Badge -->
                    @if($product->price_bulk_4 && $product->price_bulk_4 < $product->price_unit)
                        @php
                            $discount = round((($product->price_unit - $product->price_bulk_4) / $product->price_unit) * 100);
                        @endphp
                        <div class="absolute top-4 left-4 bg-red-500 text-white text-xl font-bold px-4 py-2 rounded-lg">
                            -{{ $discount }}%
                        </div>
                    @endif
                </div>
                
                <!-- Product Info -->
                <div class="p-8">
                    <!-- Category -->
                    <div class="mb-4">
                        <span class="text-sm bg-red-100 text-red-600 px-3 py-1 rounded-full font-medium">
                            {{ $product->category->name ?? 'Umum' }}
                        </span>
                    </div>
                    
                    <!-- Product Name -->
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">
                        {{ $product->name }}
                    </h1>
                    
                    <!-- Rating -->
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex items-center gap-1">
                            @for($i = 0; $i < 5; $i++)
                                <i class="fas fa-star text-yellow-400"></i>
                            @endfor
                            <span class="ml-2 text-gray-600">5.0</span>
                        </div>
                        <span class="text-gray-300">|</span>
                        <span class="text-gray-600">100+ Terjual</span>
                    </div>
                    
                    <!-- Price Section -->
                    <div class="bg-gradient-to-r from-red-50 to-orange-50 rounded-xl p-6 mb-6">
                        <div class="flex items-end gap-3 mb-4">
                            <span class="text-4xl font-bold text-red-500">
                                Rp {{ number_format($product->price_unit, 0, ',', '.') }}
                            </span>
                            <span class="text-gray-500 text-lg">/pcs</span>
                        </div>
                        
                        <!-- Tiered Pricing -->
                        <div class="space-y-3">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <i class="fas fa-tag text-red-500"></i> Harga Spesial Grosir:
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <!-- Satuan -->
                                <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                                    <p class="text-sm text-gray-500 mb-1">Satuan (1-3 pcs)</p>
                                    <p class="text-lg font-bold text-gray-800">
                                        Rp {{ number_format($product->price_unit, 0, ',', '.') }}
                                    </p>
                                </div>
                                
                                <!-- Grosir -->
                                @if($product->price_bulk_4)
                                <div class="bg-white rounded-lg p-4 border-2 border-orange-300">
                                    <p class="text-sm text-orange-600 mb-1">Grosir (4+ pcs)</p>
                                    <p class="text-lg font-bold text-orange-600">
                                        Rp {{ number_format($product->price_bulk_4, 0, ',', '.') }}
                                    </p>
                                    <p class="text-xs text-green-600 mt-1">
                                        Hemat Rp {{ number_format($product->price_unit - $product->price_bulk_4, 0, ',', '.') }}/pcs
                                    </p>
                                </div>
                                @endif
                                
                                <!-- Per Dus -->
                                @if($product->price_dozen)
                                <div class="bg-white rounded-lg p-4 border-2 border-green-400">
                                    <p class="text-sm text-green-600 mb-1">Per Dus ({{ $product->box_item_count ?? 12 }} pcs)</p>
                                    <p class="text-lg font-bold text-green-600">
                                        Rp {{ number_format($product->price_dozen, 0, ',', '.') }}
                                    </p>
                                    @php
                                        $effectivePrice = $product->price_dozen / ($product->box_item_count ?? 12);
                                    @endphp
                                    <p class="text-xs text-green-600 mt-1">
                                        = Rp {{ number_format($effectivePrice, 0, ',', '.') }}/pcs
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stock -->
                    <div class="mb-6">
                        @if($product->stock > 20)
                            <span class="inline-flex items-center gap-2 text-green-600 bg-green-50 px-4 py-2 rounded-full">
                                <i class="fas fa-check-circle"></i>
                                Stok Tersedia: {{ $product->stock }} pcs
                            </span>
                        @elseif($product->stock > 0)
                            <span class="inline-flex items-center gap-2 text-yellow-600 bg-yellow-50 px-4 py-2 rounded-full">
                                <i class="fas fa-exclamation-circle"></i>
                                Stok Terbatas: {{ $product->stock }} pcs
                            </span>
                        @else
                            <span class="inline-flex items-center gap-2 text-red-600 bg-red-50 px-4 py-2 rounded-full">
                                <i class="fas fa-times-circle"></i>
                                Stok Habis
                            </span>
                        @endif
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-8">
                        <h3 class="font-bold text-gray-800 mb-3">Deskripsi Produk</h3>
                        <p class="text-gray-600 leading-relaxed">
                            {{ $product->description ?? 'Produk berkualitas dengan harga terjangkau. Cocok untuk kebutuhan usaha maupun rumah tangga.' }}
                        </p>
                    </div>
                    
                    <!-- Add to Cart / Login -->
                    @auth
                        @if($product->stock > 0)
                        <form action="{{ route('customer.cart.add', $product) }}" method="POST" class="space-y-4">
                            @csrf
                            <!-- Quantity -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah</label>
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center border rounded-lg overflow-hidden">
                                        <button type="button" onclick="decrementQty()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 transition">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}"
                                               class="w-20 text-center border-0 focus:ring-0">
                                        <button type="button" onclick="incrementQty()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 transition">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    <span class="text-gray-500">/ {{ $product->stock }} tersedia</span>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex gap-3">
                                <button type="submit" class="flex-1 py-4 bg-gradient-to-r from-red-500 to-orange-500 hover:from-red-600 hover:to-orange-600 text-white font-bold rounded-xl transition flex items-center justify-center gap-2 shadow-lg">
                                    <i class="fas fa-cart-plus text-xl"></i>
                                    Tambah ke Keranjang
                                </button>
                                <button type="button" class="w-14 py-4 border-2 border-gray-200 hover:border-red-500 hover:text-red-500 text-gray-400 rounded-xl transition">
                                    <i class="fas fa-heart text-xl"></i>
                                </button>
                            </div>
                        </form>
                        @else
                        <div class="bg-gray-100 rounded-xl p-6 text-center">
                            <i class="fas fa-box-open text-4xl text-gray-400 mb-3"></i>
                            <p class="text-gray-600">Maaf, produk ini sedang tidak tersedia.</p>
                            <a href="{{ route('products.index') }}" class="inline-block mt-4 px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                Lihat Produk Lain
                            </a>
                        </div>
                        @endif
                    @else
                        <div class="bg-gradient-to-r from-red-50 to-orange-50 rounded-xl p-6 text-center">
                            <i class="fas fa-user-lock text-4xl text-red-400 mb-3"></i>
                            <p class="text-gray-700 mb-4">Silakan login atau daftar untuk mulai berbelanja</p>
                            <div class="flex gap-3 justify-center">
                                <a href="{{ route('login') }}" class="px-8 py-3 bg-red-500 hover:bg-red-600 text-white font-bold rounded-full transition">
                                    <i class="fas fa-sign-in-alt mr-2"></i> Login
                                </a>
                                <a href="{{ route('register') }}" class="px-8 py-3 border-2 border-red-500 text-red-500 hover:bg-red-500 hover:text-white font-bold rounded-full transition">
                                    <i class="fas fa-user-plus mr-2"></i> Daftar
                                </a>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
        
        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <i class="fas fa-th-large text-red-500"></i> Produk Serupa
            </h2>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($relatedProducts as $related)
                <a href="{{ route('products.show', $related) }}" class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all group">
                    <div class="aspect-square bg-gray-100 overflow-hidden">
                        @if($related->image)
                            <img src="{{ \Illuminate\Support\Str::startsWith($related->image, 'http') ? $related->image : asset('storage/' . $related->image) }}" 
                                 alt="{{ $related->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <i class="fas fa-image text-3xl"></i>
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-medium text-gray-800 line-clamp-2 text-sm mb-2">{{ $related->name }}</h3>
                        <p class="text-red-500 font-bold">Rp {{ number_format($related->price_unit, 0, ',', '.') }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<script>
function incrementQty() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.max);
    const current = parseInt(input.value);
    if (current < max) {
        input.value = current + 1;
    }
}

function decrementQty() {
    const input = document.getElementById('quantity');
    const current = parseInt(input.value);
    if (current > 1) {
        input.value = current - 1;
    }
}
</script>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection

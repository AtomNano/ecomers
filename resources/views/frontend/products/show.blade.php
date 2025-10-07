@extends('layouts.frontend.app')

@section('title', $product->name . ' - Grosir Berkat Ibu')
@section('description', $product->description ?? 'Produk berkualitas dengan harga terbaik')

@section('content')
<div class="bg-white">
    <div class="container-custom section-padding">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="text-neutral-500 hover:text-primary-600">Beranda</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-neutral-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('products.index') }}" class="ml-1 text-neutral-500 hover:text-primary-600 md:ml-2">Produk</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-neutral-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-neutral-500 md:ml-2">{{ $product->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Product Images -->
            <div>
                <div class="aspect-w-1 aspect-h-1 w-full mb-4">
                    <img 
                        src="{{ $product->image ? asset('storage/products/' . $product->image) : 'https://placehold.co/600x600/f3f4f6/374151?text=Produk' }}" 
                        alt="{{ $product->name }}" 
                        class="w-full h-96 object-center object-cover rounded-xl"
                    >
                </div>
                
                <!-- Additional Images (if any) -->
                <div class="grid grid-cols-4 gap-2">
                    <div class="aspect-w-1 aspect-h-1">
                        <img 
                            src="{{ $product->image ? asset('storage/products/' . $product->image) : 'https://placehold.co/150x150/f3f4f6/374151?text=Produk' }}" 
                            alt="{{ $product->name }}" 
                            class="w-full h-20 object-cover rounded-lg cursor-pointer border-2 border-primary-200"
                        >
                    </div>
                    <!-- Add more images here if needed -->
                </div>
            </div>

            <!-- Product Info -->
            <div>
                <div class="mb-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="badge-primary">{{ $product->category->name ?? 'Kategori' }}</span>
                        @if($product->is_featured)
                        <span class="badge-warning">Unggulan</span>
                        @endif
                    </div>
                    <h1 class="text-3xl font-bold text-neutral-900 mb-2">{{ $product->name }}</h1>
                    <div class="flex items-center text-yellow-400 mb-4">
                        <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                        </svg>
                        <span class="text-sm text-neutral-500 ml-1">4.8 (128 ulasan)</span>
                    </div>
                </div>

                @if($product->description)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-neutral-900 mb-2">Deskripsi Produk</h3>
                    <p class="text-neutral-600 leading-relaxed">{{ $product->description }}</p>
                </div>
                @endif

                <!-- Stock Info -->
                <div class="mb-6">
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-neutral-500">Stok Tersedia:</span>
                        <span class="font-semibold text-green-600">{{ $product->stock }} pcs</span>
                    </div>
                    @if($product->sales_count > 0)
                    <div class="flex items-center space-x-4 mt-1">
                        <span class="text-sm text-neutral-500">Terjual:</span>
                        <span class="font-semibold text-primary-600">{{ $product->sales_count }} pcs</span>
                    </div>
                    @endif
                </div>

                <!-- Price Tiers -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-neutral-900 mb-4">Harga Bertingkat</h3>
                    <div class="price-tier">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-neutral-700">Eceran (1-3 pcs):</span>
                                <span class="text-xl font-bold text-primary-600">Rp {{ number_format($product->price_per_piece) }}</span>
                            </div>
                            @if($product->price_per_four)
                            <div class="flex items-center justify-between">
                                <span class="text-neutral-700">Grosir (4-11 pcs):</span>
                                <span class="text-xl font-bold text-green-600">Rp {{ number_format($product->price_per_four) }}</span>
                            </div>
                            @endif
                            @if($product->price_per_dozen)
                            <div class="flex items-center justify-between">
                                <span class="text-neutral-700">Kartonan (12+ pcs):</span>
                                <span class="text-xl font-bold text-green-600">Rp {{ number_format($product->price_per_dozen) }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quantity & Add to Cart -->
                <div class="mb-8" x-data="productCart({{ $product->id }}, {{ $product->price_per_piece }}, {{ $product->price_per_four ?? 'null' }}, {{ $product->price_per_dozen ?? 'null' }})">
                    <div class="flex items-center space-x-4 mb-4">
                        <label class="text-sm font-medium text-neutral-700">Kuantitas:</label>
                        <div class="flex items-center border border-neutral-300 rounded-lg">
                            <button 
                                @click="decreaseQuantity()"
                                class="px-3 py-2 text-neutral-600 hover:text-primary-600 transition-colors"
                            >
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                </svg>
                            </button>
                            <input 
                                type="number" 
                                x-model="quantity"
                                @input="updatePrice()"
                                min="1" 
                                max="{{ $product->stock }}"
                                class="w-16 text-center border-0 focus:ring-0"
                            >
                            <button 
                                @click="increaseQuantity()"
                                class="px-3 py-2 text-neutral-600 hover:text-primary-600 transition-colors"
                            >
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Dynamic Price Display -->
                    <div class="mb-6">
                        <div class="bg-primary-50 border border-primary-200 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <span class="text-lg font-medium text-neutral-700">Harga per Satuan:</span>
                                <span class="text-2xl font-bold text-primary-600" x-text="'Rp ' + formatPrice(unitPrice)"></span>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-lg font-medium text-neutral-700">Total Harga:</span>
                                <span class="text-2xl font-bold text-primary-600" x-text="'Rp ' + formatPrice(totalPrice)"></span>
                            </div>
                        </div>
                    </div>

                    <div class="flex space-x-4">
                        <button 
                            @click="addToCart()"
                            class="btn-primary flex-1 py-3 text-lg"
                        >
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                            </svg>
                            Tambah ke Keranjang
                        </button>
                        <button class="btn-outline py-3 px-6">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Product Features -->
                <div class="border-t border-neutral-200 pt-6">
                    <h3 class="text-lg font-semibold text-neutral-900 mb-4">Keunggulan Produk</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-center space-x-3">
                            <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm text-neutral-700">Kualitas Terjamin</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm text-neutral-700">Harga Kompetitif</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm text-neutral-700">Pengiriman Cepat</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm text-neutral-700">Garansi Produk</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-neutral-900 mb-8">Produk Terkait</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                <div class="card-hover group">
                    <div class="relative overflow-hidden">
                        <img 
                            src="{{ $relatedProduct->image ? asset('storage/products/' . $relatedProduct->image) : 'https://placehold.co/400x300/f3f4f6/374151?text=Produk' }}" 
                            alt="{{ $relatedProduct->name }}"
                            class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                        >
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-neutral-900 mb-2 line-clamp-2">{{ $relatedProduct->name }}</h3>
                        <div class="space-y-1 mb-4">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-neutral-500">Eceran:</span>
                                <span class="font-semibold text-primary-600">Rp {{ number_format($relatedProduct->price_per_piece) }}</span>
                            </div>
                            @if($relatedProduct->price_per_four)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-neutral-500">4+:</span>
                                <span class="font-semibold text-green-600">Rp {{ number_format($relatedProduct->price_per_four) }}</span>
                            </div>
                            @endif
                        </div>
                        <a href="{{ route('products.show', $relatedProduct->slug) }}" class="btn-primary w-full text-center">
                            Lihat Detail
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<script>
function productCart(productId, pricePerPiece, pricePerFour, pricePerDozen) {
    return {
        productId: productId,
        quantity: 1,
        pricePerPiece: pricePerPiece,
        pricePerFour: pricePerFour,
        pricePerDozen: pricePerDozen,
        unitPrice: pricePerPiece,
        totalPrice: pricePerPiece,

        increaseQuantity() {
            if (this.quantity < {{ $product->stock }}) {
                this.quantity++;
                this.updatePrice();
            }
        },

        decreaseQuantity() {
            if (this.quantity > 1) {
                this.quantity--;
                this.updatePrice();
            }
        },

        updatePrice() {
            // Determine unit price based on quantity
            if (this.quantity >= 12 && this.pricePerDozen) {
                this.unitPrice = this.pricePerDozen;
            } else if (this.quantity >= 4 && this.pricePerFour) {
                this.unitPrice = this.pricePerFour;
            } else {
                this.unitPrice = this.pricePerPiece;
            }

            this.totalPrice = this.unitPrice * this.quantity;
        },

        formatPrice(price) {
            return new Intl.NumberFormat('id-ID').format(price);
        },

        addToCart() {
            // Add to cart logic
            console.log('Adding to cart:', {
                productId: this.productId,
                quantity: this.quantity,
                unitPrice: this.unitPrice,
                totalPrice: this.totalPrice
            });
            
            // Show success message
            alert('Produk berhasil ditambahkan ke keranjang!');
        }
    }
}
</script>
@endsection
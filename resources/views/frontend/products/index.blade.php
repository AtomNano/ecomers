@extends('layouts.frontend.app')

@section('title', 'Katalog Produk - Grosir Berkat Ibu')
@section('description', 'Temukan berbagai produk berkualitas dengan harga terbaik. Sistem harga bertingkat untuk keuntungan maksimal.')

@section('content')
<div class="bg-white">
    <div class="container-custom section-padding">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-neutral-900 mb-4">Katalog Produk</h1>
            <p class="text-lg text-neutral-600">Temukan produk berkualitas dengan harga terbaik</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <div class="lg:w-64 flex-shrink-0">
                <div class="card p-6 sticky top-24">
                    <h3 class="text-lg font-semibold text-neutral-900 mb-4">Filter Produk</h3>
                    
                    <!-- Search -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-neutral-700 mb-2">Cari Produk</label>
                        <form method="GET" action="{{ route('products.index') }}">
                            <input 
                                type="text" 
                                name="q" 
                                value="{{ request('q') }}"
                                placeholder="Nama produk..."
                                class="input-field"
                            >
                        </form>
                    </div>

                    <!-- Category Filter -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-neutral-700 mb-2">Kategori</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input 
                                    type="radio" 
                                    name="category" 
                                    value="" 
                                    {{ !request('category') ? 'checked' : '' }}
                                    class="text-primary-600 focus:ring-primary-500"
                                    onchange="this.form.submit()"
                                >
                                <span class="ml-2 text-sm text-neutral-700">Semua Kategori</span>
                            </label>
                            @foreach($categories as $category)
                            <label class="flex items-center">
                                <input 
                                    type="radio" 
                                    name="category" 
                                    value="{{ $category->slug }}" 
                                    {{ request('category') == $category->slug ? 'checked' : '' }}
                                    class="text-primary-600 focus:ring-primary-500"
                                    onchange="this.form.submit()"
                                >
                                <span class="ml-2 text-sm text-neutral-700">{{ $category->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-neutral-700 mb-2">Rentang Harga</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input 
                                    type="radio" 
                                    name="price" 
                                    value="" 
                                    {{ !request('price') ? 'checked' : '' }}
                                    class="text-primary-600 focus:ring-primary-500"
                                    onchange="this.form.submit()"
                                >
                                <span class="ml-2 text-sm text-neutral-700">Semua Harga</span>
                            </label>
                            <label class="flex items-center">
                                <input 
                                    type="radio" 
                                    name="price" 
                                    value="0-10000" 
                                    {{ request('price') == '0-10000' ? 'checked' : '' }}
                                    class="text-primary-600 focus:ring-primary-500"
                                    onchange="this.form.submit()"
                                >
                                <span class="ml-2 text-sm text-neutral-700">Rp 0 - 10.000</span>
                            </label>
                            <label class="flex items-center">
                                <input 
                                    type="radio" 
                                    name="price" 
                                    value="10000-50000" 
                                    {{ request('price') == '10000-50000' ? 'checked' : '' }}
                                    class="text-primary-600 focus:ring-primary-500"
                                    onchange="this.form.submit()"
                                >
                                <span class="ml-2 text-sm text-neutral-700">Rp 10.000 - 50.000</span>
                            </label>
                            <label class="flex items-center">
                                <input 
                                    type="radio" 
                                    name="price" 
                                    value="50000-100000" 
                                    {{ request('price') == '50000-100000' ? 'checked' : '' }}
                                    class="text-primary-600 focus:ring-primary-500"
                                    onchange="this.form.submit()"
                                >
                                <span class="ml-2 text-sm text-neutral-700">Rp 50.000 - 100.000</span>
                            </label>
                            <label class="flex items-center">
                                <input 
                                    type="radio" 
                                    name="price" 
                                    value="100000+" 
                                    {{ request('price') == '100000+' ? 'checked' : '' }}
                                    class="text-primary-600 focus:ring-primary-500"
                                    onchange="this.form.submit()"
                                >
                                <span class="ml-2 text-sm text-neutral-700">Rp 100.000+</span>
                            </label>
                        </div>
                    </div>

                    <!-- Stock Filter -->
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                name="in_stock" 
                                value="1" 
                                {{ request('in_stock') ? 'checked' : '' }}
                                class="text-primary-600 focus:ring-primary-500"
                                onchange="this.form.submit()"
                            >
                            <span class="ml-2 text-sm text-neutral-700">Tersedia Stok</span>
                        </label>
                    </div>

                    <!-- Clear Filters -->
                    <a href="{{ route('products.index') }}" class="btn-outline w-full text-center">
                        Hapus Filter
                    </a>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="flex-1">
                <!-- Sort & Results -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                    <div class="text-sm text-neutral-600">
                        Menampilkan {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} dari {{ $products->total() }} produk
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <label class="text-sm text-neutral-700">Urutkan:</label>
                        <select 
                            name="sort" 
                            class="input-field w-48"
                            onchange="this.form.submit()"
                        >
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="bestseller" {{ request('sort') == 'bestseller' ? 'selected' : '' }}>Terlaris</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama A-Z</option>
                        </select>
                    </div>
                </div>

                <!-- Products Grid -->
                @if($products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                    <div class="card-hover group">
                        <div class="relative overflow-hidden">
                            <img 
                                src="{{ $product->image ? asset('storage/products/' . $product->image) : 'https://placehold.co/400x300/f3f4f6/374151?text=Produk' }}" 
                                alt="{{ $product->name }}"
                                class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                            >
                            @if($product->is_featured)
                            <div class="absolute top-3 left-3">
                                <span class="badge-primary">Unggulan</span>
                            </div>
                            @endif
                            @if($product->sales_count > 0)
                            <div class="absolute top-3 right-3">
                                <span class="badge-warning">Terlaris</span>
                            </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-neutral-500">{{ $product->category->name ?? 'Kategori' }}</span>
                                <div class="flex items-center text-yellow-400">
                                    <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                    <span class="text-sm text-neutral-500 ml-1">4.8</span>
                                </div>
                            </div>
                            <h3 class="font-semibold text-neutral-900 mb-2 line-clamp-2">{{ $product->name }}</h3>
                            
                            <!-- Price Tiers -->
                            <div class="space-y-1 mb-4">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-neutral-500">Eceran:</span>
                                    <span class="font-semibold text-primary-600">Rp {{ number_format($product->price_per_piece) }}</span>
                                </div>
                                @if($product->price_per_four)
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-neutral-500">4+:</span>
                                    <span class="font-semibold text-green-600">Rp {{ number_format($product->price_per_four) }}</span>
                                </div>
                                @endif
                                @if($product->price_per_dozen)
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-neutral-500">Lusin:</span>
                                    <span class="font-semibold text-green-600">Rp {{ number_format($product->price_per_dozen) }}</span>
                                </div>
                                @endif
                            </div>

                            <div class="flex items-center justify-between mb-4">
                                <span class="text-sm text-neutral-500">Stok: {{ $product->stock }}</span>
                                @if($product->sales_count > 0)
                                <span class="text-sm text-neutral-500">Terjual: {{ $product->sales_count }}</span>
                                @endif
                            </div>

                            <a href="{{ route('products.show', $product->slug) }}" class="btn-primary w-full text-center">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->appends(request()->query())->links() }}
                </div>
                    @else
                <div class="text-center py-12">
                    <svg class="h-16 w-16 text-neutral-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-neutral-900 mb-2">Tidak ada produk ditemukan</h3>
                    <p class="text-neutral-600 mb-6">Coba ubah filter atau kata kunci pencarian Anda</p>
                    <a href="{{ route('products.index') }}" class="btn-primary">
                        Lihat Semua Produk
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
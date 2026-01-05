@extends('layouts.guest')

@section('title', 'Semua Produk - Grosir Berkat Ibu')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-red-500 via-orange-500 to-yellow-500 py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-white">
                    <h1 class="text-3xl md:text-4xl font-bold">Semua Produk</h1>
                    <p class="text-white/80 mt-1">{{ $products->total() }} produk tersedia</p>
                </div>
                
                <!-- Search Bar removed as requested -->
            </div>
        </div>
    </div>
    
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <div class="lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-2xl shadow-md p-6 sticky top-24">
                    <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-filter text-red-500"></i> Filter
                    </h3>
                    
                    <form method="GET" action="{{ route('products.index') }}" id="filterForm">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        
                        <!-- Categories -->
                        <div class="mb-6">
                            <p class="text-sm font-bold text-gray-800 mb-3 uppercase tracking-wider">Kategori</p>
                            @php
                                $icons = [
                                    'sayur' => 'fas fa-carrot text-orange-500',
                                    'buah' => 'fas fa-apple-alt text-red-500',
                                    'bumbu' => 'fas fa-mortar-pestle text-stone-500',
                                    'beras' => 'fas fa-seedling text-green-600',
                                    'gandum' => 'fas fa-wheat text-yellow-600',
                                    'minyak' => 'fas fa-bottle-droplet text-yellow-500',
                                    'susu' => 'fas fa-glass-water text-blue-400', 
                                    'kaleng' => 'fas fa-box text-gray-500',
                                    'daging' => 'fas fa-drumstick-bite text-amber-700',
                                    'ikan' => 'fas fa-fish text-blue-500',
                                    'snack' => 'fas fa-cookie text-amber-500',
                                    'minuman' => 'fas fa-coffee text-amber-800',
                                ];
                                
                                function getCategoryIcon($name, $icons) {
                                    $lowerName = strtolower($name);
                                    foreach($icons as $key => $icon) {
                                        if(str_contains($lowerName, $key)) return $icon;
                                    }
                                    return 'fas fa-tags text-gray-400';
                                }
                            @endphp

                            <div class="space-y-1">
                                <!-- All Categories -->
                                <label class="flex items-center gap-3 p-2 rounded-lg cursor-pointer transition-all duration-200
                                              {{ !request('category') ? 'bg-red-50 border-l-4 border-red-500' : 'hover:bg-gray-50 border-l-4 border-transparent' }}">
                                    <input type="radio" name="category" value="" 
                                           {{ !request('category') ? 'checked' : '' }}
                                           onchange="this.form.submit()"
                                           class="hidden">
                                    <div class="w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center border border-gray-100">
                                        <i class="fas fa-th-large text-red-500"></i>
                                    </div>
                                    <span class="text-sm font-medium {{ !request('category') ? 'text-red-700' : 'text-gray-600' }}">
                                        Semua Kategori
                                    </span>
                                </label>

                                @foreach($categories as $category)
                                <label class="flex items-center gap-3 p-2 rounded-lg cursor-pointer transition-all duration-200
                                              {{ request('category') == $category->id ? 'bg-red-50 border-l-4 border-red-500' : 'hover:bg-gray-50 border-l-4 border-transparent' }}">
                                    <input type="radio" name="category" value="{{ $category->id }}" 
                                           {{ request('category') == $category->id ? 'checked' : '' }}
                                           onchange="this.form.submit()"
                                           class="hidden">
                                    <div class="w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center border border-gray-100">
                                        <i class="{{ getCategoryIcon($category->name, $icons) }}"></i>
                                    </div>
                                    <span class="text-sm font-medium {{ request('category') == $category->id ? 'text-red-700' : 'text-gray-600' }}">
                                        {{ $category->name }}
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Sort (Divider) -->
                        <div class="border-t border-gray-100 my-4"></div>
                        <div class="mb-6">
                            <p class="text-sm font-medium text-gray-700 mb-3">Urutkan</p>
                            <select name="sort" onchange="this.form.submit()" 
                                    class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:border-red-500 focus:ring-1 focus:ring-red-500 focus:outline-none">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                            </select>
                        </div>
                        
                        <!-- Stock Filter -->
                        <div class="mb-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="in_stock" value="1"
                                       {{ request('in_stock') ? 'checked' : '' }}
                                       onchange="this.form.submit()"
                                       class="w-4 h-4 text-red-500 border-gray-300 rounded focus:ring-red-500">
                                <span class="text-gray-600">Stok Tersedia</span>
                            </label>
                        </div>
                        
                        @if(request()->hasAny(['category', 'sort', 'search', 'in_stock']))
                        <a href="{{ route('products.index') }}" 
                           class="block text-center w-full py-2 text-red-500 border border-red-500 rounded-lg hover:bg-red-50 transition text-sm">
                            <i class="fas fa-redo mr-1"></i> Reset Filter
                        </a>
                        @endif
                    </form>
                </div>
            </div>
            
            <!-- Products Grid -->
            <div class="flex-1">
                @if($products->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($products as $product)
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group border border-gray-100">
                        <!-- Product Image -->
                        <a href="{{ route('products.show', $product) }}" class="block">
                            <div class="relative aspect-square overflow-hidden bg-gray-100">
                                @if($product->image)
                                    <img src="{{ \Illuminate\Support\Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <i class="fas fa-image text-4xl"></i>
                                    </div>
                                @endif
                                
                                <!-- Discount Badge -->
                                @if($product->price_bulk_4 && $product->price_bulk_4 < $product->price_unit)
                                    @php
                                        $discount = round((($product->price_unit - $product->price_bulk_4) / $product->price_unit) * 100);
                                    @endphp
                                    <div class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                        -{{ $discount }}%
                                    </div>
                                @endif
                                
                                <!-- Stock Badge -->
                                @if($product->stock == 0)
                                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                            Habis
                                        </span>
                                    </div>
                                @elseif($product->stock <= 10)
                                    <div class="absolute top-2 right-2 bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded">
                                        Sisa {{ $product->stock }}
                                    </div>
                                @endif
                            </div>
                        </a>
                        
                        <!-- Product Info -->
                        <div class="p-4">
                            <!-- Category -->
                            <p class="text-xs text-gray-500 mb-1">{{ $product->category->name ?? 'Umum' }}</p>
                            
                            <!-- Product Name -->
                            <h3 class="font-medium text-gray-800 line-clamp-2 min-h-[40px] mb-2 hover:text-red-500 transition">
                                <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                            </h3>
                            
                            <!-- Price -->
                            <div class="mb-3">
                                <p class="text-red-500 font-bold text-lg">
                                    Rp {{ number_format($product->price_unit, 0, ',', '.') }}
                                </p>
                                @if($product->price_dozen)
                                <p class="text-xs text-green-600 mt-1">
                                    <i class="fas fa-tag"></i> Grosir: Rp {{ number_format($product->price_dozen, 0, ',', '.') }}/dus
                                </p>
                                @endif
                            </div>
                            
                            <!-- Rating & Sold -->
                            <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                                <div class="flex items-center gap-1">
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <span>5.0</span>
                                </div>
                                <span>Stok: {{ $product->stock }}</span>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex gap-2">
                                <a href="{{ route('products.show', $product) }}" 
                                   class="flex-1 py-2 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                @auth
                                    @if($product->stock > 0)
                                    <form action="{{ route('customer.cart.add', $product) }}" method="POST" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="w-full py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    </form>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="flex-1 py-2 text-center bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition">
                                        <i class="fas fa-shopping-cart"></i> Beli
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if($products->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $products->withQueryString()->links() }}
                </div>
                @endif
                @else
                <!-- Empty State -->
                <div class="bg-white rounded-2xl shadow-md p-12 text-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-box-open text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Produk Tidak Ditemukan</h3>
                    <p class="text-gray-600 mb-6">Maaf, tidak ada produk yang sesuai dengan filter Anda.</p>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-red-500 hover:bg-red-600 text-white font-medium rounded-full transition">
                        <i class="fas fa-redo"></i> Lihat Semua Produk
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection

@extends('layouts.app')

@section('title', 'Daftar Produk - Grosir Berkat Ibu')

@section('content')
<div x-data="{ mobileFilterOpen: false }" class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <!-- Filter Sidebar -->
    <div class="lg:col-span-1">
        <!-- Mobile Filter Toggle -->
        <div class="lg:hidden mb-4">
            <button @click="mobileFilterOpen = !mobileFilterOpen" class="w-full bg-emerald-600 text-white py-3 rounded-lg font-semibold flex items-center justify-center gap-2">
                <i class="fas fa-filter"></i> 
                <span x-text="mobileFilterOpen ? 'Tutup Filter' : 'Buka Filter'"></span>
            </button>
        </div>

        <!-- Filter Card -->
        <div v-show="mobileFilterOpen || window.innerWidth >= 1024" class="lg:block bg-white rounded-xl shadow-md p-6 sticky top-24 max-h-[calc(100vh-150px)] overflow-y-auto">
            <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                <i class="fas fa-sliders-h text-emerald-600"></i> Filter Produk
            </h2>
            
            <form method="GET" action="{{ route('customer.products.index') }}" class="space-y-6">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Cari Produk</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama produk..." 
                            class="w-full border-2 border-gray-200 rounded-lg px-4 py-2 focus:border-emerald-500 focus:outline-none transition">
                        <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                    </div>
                </div>
                
                <!-- Category -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">Kategori</label>
                    <div class="space-y-2">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="category" value="" {{ request('category') == '' ? 'checked' : '' }} class="w-4 h-4">
                            <span class="text-gray-700">Semua Kategori</span>
                        </label>
                        @foreach(\App\Models\Category::all() as $category)
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio" name="category" value="{{ $category->id }}" {{ request('category') == $category->id ? 'checked' : '' }} class="w-4 h-4">
                                <span class="text-gray-700">{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                
                <!-- Sort -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Urutkan</label>
                    <select name="sort" class="w-full border-2 border-gray-200 rounded-lg px-3 py-2 focus:border-emerald-500 focus:outline-none transition">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Paling Populer</option>
                    </select>
                </div>

                <!-- Price Range -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Harga Maksimal</label>
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Rp 0" 
                        class="w-full border-2 border-gray-200 rounded-lg px-4 py-2 focus:border-emerald-500 focus:outline-none transition">
                </div>
                
                <!-- Stock Status -->
                <div>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="in_stock" {{ request('in_stock') ? 'checked' : '' }} class="w-4 h-4">
                        <span class="text-gray-700 font-medium">Hanya Stok Tersedia</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 text-white py-3 rounded-lg hover:shadow-lg transition font-semibold">
                    <i class="fas fa-filter"></i> Terapkan Filter
                </button>
                
                @if(request()->has('search') || request()->has('category') || request()->has('max_price') || request()->has('sort') || request()->has('in_stock'))
                    <a href="{{ route('customer.products.index') }}" class="w-full bg-gray-200 text-gray-800 py-3 rounded-lg hover:bg-gray-300 transition font-semibold text-center">
                        <i class="fas fa-redo"></i> Reset Filter
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="lg:col-span-3">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">
                <i class="fas fa-box text-emerald-600"></i> Daftar Produk
            </h1>
            <p class="text-gray-600">{{ $products->total() }} produk tersedia</p>
        </div>
        
        @if($products->count())
            <!-- Products Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($products as $product)
                    <div class="group bg-white rounded-xl overflow-hidden shadow-md hover:shadow-2xl transition transform hover:scale-105">
                        <!-- Product Image -->
                        <div class="relative bg-gradient-to-br from-gray-100 to-gray-200 h-64 overflow-hidden">
                            @if($product->image)
                                <img src="{{ \Illuminate\Support\Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                                    class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <i class="fas fa-image text-5xl"></i>
                                </div>
                            @endif
                            
                            <!-- Badge -->
                            @if($product->stock > 0 && $product->stock <= 10)
                                <div class="absolute top-4 left-4">
                                    <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-bold animate-pulse">
                                        ⚠️ Terbatas
                                    </span>
                                </div>
                            @elseif($product->stock == 0)
                                <div class="absolute top-4 left-4">
                                    <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                        ❌ Habis
                                    </span>
                                </div>
                            @endif

                            <!-- Category Badge -->
                            <div class="absolute top-4 right-4">
                                <span class="bg-emerald-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $product->category->name ?? 'Umum' }}
                                </span>
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2 group-hover:text-emerald-600 transition">
                                {{ $product->name }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $product->description }}</p>

                            <!-- Pricing -->
                            <div class="mb-4 bg-gradient-to-r from-emerald-50 to-teal-50 p-3 rounded-lg">
                                <div class="flex items-baseline gap-2 mb-1">
                                    <span class="text-2xl font-bold text-emerald-600">
                                        Rp {{ number_format($product->price_unit, 0, ',', '.') }}
                                    </span>
                                    <span class="text-xs text-gray-600">/pcs</span>
                                </div>
                                <p class="text-xs text-emerald-700 font-medium">
                                    💰 Hemat untuk {{ $product->box_item_count ?? 12 }}+ pcs
                                </p>
                            </div>

                            <!-- Stock -->
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Stok: <strong>{{ $product->stock }}</strong> pcs</p>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-emerald-500 to-teal-500 h-2 rounded-full" style="width: {{ min(($product->stock / 100) * 100, 100) }}%"></div>
                                </div>
                            </div>

                            <!-- Action Button -->
                            @if($product->stock > 0)
                                <form action="{{ route('customer.cart.add', $product) }}" method="POST" class="w-full">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <div class="flex gap-2">
                                        <button type="submit" class="flex-1 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-bold py-3 rounded-lg transition transform hover:scale-105 flex items-center justify-center gap-2">
                                            <i class="fas fa-cart-plus"></i> Keranjang
                                        </button>
                                        <a href="{{ route('customer.products.show', $product) }}" class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 font-bold py-3 rounded-lg transition flex items-center justify-center gap-2">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                    </div>
                                </form>
                            @else
                                <button disabled class="w-full bg-gray-300 text-gray-500 font-bold py-3 rounded-lg cursor-not-allowed">
                                    Stok Habis
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="flex justify-center mt-12">
                    {{ $products->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-md p-12 text-center">
                <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Produk Tidak Ditemukan</h3>
                <p class="text-gray-600 mb-6">Maaf, kami tidak menemukan produk yang sesuai dengan kriteria Anda.</p>
                <a href="{{ route('customer.products.index') }}" class="inline-block px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg transition">
                    <i class="fas fa-redo"></i> Lihat Semua Produk
                </a>
            </div>
        @endif
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

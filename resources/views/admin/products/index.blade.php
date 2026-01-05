@extends('layouts.admin-layout')

@section('title', 'Kelola Produk - Admin')
@section('breadcrumb', 'Produk')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Kelola Produk</h1>
            <p class="text-gray-500 text-sm mt-1">{{ $products->total() }} produk ditemukan</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-6 py-3 rounded-xl hover:from-emerald-600 hover:to-teal-700 transition shadow-lg hover:shadow-xl font-medium">
            <i class="fas fa-plus"></i>
            Tambah Produk
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
        <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-col lg:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari produk..." 
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>
            
            <!-- Category Filter -->
            <div class="w-full lg:w-48">
                <select name="category" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent bg-white">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Stock Filter -->
            <div class="w-full lg:w-48">
                <select name="stock" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent bg-white">
                    <option value="">Semua Stok</option>
                    <option value="low" {{ request('stock') == 'low' ? 'selected' : '' }}>🔴 Stok Rendah (≤10)</option>
                    <option value="medium" {{ request('stock') == 'medium' ? 'selected' : '' }}>🟡 Stok Sedang (11-50)</option>
                    <option value="high" {{ request('stock') == 'high' ? 'selected' : '' }}>🟢 Stok Banyak (>50)</option>
                </select>
            </div>
            
            <!-- Filter Actions -->
            <div class="flex gap-2">
                <button type="submit" class="px-6 py-3 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition font-medium">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
                @if(request()->hasAny(['search', 'category', 'stock']))
                <a href="{{ route('admin.products.index') }}" class="px-4 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition">
                    <i class="fas fa-times"></i>
                </a>
                @endif
            </div>
        </form>
    </div>

    @if($products->count() > 0)
    <!-- Products Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
        @foreach($products as $product)
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
            <!-- Product Image -->
            <div class="relative h-40 lg:h-48 overflow-hidden bg-gray-100">
                @if($product->image)
                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                @else
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                    <i class="fas fa-box text-4xl text-gray-300"></i>
                </div>
                @endif
                
                <!-- Stock Badge -->
                <div class="absolute top-2 right-2">
                    <span class="px-2 py-1 rounded-full text-xs font-bold shadow
                        @if($product->stock <= 10) bg-red-500 text-white
                        @elseif($product->stock <= 50) bg-amber-500 text-white
                        @else bg-emerald-500 text-white
                        @endif">
                        {{ $product->stock }} stok
                    </span>
                </div>
                
                <!-- Category Badge -->
                <div class="absolute top-2 left-2">
                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-white/90 text-gray-700 shadow">
                        {{ $product->category->name }}
                    </span>
                </div>
            </div>
            
            <!-- Product Info -->
            <div class="p-4">
                <h3 class="font-bold text-gray-800 text-sm lg:text-base line-clamp-2 mb-2 min-h-[2.5rem]">
                    {{ $product->name }}
                </h3>
                <p class="text-emerald-600 font-bold text-lg mb-3">
                    Rp {{ number_format($product->price_unit, 0, ',', '.') }}
                    <span class="text-xs text-gray-400 font-normal">/{{ $product->unit ?? 'pcs' }}</span>
                </p>
                
                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <a href="{{ route('admin.products.show', $product) }}" 
                       class="flex-1 py-2 text-center bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition text-sm font-medium">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('admin.products.edit', $product) }}" 
                       class="flex-1 py-2 text-center bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition text-sm font-medium">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Hapus produk ini?')"
                                class="w-full py-2 text-center bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition text-sm font-medium">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
        {{ $products->links() }}
    </div>
    @else
    <!-- Empty State -->
    <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-box-open text-gray-400 text-3xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Tidak ada produk</h3>
        <p class="text-gray-500 mb-6">
            @if(request()->hasAny(['search', 'category', 'stock']))
                Tidak ada produk yang sesuai dengan filter Anda.
            @else
                Belum ada produk yang ditambahkan.
            @endif
        </p>
        @if(request()->hasAny(['search', 'category', 'stock']))
        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-2 bg-gray-200 text-gray-700 px-6 py-3 rounded-xl hover:bg-gray-300 transition font-medium">
            <i class="fas fa-times"></i>
            Reset Filter
        </a>
        @else
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-6 py-3 rounded-xl hover:from-emerald-600 hover:to-teal-700 transition shadow font-medium">
            <i class="fas fa-plus"></i>
            Tambah Produk Pertama
        </a>
        @endif
    </div>
    @endif
</div>
@endsection

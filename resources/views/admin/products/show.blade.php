@extends('layouts.admin-layout')

@section('title', 'Detail Produk - ' . $product->name)
@section('breadcrumb', 'Detail Produk')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-emerald-600 transition">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div class="flex-1">
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">{{ $product->name }}</h1>
            <div class="flex items-center gap-2 mt-1">
                <span class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">
                    <i class="fas fa-folder"></i> {{ $product->category->name }}
                </span>
                @if($product->is_featured)
                <span class="inline-flex items-center gap-1 bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-medium">
                    <i class="fas fa-star"></i> Unggulan
                </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content - Two Column -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Product Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Image + Basic Info Card -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
                    <!-- Image -->
                    <div class="relative bg-gray-100">
                        @if($product->image)
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" 
                             class="w-full h-64 md:h-full object-cover">
                        @else
                        <div class="w-full h-64 md:h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                            <i class="fas fa-image text-5xl text-gray-300"></i>
                        </div>
                        @endif
                        <!-- Stock Badge -->
                        <div class="absolute bottom-3 left-3">
                            <span class="px-3 py-2 rounded-xl text-sm font-bold shadow-lg
                                @if($product->stock <= 10) bg-red-500 text-white
                                @elseif($product->stock <= 50) bg-amber-500 text-white
                                @else bg-emerald-500 text-white
                                @endif">
                                <i class="fas fa-boxes mr-1"></i> {{ $product->stock }} stok
                            </span>
                        </div>
                    </div>
                    
                    <!-- Basic Info -->
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Harga Bertingkat</h3>
                        
                        <!-- Pricing Table -->
                        <div class="space-y-3">
                            <!-- Unit Price -->
                            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-xl">
                                <div>
                                    <p class="text-xs text-blue-600 font-semibold">SATUAN</p>
                                    <p class="text-sm text-gray-500">1 {{ $product->unit ?? 'pcs' }}</p>
                                </div>
                                <p class="text-xl font-bold text-blue-600">
                                    Rp {{ number_format($product->price_unit, 0, ',', '.') }}
                                </p>
                            </div>
                            
                            <!-- Bulk Price -->
                            <div class="flex items-center justify-between p-3 bg-amber-50 rounded-xl">
                                <div>
                                    <p class="text-xs text-amber-600 font-semibold">GROSIR ({{ $product->bulk_min_qty ?? 4 }}+)</p>
                                    <p class="text-sm text-gray-500">Min. {{ $product->bulk_min_qty ?? 4 }} pcs</p>
                                </div>
                                @if($product->price_bulk_4)
                                <div class="text-right">
                                    <p class="text-xl font-bold text-amber-600">
                                        Rp {{ number_format($product->price_bulk_4, 0, ',', '.') }}
                                    </p>
                                    @if($product->price_bulk_4 < $product->price_unit)
                                    <p class="text-xs text-emerald-600">
                                        -Rp {{ number_format($product->price_unit - $product->price_bulk_4, 0, ',', '.') }}
                                    </p>
                                    @endif
                                </div>
                                @else
                                <p class="text-gray-400">-</p>
                                @endif
                            </div>
                            
                            <!-- Dozen Price -->
                            <div class="flex items-center justify-between p-3 bg-emerald-50 rounded-xl">
                                <div>
                                    <p class="text-xs text-emerald-600 font-semibold">LUSIN/DUS</p>
                                    <p class="text-sm text-gray-500">Min. {{ $product->box_item_count ?? 12 }} pcs</p>
                                </div>
                                @if($product->price_dozen)
                                <div class="text-right">
                                    <p class="text-xl font-bold text-emerald-600">
                                        Rp {{ number_format($product->price_dozen, 0, ',', '.') }}
                                    </p>
                                    @if($product->price_dozen < $product->price_unit)
                                    <p class="text-xs text-emerald-600">
                                        -Rp {{ number_format($product->price_unit - $product->price_dozen, 0, ',', '.') }}
                                    </p>
                                    @endif
                                </div>
                                @else
                                <p class="text-gray-400">-</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <i class="fas fa-align-left text-emerald-500"></i> Deskripsi
                </h3>
                <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
            </div>

            <!-- Additional Info -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl shadow p-4 text-center">
                    <p class="text-xs text-gray-500 mb-1">Satuan</p>
                    <p class="font-bold text-gray-800">{{ $product->unit ?? 'pcs' }}</p>
                </div>
                <div class="bg-white rounded-xl shadow p-4 text-center">
                    <p class="text-xs text-gray-500 mb-1">Per Dus</p>
                    <p class="font-bold text-gray-800">{{ $product->box_item_count ?? 12 }} pcs</p>
                </div>
                <div class="bg-white rounded-xl shadow p-4 text-center">
                    <p class="text-xs text-gray-500 mb-1">Dibuat</p>
                    <p class="font-bold text-gray-800">{{ $product->created_at->format('d/m/Y') }}</p>
                </div>
                <div class="bg-white rounded-xl shadow p-4 text-center">
                    <p class="text-xs text-gray-500 mb-1">Diupdate</p>
                    <p class="font-bold text-gray-800">{{ $product->updated_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Right Column: Quick Actions (Sticky) -->
        <div class="lg:col-span-1">
            <div class="sticky top-24 space-y-4">
                <!-- Action Card -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-bolt text-amber-500"></i> Aksi Cepat
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.products.edit', $product) }}" 
                           class="flex items-center justify-center gap-2 w-full py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:from-blue-600 hover:to-blue-700 transition shadow-md hover:shadow-lg font-medium">
                            <i class="fas fa-edit"></i> Edit Produk
                        </a>
                        <a href="{{ route('admin.products.create') }}" 
                           class="flex items-center justify-center gap-2 w-full py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl hover:from-emerald-600 hover:to-teal-700 transition shadow-md hover:shadow-lg font-medium">
                            <i class="fas fa-plus"></i> Tambah Produk Baru
                        </a>
                        <a href="{{ route('admin.products.index') }}" 
                           class="flex items-center justify-center gap-2 w-full py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition font-medium">
                            <i class="fas fa-list"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>

                <!-- Stock Status Card -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-warehouse text-purple-500"></i> Status Stok
                    </h3>
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full mb-3
                            @if($product->stock <= 10) bg-red-100
                            @elseif($product->stock <= 50) bg-amber-100
                            @else bg-emerald-100
                            @endif">
                            <span class="text-3xl font-bold
                                @if($product->stock <= 10) text-red-600
                                @elseif($product->stock <= 50) text-amber-600
                                @else text-emerald-600
                                @endif">
                                {{ $product->stock }}
                            </span>
                        </div>
                        <p class="text-sm font-medium
                            @if($product->stock <= 10) text-red-600
                            @elseif($product->stock <= 50) text-amber-600
                            @else text-emerald-600
                            @endif">
                            @if($product->stock <= 10)
                                <i class="fas fa-exclamation-triangle"></i> Stok Rendah!
                            @elseif($product->stock <= 50)
                                <i class="fas fa-info-circle"></i> Stok Sedang
                            @else
                                <i class="fas fa-check-circle"></i> Stok Aman
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-red-100">
                    <h3 class="text-lg font-bold text-red-600 mb-4 flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle"></i> Zona Berbahaya
                    </h3>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.')"
                                class="flex items-center justify-center gap-2 w-full py-3 bg-red-100 text-red-600 rounded-xl hover:bg-red-200 transition font-medium border border-red-200">
                            <i class="fas fa-trash"></i> Hapus Produk
                        </button>
                    </form>
                    <p class="text-xs text-gray-500 mt-2 text-center">Produk yang sudah pernah diorder tidak dapat dihapus</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

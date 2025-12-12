@extends('layouts.admin.app')

@section('title', 'Detail Produk - ' . $product->name)

@section('content')
<div class="flex flex-col gap-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-neutral-900">Detail Produk</h1>
            <p class="text-neutral-600 mt-1">Informasi lengkap dan pengaturan untuk produk <span class="font-semibold">{{ $product->name }}</span>.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Produk
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 flex flex-col gap-8">
            <!-- Product Information -->
            <div class="card p-6">
                <div class="flex flex-col sm:flex-row items-start justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-neutral-900">{{ $product->name }}</h2>
                        <p class="text-neutral-600">{{ $product->category->name ?? 'Tanpa Kategori' }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        @if($product->is_featured)
                            <span class="badge badge-primary">Unggulan</span>
                        @endif
                        <span class="badge {{ $product->stock > 0 ? 'badge-success' : 'badge-danger' }}">
                            {{ $product->stock > 0 ? 'Aktif' : 'Habis' }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="w-full h-80 bg-neutral-100 rounded-lg flex items-center justify-center">
                        <img 
                            src="{{ $product->image ? asset('storage/products/' . $product->image) : 'https://placehold.co/600x600/f3f4f6/374151?text=Gambar+Produk' }}" 
                            alt="{{ $product->name }}"
                            class="w-full h-full object-cover rounded-lg"
                        >
                    </div>
                    
                    <div class="flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-neutral-800">Deskripsi</h3>
                            <p class="text-neutral-700 mt-1">{{ $product->description ?: 'Tidak ada deskripsi.' }}</p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <h3 class="text-sm font-medium text-neutral-500">Stok</h3>
                                <p class="text-2xl font-bold text-neutral-900">{{ $product->stock }} <span class="text-base font-normal">pcs</span></p>
                                @if($product->stock < 5 && $product->stock > 0)
                                    <p class="text-xs text-yellow-600 mt-1">Stok hampir habis</p>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-neutral-500">Terjual</h3>
                                <p class="text-2xl font-bold text-neutral-900">{{ $product->sales_count }} <span class="text-base font-normal">pcs</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing Information -->
            <div class="card p-6">
                <h3 class="text-xl font-semibold text-neutral-900 mb-4">Informasi Harga</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <!-- Basic Pricing -->
                    <div class="bg-neutral-50 border border-neutral-200 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-neutral-600 mb-1">Harga Eceran (1-3 pcs)</h4>
                        <p class="text-2xl font-bold text-neutral-900">Rp {{ number_format($product->price_per_piece, 0, ',', '.') }}</p>
                    </div>
                    
                    @if($product->price_per_four)
                    <div class="bg-neutral-50 border border-neutral-200 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-neutral-600 mb-1">Harga 4+ (4-11 pcs)</h4>
                        <p class="text-2xl font-bold text-neutral-900">Rp {{ number_format($product->price_per_four, 0, ',', '.') }}</p>
                    </div>
                    @endif
                    
                    @if($product->price_per_dozen)
                    <div class="bg-neutral-50 border border-neutral-200 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-neutral-600 mb-1">Harga Lusin (12+ pcs)</h4>
                        <p class="text-2xl font-bold text-neutral-900">Rp {{ number_format($product->price_per_dozen, 0, ',', '.') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Sales Analytics -->
            <div class="card p-6">
                <h3 class="text-xl font-semibold text-neutral-900 mb-4">Analitik Penjualan</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex items-center p-4 bg-blue-50 rounded-lg">
                        <div class="bg-blue-100 p-3 rounded-full mr-4">
                            <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-blue-600">Total Terjual</p>
                            <p class="text-2xl font-bold text-blue-900">{{ $product->sales_count }}</p>
                        </div>
                    </div>
                    <div class="flex items-center p-4 bg-green-50 rounded-lg">
                         <div class="bg-green-100 p-3 rounded-full mr-4">
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-green-600">Total Pendapatan</p>
                            <p class="text-2xl font-bold text-green-900">Rp {{ number_format($product->sales_count * $product->price_per_piece, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center p-4 bg-purple-50 rounded-lg">
                        <div class="bg-purple-100 p-3 rounded-full mr-4">
                            <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-purple-600">Hari Aktif</p>
                            <p class="text-2xl font-bold text-purple-900">{{ $product->created_at->diffInDays(now()) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="flex flex-col gap-8">
             <!-- Quick Actions -->
            <div class="card p-6">
                <h3 class="text-xl font-semibold text-neutral-900 mb-4">Aksi Cepat</h3>
                <div class="flex flex-col gap-3">
                    <button 
                        onclick="if(admin.confirmDelete('Apakah Anda yakin ingin menghapus produk ini secara permanen? Tindakan ini tidak dapat diurungkan.')) { document.getElementById('delete-form').submit(); }"
                        class="btn btn-danger w-full"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus Produk
                    </button>
                </div>
            </div>
            
            <!-- Product Meta -->
            <div class="card p-6">
                <h3 class="text-xl font-semibold text-neutral-900 mb-4">Informasi Tambahan</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-neutral-500">ID Produk</p>
                        <p class="text-sm font-mono text-neutral-800 bg-neutral-100 px-2 py-1 rounded">{{ $product->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-neutral-500">Slug</p>
                        <p class="text-sm font-mono text-neutral-800 bg-neutral-100 px-2 py-1 rounded">{{ $product->slug }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-neutral-500">Dibuat Pada</p>
                        <p class="text-sm font-medium text-neutral-800">{{ $product->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-neutral-500">Diperbarui Pada</p>
                        <p class="text-sm font-medium text-neutral-800">{{ $product->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

             @if($product->stock < 5)
            <div class="card bg-yellow-50 border-yellow-200">
                <div class="p-5 flex items-center">
                    <div class="mr-4">
                        <svg class="h-8 w-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-yellow-800">Perhatian Stok Rendah</h4>
                        <p class="text-sm text-yellow-700">Stok produk ini hampir habis. Pertimbangkan untuk segera melakukan restock untuk menghindari kehabisan.</p>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

<!-- Delete Form -->
<form id="delete-form" action="{{ route('admin.products.destroy', $product) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endsection

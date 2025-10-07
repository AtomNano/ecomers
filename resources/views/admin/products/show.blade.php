@extends('layouts.admin.app')

@section('title', 'Detail Produk - ' . $product->name)
@section('page-title', 'Detail Produk')
@section('page-description', 'Informasi lengkap dan pengaturan produk')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Product Information -->
        <div class="card p-6">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-neutral-900">{{ $product->name }}</h2>
                    <p class="text-neutral-600">{{ $product->category->name ?? 'Kategori' }}</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn-outline">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <img 
                        src="{{ $product->image ? asset('storage/products/' . $product->image) : 'https://placehold.co/400x300/f3f4f6/374151?text=Produk' }}" 
                        alt="{{ $product->name }}"
                        class="w-full h-64 object-cover rounded-lg"
                    >
                </div>
                
                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-neutral-700">Deskripsi</h3>
                        <p class="text-neutral-900">{{ $product->description ?: 'Tidak ada deskripsi' }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-neutral-700">Stok</h3>
                        <div class="flex items-center space-x-2">
                            <span class="text-2xl font-bold text-neutral-900">{{ $product->stock }}</span>
                            <span class="text-sm text-neutral-500">pcs</span>
                            @if($product->stock < 5)
                            <span class="badge-warning">Rendah</span>
                            @endif
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-neutral-700">Terjual</h3>
                        <div class="flex items-center space-x-2">
                            <span class="text-2xl font-bold text-neutral-900">{{ $product->sales_count }}</span>
                            <span class="text-sm text-neutral-500">pcs</span>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-neutral-700">Status</h3>
                        <div class="flex items-center space-x-2">
                            @if($product->is_featured)
                            <span class="badge-primary">Unggulan</span>
                            @endif
                            <span class="badge {{ $product->stock > 0 ? 'badge-success' : 'badge-danger' }}">
                                {{ $product->stock > 0 ? 'Aktif' : 'Habis' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pricing Information -->
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-neutral-900 mb-4">Informasi Harga</h3>
            
            <div class="space-y-4">
                <!-- Basic Pricing -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-primary-50 border border-primary-200 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-primary-800 mb-2">Harga Eceran</h4>
                        <p class="text-2xl font-bold text-primary-900">Rp {{ number_format($product->price_per_piece) }}</p>
                        <p class="text-xs text-primary-600">1-3 pcs</p>
                    </div>
                    
                    @if($product->price_per_four)
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-green-800 mb-2">Harga 4+</h4>
                        <p class="text-2xl font-bold text-green-900">Rp {{ number_format($product->price_per_four) }}</p>
                        <p class="text-xs text-green-600">4-11 pcs</p>
                    </div>
                    @endif
                    
                    @if($product->price_per_dozen)
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-green-800 mb-2">Harga Lusin</h4>
                        <p class="text-2xl font-bold text-green-900">Rp {{ number_format($product->price_per_dozen) }}</p>
                        <p class="text-xs text-green-600">12+ pcs</p>
                    </div>
                    @endif
                </div>

                <!-- Advanced Tier Pricing -->
                @if($product->tierPrices->count() > 0)
                <div>
                    <h4 class="text-md font-medium text-neutral-900 mb-3">Harga Bertingkat Lanjutan</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-neutral-200">
                            <thead class="bg-neutral-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-neutral-500 uppercase">Nama Tingkat</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-neutral-500 uppercase">Min. Kuantitas</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-neutral-500 uppercase">Harga per Satuan</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-neutral-500 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-neutral-200">
                                @foreach($product->tierPrices as $tierPrice)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-neutral-900">{{ $tierPrice->tier_name }}</td>
                                    <td class="px-4 py-2 text-sm text-neutral-900">{{ $tierPrice->min_quantity }} pcs</td>
                                    <td class="px-4 py-2 text-sm text-neutral-900">Rp {{ number_format($tierPrice->price) }}</td>
                                    <td class="px-4 py-2">
                                        <span class="badge {{ $tierPrice->is_active ? 'badge-success' : 'badge-danger' }}">
                                            {{ $tierPrice->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Sales Analytics -->
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-neutral-900 mb-4">Analitik Penjualan</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <p class="text-2xl font-bold text-blue-900">{{ $product->sales_count }}</p>
                    <p class="text-sm text-blue-600">Total Terjual</p>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <p class="text-2xl font-bold text-green-900">Rp {{ number_format($product->sales_count * $product->price_per_piece) }}</p>
                    <p class="text-sm text-green-600">Total Pendapatan</p>
                </div>
                <div class="text-center p-4 bg-purple-50 rounded-lg">
                    <p class="text-2xl font-bold text-purple-900">{{ $product->created_at->diffInDays(now()) }}</p>
                    <p class="text-sm text-purple-600">Hari Aktif</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Quick Actions -->
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-neutral-900 mb-4">Aksi Cepat</h3>
            
            <div class="space-y-3">
                <a href="{{ route('admin.products.edit', $product) }}" class="btn-primary w-full text-center">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Produk
                </a>
                
                <button 
                    onclick="if(admin.confirmDelete('Apakah Anda yakin ingin menghapus produk ini?')) { document.getElementById('delete-form').submit(); }"
                    class="btn-outline w-full text-center text-red-600 border-red-600 hover:bg-red-50"
                >
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus Produk
                </button>
                
                <a href="{{ route('admin.products.index') }}" class="btn-outline w-full text-center">
                    Kembali ke Daftar
                </a>
            </div>
        </div>

        <!-- Product Meta -->
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-neutral-900 mb-4">Informasi Produk</h3>
            
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-neutral-500">ID Produk</p>
                    <p class="text-sm font-medium text-neutral-900">{{ $product->id }}</p>
                </div>
                
                <div>
                    <p class="text-sm text-neutral-500">Slug</p>
                    <p class="text-sm font-medium text-neutral-900">{{ $product->slug }}</p>
                </div>
                
                <div>
                    <p class="text-sm text-neutral-500">Dibuat</p>
                    <p class="text-sm font-medium text-neutral-900">{{ $product->created_at->format('d M Y, H:i') }}</p>
                </div>
                
                <div>
                    <p class="text-sm text-neutral-500">Diperbarui</p>
                    <p class="text-sm font-medium text-neutral-900">{{ $product->updated_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Stock Management -->
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-neutral-900 mb-4">Manajemen Stok</h3>
            
            <div class="space-y-4">
                <div class="text-center">
                    <p class="text-3xl font-bold text-neutral-900">{{ $product->stock }}</p>
                    <p class="text-sm text-neutral-500">Stok Tersedia</p>
                </div>
                
                @if($product->stock < 5)
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <p class="text-sm text-yellow-800">Stok rendah, pertimbangkan untuk restock</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Delete Form -->
<form id="delete-form" action="{{ route('admin.products.destroy', $product) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endsection
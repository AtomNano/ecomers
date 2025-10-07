@extends('layouts.admin.app')

@section('title', 'Manajemen Produk - Grosir Berkat Ibu')
@section('page-title', 'Manajemen Produk')
@section('page-description', 'Kelola produk, stok, dan harga bertingkat')

@section('content')
<!-- Header Actions -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h2 class="text-2xl font-bold text-neutral-900">Daftar Produk</h2>
        <p class="text-neutral-600">Kelola semua produk dan sistem harga bertingkat</p>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('admin.products.create') }}" class="btn-primary">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Produk
        </a>
    </div>
</div>

<!-- Filters -->
<div class="card p-4 mb-6">
    <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-64">
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}"
                placeholder="Cari produk..."
                class="input-field"
            >
        </div>
        <div class="min-w-48">
            <select name="category" class="input-field">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="min-w-32">
            <select name="status" class="input-field">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>
        <button type="submit" class="btn-outline">
            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            Filter
        </button>
        @if(request()->hasAny(['search', 'category', 'status']))
        <a href="{{ route('admin.products.index') }}" class="btn-outline">
            Hapus Filter
        </a>
        @endif
    </form>
</div>

<!-- Products Table -->
<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-neutral-200">
            <thead class="bg-neutral-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                        Produk
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                        Kategori
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                        Harga
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                        Stok
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                        Terjual
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-neutral-200">
                @forelse($products as $product)
                <tr class="hover:bg-neutral-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-12 w-12">
                                <img 
                                    src="{{ $product->image ? asset('storage/products/' . $product->image) : 'https://placehold.co/48x48/f3f4f6/374151?text=P' }}" 
                                    alt="{{ $product->name }}"
                                    class="h-12 w-12 rounded-lg object-cover"
                                >
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-neutral-900">{{ $product->name }}</div>
                                <div class="text-sm text-neutral-500">SKU: {{ $product->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm text-neutral-900">{{ $product->category->name ?? '-' }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-neutral-900">
                            <div>Eceran: Rp {{ number_format($product->price_per_piece) }}</div>
                            @if($product->price_per_four)
                            <div class="text-xs text-green-600">4+: Rp {{ number_format($product->price_per_four) }}</div>
                            @endif
                            @if($product->price_per_dozen)
                            <div class="text-xs text-green-600">Lusin: Rp {{ number_format($product->price_per_dozen) }}</div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="text-sm text-neutral-900">{{ $product->stock }}</span>
                            @if($product->stock < 5)
                            <span class="ml-2 badge-warning text-xs">Rendah</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-2">
                            @if($product->is_featured)
                            <span class="badge-primary text-xs">Unggulan</span>
                            @endif
                            <span class="badge {{ $product->stock > 0 ? 'badge-success' : 'badge-danger' }}">
                                {{ $product->stock > 0 ? 'Aktif' : 'Habis' }}
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">
                        {{ $product->sales_count }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('admin.products.show', $product) }}" 
                               class="text-primary-600 hover:text-primary-900 transition-colors">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('admin.products.edit', $product) }}" 
                               class="text-neutral-600 hover:text-neutral-900 transition-colors">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <button 
                                onclick="if(admin.confirmDelete('Apakah Anda yakin ingin menghapus produk ini?')) { document.getElementById('delete-form-{{ $product->id }}').submit(); }"
                                class="text-red-600 hover:text-red-900 transition-colors"
                            >
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                            
                            <!-- Delete Form -->
                            <form id="delete-form-{{ $product->id }}" 
                                  action="{{ route('admin.products.destroy', $product) }}" 
                                  method="POST" 
                                  class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <svg class="h-12 w-12 text-neutral-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-neutral-900 mb-2">Tidak ada produk ditemukan</h3>
                        <p class="text-neutral-500 mb-4">Mulai dengan menambahkan produk pertama Anda</p>
                        <a href="{{ route('admin.products.create') }}" class="btn-primary">
                            Tambah Produk
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div class="px-6 py-4 border-t border-neutral-200">
        {{ $products->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
@extends('layouts.admin.app')

@section('title', 'Manajemen Produk - Grosir Berkat Ibu')

@section('content')
<div class="flex flex-col gap-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-neutral-900">Manajemen Produk</h1>
            <p class="text-neutral-600 mt-1">Kelola semua produk, stok, dan harga di toko Anda.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Tambah Produk Baru
        </a>
    </div>

    <!-- Filters and Table -->
    <div class="card">
        <!-- Filter Bar -->
        <div class="p-6 border-b border-neutral-200">
            <form method="GET" action="{{ route('admin.products.index') }}">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="relative flex-1">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-neutral-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Cari berdasarkan nama atau SKU..."
                            class="form-input pl-10"
                        >
                    </div>
                    <div class="w-full sm:w-48">
                        <select name="category" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full sm:w-40">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Habis</option>
                            <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>Unggulan</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="btn btn-secondary w-full sm:w-auto">Filter</button>
                         @if(request()->hasAny(['search', 'category', 'status']))
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline w-full sm:w-auto" title="Hapus Filter">
                           <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200">
                <thead class="bg-neutral-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Produk</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Harga Eceran</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Stok</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-neutral-200">
                    @forelse($products as $product)
                    <tr class="hover:bg-neutral-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-4">
                                <a href="{{ route('admin.products.show', $product) }}">
                                    <img 
                                        src="{{ $product->image ? asset('storage/products/' . $product->image) : 'https://placehold.co/100x100/f3f4f6/374151?text=Img' }}" 
                                        alt="{{ $product->name }}"
                                        class="h-12 w-12 rounded-lg object-cover"
                                    >
                                </a>
                                <div>
                                    <a href="{{ route('admin.products.show', $product) }}" class="text-sm font-semibold text-neutral-900 hover:text-primary-600">{{ $product->name }}</a>
                                    <div class="text-sm text-neutral-500">{{ $product->category->name ?? 'Tanpa kategori' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-neutral-900">Rp {{ number_format($product->price_per_piece, 0, ',', '.') }}</div>
                            @if($product->price_per_dozen)
                            <div class="text-xs text-neutral-500">Lusin: Rp {{ number_format($product->price_per_dozen, 0, ',', '.') }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($product->stock <= 0)
                                <div class="text-sm font-bold text-red-600">{{ $product->stock }} pcs</div>
                            @elseif($product->stock < 5)
                                <div class="text-sm font-semibold text-yellow-600">{{ $product->stock }} pcs</div>
                            @else
                                <div class="text-sm text-neutral-900">{{ $product->stock }} pcs</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <span class="badge {{ $product->stock > 0 ? 'badge-success' : 'badge-danger' }}">
                                    {{ $product->stock > 0 ? 'Aktif' : 'Habis' }}
                                </span>
                                @if($product->is_featured)
                                <span class="badge badge-primary">Unggulan</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-icon btn-light" title="Lihat">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-icon btn-light" title="Edit">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <button 
                                    onclick="if(admin.confirmDelete('Anda yakin ingin menghapus produk `{{ $product->name }}` secara permanen?')) { document.getElementById('delete-form-{{ $product->id }}').submit(); }"
                                    class="btn btn-sm btn-icon btn-light-danger"
                                    title="Hapus"
                                >
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                                
                                <form id="delete-form-{{ $product->id }}" action="{{ route('admin.products.destroy', $product) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="h-16 w-16 text-neutral-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <h3 class="text-xl font-semibold text-neutral-800 mb-2">Tidak ada produk ditemukan</h3>
                                @if(request()->hasAny(['search', 'category', 'status']))
                                    <p class="text-neutral-500 mb-4">Coba sesuaikan filter pencarian Anda.</p>
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Hapus Filter</a>
                                @else
                                    <p class="text-neutral-500 mb-4">Mulai dengan menambahkan produk pertama Anda.</p>
                                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Tambah Produk</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
        <div class="p-6 border-t border-neutral-200">
            {{ $products->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

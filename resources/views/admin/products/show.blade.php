@extends('layouts.app')

@section('title', 'Detail Produk - ' . $product->name)

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-start mb-8">
        <div>
            <h1 class="text-4xl font-bold text-gray-800">{{ $product->name }}</h1>
            <p class="text-gray-600 mt-2">
                <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded text-sm font-semibold">
                    📁 {{ $product->category->name }}
                </span>
            </p>
        </div>
        <div class="space-x-2">
            <a href="{{ route('admin.products.edit', $product) }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 font-semibold">
                ✏️ Edit Produk
            </a>
            <a href="{{ route('admin.products.index') }}" class="inline-block bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700 font-semibold">
                ← Kembali
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Image Section -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-auto rounded-lg object-cover">
                @else
                    <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                        <span class="text-gray-500 text-lg">📸 Tidak ada gambar</span>
                    </div>
                @endif
                
                <!-- Stock Status -->
                <div class="mt-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Status Stock</h3>
                    <div class="text-center">
                        <span class="text-4xl font-bold
                            @if($product->stock <= 10) text-red-600
                            @elseif($product->stock <= 20) text-yellow-600
                            @else text-green-600
                            @endif">
                            {{ $product->stock }}
                        </span>
                        <p class="text-gray-600 text-sm mt-2">
                            @if($product->stock <= 10)
                                🔴 Stok Rendah
                            @elseif($product->stock <= 20)
                                🟡 Stok Sedang
                            @else
                                🟢 Stok Aman
                            @endif
                        </p>
                    </div>
                    <p class="text-center text-xs text-gray-500 mt-2">Minimum stok: {{ $product->min_stock ?? 5 }} pcs</p>
                </div>
            </div>
        </div>

        <!-- Details Section -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Description -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">📝 Deskripsi</h2>
                <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
            </div>

            <!-- Pricing -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">💰 Harga Bertingkat</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Unit Price -->
                    <div class="border-l-4 border-blue-500 pl-4">
                        <p class="text-gray-600 text-sm font-semibold">HARGA PER SATUAN</p>
                        <p class="text-2xl font-bold text-blue-600 mt-1">
                            Rp {{ number_format($product->price_unit, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">Per 1 {{ $product->unit ?? 'pcs' }}</p>
                    </div>

                    <!-- Bulk Price -->
                    <div class="border-l-4 border-yellow-500 pl-4">
                        <p class="text-gray-600 text-sm font-semibold">HARGA BULK (4+)</p>
                        @if($product->price_bulk_4)
                            <p class="text-2xl font-bold text-yellow-600 mt-1">
                                Rp {{ number_format($product->price_bulk_4, 0, ',', '.') }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">Mulai pembelian 4 pcs</p>
                            @if($product->price_bulk_4 < $product->price_unit)
                                <p class="text-xs text-green-600 font-semibold mt-1">
                                    💚 Hemat Rp {{ number_format($product->price_unit - $product->price_bulk_4, 0, ',', '.') }}/pcs
                                </p>
                            @endif
                        @else
                            <p class="text-2xl font-bold text-gray-400 mt-1">-</p>
                            <p class="text-xs text-gray-500 mt-1">Tidak ada harga bulk</p>
                        @endif
                    </div>

                    <!-- Dozen Price -->
                    <div class="border-l-4 border-green-500 pl-4">
                        <p class="text-gray-600 text-sm font-semibold">HARGA LUSIN/DUS</p>
                        @if($product->price_dozen)
                            <p class="text-2xl font-bold text-green-600 mt-1">
                                Rp {{ number_format($product->price_dozen, 0, ',', '.') }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">Mulai pembelian {{ $product->box_item_count ?? 12 }} pcs</p>
                            @if($product->price_dozen < $product->price_unit)
                                <p class="text-xs text-green-600 font-semibold mt-1">
                                    💚 Hemat Rp {{ number_format($product->price_unit - $product->price_dozen, 0, ',', '.') }}/pcs
                                </p>
                            @endif
                        @else
                            <p class="text-2xl font-bold text-gray-400 mt-1">-</p>
                            <p class="text-xs text-gray-500 mt-1">Tidak ada harga lusin</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Unit Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">📦 Informasi Satuan</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600 text-sm font-semibold">Satuan Dasar</p>
                        <p class="text-lg font-bold text-gray-800 mt-1">{{ $product->unit ?? 'pcs' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm font-semibold">Item Per Dus</p>
                        <p class="text-lg font-bold text-gray-800 mt-1">{{ $product->box_item_count ?? 12 }} {{ $product->unit ?? 'pcs' }}</p>
                    </div>
                </div>
            </div>

            <!-- Featured Status -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">⭐ Status Unggulan</h2>
                @if($product->is_featured)
                    <div class="bg-purple-100 border-l-4 border-purple-500 p-4 rounded">
                        <p class="text-purple-800 font-semibold">✅ Produk Unggulan</p>
                        <p class="text-purple-700 text-sm mt-1">Produk ini ditampilkan di halaman utama</p>
                    </div>
                @else
                    <div class="bg-gray-100 border-l-4 border-gray-400 p-4 rounded">
                        <p class="text-gray-800 font-semibold">⭕ Bukan Produk Unggulan</p>
                        <p class="text-gray-700 text-sm mt-1">Produk tidak ditampilkan di halaman utama</p>
                    </div>
                @endif
            </div>

            <!-- Timestamps -->
            <div class="bg-gray-50 rounded-lg p-6 text-sm text-gray-600">
                <p>📅 Dibuat: {{ $product->created_at->format('d M Y, H:i') }}</p>
                <p>✏️ Diperbarui: {{ $product->updated_at->format('d M Y, H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-8 flex justify-center gap-4">
        <a href="{{ route('admin.products.edit', $product) }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 font-semibold transition">
            ✏️ Edit Produk
        </a>
        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-8 py-3 rounded-lg hover:bg-red-700 font-semibold transition" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                🗑️ Hapus Produk
            </button>
        </form>
        <a href="{{ route('admin.products.index') }}" class="bg-gray-600 text-white px-8 py-3 rounded-lg hover:bg-gray-700 font-semibold transition">
            ← Kembali ke Daftar
        </a>
    </div>
</div>
@endsection

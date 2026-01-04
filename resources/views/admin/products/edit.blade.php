@extends('layouts.app')

@section('title', 'Edit Produk - Admin')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Edit Produk</h1>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded shadow p-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-bold mb-2">Nama Produk</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border rounded px-3 py-2" required>
            @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-bold mb-2">Deskripsi</label>
            <textarea name="description" class="w-full border rounded px-3 py-2" rows="4" required>{{ old('description', $product->description) }}</textarea>
            @error('description')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-bold mb-2">Kategori</label>
            <select name="category_id" class="w-full border rounded px-3 py-2" required>
                <option value="">Pilih Kategori</option>
                @foreach(\App\Models\Category::all() as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-bold mb-2">Harga Satuan (pcs)</label>
                <input type="number" name="price_unit" value="{{ old('price_unit', $product->price_unit) }}" step="0.01" class="w-full border rounded px-3 py-2" required>
                @error('price_unit')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-bold mb-2">Harga Grosir 4+ (pcs)</label>
                <input type="number" name="price_bulk_4" value="{{ old('price_bulk_4', $product->price_bulk_4) }}" step="0.01" class="w-full border rounded px-3 py-2" required>
                @error('price_bulk_4')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-bold mb-2">Harga Lusin</label>
                <input type="number" name="price_dozen" value="{{ old('price_dozen', $product->price_dozen) }}" step="0.01" class="w-full border rounded px-3 py-2" required>
                @error('price_dozen')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold mb-2">Stock</label>
            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full border rounded px-3 py-2" required>
            @error('stock')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-bold mb-2">Gambar Produk</label>
            @if($product->image)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="max-w-xs rounded">
                </div>
            @endif
            <input type="file" name="image" accept="image/*" class="w-full border rounded px-3 py-2">
            <p class="text-gray-600 text-sm mt-1">Biarkan kosong jika tidak ingin mengubah</p>
            @error('image')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-4">
            <a href="{{ route('admin.products.index') }}" class="flex-1 bg-gray-600 text-white py-2 rounded text-center hover:bg-gray-700">
                Batal
            </a>
            <button type="submit" class="flex-1 bg-green-600 text-white py-2 rounded font-bold hover:bg-green-700">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection

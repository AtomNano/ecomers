@extends('layouts.admin-layout')

@section('title', 'Edit Produk - Admin')
@section('breadcrumb', 'Edit Produk')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.products.show', $product) }}" class="text-gray-500 hover:text-emerald-600 transition">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Edit Produk</h1>
            <p class="text-gray-500 text-sm">{{ $product->name }}</p>
        </div>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Main Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Info Card -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle text-emerald-500"></i> Informasi Dasar
                    </h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Produk <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" 
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-transparent" required>
                            @error('name')
                                <p class="text-red-600 text-sm mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi <span class="text-red-500">*</span></label>
                            <textarea name="description" rows="4" 
                                      class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-transparent" required>{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <p class="text-red-600 text-sm mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                                <select name="category_id" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-transparent bg-white" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="text-red-600 text-sm mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Satuan</label>
                                <input type="text" name="unit" value="{{ old('unit', $product->unit ?? 'pcs') }}" 
                                       placeholder="pcs, botol, sachet..."
                                       class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing Card -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-tags text-amber-500"></i> Harga Bertingkat
                    </h3>
                    <p class="text-sm text-gray-500 mb-4">Atur harga berbeda untuk pembelian satuan, grosir, dan per dus</p>
                    
                    <div class="space-y-4">
                        <!-- Unit Price -->
                        <div class="p-4 bg-blue-50 rounded-xl border-2 border-blue-200">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="w-8 h-8 bg-blue-500 text-white rounded-lg flex items-center justify-center text-sm font-bold">1</span>
                                <span class="font-semibold text-blue-700">Harga Satuan</span>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Harga per 1 item <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                                    <input type="number" name="price_unit" value="{{ old('price_unit', $product->price_unit) }}" step="1" min="100"
                                           class="w-full border border-gray-300 rounded-xl pl-12 pr-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                </div>
                                @error('price_unit')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Bulk Price -->
                        <div class="p-4 bg-amber-50 rounded-xl border-2 border-amber-200">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="w-8 h-8 bg-amber-500 text-white rounded-lg flex items-center justify-center text-sm font-bold">2</span>
                                <span class="font-semibold text-amber-700">Harga Grosir</span>
                                <span class="text-xs bg-amber-200 text-amber-700 px-2 py-1 rounded-full">Opsional</span>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Minimal beli</label>
                                    <div class="relative">
                                        <input type="number" name="bulk_min_qty" value="{{ old('bulk_min_qty', $product->bulk_min_qty ?? 4) }}" min="2" max="100"
                                               class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm">pcs</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Min. qty untuk dapat harga grosir</p>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Harga per item</label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                                        <input type="number" name="price_bulk_4" value="{{ old('price_bulk_4', $product->price_bulk_4) }}" step="1" min="100"
                                               class="w-full border border-gray-300 rounded-xl pl-12 pr-4 py-3 focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                    </div>
                                    @error('price_bulk_4')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Box/Dus Price -->
                        <div class="p-4 bg-emerald-50 rounded-xl border-2 border-emerald-200">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="w-8 h-8 bg-emerald-500 text-white rounded-lg flex items-center justify-center text-sm font-bold">3</span>
                                <span class="font-semibold text-emerald-700">Harga Dus/Box</span>
                                <span class="text-xs bg-emerald-200 text-emerald-700 px-2 py-1 rounded-full">Opsional</span>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Isi per dus/box</label>
                                    <div class="relative">
                                        <input type="number" name="box_item_count" value="{{ old('box_item_count', $product->box_item_count ?? 12) }}" min="2" max="999"
                                               class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm">pcs</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Jumlah item dalam 1 dus</p>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Harga per item</label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                                        <input type="number" name="price_dozen" value="{{ old('price_dozen', $product->price_dozen) }}" step="1" min="100"
                                               class="w-full border border-gray-300 rounded-xl pl-12 pr-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                    </div>
                                    @error('price_dozen')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Image & Stock -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Image Upload -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-image text-purple-500"></i> Gambar Produk
                    </h3>
                    
                    @if($product->image)
                    <div class="mb-4">
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full rounded-xl">
                        <p class="text-xs text-gray-500 mt-2 text-center">Gambar saat ini</p>
                    </div>
                    @endif
                    
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-emerald-500 transition cursor-pointer" onclick="document.getElementById('image-input').click()">
                        <div id="image-preview" class="hidden mb-4">
                            <img id="preview-img" src="" alt="Preview" class="max-h-40 mx-auto rounded-lg">
                        </div>
                        <div id="image-placeholder">
                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-500">Klik untuk ganti gambar</p>
                            <p class="text-xs text-gray-400">PNG, JPG, WEBP (Max. 2MB)</p>
                        </div>
                        <input type="file" name="image" id="image-input" accept="image/*" class="hidden" onchange="previewImage(this)">
                    </div>
                    @error('image')
                        <p class="text-red-600 text-sm mt-2"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Stock -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-warehouse text-blue-500"></i> Stok
                    </h3>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Stok <span class="text-red-500">*</span></label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0"
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-center text-2xl font-bold" required>
                        @error('stock')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Featured -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                               class="w-5 h-5 text-emerald-600 rounded focus:ring-emerald-500">
                        <div>
                            <span class="font-semibold text-gray-800">Produk Unggulan</span>
                            <p class="text-xs text-gray-500">Tampilkan di halaman utama</p>
                        </div>
                    </label>
                </div>

                <!-- Submit Buttons -->
                <div class="space-y-3">
                    <button type="submit" class="w-full py-4 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl hover:from-emerald-600 hover:to-teal-700 transition shadow-lg hover:shadow-xl font-bold text-lg">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.products.show', $product) }}" class="block w-full py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition text-center font-medium">
                        <i class="fas fa-times mr-2"></i> Batal
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('image-preview').classList.remove('hidden');
            document.getElementById('image-placeholder').classList.add('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection

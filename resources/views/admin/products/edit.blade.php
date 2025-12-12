@extends('layouts.admin.app')

@section('title', 'Edit Produk - ' . $product->name)

@section('content')
<div x-data="productForm()" class="max-w-5xl mx-auto">
    
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
            <div>
                <a href="{{ route('admin.products.index') }}" class="mb-6 flex items-center text-slate-500 hover:text-primary-600 transition-colors gap-2 text-sm font-medium group">
                    <i class="ph-bold ph-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                    Kembali ke Daftar Produk
                </a>
                <h1 class="text-3xl font-bold text-slate-800">Edit Produk</h1>
                <p class="text-slate-500 mt-1">Ubah detail untuk <span class="font-semibold text-slate-700">{{ $product->name }}</span></p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Form -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Card: Basic Info -->
                <div class="bg-white p-8 rounded-2xl shadow-soft border border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                        <i class="ph-duotone ph-info text-primary-500 text-xl"></i>
                        Informasi Dasar
                    </h3>
                    
                    <div class="space-y-6">
                        <div class="input-group">
                            <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Produk <span class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required placeholder="Contoh: Kopi Robusta Premium" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary-100 focus:border-primary-500 transition-all outline-none @error('name') border-red-500 @enderror">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="input-group">
                                <label for="category_id" class="block text-sm font-semibold text-slate-700 mb-2">Kategori</label>
                                <div class="relative">
                                    <select id="category_id" name="category_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl appearance-none focus:bg-white focus:ring-2 focus:ring-primary-100 focus:border-primary-500 transition-all outline-none cursor-pointer @error('category_id') border-red-500 @enderror">
                                        <option value="">Pilih Kategori...</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class="ph-bold ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                                </div>
                                @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="input-group">
                                <label for="stock" class="block text-sm font-semibold text-slate-700 mb-2">Stok</label>
                                <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary-100 focus:border-primary-500 transition-all outline-none @error('stock') border-red-500 @enderror">
                                @error('stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="input-group">
                            <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi</label>
                            <textarea id="description" name="description" rows="4" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary-100 focus:border-primary-500 transition-all outline-none placeholder:text-slate-400 @error('description') border-red-500 @enderror" placeholder="Jelaskan detail produk...">{{ old('description', $product->description) }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Card: Pricing Strategy -->
                <div class="bg-white p-8 rounded-2xl shadow-soft border border-slate-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-primary-50 to-transparent rounded-bl-full opacity-50 pointer-events-none"></div>

                    <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                        <i class="ph-duotone ph-currency-dollar text-emerald-500 text-xl"></i>
                        Strategi Harga
                    </h3>

                    <div class="space-y-6">
                        <div class="input-group">
                            <label for="price_per_piece" class="block text-sm font-semibold text-slate-700 mb-2">Harga Eceran (Satuan)</label>
                            <div class="relative group">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-medium group-focus-within:text-primary-600 transition-colors">Rp</span>
                                <input type="number" id="price_per_piece" name="price_per_piece" value="{{ old('price_per_piece', $product->price_per_piece) }}" placeholder="0" class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary-100 focus:border-primary-500 transition-all outline-none font-semibold text-slate-800 @error('price_per_piece') border-red-500 @enderror">
                            </div>
                            @error('price_per_piece') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="border-t border-slate-100 pt-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">Harga Grosir (Bertingkat)</h4>
                                    <p class="text-xs text-slate-500 mt-1">Atur harga lebih murah untuk pembelian banyak.</p>
                                </div>
                                <button type="button" @click="addTier()" class="px-3 py-1.5 bg-primary-50 text-primary-600 text-xs font-bold rounded-lg hover:bg-primary-100 transition-colors flex items-center gap-1">
                                    <i class="ph-bold ph-plus"></i> Tambah Level
                                </button>
                            </div>

                            <div class="space-y-3">
                                <template x-for="(tier, index) in tierPrices" :key="index">
                                    <div class="flex items-center gap-3 bg-slate-50 p-3 rounded-xl border border-slate-200 group hover:border-primary-200 hover:shadow-sm transition-all">
                                        <div class="flex-1">
                                            <input type="text" :name="`tier_prices[${index}][tier_name]`" x-model="tier.tier_name" placeholder="Nama (ex: Lusin)" class="w-full bg-transparent border-none p-0 text-sm focus:ring-0 placeholder:text-slate-400 font-medium text-slate-700">
                                        </div>
                                        <div class="w-24">
                                            <input type="number" :name="`tier_prices[${index}][min_quantity]`" x-model="tier.min_quantity" placeholder="Min Qty" class="w-full bg-white border border-slate-200 rounded-lg px-2 py-1.5 text-xs focus:ring-1 focus:ring-primary-500 focus:border-primary-500 text-center">
                                        </div>
                                        <div class="w-32 relative">
                                            <span class="absolute left-2 top-1/2 -translate-y-1/2 text-xs text-slate-400">Rp</span>
                                            <input type="number" :name="`tier_prices[${index}][price]`" x-model="tier.price" placeholder="Harga" class="w-full bg-white border border-slate-200 rounded-lg pl-6 pr-2 py-1.5 text-xs focus:ring-1 focus:ring-primary-500 focus:border-primary-500 font-semibold">
                                        </div>
                                        <button type="button" @click="removeTier(index)" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                            <i class="ph-bold ph-x"></i>
                                        </button>
                                    </div>
                                </template>
                                <div x-show="tierPrices.length === 0" class="text-center py-6 border-2 border-dashed border-slate-200 rounded-xl">
                                    <p class="text-xs text-slate-400">Belum ada harga grosir diatur.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Media & Publish -->
            <div class="space-y-8">
                <!-- Publish Action -->
                <div class="bg-white p-6 rounded-2xl shadow-soft border border-slate-100 sticky top-24">
                    <h3 class="text-sm font-bold text-slate-800 mb-4 uppercase tracking-wider">Aksi</h3>
                    
                    <div class="flex items-center justify-between mb-4 pb-4 border-b border-slate-100">
                        <label for="is_featured" class="text-sm font-medium text-slate-700">Jadikan Unggulan</label>
                        <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 appearance-none cursor-pointer transition-transform duration-200 ease-in-out checked:translate-x-full checked:border-primary-500"/>
                            <label for="is_featured" class="toggle-label block overflow-hidden h-5 rounded-full bg-slate-300 cursor-pointer"></label>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <button type="submit" class="w-full py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-bold shadow-lg shadow-primary-500/30 transition-all hover:-translate-y-0.5 active:translate-y-0">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="w-full py-3 bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 rounded-xl font-semibold transition-colors text-center">
                            Batal
                        </a>
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="bg-white p-6 rounded-2xl shadow-soft border border-slate-100">
                    <h3 class="text-sm font-bold text-slate-800 mb-4 uppercase tracking-wider">Gambar Produk</h3>
                    
                    <div class="relative w-full aspect-square bg-slate-50 border-2 border-dashed border-slate-300 rounded-2xl flex flex-col items-center justify-center cursor-pointer group hover:border-primary-500 hover:bg-primary-50/50 transition-all overflow-hidden" @click="$refs.fileInput.click()">
                        
                        <div x-show="!imagePreview" class="text-center p-6 transition-transform group-hover:scale-105">
                            <div class="w-12 h-12 bg-white rounded-xl shadow-sm border border-slate-200 flex items-center justify-center mx-auto mb-3 text-slate-400 group-hover:text-primary-500">
                                <i class="ph-duotone ph-image text-2xl"></i>
                            </div>
                            <p class="text-sm font-medium text-slate-600">Klik untuk Ganti</p>
                            <p class="text-[10px] text-slate-400 mt-1">PNG, JPG (Maks. 2MB)</p>
                        </div>

                        <img x-show="imagePreview" :src="imagePreview" class="absolute inset-0 w-full h-full object-cover">
                        
                        <div x-show="imagePreview" class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <p class="text-white text-sm font-medium"><i class="ph-bold ph-pencil"></i> Ganti Gambar</p>
                        </div>

                        <input type="file" name="image" x-ref="fileInput" class="hidden" @change="handleImageUpload">
                    </div>
                    
                    <button type="button" x-show="imagePreview && '{{ $product->image }}'" @click.stop="removeImage" class="mt-3 w-full py-2 text-xs font-bold text-red-500 hover:bg-red-50 rounded-lg transition-colors flex items-center justify-center gap-1">
                        <i class="ph-bold ph-trash"></i> Hapus Gambar Saat Ini
                    </button>
                    @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    <input type="hidden" name="remove_image" x-model="removeImageFlag">
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function productForm() {
    return {
        tierPrices: @json(old('tier_prices', $product->tierPrices)),
        imagePreview: '{{ $product->image ? asset('storage/products/' . $product->image) : '' }}',
        removeImageFlag: false,

        addTier() {
            this.tierPrices.push({ tier_name: '', min_quantity: 1, price: 0 });
        },

        removeTier(index) {
            this.tierPrices.splice(index, 1);
        },

        handleImageUpload(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                    this.removeImageFlag = false;
                };
                reader.readAsDataURL(file);
            }
        },

        removeImage() {
            this.imagePreview = null;
            this.removeImageFlag = true;
            this.$refs.fileInput.value = '';
        }
    }
}
</script>
@endsection

@extends('layouts.admin.app')

@section('title', 'Tambah Produk - Grosir Berkat Ibu')
@section('page-title', 'Tambah Produk')
@section('page-description', 'Tambahkan produk baru dengan sistem harga bertingkat')

@section('content')
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" x-data="productForm()">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="card p-6">
                <h3 class="text-lg font-semibold text-neutral-900 mb-4">Informasi Dasar</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-neutral-700 mb-2">Nama Produk *</label>
                        <input 
                            type="text" 
                            name="name" 
                            value="{{ old('name') }}"
                            class="input-field @error('name') border-red-500 @enderror"
                            placeholder="Masukkan nama produk"
                            required
                        >
                        @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-neutral-700 mb-2">Deskripsi</label>
                        <textarea 
                            name="description" 
                            rows="4"
                            class="input-field @error('description') border-red-500 @enderror"
                            placeholder="Deskripsi produk"
                        >{{ old('description') }}</textarea>
                        @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">Kategori *</label>
                        <select 
                            name="category_id" 
                            class="input-field @error('category_id') border-red-500 @enderror"
                            required
                        >
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">Stok *</label>
                        <input 
                            type="number" 
                            name="stock" 
                            value="{{ old('stock', 0) }}"
                            min="0"
                            class="input-field @error('stock') border-red-500 @enderror"
                            required
                        >
                        @error('stock')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Pricing System -->
            <div class="card p-6">
                <h3 class="text-lg font-semibold text-neutral-900 mb-4">Sistem Harga Bertingkat</h3>
                
                <div class="space-y-6">
                    <!-- Basic Pricing -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Harga Eceran *</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-neutral-500">Rp</span>
                                <input 
                                    type="number" 
                                    name="price_per_piece" 
                                    value="{{ old('price_per_piece') }}"
                                    min="0"
                                    step="100"
                                    class="input-field pl-10 @error('price_per_piece') border-red-500 @enderror"
                                    placeholder="0"
                                    required
                                >
                            </div>
                            @error('price_per_piece')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Harga 4+ (Opsional)</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-neutral-500">Rp</span>
                                <input 
                                    type="number" 
                                    name="price_per_four" 
                                    value="{{ old('price_per_four') }}"
                                    min="0"
                                    step="100"
                                    class="input-field pl-10 @error('price_per_four') border-red-500 @enderror"
                                    placeholder="0"
                                >
                            </div>
                            @error('price_per_four')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Harga Lusin (Opsional)</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-neutral-500">Rp</span>
                                <input 
                                    type="number" 
                                    name="price_per_dozen" 
                                    value="{{ old('price_per_dozen') }}"
                                    min="0"
                                    step="100"
                                    class="input-field pl-10 @error('price_per_dozen') border-red-500 @enderror"
                                    placeholder="0"
                                >
                            </div>
                            @error('price_per_dozen')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Advanced Tier Pricing -->
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-md font-medium text-neutral-900">Harga Bertingkat Lanjutan</h4>
                            <button 
                                type="button" 
                                @click="addTierPrice()"
                                class="btn-outline text-sm"
                            >
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Tambah Tingkat Harga
                            </button>
                        </div>
                        
                        <div class="space-y-3" x-ref="tierPrices">
                            <template x-for="(tier, index) in tierPrices" :key="index">
                                <div class="flex items-center space-x-3 p-3 bg-neutral-50 rounded-lg">
                                    <div class="flex-1">
                                        <input 
                                            type="text" 
                                            x-model="tier.tier_name"
                                            placeholder="Nama Tingkat (e.g., Grosir, Kartonan)"
                                            class="input-field text-sm"
                                        >
                                    </div>
                                    <div class="w-24">
                                        <input 
                                            type="number" 
                                            x-model="tier.min_quantity"
                                            placeholder="Min Qty"
                                            min="1"
                                            class="input-field text-sm"
                                        >
                                    </div>
                                    <div class="w-32">
                                        <div class="relative">
                                            <span class="absolute left-2 top-1/2 transform -translate-y-1/2 text-xs text-neutral-500">Rp</span>
                                            <input 
                                                type="number" 
                                                x-model="tier.price"
                                                placeholder="Harga"
                                                min="0"
                                                step="100"
                                                class="input-field text-sm pl-8"
                                            >
                                        </div>
                                    </div>
                                    <button 
                                        type="button" 
                                        @click="removeTierPrice(index)"
                                        class="p-2 text-red-600 hover:text-red-800 transition-colors"
                                    >
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Settings -->
            <div class="card p-6">
                <h3 class="text-lg font-semibold text-neutral-900 mb-4">Pengaturan Produk</h3>
                
                <div class="space-y-4">
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="is_featured" 
                            value="1"
                            {{ old('is_featured') ? 'checked' : '' }}
                            class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-neutral-300 rounded"
                        >
                        <span class="ml-2 text-sm text-neutral-700">Tandai sebagai produk unggulan</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Product Image -->
            <div class="card p-6">
                <h3 class="text-lg font-semibold text-neutral-900 mb-4">Gambar Produk</h3>
                
                <div class="space-y-4">
                    <div class="border-2 border-dashed border-neutral-300 rounded-lg p-6 text-center">
                        <input 
                            type="file" 
                            name="image" 
                            id="image"
                            accept="image/*"
                            class="hidden"
                            @change="handleImageUpload"
                        >
                        <label for="image" class="cursor-pointer">
                            <svg class="h-12 w-12 text-neutral-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-sm text-neutral-600">Klik untuk upload gambar</p>
                            <p class="text-xs text-neutral-500 mt-1">PNG, JPG, JPEG (Max 2MB)</p>
                        </label>
                    </div>
                    
                    <div x-show="imagePreview" class="mt-4">
                        <img :src="imagePreview" alt="Preview" class="w-full h-48 object-cover rounded-lg">
                    </div>
                    
                    @error('image')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Actions -->
            <div class="card p-6">
                <h3 class="text-lg font-semibold text-neutral-900 mb-4">Aksi</h3>
                
                <div class="space-y-3">
                    <button type="submit" class="btn-primary w-full">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Produk
                    </button>
                    
                    <a href="{{ route('admin.products.index') }}" class="btn-outline w-full text-center">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden inputs for tier prices -->
    <template x-for="(tier, index) in tierPrices" :key="index">
        <input type="hidden" :name="`tier_prices[${index}][tier_name]`" :value="tier.tier_name">
        <input type="hidden" :name="`tier_prices[${index}][min_quantity]`" :value="tier.min_quantity">
        <input type="hidden" :name="`tier_prices[${index}][price]`" :value="tier.price">
    </template>
</form>

<script>
function productForm() {
    return {
        tierPrices: [],
        imagePreview: null,
        
        addTierPrice() {
            this.tierPrices.push({
                tier_name: '',
                min_quantity: 1,
                price: 0
            });
        },
        
        removeTierPrice(index) {
            this.tierPrices.splice(index, 1);
        },
        
        handleImageUpload(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    }
}
</script>
@endsection
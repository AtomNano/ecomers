@extends('layouts.admin.app')

@section('title', 'Tambah Produk - Grosir Berkat Ibu')

@section('content')
<div class="flex flex-col gap-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-neutral-900">Tambah Produk Baru</h1>
            <p class="text-neutral-600 mt-1">Tambahkan produk baru ke toko Anda dengan informasi detail dan sistem harga bertingkat.</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar Produk
        </a>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" x-data="productForm()">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Form -->
            <div class="lg:col-span-2 flex flex-col gap-8">
                <!-- Basic Information -->
                <div class="card p-6">
                    <h3 class="text-xl font-semibold text-neutral-900 mb-6">Informasi Dasar Produk</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-neutral-700 mb-2">Nama Produk <span class="text-red-500">*</span></label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name"
                                value="{{ old('name') }}"
                                class="form-input @error('name') border-red-500 @enderror"
                                placeholder="Contoh: Kopi Bubuk Premium"
                                required
                            >
                            @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-neutral-700 mb-2">Deskripsi Produk</label>
                            <textarea 
                                name="description" 
                                id="description"
                                rows="4"
                                class="form-textarea @error('description') border-red-500 @enderror"
                                placeholder="Jelaskan detail produk, manfaat, atau cara penggunaan"
                            >{{ old('description') }}</textarea>
                            @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category_id" class="block text-sm font-medium text-neutral-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                            <select 
                                name="category_id" 
                                id="category_id"
                                class="form-select @error('category_id') border-red-500 @enderror"
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
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="stock" class="block text-sm font-medium text-neutral-700 mb-2">Stok <span class="text-red-500">*</span></label>
                            <input 
                                type="number" 
                                name="stock" 
                                id="stock"
                                value="{{ old('stock', 0) }}"
                                min="0"
                                class="form-input @error('stock') border-red-500 @enderror"
                                required
                            >
                            @error('stock')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Pricing System -->
                <div class="card p-6">
                    <h3 class="text-xl font-semibold text-neutral-900 mb-6">Penetapan Harga</h3>
                    
                    <div class="space-y-6">
                        <!-- Basic Pricing -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div>
                                <label for="price_per_piece" class="block text-sm font-medium text-neutral-700 mb-2">Harga Eceran <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-neutral-500">Rp</span>
                                    <input 
                                        type="number" 
                                        name="price_per_piece" 
                                        id="price_per_piece"
                                        value="{{ old('price_per_piece') }}"
                                        min="0"
                                        step="100"
                                        class="form-input pl-10 @error('price_per_piece') border-red-500 @enderror"
                                        placeholder="0"
                                        required
                                    >
                                </div>
                                @error('price_per_piece')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="price_per_four" class="block text-sm font-medium text-neutral-700 mb-2">Harga 4+ (Opsional)</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-neutral-500">Rp</span>
                                    <input 
                                        type="number" 
                                        name="price_per_four" 
                                        id="price_per_four"
                                        value="{{ old('price_per_four') }}"
                                        min="0"
                                        step="100"
                                        class="form-input pl-10 @error('price_per_four') border-red-500 @enderror"
                                        placeholder="0"
                                    >
                                </div>
                                @error('price_per_four')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="price_per_dozen" class="block text-sm font-medium text-neutral-700 mb-2">Harga Lusin (Opsional)</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-neutral-500">Rp</span>
                                    <input 
                                        type="number" 
                                        name="price_per_dozen" 
                                        id="price_per_dozen"
                                        value="{{ old('price_per_dozen') }}"
                                        min="0"
                                        step="100"
                                        class="form-input pl-10 @error('price_per_dozen') border-red-500 @enderror"
                                        placeholder="0"
                                    >
                                </div>
                                @error('price_per_dozen')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Advanced Tier Pricing -->
                        <div class="border-t border-neutral-200 pt-6">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-md font-semibold text-neutral-900">Harga Bertingkat Lanjutan (Opsional)</h4>
                                <button 
                                    type="button" 
                                    @click="addTierPrice()"
                                    class="btn btn-sm btn-secondary"
                                >
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Tambah Tingkat
                                </button>
                            </div>
                            
                            <div class="space-y-4" x-ref="tierPrices">
                                <template x-for="(tier, index) in tierPrices" :key="index">
                                    <div class="flex flex-col sm:flex-row items-center gap-3 p-3 bg-neutral-50 rounded-lg border border-neutral-200">
                                        <div class="flex-1 w-full sm:w-auto">
                                            <label :for="`tier_name_${index}`" class="sr-only">Nama Tingkat</label>
                                            <input 
                                                type="text" 
                                                :name="`tier_prices[${index}][tier_name]`"
                                                :id="`tier_name_${index}`"
                                                x-model="tier.tier_name"
                                                placeholder="Nama Tingkat (e.g., Grosir, Kartonan)"
                                                class="form-input text-sm"
                                            >
                                        </div>
                                        <div class="w-full sm:w-32">
                                            <label :for="`min_quantity_${index}`" class="sr-only">Min. Kuantitas</label>
                                            <input 
                                                type="number" 
                                                :name="`tier_prices[${index}][min_quantity]`"
                                                :id="`min_quantity_${index}`"
                                                x-model="tier.min_quantity"
                                                placeholder="Min Qty"
                                                min="1"
                                                class="form-input text-sm"
                                            >
                                        </div>
                                        <div class="w-full sm:w-40">
                                            <label :for="`tier_price_${index}`" class="sr-only">Harga</label>
                                            <div class="relative">
                                                <span class="absolute left-2 top-1/2 transform -translate-y-1/2 text-xs text-neutral-500">Rp</span>
                                                <input 
                                                    type="number" 
                                                    :name="`tier_prices[${index}][price]`"
                                                    :id="`tier_price_${index}`"
                                                    x-model="tier.price"
                                                    placeholder="Harga"
                                                    min="0"
                                                    step="100"
                                                    class="form-input text-sm pl-8"
                                                >
                                            </div>
                                        </div>
                                        <button 
                                            type="button" 
                                            @click="removeTierPrice(index)"
                                            class="btn btn-sm btn-danger-text"
                                            title="Hapus Tingkat Harga"
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
                    <h3 class="text-xl font-semibold text-neutral-900 mb-4">Pengaturan Tambahan</h3>
                    
                    <div>
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="is_featured" 
                                value="1"
                                {{ old('is_featured') ? 'checked' : '' }}
                                class="form-checkbox h-5 w-5 text-primary-600 rounded focus:ring-primary-500"
                            >
                            <span class="text-sm font-medium text-neutral-700">Tandai sebagai produk unggulan</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="flex flex-col gap-8">
                <!-- Product Image -->
                <div class="card p-6">
                    <h3 class="text-xl font-semibold text-neutral-900 mb-4">Gambar Produk</h3>
                    
                    <div class="flex flex-col items-center justify-center border-2 border-dashed border-neutral-300 rounded-lg p-6 text-center hover:border-primary-400 transition-colors duration-200">
                        <input 
                            type="file" 
                            name="image" 
                            id="image"
                            accept="image/*"
                            class="hidden"
                            @change="handleImageUpload"
                        >
                        <label for="image" class="cursor-pointer">
                            <div x-show="!imagePreview">
                                <svg class="h-12 w-12 text-neutral-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-sm text-neutral-600">Klik untuk upload gambar</p>
                                <p class="text-xs text-neutral-500 mt-1">PNG, JPG, JPEG (Maks. 2MB)</p>
                            </div>
                            <div x-show="imagePreview" class="relative w-full h-48">
                                <img :src="imagePreview" alt="Pratinjau Gambar" class="w-full h-full object-cover rounded-lg">
                                <button type="button" @click.prevent="removeImage" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 text-xs">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </label>
                    </div>
                    
                    @error('image')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="card p-6">
                    <h3 class="text-xl font-semibold text-neutral-900 mb-4">Aksi</h3>
                    
                    <div class="flex flex-col gap-3">
                        <button type="submit" class="btn btn-primary w-full">
                            <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Simpan Produk
                        </button>
                        
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline w-full text-center">
                            <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
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
</div>

<script>
function productForm() {
    return {
        tierPrices: @json(old('tier_prices', [])),
        imagePreview: null,
        
        init() {
            // If old image exists, show it
            @if(old('image_url'))
                this.imagePreview = "{{ old('image_url') }}";
            @endif
        },

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
            } else {
                this.imagePreview = null;
            }
        },

        removeImage() {
            this.imagePreview = null;
            const fileInput = document.getElementById('image');
            if (fileInput) {
                fileInput.value = ''; // Clear the file input
            }
        }
    }
}
</script>
@endsection

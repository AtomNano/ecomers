@extends('layouts.app')

@section('title', $product->name . ' - Grosir Berkat Ibu')

@section('content')
<div x-data="{ 
    quantity: 1,
    selectedTab: 'description'
}" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Product Image & Info -->
    <div class="lg:col-span-2">
        <!-- Breadcrumb -->
        <div class="mb-6 flex items-center gap-2 text-sm text-gray-600">
            <a href="{{ route('home') }}" class="hover:text-emerald-600 transition">
                <i class="fas fa-home"></i> Home
            </a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('customer.products.index') }}" class="hover:text-emerald-600 transition">
                Produk
            </a>
            <i class="fas fa-chevron-right"></i>
            <span class="text-gray-800 font-semibold">{{ $product->name }}</span>
        </div>

        <!-- Main Image -->
        <div class="bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl overflow-hidden mb-6 h-96 lg:h-[500px] flex items-center justify-center shadow-lg">
            @if($product->image)
                <img src="{{ \Illuminate\Support\Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain">
            @else
                <i class="fas fa-image text-6xl text-gray-400"></i>
            @endif
        </div>

        <!-- Tabs -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="flex border-b">
                <button @click="selectedTab = 'description'" :class="selectedTab === 'description' ? 'bg-emerald-50 text-emerald-600 border-b-2 border-emerald-600' : 'text-gray-600 hover:text-gray-800'" class="flex-1 py-4 font-semibold transition">
                    <i class="fas fa-align-left"></i> Deskripsi
                </button>
                <button @click="selectedTab = 'specs'" :class="selectedTab === 'specs' ? 'bg-emerald-50 text-emerald-600 border-b-2 border-emerald-600' : 'text-gray-600 hover:text-gray-800'" class="flex-1 py-4 font-semibold transition">
                    <i class="fas fa-list"></i> Spesifikasi
                </button>
            </div>

            <div class="p-6">
                <!-- Description Tab -->
                <div x-show="selectedTab === 'description'" class="space-y-4">
                    <p class="text-gray-700 leading-relaxed text-lg">
                        {{ $product->description }}
                    </p>
                    
                    <div class="bg-emerald-50 border-l-4 border-emerald-600 p-4 rounded">
                        <p class="text-emerald-800 font-medium">
                            <i class="fas fa-lightbulb"></i> Tips: Produk ini lebih hemat jika dibeli dalam jumlah besar. 
                            Dapatkan harga spesial untuk pembelian {{ $product->box_item_count ?? 12 }}+ pcs.
                        </p>
                    </div>
                </div>

                <!-- Specs Tab -->
                <div x-show="selectedTab === 'specs'" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="border-b pb-3">
                            <p class="text-gray-600 text-sm">Kategori</p>
                            <p class="font-semibold text-gray-800">{{ $product->category->name ?? 'Umum' }}</p>
                        </div>
                        <div class="border-b pb-3">
                            <p class="text-gray-600 text-sm">Unit</p>
                            <p class="font-semibold text-gray-800">{{ $product->unit ?? 'Pcs' }}</p>
                        </div>
                        <div class="border-b pb-3">
                            <p class="text-gray-600 text-sm">Stok Tersedia</p>
                            <p class="font-semibold text-gray-800">{{ $product->stock }} {{ $product->unit ?? 'Pcs' }}</p>
                        </div>
                        <div class="border-b pb-3">
                            <p class="text-gray-600 text-sm">Min. Pembelian</p>
                            <p class="font-semibold text-gray-800">1 {{ $product->unit ?? 'Pcs' }}</p>
                        </div>
                        <div class="border-b pb-3">
                            <p class="text-gray-600 text-sm">Harga Unit</p>
                            <p class="font-semibold text-emerald-600 text-lg">Rp {{ number_format($product->price_unit, 0, ',', '.') }}</p>
                        </div>
                        <div class="border-b pb-3">
                            <p class="text-gray-600 text-sm">Diskon Grosir</p>
                            @php
                                $discountPercent = ($product->getDiscount() / $product->price_unit) * 100;
                            @endphp
                            <p class="font-semibold text-orange-600">{{ round($discountPercent) }}%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Purchase Info Sidebar -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-md overflow-hidden sticky top-24">
            <!-- Header -->
            <div class="bg-gradient-to-r from-emerald-600 to-teal-600 p-6 text-white">
                <h2 class="text-2xl font-bold mb-2">{{ $product->name }}</h2>
                <div class="flex items-center gap-2 mb-3">
                    <div class="flex text-yellow-300">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <span class="text-sm">(4.5/5)</span>
                </div>
                
                <!-- Stock Status -->
                <div class="flex items-center gap-2">
                    @if($product->stock > 20)
                        <span class="inline-block w-3 h-3 bg-green-400 rounded-full animate-pulse"></span>
                        <span>Stok Melimpah</span>
                    @elseif($product->stock > 0)
                        <span class="inline-block w-3 h-3 bg-yellow-400 rounded-full animate-pulse"></span>
                        <span>Terbatas ({{ $product->stock }} sisa)</span>
                    @else
                        <span class="inline-block w-3 h-3 bg-red-400 rounded-full"></span>
                        <span>Habis</span>
                    @endif
                </div>
            </div>

            <!-- Pricing -->
            <div class="p-6 border-b">
                <div class="mb-4">
                    <p class="text-gray-600 text-sm mb-1">Harga Per Unit</p>
                    <p class="text-4xl font-bold text-emerald-600 mb-2">
                        Rp {{ number_format($product->price_unit, 0, ',', '.') }}
                    </p>
                    <p class="text-xs text-gray-600">
                        <i class="fas fa-info-circle"></i> Hemat untuk {{ $product->box_item_count ?? 12 }}+ pcs
                    </p>
                </div>
            </div>

            <!-- Quantity Selector -->
            <div class="p-6 border-b">
                <label class="block text-sm font-bold text-gray-700 mb-3">Jumlah</label>
                <div class="flex items-center gap-2 mb-2">
                    <button @click="quantity = Math.max(1, quantity - 1)" class="w-10 h-10 rounded-lg border-2 border-gray-300 hover:border-emerald-500 hover:bg-emerald-50 transition font-bold">
                        <i class="fas fa-minus"></i>
                    </button>
                    <input type="number" x-model.number="quantity" min="1" class="flex-1 h-10 text-center border-2 border-gray-300 rounded-lg focus:border-emerald-500 focus:outline-none" @change="quantity = Math.max(1, quantity)">
                    <button @click="quantity++" class="w-10 h-10 rounded-lg border-2 border-gray-300 hover:border-emerald-500 hover:bg-emerald-50 transition font-bold">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <p class="text-xs text-gray-600">Min: 1 {{ $product->unit ?? 'Pcs' }}</p>
            </div>

            <!-- Price Summary -->
            <div class="p-6 border-b bg-gradient-to-b from-emerald-50 to-teal-50">
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-700">Subtotal:</span>
                        <span x-text="`Rp ${(parseInt(quantity) * {{ $product->price_unit }}).toLocaleString('id-ID')}`" class="font-bold text-lg text-emerald-600"></span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <form action="{{ route('customer.cart.add', $product) }}" method="POST" class="p-6 space-y-3">
                @csrf
                <input type="hidden" name="quantity" x-bind:value="quantity">
                
                @if($product->stock > 0)
                    <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold py-4 rounded-lg transition flex items-center justify-center gap-2 hover:shadow-lg">
                        <i class="fas fa-shopping-cart"></i> Tambah Keranjang
                    </button>
                @else
                    <button type="button" disabled class="w-full bg-gray-400 text-white font-bold py-4 rounded-lg cursor-not-allowed">
                        Stok Habis
                    </button>
                @endif

                <button type="button" class="w-full border-2 border-emerald-600 text-emerald-600 font-bold py-3 rounded-lg hover:bg-emerald-50 transition flex items-center justify-center gap-2">
                    <i class="fas fa-heart"></i> Wishlist
                </button>
            </form>

            <!-- Additional Info -->
            <div class="bg-blue-50 border-t p-4 text-sm text-blue-700 space-y-2">
                <p><i class="fas fa-truck"></i> Gratis ongkir untuk pembelian > Rp 500.000</p>
                <p><i class="fas fa-shield-alt"></i> Garansi keaslian 100%</p>
                <p><i class="fas fa-undo"></i> Bisa retur dalam 7 hari</p>
            </div>
        </div>
    </div>
</div>

<!-- Related Products -->
<div class="mt-16">
    <h3 class="text-3xl font-bold mb-8 flex items-center gap-3">
        <i class="fas fa-boxes text-emerald-600"></i> Produk Serupa
    </h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $related = \App\Models\Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->limit(4)->get();
        @endphp
        @forelse($related as $rel)
            <div class="group bg-white rounded-xl overflow-hidden shadow-md hover:shadow-2xl transition transform hover:scale-105">
                <div class="relative bg-gray-100 h-48 overflow-hidden">
                    @if($rel->image)
                        <img src="{{ asset('storage/' . $rel->image) }}" alt="{{ $rel->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fas fa-image text-3xl text-gray-400"></i>
                        </div>
                    @endif
                    <span class="absolute top-3 right-3 bg-emerald-600 text-white px-2 py-1 rounded text-xs font-bold">
                        {{ $rel->category->name ?? 'Umum' }}
                    </span>
                </div>
                
                <div class="p-4">
                    <h4 class="font-bold text-gray-800 mb-2 line-clamp-2 group-hover:text-emerald-600">{{ $rel->name }}</h4>
                    <p class="text-emerald-600 font-bold text-lg mb-3">Rp {{ number_format($rel->price_unit, 0, ',', '.') }}</p>
                    
                    <a href="{{ route('customer.products.show', $rel) }}" class="block w-full bg-emerald-600 hover:bg-emerald-700 text-white py-2 rounded-lg text-center font-semibold transition">
                        <i class="fas fa-eye"></i> Lihat
                    </a>
                </div>
            </div>
        @empty
            <p class="col-span-4 text-center text-gray-600">Tidak ada produk terkait</p>
        @endforelse
    </div>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection

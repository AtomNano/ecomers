<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold">Detail Produk: {{ $product->name }}</h1>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Edit
                            </a>
                            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Kembali
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Product Image -->
                        <div>
                            <div class="aspect-w-1 aspect-h-1 w-full">
                                <img src="{{ $product->image ? asset('storage/products/' . $product->image) : 'https://placehold.co/600x600/f3f4f6/374151?text=Produk' }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-96 object-center object-cover rounded-lg">
                            </div>
                        </div>

                        <!-- Product Details -->
                        <div class="space-y-6">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900">{{ $product->name }}</h2>
                                <p class="text-sm text-gray-500">Kategori: {{ $product->category->name ?? 'Tidak ada kategori' }}</p>
                            </div>

                            @if($product->description)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Deskripsi</h3>
                                <p class="mt-1 text-gray-600">{{ $product->description }}</p>
                            </div>
                            @endif

                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Harga</h3>
                                <div class="mt-2 space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Harga Satuan (per pcs):</span>
                                        <span class="text-sm font-medium text-gray-900">Rp {{ number_format($product->price_per_piece, 0, ',', '.') }}</span>
                                    </div>
                                    @if($product->price_per_four)
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Harga Grosir (> 4 pcs):</span>
                                        <span class="text-sm font-medium text-gray-900">Rp {{ number_format($product->price_per_four, 0, ',', '.') }}</span>
                                    </div>
                                    @endif
                                    @if($product->price_per_dozen)
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Harga per Lusin/Dus:</span>
                                        <span class="text-sm font-medium text-gray-900">Rp {{ number_format($product->price_per_dozen, 0, ',', '.') }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Informasi Stok</h3>
                                <div class="mt-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        @if($product->stock > 10) bg-green-100 text-green-800
                                        @elseif($product->stock > 0) bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $product->stock }} pcs tersedia
                                    </span>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Status</h3>
                                <div class="mt-2 space-y-2">
                                    <div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($product->is_featured) bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            @if($product->is_featured) Produk Unggulan @else Produk Normal @endif
                                        </span>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-600">Total Penjualan: {{ $product->sales_count }} pcs</span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Informasi Produk</h3>
                                <div class="mt-2 space-y-1 text-sm text-gray-600">
                                    <div>Dibuat: {{ $product->created_at->format('d M Y H:i') }}</div>
                                    <div>Diperbarui: {{ $product->updated_at->format('d M Y H:i') }}</div>
                                    <div>Slug: {{ $product->slug }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>




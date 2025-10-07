@extends('layouts.frontend.app')

@section('title', $product->name . ' - Grosir Berkat Ibu')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-x-8 lg:items-start">
            <!-- Image -->
            <div class="flex flex-col-reverse">
                <div class="aspect-w-1 aspect-h-1 w-full">
                    <img src="{{ $product->image ? asset('storage/products/' . $product->image) : 'https://placehold.co/600x600/f3f4f6/374151?text=Produk' }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-96 object-center object-cover sm:rounded-lg">
                </div>
            </div>

            <!-- Product info -->
            <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">{{ $product->name }}</h1>
                <p class="mt-3 text-lg text-gray-500">{{ $product->category->name ?? 'Kategori' }}</p>

                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900">Harga:</h3>
                    <div class="mt-4 space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Harga Satuan (per pcs):</span>
                            <span class="text-sm font-medium text-gray-900">Rp {{ number_format($product->price_per_piece, 0, ',', '.') }}</span>
                        </div>
                        @if($product->price_per_four)
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Harga Lebih dari 4:</span>
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

                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900">Stok:</h3>
                    <p class="mt-2 text-sm text-gray-600">{{ $product->stock }} pcs tersedia</p>
                </div>

                @if($product->description)
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900">Deskripsi:</h3>
                    <div class="mt-2 text-sm text-gray-600">
                        {{ $product->description }}
                    </div>
                </div>
                @endif

                <div class="mt-8">
                    @auth
                    <form action="{{ route('cart.add') }}" method="POST" class="flex items-center space-x-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div>
                            <label for="quantity" class="sr-only">Quantity</label>
                            <input type="number" 
                                   id="quantity" 
                                   name="quantity" 
                                   min="1" 
                                   max="{{ $product->stock }}" 
                                   value="1" 
                                   class="w-20 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <button type="submit" 
                                class="flex-1 bg-indigo-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Tambah ke Keranjang
                        </button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" 
                       class="w-full bg-gray-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Login untuk Beli
                    </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Related products -->
        @if($relatedProducts->count() > 0)
        <div class="mt-16">
            <h2 class="text-2xl font-extrabold text-gray-900">Produk Terkait</h2>
            <div class="mt-8 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                @foreach($relatedProducts as $relatedProduct)
                <div class="group relative">
                    <div class="w-full aspect-w-1 aspect-h-1 bg-gray-200 rounded-lg overflow-hidden group-hover:opacity-75">
                        <img src="{{ $relatedProduct->image ? asset('storage/products/' . $relatedProduct->image) : 'https://placehold.co/400x400/f3f4f6/374151?text=Produk' }}" 
                             alt="{{ $relatedProduct->name }}" 
                             class="w-full h-full object-center object-cover">
                    </div>
                    <div class="mt-4 flex justify-between">
                        <div>
                            <h3 class="text-sm text-gray-700">
                                <a href="{{ route('products.show', $relatedProduct) }}">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    {{ $relatedProduct->name }}
                                </a>
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">{{ $relatedProduct->category->name ?? 'Kategori' }}</p>
                        </div>
                        <p class="text-sm font-medium text-gray-900">Rp {{ number_format($relatedProduct->price_per_piece, 0, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection





@extends('layouts.frontend.app')

@section('title', 'Produk - Grosir Berkat Ibu')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-3xl font-extrabold text-gray-900">Semua Produk</h1>
            <p class="mt-4 text-lg text-gray-500">Temukan produk terbaik dengan harga grosir</p>
        </div>

        <div class="mt-12 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
            @forelse($products as $product)
            <div class="group relative">
                <div class="w-full aspect-w-1 aspect-h-1 bg-gray-200 rounded-lg overflow-hidden group-hover:opacity-75">
                    <img src="{{ $product->image ? asset('storage/products/' . $product->image) : 'https://placehold.co/400x400/f3f4f6/374151?text=Produk' }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-full object-center object-cover">
                </div>
                <div class="mt-4 flex justify-between">
                    <div>
                        <h3 class="text-sm text-gray-700">
                            <a href="{{ route('products.show', $product) }}">
                                <span aria-hidden="true" class="absolute inset-0"></span>
                                {{ $product->name }}
                            </a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">{{ $product->category->name ?? 'Kategori' }}</p>
                    </div>
                    <p class="text-sm font-medium text-gray-900">Rp {{ number_format($product->price_per_piece, 0, ',', '.') }}</p>
                </div>
                <div class="mt-2">
                    @auth
                    <form action="{{ route('cart.add') }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="bg-indigo-600 text-white px-3 py-1 rounded text-sm hover:bg-indigo-700">
                            Tambah ke Keranjang
                        </button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="bg-gray-600 text-white px-3 py-1 rounded text-sm hover:bg-gray-700">
                        Login untuk Beli
                    </a>
                    @endauth
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500">Belum ada produk tersedia.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection







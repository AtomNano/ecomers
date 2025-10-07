@extends('layouts.frontend.app')

@section('title', 'Keranjang - Grosir Berkat Ibu')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Keranjang Belanja</h1>

        @if($cartItems->count() > 0)
        <div class="mt-8 lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start xl:gap-x-16">
            <section aria-labelledby="cart-heading" class="lg:col-span-7">
                <h2 id="cart-heading" class="sr-only">Items in your shopping cart</h2>

                <ul role="list" class="border-t border-b border-gray-200 divide-y divide-gray-200">
                    @foreach($cartItems as $item)
                    <li class="flex py-6 sm:py-10">
                        <div class="flex-shrink-0">
                            <img src="{{ $item->product->image ? asset('storage/products/' . $item->product->image) : 'https://placehold.co/200x200/f3f4f6/374151?text=Produk' }}" 
                                 alt="{{ $item->product->name }}" 
                                 class="w-24 h-24 rounded-md object-center object-cover sm:w-48 sm:h-48">
                        </div>

                        <div class="ml-4 flex-1 flex flex-col justify-between sm:ml-6">
                            <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                                <div>
                                    <div class="flex justify-between">
                                        <h3 class="text-sm">
                                            <a href="{{ route('products.show', $item->product) }}" class="font-medium text-gray-700 hover:text-gray-800">
                                                {{ $item->product->name }}
                                            </a>
                                        </h3>
                                    </div>
                                    <div class="mt-1 flex text-sm">
                                        <p class="text-gray-500">{{ $item->product->category->name ?? 'Kategori' }}</p>
                                    </div>
                                    <p class="mt-1 text-sm font-medium text-gray-900">Rp {{ number_format($item->product->price_per_piece, 0, ',', '.') }}</p>
                                </div>

                                <div class="mt-4 sm:mt-0 sm:pr-9">
                                    <label for="quantity-{{ $item->id }}" class="sr-only">Quantity, {{ $item->product->name }}</label>
                                    <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center space-x-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" 
                                               id="quantity-{{ $item->id }}" 
                                               name="quantity" 
                                               min="1" 
                                               max="{{ $item->product->stock }}" 
                                               value="{{ $item->quantity }}" 
                                               class="w-16 px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        <button type="submit" class="text-indigo-600 hover:text-indigo-500 text-sm">
                                            Update
                                        </button>
                                    </form>

                                    <div class="absolute top-0 right-0">
                                        <form action="{{ route('cart.destroy', $item) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="-m-2 inline-flex p-2 text-gray-400 hover:text-gray-500">
                                                <span class="sr-only">Remove</span>
                                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <p class="mt-4 flex text-sm text-gray-700 space-x-2">
                                <span>Subtotal: Rp {{ number_format($item->quantity * $item->product->price_per_piece, 0, ',', '.') }}</span>
                            </p>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </section>

            <!-- Order summary -->
            <section aria-labelledby="summary-heading" class="mt-16 bg-gray-50 rounded-lg px-4 py-6 sm:p-6 lg:p-8 lg:mt-0 lg:col-span-5">
                <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Ringkasan Pesanan</h2>

                <dl class="mt-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <dt class="text-sm text-gray-600">Subtotal</dt>
                        <dd class="text-sm font-medium text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</dd>
                    </div>
                    <div class="border-t border-gray-200 pt-4 flex items-center justify-between">
                        <dt class="text-base font-medium text-gray-900">Total</dt>
                        <dd class="text-base font-medium text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</dd>
                    </div>
                </dl>

                <div class="mt-6">
                    <a href="{{ route('checkout.index') }}" 
                       class="w-full bg-indigo-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Checkout
                    </a>
                </div>

                <div class="mt-6 text-center">
                    <a href="{{ route('products.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                        Lanjutkan Belanja
                    </a>
                </div>
            </section>
        </div>
        @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Keranjang kosong</h3>
            <p class="mt-1 text-sm text-gray-500">Mulai belanja untuk menambahkan produk ke keranjang.</p>
            <div class="mt-6">
                <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    Mulai Belanja
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection





@extends('layouts.frontend.app')

@section('title', 'Checkout - Grosir Berkat Ibu')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Checkout</h1>

        <form action="{{ route('checkout.process') }}" method="POST" class="mt-8 lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start xl:gap-x-16">
            @csrf
            
            <section aria-labelledby="cart-heading" class="lg:col-span-7">
                <h2 id="cart-heading" class="text-lg font-medium text-gray-900">Pesanan Anda</h2>

                <ul role="list" class="mt-6 border-t border-b border-gray-200 divide-y divide-gray-200">
                    @foreach($cartItems as $item)
                    <li class="flex py-6">
                        <div class="flex-shrink-0">
                            <img src="{{ $item->product->image ? asset('storage/products/' . $item->product->image) : 'https://placehold.co/100x100/f3f4f6/374151?text=Produk' }}" 
                                 alt="{{ $item->product->name }}" 
                                 class="w-24 h-24 rounded-md object-center object-cover">
                        </div>

                        <div class="ml-4 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between">
                                    <h3 class="text-sm">
                                        <span class="font-medium text-gray-700">{{ $item->product->name }}</span>
                                    </h3>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                                <p class="mt-1 text-sm font-medium text-gray-900">Rp {{ number_format($item->product->price_per_piece, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>

                <!-- Shipping Address -->
                <div class="mt-8">
                    <h2 class="text-lg font-medium text-gray-900">Alamat Pengiriman</h2>
                    <div class="mt-4 bg-gray-50 p-4 rounded-md">
                        <p class="text-sm text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-sm text-gray-600">{{ auth()->user()->address }}</p>
                        <p class="text-sm text-gray-600">{{ auth()->user()->city }}, {{ auth()->user()->province }}</p>
                        <p class="text-sm text-gray-600">{{ auth()->user()->phone_number }}</p>
                    </div>
                </div>

                <!-- Courier -->
                <div class="mt-8">
                    <h2 class="text-lg font-medium text-gray-900">Kurir</h2>
                    <div class="mt-4 space-y-4">
                        <div class="flex items-center">
                            <input id="jne" name="courier" type="radio" value="JNE" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                            <label for="jne" class="ml-3 block text-sm font-medium text-gray-700">JNE</label>
                        </div>
                        <div class="flex items-center">
                            <input id="tiki" name="courier" type="radio" value="TIKI" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                            <label for="tiki" class="ml-3 block text-sm font-medium text-gray-700">TIKI</label>
                        </div>
                        <div class="flex items-center">
                            <input id="pos" name="courier" type="radio" value="POS" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                            <label for="pos" class="ml-3 block text-sm font-medium text-gray-700">POS Indonesia</label>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="mt-8">
                    <h2 class="text-lg font-medium text-gray-900">Metode Pembayaran</h2>
                    <div class="mt-4 space-y-4">
                        <div class="flex items-center">
                            <input id="transfer" name="payment_method" type="radio" value="transfer" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                            <label for="transfer" class="ml-3 block text-sm font-medium text-gray-700">Transfer Bank</label>
                        </div>
                        <div class="flex items-center">
                            <input id="qris" name="payment_method" type="radio" value="qris" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                            <label for="qris" class="ml-3 block text-sm font-medium text-gray-700">QRIS</label>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Order summary -->
            <section aria-labelledby="summary-heading" class="mt-16 bg-gray-50 rounded-lg px-4 py-6 sm:p-6 lg:p-8 lg:mt-0 lg:col-span-5">
                <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Ringkasan Pesanan</h2>

                <dl class="mt-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <dt class="text-sm text-gray-600">Subtotal</dt>
                        <dd class="text-sm font-medium text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-sm text-gray-600">Ongkir</dt>
                        <dd class="text-sm font-medium text-gray-900">Rp 0</dd>
                    </div>
                    <div class="border-t border-gray-200 pt-4 flex items-center justify-between">
                        <dt class="text-base font-medium text-gray-900">Total</dt>
                        <dd class="text-base font-medium text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</dd>
                    </div>
                </dl>

                <div class="mt-6">
                    <button type="submit" 
                            class="w-full bg-indigo-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Proses Pesanan
                    </button>
                </div>

                <div class="mt-6 text-center">
                    <a href="{{ route('cart.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                        Kembali ke Keranjang
                    </a>
                </div>
            </section>
        </form>
    </div>
</div>
@endsection





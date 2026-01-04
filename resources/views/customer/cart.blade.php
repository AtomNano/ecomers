@extends('layouts.app')

@section('title', 'Keranjang Belanja - Grosir Berkat Ibu')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Cart Items -->
    <div class="lg:col-span-2">
        <h1 class="text-4xl font-bold mb-8 flex items-center gap-3">
            <i class="fas fa-shopping-cart text-emerald-600"></i> Keranjang Belanja
        </h1>

        @if($cartItems->count() > 0)
            <div class="space-y-4">
                @foreach($cartItems as $item)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-6">
                        <div class="flex flex-col md:flex-row gap-6">
                            <!-- Product Image -->
                            <div class="w-full md:w-32 h-32 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                @if($item->product->image)
                                    <img src="{{ \Illuminate\Support\Str::startsWith($item->product->image, 'http') ? $item->product->image : asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded-lg">
                                @else
                                    <i class="fas fa-image text-4xl text-gray-400"></i>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div class="flex-1">
                                <a href="{{ route('customer.products.show', $item->product) }}" class="text-xl font-bold text-emerald-600 hover:text-emerald-700 transition">
                                    {{ $item->product->name }}
                                </a>
                                <p class="text-gray-600 text-sm mt-1">{{ $item->product->category->name ?? 'Umum' }}</p>
                                
                                <!-- Price Info -->
                                <div class="mt-3 bg-gradient-to-r from-emerald-50 to-teal-50 p-3 rounded-lg">
                                    <p class="text-sm text-gray-700">
                                        Harga: <span class="font-bold text-emerald-600">Rp {{ number_format($item->price_calculated, 0, ',', '.') }}/pcs</span>
                                    </p>
                                    <p class="text-xs text-gray-600 mt-1">
                                        Tier: 
                                        @if($item->active_tier === 'unit')
                                            <span class="inline-block bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">Satuan</span>
                                        @elseif($item->active_tier === 'bulk_4')
                                            <span class="inline-block bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">Grosir (4+)</span>
                                        @elseif($item->active_tier === 'dozen')
                                            <span class="inline-block bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Dus (12+)</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Quantity & Total -->
                            <div class="md:flex md:flex-col md:justify-between md:items-end">
                                <div class="mb-4 md:mb-0">
                                    <label class="text-sm text-gray-600 font-medium">Jumlah</label>
                                    <form action="{{ route('customer.cart.update', $item) }}" method="POST" class="flex items-center gap-2 mt-2">
                                        @csrf
                                        @method('PUT')
                                        <button type="button" onclick="decreaseQty(this)" class="w-8 h-8 border-2 border-gray-300 rounded-lg hover:border-emerald-500 hover:bg-emerald-50 transition font-bold">
                                            <i class="fas fa-minus text-sm"></i>
                                        </button>
                                        <input type="number" name="quantity" min="1" max="{{ $item->product->stock }}" value="{{ $item->quantity }}" class="w-16 text-center border-2 border-gray-300 rounded-lg focus:border-emerald-500 focus:outline-none" onchange="this.form.submit()">
                                        <button type="button" onclick="increaseQty(this)" class="w-8 h-8 border-2 border-gray-300 rounded-lg hover:border-emerald-500 hover:bg-emerald-50 transition font-bold">
                                            <i class="fas fa-plus text-sm"></i>
                                        </button>
                                    </form>
                                </div>

                                <div class="text-right">
                                    <p class="text-sm text-gray-600">Subtotal</p>
                                    <p class="text-2xl font-bold text-emerald-600 mt-1">
                                        Rp {{ number_format($item->total_price, 0, ',', '.') }}
                                    </p>
                                    <form action="{{ route('customer.cart.remove', $item) }}" method="POST" class="mt-3">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-semibold transition" onclick="return confirm('Hapus item ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Continue Shopping Button -->
            <div class="mt-8">
                <a href="{{ route('customer.products.index') }}" class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 font-semibold transition">
                    <i class="fas fa-arrow-left"></i> Lanjut Belanja
                </a>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="bg-white rounded-xl shadow-md p-12 text-center">
                <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Keranjang Kosong</h3>
                <p class="text-gray-600 mb-6">Yuk mulai belanja produk grosir berkualitas dari kami!</p>
                <a href="{{ route('customer.products.index') }}" class="inline-block px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg transition">
                    <i class="fas fa-shopping-bag"></i> Mulai Belanja
                </a>
            </div>
        @endif
    </div>

    <!-- Order Summary Sidebar -->
    @if($cartItems->count() > 0)
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-md p-6 sticky top-24 max-h-[calc(100vh-150px)] overflow-y-auto">
                <h3 class="text-2xl font-bold mb-6 flex items-center gap-2">
                    <i class="fas fa-receipt text-emerald-600"></i> Ringkasan
                </h3>

                <!-- Items Summary -->
                <div class="border-b pb-4 mb-4">
                    <div class="space-y-2 mb-4">
                        @foreach($cartItems as $item)
                            <div class="flex justify-between text-sm text-gray-700">
                                <span>{{ $item->product->name }} × {{ $item->quantity }}</span>
                                <span class="font-semibold">Rp {{ number_format($item->total_price, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Price Breakdown -->
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-gray-700">
                        <span>Subtotal:</span>
                        <span class="font-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-700">
                        <span>Ongkos Kirim:</span>
                        <span class="font-semibold text-emerald-600">Gratis*</span>
                    </div>
                    <div class="flex justify-between text-gray-700 text-sm">
                        <span>*min. Rp 500.000</span>
                    </div>
                </div>

                <!-- Total -->
                <div class="bg-gradient-to-r from-emerald-100 to-teal-100 rounded-lg p-4 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-gray-800">Total:</span>
                        <span class="text-3xl font-bold text-emerald-600">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border-l-4 border-blue-500 p-3 rounded mb-6 text-sm text-blue-700">
                    <p><i class="fas fa-info-circle"></i> Harga otomatis berubah sesuai jumlah pembelian!</p>
                </div>

                <!-- Checkout Button -->
                <a href="{{ route('customer.checkout.index') }}" class="block w-full bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold py-4 rounded-lg transition text-center mb-3 flex items-center justify-center gap-2">
                    <i class="fas fa-lock"></i> Lanjut Checkout
                </a>

                <!-- Clear Cart -->
                <form action="{{ route('customer.cart.clear') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full border-2 border-red-300 text-red-600 font-semibold py-2 rounded-lg hover:bg-red-50 transition" onclick="return confirm('Hapus semua item?')">
                        <i class="fas fa-trash"></i> Kosongkan Keranjang
                    </button>
                </form>
            </div>
        </div>
    @endif
</div>

<script>
    function increaseQty(btn) {
        const input = btn.parentElement.querySelector('input[type="number"]');
        input.value = Math.min(parseInt(input.value) + 1, parseInt(input.max));
        input.form.submit();
    }

    function decreaseQty(btn) {
        const input = btn.parentElement.querySelector('input[type="number"]');
        input.value = Math.max(parseInt(input.value) - 1, 1);
        input.form.submit();
    }
</script>
@endsection

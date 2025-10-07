 @extends('layouts.frontend.app')

 @section('title', 'Selamat Datang di Grosir Berkat Ibu')

 @section('content')
<div class="bg-white">
    <main>
        <!-- Hero -->
        <div class="bg-indigo-700">
            <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">Grosir Berkat Ibu</h1>
                <p class="mt-4 text-xl text-indigo-200">Solusi Kebutuhan Harian Anda dengan Harga Grosir</p>
                <a href="{{ route('products.index') }}" class="mt-8 w-full inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 sm:w-auto">
                    Belanja Sekarang
                </a>
            </div>
        </div>

        <!-- Featured Products -->
        <section aria-labelledby="trending-heading" class="bg-white">
            <div class="py-16 sm:py-24 lg:max-w-7xl lg:mx-auto lg:py-32 lg:px-8">
                <div class="px-4 flex items-center justify-between sm:px-6 lg:px-0">
                    <h2 id="trending-heading" class="text-2xl font-extrabold tracking-tight text-gray-900">Barang Terlaris</h2>
                </div>

                <div class="mt-8 grid grid-cols-1 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
                    @foreach ($featuredProducts as $product)
                    <div class="relative">
                        <div class="relative w-full h-72 rounded-lg overflow-hidden">
                            <img src="{{ $product->image ? asset('storage/products/' . $product->image) : 'https://placehold.co/400x400/f3f4f6/374151?text=Produk' }}" alt="{{ $product->name }}" class="w-full h-full object-center object-cover">
                        </div>
                        <div class="relative mt-4">
                            <h3 class="text-sm font-medium text-gray-900">{{ $product->name }}</h3>
                            <p class="mt-1 text-sm text-gray-500">{{ $product->category->name }}</p>
                        </div>
                        <div class="absolute top-0 inset-x-0 h-72 rounded-lg p-4 flex items-end justify-end overflow-hidden">
                            <div aria-hidden="true" class="absolute inset-x-0 bottom-0 h-36 bg-gradient-to-t from-black opacity-50"></div>
                            <p class="relative text-lg font-semibold text-white">Rp {{ number_format($product->price_per_piece, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Newest Products -->
        <section aria-labelledby="new-heading" class="bg-gray-50">
            <div class="py-16 sm:py-24 lg:max-w-7xl lg:mx-auto lg:py-32 lg:px-8">
                <div class="px-4 flex items-center justify-between sm:px-6 lg:px-0">
                    <h2 id="new-heading" class="text-2xl font-extrabold tracking-tight text-gray-900">Barang Terbaru</h2>
                </div>

                <div class="mt-8 grid grid-cols-1 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
                     {{-- Loop for newest products --}}
                    @foreach ($newestProducts as $product)
                    <div class="relative">
                        <div class="relative w-full h-72 rounded-lg overflow-hidden">
                            <img src="{{ $product->image ? asset('storage/products/' . $product->image) : 'https://placehold.co/400x400/e5e7eb/4b5563?text=Produk' }}" alt="{{ $product->name }}" class="w-full h-full object-center object-cover">
                        </div>
                        <div class="relative mt-4">
                            <h3 class="text-sm font-medium text-gray-900">{{ $product->name }}</h3>
                            <p class="mt-1 text-sm text-gray-500">{{ $product->category->name }}</p>
                        </div>
                        <div class="absolute top-0 inset-x-0 h-72 rounded-lg p-4 flex items-end justify-end overflow-hidden">
                            <div aria-hidden="true" class="absolute inset-x-0 bottom-0 h-36 bg-gradient-to-t from-black opacity-50"></div>
                            <p class="relative text-lg font-semibold text-white">Rp {{ number_format($product->price_per_piece, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        
        <!-- Location Section -->
        <section aria-labelledby="location-heading" class="bg-white">
            <div class="max-w-7xl mx-auto py-24 px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900" id="location-heading">Lokasi Kami</h2>
                    <p class="mt-4 text-lg text-gray-500">Kunjungi toko fisik kami di Padang, Sumatera Barat.</p>
                    <div class="mt-8">
                                             </div>
                </div>
            </div>
        </section>

    </main>
</div>
 @endsection

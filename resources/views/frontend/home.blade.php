@extends('layouts.frontend.app')

@section('title', 'Grosir Berkat Ibu - Platform Grosir Digital Terpercaya')
@section('description', 'Platform grosir digital terpercaya dengan sistem harga bertingkat yang fleksibel. Transaksi mudah, harga kompetitif, dan pengiriman cepat.')

@section('content')
<!-- Hero Section -->
<section class="hero-gradient text-white">
    <div class="container-custom section-padding">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-4xl lg:text-6xl font-bold mb-6 leading-tight">
                    Platform Grosir Digital
                    <span class="text-secondary-300">Terpercaya</span>
                </h1>
                <p class="text-xl text-primary-100 mb-8 leading-relaxed">
                    Sistem harga bertingkat yang fleksibel, transaksi mudah, dan pengiriman cepat 
                    untuk kebutuhan bisnis Anda. Dari WhatsApp ke platform digital profesional.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('products.index') }}" class="btn-secondary text-lg px-8 py-4">
                        Mulai Belanja
                    </a>
                    <a href="{{ route('about') }}" class="btn-outline border-white text-white hover:bg-white hover:text-primary-600 text-lg px-8 py-4">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
            <div class="relative">
                <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-8">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white bg-opacity-20 rounded-lg p-4 text-center">
                            <div class="text-3xl font-bold mb-2">500+</div>
                            <div class="text-sm text-primary-100">Produk Tersedia</div>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-lg p-4 text-center">
                            <div class="text-3xl font-bold mb-2">1000+</div>
                            <div class="text-sm text-primary-100">Pelanggan Aktif</div>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-lg p-4 text-center">
                            <div class="text-3xl font-bold mb-2">24/7</div>
                            <div class="text-sm text-primary-100">Layanan Pelanggan</div>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-lg p-4 text-center">
                            <div class="text-3xl font-bold mb-2">99%</div>
                            <div class="text-sm text-primary-100">Kepuasan Pelanggan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="section-padding bg-white">
    <div class="container-custom">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-neutral-900 mb-4">Kategori Produk</h2>
            <p class="text-lg text-neutral-600 max-w-2xl mx-auto">
                Temukan berbagai kategori produk berkualitas dengan harga terbaik
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @foreach($categories as $category)
            <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
               class="group card-hover p-6 text-center">
                <div class="w-16 h-16 bg-primary-100 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-primary-200 transition-colors">
                    <svg class="h-8 w-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-neutral-900 group-hover:text-primary-600 transition-colors">
                    {{ $category->name }}
                </h3>
                <p class="text-sm text-neutral-500 mt-1">
                    {{ $category->products_count ?? 0 }} produk
                </p>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="section-padding bg-neutral-50">
    <div class="container-custom">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-neutral-900 mb-4">Produk Unggulan</h2>
            <p class="text-lg text-neutral-600 max-w-2xl mx-auto">
                Produk terbaik dengan kualitas premium dan harga kompetitif
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
            <div class="card-hover group">
                <div class="relative overflow-hidden">
                    <img 
                        src="{{ $product->image ? asset('storage/products/' . $product->image) : 'https://placehold.co/400x300/f3f4f6/374151?text=Produk' }}" 
                        alt="{{ $product->name }}"
                        class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                    >
                    @if($product->is_featured)
                    <div class="absolute top-3 left-3">
                        <span class="badge-primary">Unggulan</span>
                    </div>
                    @endif
                    <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button class="w-10 h-10 bg-white rounded-full shadow-soft flex items-center justify-center hover:bg-primary-50 transition-colors">
                            <svg class="h-5 w-5 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-neutral-500">{{ $product->category->name ?? 'Kategori' }}</span>
                        <div class="flex items-center text-yellow-400">
                            <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                            <span class="text-sm text-neutral-500 ml-1">4.8</span>
                        </div>
                    </div>
                    <h3 class="font-semibold text-neutral-900 mb-2 line-clamp-2">{{ $product->name }}</h3>
                    <div class="space-y-1 mb-4">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-neutral-500">Eceran:</span>
                            <span class="font-semibold text-primary-600">Rp {{ number_format($product->price_per_piece) }}</span>
                        </div>
                        @if($product->price_per_four)
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-neutral-500">4+:</span>
                            <span class="font-semibold text-green-600">Rp {{ number_format($product->price_per_four) }}</span>
                        </div>
                        @endif
                        @if($product->price_per_dozen)
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-neutral-500">Lusin:</span>
                            <span class="font-semibold text-green-600">Rp {{ number_format($product->price_per_dozen) }}</span>
                        </div>
                        @endif
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-neutral-500">Stok: {{ $product->stock }}</span>
                        <a href="{{ route('products.show', $product->slug) }}" class="btn-primary text-sm px-4 py-2">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('products.index') }}" class="btn-outline">
                Lihat Semua Produk
            </a>
        </div>
    </div>
</section>

<!-- Best Sellers Section -->
<section class="section-padding bg-white">
    <div class="container-custom">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-neutral-900 mb-4">Produk Terlaris</h2>
            <p class="text-lg text-neutral-600 max-w-2xl mx-auto">
                Produk yang paling banyak dibeli oleh pelanggan kami
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($bestSellers as $product)
            <div class="card-hover group">
                <div class="relative overflow-hidden">
                    <img 
                        src="{{ $product->image ? asset('storage/products/' . $product->image) : 'https://placehold.co/400x300/f3f4f6/374151?text=Produk' }}" 
                        alt="{{ $product->name }}"
                        class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                    >
                    <div class="absolute top-3 left-3">
                        <span class="badge-warning">Terlaris</span>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-neutral-900 mb-2 line-clamp-2">{{ $product->name }}</h3>
                    <div class="flex items-center justify-between text-sm mb-2">
                        <span class="text-neutral-500">Terjual:</span>
                        <span class="font-semibold text-primary-600">{{ $product->sales_count }} pcs</span>
                    </div>
                    <div class="space-y-1 mb-4">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-neutral-500">Eceran:</span>
                            <span class="font-semibold text-primary-600">Rp {{ number_format($product->price_per_piece) }}</span>
                        </div>
                        @if($product->price_per_four)
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-neutral-500">4+:</span>
                            <span class="font-semibold text-green-600">Rp {{ number_format($product->price_per_four) }}</span>
                        </div>
                        @endif
                    </div>
                    <a href="{{ route('products.show', $product->slug) }}" class="btn-primary w-full text-center">
                        Lihat Detail
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="section-padding bg-primary-50">
    <div class="container-custom">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-neutral-900 mb-4">Mengapa Memilih Kami?</h2>
            <p class="text-lg text-neutral-600 max-w-2xl mx-auto">
                Keunggulan yang membuat kami menjadi pilihan terbaik untuk kebutuhan grosir Anda
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-primary-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-neutral-900 mb-2">Harga Bertingkat</h3>
                <p class="text-neutral-600">Sistem harga fleksibel sesuai kuantitas pembelian untuk keuntungan maksimal</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-primary-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-neutral-900 mb-2">Kualitas Terjamin</h3>
                <p class="text-neutral-600">Produk berkualitas tinggi dengan standar internasional dan sertifikasi resmi</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-primary-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-neutral-900 mb-2">Pengiriman Cepat</h3>
                <p class="text-neutral-600">Layanan pengiriman cepat dan aman ke seluruh Indonesia dengan tracking real-time</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-primary-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 100 19.5 9.75 9.75 0 000-19.5z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-neutral-900 mb-2">24/7 Support</h3>
                <p class="text-neutral-600">Tim customer service siap membantu Anda 24 jam sehari, 7 hari seminggu</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section-padding bg-primary-600 text-white">
    <div class="container-custom text-center">
        <h2 class="text-3xl font-bold mb-4">Siap Memulai Bisnis Grosir Digital?</h2>
        <p class="text-xl text-primary-100 mb-8 max-w-2xl mx-auto">
            Bergabunglah dengan ribuan pelanggan yang telah mempercayai kami untuk kebutuhan grosir mereka
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('register') }}" class="btn-secondary text-lg px-8 py-4">
                Daftar Sekarang
            </a>
            <a href="{{ route('contact') }}" class="btn-outline border-white text-white hover:bg-white hover:text-primary-600 text-lg px-8 py-4">
                Hubungi Kami
            </a>
        </div>
    </div>
</section>
@endsection
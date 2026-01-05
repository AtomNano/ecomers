@extends('layouts.guest')

@section('title', 'Grosir Berkat Ibu - Belanja Grosir Online Terpercaya')

@section('content')
<!-- Hero Section - Shopee Style Banner -->
<section class="relative bg-gradient-to-br from-orange-500 via-red-500 to-pink-500 overflow-hidden">
    <!-- Animated Background Shapes -->
    <div class="absolute inset-0">
        <div class="absolute top-10 left-10 w-32 h-32 bg-yellow-300 opacity-20 rounded-full animate-bounce" style="animation-duration: 3s;"></div>
        <div class="absolute bottom-20 right-20 w-48 h-48 bg-white opacity-10 rounded-full animate-pulse"></div>
        <div class="absolute top-1/2 left-1/3 w-24 h-24 bg-orange-300 opacity-15 rounded-full animate-ping" style="animation-duration: 2s;"></div>
    </div>
    
    <div class="relative container mx-auto px-4 py-16 lg:py-24">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            <!-- Left Content -->
            <div class="text-white space-y-6 animate-fade-in-left">
                <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium">
                    <span class="animate-pulse">🔥</span> Promo Spesial Hari Ini!
                </div>
                
                <h1 class="text-4xl md:text-6xl font-black leading-tight">
                    Belanja Grosir
                    <span class="block text-yellow-300 drop-shadow-lg">Super Hemat!</span>
                </h1>
                
                <p class="text-lg md:text-xl text-white/90 max-w-lg">
                    Dapatkan harga terbaik untuk kebutuhan usaha Anda. Semakin banyak beli, semakin hemat!
                </p>
                
                <div class="flex flex-wrap gap-4">
                    <a href="#products" class="group px-8 py-4 bg-white text-red-500 font-bold rounded-full hover:bg-yellow-300 hover:text-red-600 transition-all transform hover:scale-105 shadow-xl inline-flex items-center gap-2">
                        <i class="fas fa-shopping-bag group-hover:animate-bounce"></i>
                        Belanja Sekarang
                    </a>
                    <a href="{{ route('about') }}" class="px-8 py-4 bg-transparent border-2 border-white text-white font-bold rounded-full hover:bg-white hover:text-red-500 transition-all inline-flex items-center gap-2">
                        <i class="fas fa-store"></i>
                        Tentang Kami
                    </a>
                </div>
                
                <!-- Trust Badges -->
                <div class="flex flex-wrap gap-6 pt-6">
                    <div class="flex items-center gap-2 text-white/90">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-truck text-yellow-300"></i>
                        </div>
                        <span class="text-sm">Gratis Ongkir</span>
                    </div>
                    <div class="flex items-center gap-2 text-white/90">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-shield-alt text-yellow-300"></i>
                        </div>
                        <span class="text-sm">100% Original</span>
                    </div>
                    <div class="flex items-center gap-2 text-white/90">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-headset text-yellow-300"></i>
                        </div>
                        <span class="text-sm">24/7 Support</span>
                    </div>
                </div>
            </div>
            
            <!-- Right - Promo Card -->
            <div class="hidden lg:block animate-fade-in-right">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-400 to-orange-400 rounded-3xl transform rotate-6 opacity-50"></div>
                    <div class="relative bg-white rounded-3xl p-8 shadow-2xl">
                        <div class="text-center space-y-4">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-red-500 to-pink-500 rounded-full text-white text-3xl shadow-lg">
                                <i class="fas fa-percent animate-pulse"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">Diskon Hingga</h3>
                            <p class="text-6xl font-black text-red-500">50%</p>
                            <p class="text-gray-600">Untuk pembelian dalam jumlah besar</p>
                            <a href="#products" class="block w-full py-3 bg-gradient-to-r from-red-500 to-pink-500 text-white font-bold rounded-full hover:shadow-lg transition">
                                Lihat Promo <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Wave Divider -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white"/>
        </svg>
    </div>
</section>

<!-- Flash Sale Banner -->
<section class="py-6 bg-white">
    <div class="container mx-auto px-4">
        <div class="bg-gradient-to-r from-red-600 to-orange-500 rounded-2xl p-6 shadow-lg overflow-hidden relative">
            <div class="absolute right-0 top-0 bottom-0 w-1/3 bg-gradient-to-l from-yellow-400/30 to-transparent"></div>
            <div class="relative flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="text-white">
                        <i class="fas fa-bolt text-4xl text-yellow-300 animate-pulse"></i>
                    </div>
                    <div class="text-white">
                        <h3 class="text-2xl font-black">FLASH SALE</h3>
                        <p class="text-white/80">Berakhir dalam waktu terbatas!</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="bg-white text-red-600 px-4 py-2 rounded-lg font-bold text-xl" id="countdown-hours">00</div>
                    <span class="text-white text-2xl font-bold">:</span>
                    <div class="bg-white text-red-600 px-4 py-2 rounded-lg font-bold text-xl" id="countdown-minutes">00</div>
                    <span class="text-white text-2xl font-bold">:</span>
                    <div class="bg-white text-red-600 px-4 py-2 rounded-lg font-bold text-xl" id="countdown-seconds">00</div>
                </div>
                <a href="#products" class="px-6 py-3 bg-white text-red-600 font-bold rounded-full hover:bg-yellow-300 transition shadow-lg">
                    Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section - Shopee Style -->
@if($categories->count() > 0)
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-th-large text-red-500"></i> Kategori
            </h2>
            <a href="#" class="text-red-500 hover:text-red-600 font-medium flex items-center gap-1">
                Lihat Semua <i class="fas fa-chevron-right text-sm"></i>
            </a>
        </div>
        
        <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($categories as $category)
            <a href="{{ route('home') }}?category={{ $category->id }}#products" class="group text-center">
                <div class="bg-gradient-to-br from-red-50 to-orange-50 rounded-2xl p-6 mb-3 group-hover:shadow-lg group-hover:from-red-100 group-hover:to-orange-100 transition-all transform group-hover:scale-105">
                    <div class="w-16 h-16 mx-auto bg-gradient-to-br from-red-500 to-orange-500 rounded-full flex items-center justify-center text-white text-2xl shadow-md group-hover:shadow-lg transition">
                        @switch(strtolower($category->name))
                            @case('makanan')
                                <i class="fas fa-utensils"></i>
                                @break
                            @case('minuman')
                                <i class="fas fa-coffee"></i>
                                @break
                            @case('elektronik')
                                <i class="fas fa-tv"></i>
                                @break
                            @case('pakaian')
                                <i class="fas fa-tshirt"></i>
                                @break
                            @case('kesehatan')
                                <i class="fas fa-heartbeat"></i>
                                @break
                            @default
                                <i class="fas fa-box"></i>
                        @endswitch
                    </div>
                </div>
                <p class="text-sm font-medium text-gray-700 group-hover:text-red-500 transition">{{ $category->name }}</p>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Products Section -->
<section id="products" class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-3">
                <div class="w-1 h-8 bg-red-500 rounded-full"></div>
                <h2 class="text-2xl font-bold text-gray-800">Produk Terbaru</h2>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-gray-500 text-sm">{{ $latestProducts->count() }} produk</span>
            </div>
        </div>
        
        <!-- Products Grid - Shopee Style Cards -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($latestProducts as $product)
            <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group border border-gray-100">
                <!-- Product Image -->
                <div class="relative aspect-square overflow-hidden bg-gray-100">
                    @if($product->image)
                        <img src="{{ \Illuminate\Support\Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <i class="fas fa-image text-4xl"></i>
                        </div>
                    @endif
                    
                    <!-- Discount Badge -->
                    @if($product->price_bulk_4 && $product->price_bulk_4 < $product->price_unit)
                        @php
                            $discount = round((($product->price_unit - $product->price_bulk_4) / $product->price_unit) * 100);
                        @endphp
                        <div class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                            -{{ $discount }}%
                        </div>
                    @endif
                    
                    <!-- Favorite Button -->
                    <button class="absolute top-2 right-2 w-8 h-8 bg-white/80 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-400 hover:text-red-500 transition opacity-0 group-hover:opacity-100">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                
                <!-- Product Info -->
                <div class="p-3">
                    <!-- Product Name -->
                    <h3 class="text-sm text-gray-800 font-medium line-clamp-2 min-h-[40px] hover:text-red-500 transition">
                        <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                    </h3>
                    
                    <!-- Price -->
                    <div class="mt-2">
                        <p class="text-red-500 font-bold text-lg">
                            Rp {{ number_format($product->price_unit, 0, ',', '.') }}
                        </p>
                        @if($product->price_dozen)
                        <p class="text-xs text-gray-500 mt-1">
                            <span class="text-green-600 font-medium">Grosir:</span> 
                            Rp {{ number_format($product->price_dozen, 0, ',', '.') }}/dus
                        </p>
                        @endif
                    </div>
                    
                    <!-- Bottom Info -->
                    <div class="mt-3 flex items-center justify-between text-xs text-gray-500">
                        <div class="flex items-center gap-1">
                            <i class="fas fa-star text-yellow-400"></i>
                            <span>5.0</span>
                        </div>
                        <span>Stok: {{ $product->stock }}</span>
                    </div>
                    
                    <!-- Quick Add Button -->
                    @auth
                        @if($product->stock > 0)
                        <form action="{{ route('customer.cart.add', $product) }}" method="POST" class="mt-3">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="w-full py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition flex items-center justify-center gap-2">
                                <i class="fas fa-cart-plus"></i> Tambah
                            </button>
                        </form>
                        @else
                        <button disabled class="w-full py-2 mt-3 bg-gray-200 text-gray-500 text-sm font-medium rounded-lg">
                            Stok Habis
                        </button>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="w-full py-2 mt-3 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition flex items-center justify-center gap-2 block">
                            <i class="fas fa-shopping-cart"></i> Beli
                        </a>
                    @endauth
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- View All Button -->
        <div class="text-center mt-10">
            @auth
                <a href="{{ route('customer.products.index') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-white border-2 border-red-500 text-red-500 font-bold rounded-full hover:bg-red-500 hover:text-white transition">
                    Lihat Semua Produk <i class="fas fa-arrow-right"></i>
                </a>
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-red-500 text-white font-bold rounded-full hover:bg-red-600 transition shadow-lg">
                    Daftar untuk Belanja <i class="fas fa-arrow-right"></i>
                </a>
            @endauth
        </div>
    </div>
</section>

<!-- Best Sellers Section -->
@if($bestSellingProducts->count() > 0)
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-3">
                <div class="w-1 h-8 bg-orange-500 rounded-full"></div>
                <h2 class="text-2xl font-bold text-gray-800">Produk Terlaris</h2>
                <span class="bg-orange-100 text-orange-600 text-xs font-bold px-3 py-1 rounded-full">HOT</span>
            </div>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($bestSellingProducts as $product)
            <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group border border-gray-100">
                <div class="relative aspect-square overflow-hidden bg-gray-100">
                    @if($product->image)
                        <img src="{{ \Illuminate\Support\Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <i class="fas fa-image text-4xl"></i>
                        </div>
                    @endif
                    
                    <div class="absolute top-2 left-2 bg-orange-500 text-white text-xs font-bold px-2 py-1 rounded flex items-center gap-1">
                        <i class="fas fa-fire"></i> Laris
                    </div>
                </div>
                
                <div class="p-3">
                    <h3 class="text-sm text-gray-800 font-medium line-clamp-2 min-h-[40px]">{{ $product->name }}</h3>
                    <p class="text-red-500 font-bold text-lg mt-2">
                        Rp {{ number_format($product->price_unit, 0, ',', '.') }}
                    </p>
                    <div class="mt-2 flex items-center gap-1 text-xs text-gray-500">
                        <i class="fas fa-star text-yellow-400"></i>
                        <span>5.0</span>
                        <span class="mx-1">|</span>
                        <span>Terjual 100+</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Store Info Section -->
<section class="py-16 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <!-- Info -->
            <div class="space-y-6">
                <h2 class="text-3xl md:text-4xl font-bold">
                    <span class="text-red-400">{{ $storeSetting->store_name ?? 'Grosir Berkat Ibu' }}</span>
                </h2>
                <p class="text-gray-300 text-lg leading-relaxed">
                    Toko grosir terpercaya dengan pengalaman lebih dari 10 tahun melayani kebutuhan usaha Anda. 
                    Kami menyediakan berbagai produk berkualitas dengan harga terbaik.
                </p>
                
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-red-500/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-red-400"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Alamat</p>
                            <p class="font-medium">{{ $storeSetting->address ?? 'Jakarta, Indonesia' }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-500/20 rounded-full flex items-center justify-center">
                            <i class="fab fa-whatsapp text-green-400"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">WhatsApp</p>
                            <p class="font-medium">{{ $storeSetting->phone ?? '+62 812-3456-7890' }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-500/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-clock text-blue-400"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Jam Operasional</p>
                            <p class="font-medium">Senin - Sabtu, 08:00 - 17:00</p>
                        </div>
                    </div>
                </div>
                
                <div class="flex gap-4 pt-4">
                    @if($storeSetting && $storeSetting->phone)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $storeSetting->phone) }}" target="_blank" class="px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-full transition flex items-center gap-2 shadow-lg">
                        <i class="fab fa-whatsapp"></i> Chat Sekarang
                    </a>
                    @endif
                    @if($storeSetting && $storeSetting->maps_url)
                    <a href="{{ $storeSetting->maps_url }}" target="_blank" class="px-6 py-3 bg-white/10 hover:bg-white/20 text-white font-bold rounded-full transition flex items-center gap-2">
                        <i class="fas fa-map"></i> Lihat Maps
                    </a>
                    @endif
                </div>
            </div>
            
            <!-- Map Placeholder -->
            <div class="bg-gray-700 rounded-2xl h-80 overflow-hidden shadow-2xl">
                @if($storeSetting && $storeSetting->maps_url)
                <iframe 
                    src="{{ str_replace('/maps/', '/maps/embed?pb=', $storeSetting->maps_url) }}" 
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy"
                    class="grayscale hover:grayscale-0 transition-all duration-500">
                </iframe>
                @else
                <div class="w-full h-full flex items-center justify-center text-gray-500">
                    <div class="text-center">
                        <i class="fas fa-map-marked-alt text-5xl mb-3"></i>
                        <p>Lokasi Toko</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
@guest
<section class="py-16 bg-gradient-to-r from-red-500 via-orange-500 to-yellow-500 relative overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute top-0 left-1/4 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
    </div>
    
    <div class="container mx-auto px-4 text-center relative">
        <h2 class="text-3xl md:text-4xl font-black text-white mb-4">
            Siap Memulai Bisnis Anda?
        </h2>
        <p class="text-white/90 text-lg mb-8 max-w-2xl mx-auto">
            Daftar sekarang dan nikmati harga grosir terbaik untuk kebutuhan usaha Anda. 
            Gratis registrasi, tanpa biaya tersembunyi!
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('register') }}" class="px-10 py-4 bg-white text-red-500 font-bold rounded-full hover:bg-yellow-300 transition transform hover:scale-105 shadow-xl inline-flex items-center justify-center gap-2">
                <i class="fas fa-user-plus"></i> Daftar Gratis Sekarang
            </a>
            <a href="{{ route('login') }}" class="px-10 py-4 bg-transparent border-2 border-white text-white font-bold rounded-full hover:bg-white hover:text-red-500 transition inline-flex items-center justify-center gap-2">
                <i class="fas fa-sign-in-alt"></i> Sudah Punya Akun?
            </a>
        </div>
    </div>
</section>
@endguest

<!-- Custom Animations -->
<style>
    @keyframes fadeInLeft {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes fadeInRight {
        from { opacity: 0; transform: translateX(30px); }
        to { opacity: 1; transform: translateX(0); }
    }
    .animate-fade-in-left { animation: fadeInLeft 0.8s ease-out; }
    .animate-fade-in-right { animation: fadeInRight 0.8s ease-out 0.2s backwards; }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<!-- Countdown Script -->
<script>
    function updateCountdown() {
        const now = new Date();
        const endOfDay = new Date();
        endOfDay.setHours(23, 59, 59, 999);
        
        const diff = endOfDay - now;
        
        const hours = Math.floor(diff / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);
        
        document.getElementById('countdown-hours').textContent = hours.toString().padStart(2, '0');
        document.getElementById('countdown-minutes').textContent = minutes.toString().padStart(2, '0');
        document.getElementById('countdown-seconds').textContent = seconds.toString().padStart(2, '0');
    }
    
    setInterval(updateCountdown, 1000);
    updateCountdown();
</script>
@endsection

@extends('layouts.app')

@section('title', 'Grosir Berkat Ibu - Belanja Grosir Online Terpercaya')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-emerald-600 via-teal-600 to-blue-600 text-white overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-white opacity-10 rounded-full animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-white opacity-10 rounded-full animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="relative container mx-auto px-4 py-24">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div class="animate-fade-in-left">
                <h1 class="text-5xl md:text-6xl font-black mb-6 leading-tight">
                    Belanja Grosir <span class="text-yellow-300">Jadi Hemat!</span>
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-gray-100">
                    Ribuan produk berkualitas dengan harga grosir terjangkau. Pesan sekarang dan nikmati diskon otomatis untuk pembelian dalam jumlah besar.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    @auth
                        <a href="{{ route('customer.products.index') }}" class="px-8 py-4 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold rounded-lg transition transform hover:scale-105 inline-flex items-center justify-center gap-2 shadow-lg">
                            <i class="fas fa-shopping-cart"></i> Mulai Belanja
                        </a>
                        <a href="{{ route('customer.orders') }}" class="px-8 py-4 bg-white hover:bg-gray-100 text-emerald-600 font-bold rounded-lg transition transform hover:scale-105 inline-flex items-center justify-center gap-2 shadow-lg">
                            <i class="fas fa-history"></i> Pesanan Saya
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-8 py-4 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold rounded-lg transition transform hover:scale-105 inline-flex items-center justify-center gap-2 shadow-lg">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-white hover:bg-gray-100 text-emerald-600 font-bold rounded-lg transition transform hover:scale-105 inline-flex items-center justify-center gap-2 shadow-lg">
                            <i class="fas fa-user-plus"></i> Daftar
                        </a>
                    @endauth
                </div>

                <!-- Stats -->
                <div class="mt-12 grid grid-cols-3 gap-4">
                    <div class="text-center">
                        <p class="text-4xl font-bold">10K+</p>
                        <p class="text-sm text-gray-200">Produk</p>
                    </div>
                    <div class="text-center">
                        <p class="text-4xl font-bold">5K+</p>
                        <p class="text-sm text-gray-200">Pelanggan</p>
                    </div>
                    <div class="text-center">
                        <p class="text-4xl font-bold">24/7</p>
                        <p class="text-sm text-gray-200">Support</p>
                    </div>
                </div>
            </div>

            <!-- Right Image -->
            <div class="animate-fade-in-right hidden md:block">
                <div class="relative">
                    <div class="absolute inset-0 bg-white opacity-20 rounded-2xl transform -rotate-6"></div>
                    <div class="relative bg-gradient-to-br from-yellow-200 to-orange-200 rounded-2xl p-8 shadow-2xl transform hover:rotate-3 transition">
                        <div class="text-center">
                            <i class="fas fa-shopping-bags text-8xl text-white opacity-80"></i>
                            <p class="mt-4 text-2xl font-bold text-gray-800">Harga Grosir Terjangkau</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">Mengapa Memilih Kami?</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition transform hover:scale-105 text-center group">
                <div class="text-5xl mb-4 inline-block p-4 bg-emerald-100 rounded-full group-hover:bg-emerald-200 transition">
                    <i class="fas fa-tag text-emerald-600"></i>
                </div>
                <h3 class="text-xl font-bold mb-2 text-gray-800">Harga Grosir</h3>
                <p class="text-gray-600">Harga otomatis lebih murah untuk pembelian dalam jumlah besar</p>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition transform hover:scale-105 text-center group">
                <div class="text-5xl mb-4 inline-block p-4 bg-blue-100 rounded-full group-hover:bg-blue-200 transition">
                    <i class="fas fa-truck text-blue-600"></i>
                </div>
                <h3 class="text-xl font-bold mb-2 text-gray-800">Pengiriman Cepat</h3>
                <p class="text-gray-600">Gratis ongkir untuk pembelian di atas minimum order</p>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition transform hover:scale-105 text-center group">
                <div class="text-5xl mb-4 inline-block p-4 bg-purple-100 rounded-full group-hover:bg-purple-200 transition">
                    <i class="fas fa-shield-alt text-purple-600"></i>
                </div>
                <h3 class="text-xl font-bold mb-2 text-gray-800">Terpercaya</h3>
                <p class="text-gray-600">Produk original dengan garansi keaslian 100%</p>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition transform hover:scale-105 text-center group">
                <div class="text-5xl mb-4 inline-block p-4 bg-orange-100 rounded-full group-hover:bg-orange-200 transition">
                    <i class="fas fa-headset text-orange-600"></i>
                </div>
                <h3 class="text-xl font-bold mb-2 text-gray-800">Customer Service</h3>
                <p class="text-gray-600">Tim siap membantu Anda setiap saat 24 jam</p>
            </div>
        </div>
    </div>
</section>

<!-- Category Section -->
@if($categories->count() > 0)
<section class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">Kategori Produk</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($categories as $category)
                <a href="{{ route('customer.products.index', ['category' => $category->id]) }}" class="group">
                    <div class="bg-gradient-to-br from-emerald-400 to-teal-500 rounded-xl p-6 text-white text-center hover:shadow-xl transition transform hover:scale-110">
                        <div class="text-4xl mb-3">
                            <i class="fas fa-cube"></i>
                        </div>
                        <p class="font-bold text-sm">{{ $category->name }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Latest Products Section -->
@if($latestProducts->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Produk Terbaru</h2>
            <p class="text-gray-600 text-lg">Koleksi terbaru kami dengan harga terbaik</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($latestProducts as $product)
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-2xl transition transform hover:scale-105 group">
                    <!-- Product Image -->
                    <div class="relative bg-gray-200 h-64 overflow-hidden group-hover:bg-gray-300 transition">
                        @if($product->image)
                            <img src="{{ \Illuminate\Support\Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <i class="fas fa-image text-6xl"></i>
                            </div>
                        @endif
                        
                        <!-- Badge -->
                        <div class="absolute top-4 left-4">
                            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold animate-pulse">Baru</span>
                        </div>

                        <!-- Quick View Button -->
                        @auth
                            <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-4">
                                <a href="{{ route('customer.products.show', $product) }}" class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-2 rounded-lg font-bold transition transform hover:scale-110">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                            </div>
                        @endauth
                    </div>

                    <!-- Product Info -->
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">{{ $product->name }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $product->description }}</p>

                        <!-- Pricing -->
                        <div class="mb-4">
                            <div class="flex items-baseline gap-2 mb-2">
                                <span class="text-2xl font-bold text-emerald-600">Rp {{ number_format($product->price_unit, 0, ',', '.') }}</span>
                                <span class="text-sm text-gray-500">/pcs</span>
                            </div>
                            <p class="text-xs text-gray-500">
                                💰 Harga otomatis lebih murah untuk pembelian {{ $product->box_item_count ?? 12 }}+ pcs
                            </p>
                        </div>

                        <!-- Stock Status -->
                        <div class="mb-4">
                            @if($product->stock > 20)
                                <span class="text-xs font-bold text-green-600 bg-green-50 px-3 py-1 rounded-full">
                                    ✅ Stok Tersedia ({{ $product->stock }})
                                </span>
                            @elseif($product->stock > 0)
                                <span class="text-xs font-bold text-yellow-600 bg-yellow-50 px-3 py-1 rounded-full">
                                    ⚠️ Stok Terbatas ({{ $product->stock }})
                                </span>
                            @else
                                <span class="text-xs font-bold text-red-600 bg-red-50 px-3 py-1 rounded-full">
                                    ❌ Habis Terjual
                                </span>
                            @endif
                        </div>

                        <!-- Action Button -->
                        @auth
                            @if($product->stock > 0)
                                <form action="{{ route('customer.cart.add', $product) }}" method="POST" class="w-full">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="w-full bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-bold py-3 rounded-lg transition transform hover:scale-105 flex items-center justify-center gap-2">
                                        <i class="fas fa-cart-plus"></i> Tambah Keranjang
                                    </button>
                                </form>
                            @else
                                <button disabled class="w-full bg-gray-300 text-gray-500 font-bold py-3 rounded-lg cursor-not-allowed">
                                    Stok Habis
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 rounded-lg transition block text-center">
                                Login untuk Belanja
                            </a>
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>

        @auth
            <div class="text-center mt-12">
                <a href="{{ route('customer.products.index') }}" class="inline-block px-8 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg transition transform hover:scale-105">
                    Lihat Semua Produk <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        @endauth
    </div>
</section>
@endif

<!-- CTA Section -->
@if(!auth()->check())
<section class="py-16 bg-gradient-to-r from-emerald-600 to-teal-600 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold mb-6">Daftar Sekarang dan Dapatkan Diskon Khusus!</h2>
        <p class="text-xl mb-8 text-gray-100">Bergabunglah dengan ribuan pelanggan yang puas dan nikmati harga grosir terbaik</p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('register') }}" class="px-8 py-4 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold rounded-lg transition transform hover:scale-105 inline-flex items-center justify-center gap-2">
                <i class="fas fa-user-plus"></i> Daftar Gratis
            </a>
            <a href="{{ route('about') }}" class="px-8 py-4 bg-white hover:bg-gray-100 text-emerald-600 font-bold rounded-lg transition transform hover:scale-105 inline-flex items-center justify-center gap-2">
                <i class="fas fa-info-circle"></i> Pelajari Lebih Lanjut
            </a>
        </div>
    </div>
</section>
@endif

<!-- Styles for Custom Animations -->
<style>
    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-fade-in-left {
        animation: fadeInLeft 1s ease-out;
    }

    .animate-fade-in-right {
        animation: fadeInRight 1s ease-out 0.2s backwards;
    }

    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }

    /* Line clamp polyfill for older browsers */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<!-- Alpine.js untuk interaktivitas -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
    // Animate elements on scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('[data-animate]').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });

    // Cart notification
    document.querySelectorAll('form[action*="cart"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            const btn = this.querySelector('button');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner animate-spin"></i> Menambahkan...';
            btn.disabled = true;
            
            // Reset after 1 second
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }, 1000);
        });
    });
</script>
@endsection

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Grosir Berkat Ibu - Platform belanja grosir online terpercaya dengan harga terbaik">
    <title>@yield('title', 'Grosir Berkat Ibu - Belanja Grosir Online')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        html { scroll-behavior: smooth; }
        
        .navbar-blur {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #ff5722; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #e64a19; }
        
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased" x-data="{ mobileMenuOpen: false, searchOpen: false }">
    <!-- Top Bar -->
    <div class="bg-gradient-to-r from-red-600 to-orange-500 text-white text-sm py-2">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <span class="hidden md:flex items-center gap-2">
                    <i class="fas fa-headset"></i> Customer Service: +62 812-3456-7890
                </span>
                <span class="flex items-center gap-2">
                    <i class="fas fa-truck"></i> Gratis Ongkir untuk pembelian grosir!
                </span>
            </div>
            <div class="flex items-center gap-4">
                <a href="#" class="hover:text-yellow-300 transition"><i class="fab fa-instagram"></i></a>
                <a href="#" class="hover:text-yellow-300 transition"><i class="fab fa-facebook"></i></a>
                <a href="#" class="hover:text-yellow-300 transition"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>
    </div>
    
    <!-- Main Navigation -->
    <nav class="sticky top-0 z-50 bg-white shadow-md navbar-blur" x-data="{ scrolled: false }" @scroll.window="scrolled = window.scrollY > 50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition">
                        <i class="fas fa-store text-white text-lg"></i>
                    </div>
                    <div class="hidden sm:block">
                        <p class="font-bold text-gray-800 text-lg">Grosir Berkat Ibu</p>
                        <p class="text-xs text-gray-500">Belanja Hemat & Cepat</p>
                    </div>
                </a>
                
                <!-- Search Bar (Desktop) -->
                <div class="hidden lg:flex flex-1 max-w-xl mx-8">
                    <form action="{{ route('products.index') }}" method="GET" class="relative w-full">
                        <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}"
                               class="w-full pl-4 pr-12 py-3 border-2 border-gray-200 rounded-full focus:border-red-500 focus:outline-none transition">
                        <button type="submit" class="absolute right-1 top-1 bottom-1 px-4 bg-gradient-to-r from-red-500 to-orange-500 text-white rounded-full hover:from-red-600 hover:to-orange-600 transition">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center gap-6">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-red-500 font-medium transition flex items-center gap-2">
                        <i class="fas fa-home"></i> Home
                    </a>
                    <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-red-500 font-medium transition flex items-center gap-2">
                        <i class="fas fa-box"></i> Produk
                    </a>
                    <a href="{{ route('about') }}" class="text-gray-700 hover:text-red-500 font-medium transition flex items-center gap-2">
                        <i class="fas fa-info-circle"></i> Tentang
                    </a>
                    
                    @auth
                        <!-- Cart -->
                        @if(auth()->user()->role === 'customer')
                        <a href="{{ route('customer.cart.index') }}" class="relative text-gray-700 hover:text-red-500 transition">
                            <i class="fas fa-shopping-cart text-xl"></i>
                            @php $cartCount = auth()->user()->carts()->count(); @endphp
                            @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-bold">
                                {{ $cartCount }}
                            </span>
                            @endif
                        </a>
                        @endif
                        
                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 text-gray-700 hover:text-red-500 font-medium transition">
                                <div class="w-8 h-8 bg-gradient-to-br from-red-500 to-orange-500 rounded-full flex items-center justify-center text-white">
                                    <i class="fas fa-user text-sm"></i>
                                </div>
                                <span class="max-w-24 truncate">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" x-transition 
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border py-2 z-50">
                                @if(auth()->user()->role === 'customer')
                                    <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-3 px-4 py-2 text-gray-700 hover:bg-gray-50 transition">
                                        <i class="fas fa-tachometer-alt w-4"></i> Dashboard
                                    </a>
                                    <a href="{{ route('customer.orders') }}" class="flex items-center gap-3 px-4 py-2 text-gray-700 hover:bg-gray-50 transition">
                                        <i class="fas fa-shopping-bag w-4"></i> Pesanan Saya
                                    </a>
                                @elseif(auth()->user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2 text-gray-700 hover:bg-gray-50 transition">
                                        <i class="fas fa-chart-line w-4"></i> Admin Dashboard
                                    </a>
                                @elseif(auth()->user()->role === 'owner')
                                    <a href="{{ route('owner.dashboard') }}" class="flex items-center gap-3 px-4 py-2 text-gray-700 hover:bg-gray-50 transition">
                                        <i class="fas fa-crown w-4"></i> Owner Dashboard
                                    </a>
                                @endif
                                <hr class="my-2">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-3 px-4 py-2 text-red-600 hover:bg-red-50 transition w-full">
                                        <i class="fas fa-sign-out-alt w-4"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2 border-2 border-red-500 text-red-500 font-semibold rounded-full hover:bg-red-500 hover:text-white transition">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="px-5 py-2 bg-gradient-to-r from-red-500 to-orange-500 text-white font-semibold rounded-full hover:from-red-600 hover:to-orange-600 transition shadow-md hover:shadow-lg">
                            Daftar
                        </a>
                    @endauth
                </div>
                
                <!-- Mobile Menu Button -->
                <div class="flex items-center gap-4 lg:hidden">
                    <button @click="searchOpen = !searchOpen" class="text-gray-700 text-xl">
                        <i class="fas fa-search"></i>
                    </button>
                    @auth
                        @if(auth()->user()->role === 'customer')
                        <a href="{{ route('customer.cart.index') }}" class="relative text-gray-700">
                            <i class="fas fa-shopping-cart text-xl"></i>
                            @if(auth()->user()->carts()->count() > 0)
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                                {{ auth()->user()->carts()->count() }}
                            </span>
                            @endif
                        </a>
                        @endif
                    @endauth
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-700 text-xl">
                        <i class="fas" :class="mobileMenuOpen ? 'fa-times' : 'fa-bars'"></i>
                    </button>
                </div>
            </div>
            
            <!-- Mobile Search -->
            <div x-show="searchOpen" x-transition class="lg:hidden pb-4">
                <form action="{{ route('products.index') }}" method="GET" class="relative">
                    <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}"
                           class="w-full pl-4 pr-12 py-3 border-2 border-gray-200 rounded-full focus:border-red-500 focus:outline-none">
                    <button type="submit" class="absolute right-1 top-1 bottom-1 px-4 bg-red-500 text-white rounded-full">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            
            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" x-transition @click.away="mobileMenuOpen = false" 
                 class="lg:hidden pb-4 border-t border-gray-100">
                <div class="py-4 space-y-2">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg">
                        <i class="fas fa-home w-5"></i> Home
                    </a>
                    <a href="#products" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg">
                        <i class="fas fa-box w-5"></i> Produk
                    </a>
                    <a href="{{ route('about') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg">
                        <i class="fas fa-info-circle w-5"></i> Tentang Kami
                    </a>
                    
                    @auth
                        <hr class="my-2">
                        @if(auth()->user()->role === 'customer')
                            <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg">
                                <i class="fas fa-tachometer-alt w-5"></i> Dashboard
                            </a>
                            <a href="{{ route('customer.orders') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg">
                                <i class="fas fa-shopping-bag w-5"></i> Pesanan Saya
                            </a>
                        @elseif(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg">
                                <i class="fas fa-chart-line w-5"></i> Admin Dashboard
                            </a>
                        @elseif(auth()->user()->role === 'owner')
                            <a href="{{ route('owner.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg">
                                <i class="fas fa-crown w-5"></i> Owner Dashboard
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="px-4">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 py-3 text-red-600 hover:bg-red-50 rounded-lg">
                                <i class="fas fa-sign-out-alt w-5"></i> Logout
                            </button>
                        </form>
                    @else
                        <hr class="my-2">
                        <div class="px-4 flex gap-3">
                            <a href="{{ route('login') }}" class="flex-1 py-3 border-2 border-red-500 text-red-500 font-semibold rounded-full text-center hover:bg-red-500 hover:text-white transition">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="flex-1 py-3 bg-gradient-to-r from-red-500 to-orange-500 text-white font-semibold rounded-full text-center hover:from-red-600 hover:to-orange-600 transition">
                                Daftar
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Flash Messages -->
    @if(session('success'))
    <div class="fixed top-20 right-4 z-50 animate-bounce pointer-events-none" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)" x-cloak>
        <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-xl flex items-center gap-3 pointer-events-auto">
            <i class="fas fa-check-circle text-xl"></i>
            <span>{{ session('success') }}</span>
            <button @click="show = false" class="ml-2 hover:text-green-200"><i class="fas fa-times"></i></button>
        </div>
    </div>
    @endif
    
    @if(session('error'))
    <div class="fixed top-20 right-4 z-50 pointer-events-none" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)" x-cloak>
        <div class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-xl flex items-center gap-3 pointer-events-auto">
            <i class="fas fa-exclamation-circle text-xl"></i>
            <span>{{ session('error') }}</span>
            <button @click="show = false" class="ml-2 hover:text-red-200"><i class="fas fa-times"></i></button>
        </div>
    </div>
    @endif
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <!-- Main Footer -->
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Brand -->
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-orange-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-store text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-xl">Grosir Berkat Ibu</p>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm mb-4">
                        Platform belanja grosir online terpercaya dengan harga terbaik dan layanan pelanggan terbaik.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-red-500 rounded-full flex items-center justify-center transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-pink-500 rounded-full flex items-center justify-center transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-green-500 rounded-full flex items-center justify-center transition">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="font-bold text-lg mb-4">Link Cepat</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('home') }}" class="hover:text-red-400 transition">Home</a></li>
                        <li><a href="#products" class="hover:text-red-400 transition">Produk</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-red-400 transition">Tentang Kami</a></li>
                        @guest
                        <li><a href="{{ route('login') }}" class="hover:text-red-400 transition">Login</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-red-400 transition">Daftar</a></li>
                        @endguest
                    </ul>
                </div>
                
                <!-- Support -->
                <div>
                    <h4 class="font-bold text-lg mb-4">Bantuan</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-red-400 transition">FAQ</a></li>
                        <li><a href="#" class="hover:text-red-400 transition">Cara Belanja</a></li>
                        <li><a href="#" class="hover:text-red-400 transition">Kebijakan Pengembalian</a></li>
                        <li><a href="#" class="hover:text-red-400 transition">Hubungi Kami</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h4 class="font-bold text-lg mb-4">Hubungi Kami</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt text-red-400 mt-1"></i>
                            <span>Jl.timur, Ulak Karang Utara, Kec. Padang Utara, Kota Padang, Sumatera Barat 25000</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-phone text-red-400"></i>
                            <span>+62 812-3456-7890</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-envelope text-red-400"></i>
                            <span>info@grosirberkat.com</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-clock text-red-400"></i>
                            <span>Senin - Sabtu, 07:00 - 17:45</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Bottom Bar -->
        <div class="border-t border-gray-800">
            <div class="container mx-auto px-4 py-6">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-gray-500 text-sm">
                        &copy; 2025 Grosir Berkat Ibu. Semua hak dilindungi.
                    </p>
                    <div class="flex items-center gap-6 text-gray-500 text-sm">
                        <a href="#" class="hover:text-red-400 transition">Kebijakan Privasi</a>
                        <a href="#" class="hover:text-red-400 transition">Syarat & Ketentuan</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Back to Top Button -->
    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
            class="fixed bottom-6 right-6 w-12 h-12 bg-red-500 hover:bg-red-600 text-white rounded-full shadow-xl z-50 transition transform hover:scale-110"
            x-data="{ show: false }" 
            x-show="show" 
            @scroll.window="show = window.scrollY > 300">
        <i class="fas fa-arrow-up"></i>
    </button>
</body>
</html>

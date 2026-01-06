<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Grosir Berkat Ibu')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @keyframes slideDown {
            from { transform: translateY(-100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .animate-slide-down { animation: slideDown 0.3s ease-out; }
        .animate-fade-in { animation: fadeIn 0.3s ease-out; }
        
        html { scroll-behavior: smooth; }
        
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-gray-50" x-data="{ mobileMenuOpen: false }">
    <!-- Navigation Bar -->
    <nav class="sticky top-0 z-50 bg-gradient-to-r from-orange-500 via-red-500 to-pink-500 shadow-lg animate-slide-down">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="bg-white p-2 rounded-lg group-hover:shadow-lg transition">
                        <i class="fas fa-shopping-bag text-red-500 text-2xl"></i>
                    </div>
                    <div class="hidden sm:block">
                        <p class="font-bold text-white text-lg">Grosir Berkat Ibu</p>
                        <p class="text-orange-100 text-xs">Belanja Grosir Hemat</p>
                    </div>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center gap-8">
                    @auth
                        @if(auth()->user()->role === 'customer')
                            <a href="{{ route('customer.products.index') }}" class="text-white hover:text-yellow-300 transition font-medium">
                                <i class="fas fa-boxes"></i> Produk
                            </a>
                            <a href="{{ route('customer.orders') }}" class="text-white hover:text-yellow-300 transition font-medium">
                                <i class="fas fa-history"></i> Pesanan
                            </a>
                        @elseif(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-white hover:text-yellow-300 transition font-medium">
                                <i class="fas fa-chart-line"></i> Dashboard
                            </a>
                            <a href="{{ route('admin.products.index') }}" class="text-white hover:text-yellow-300 transition font-medium">
                                <i class="fas fa-boxes"></i> Produk
                            </a>
                            <a href="{{ route('admin.orders.index') }}" class="text-white hover:text-yellow-300 transition font-medium">
                                <i class="fas fa-shopping-cart"></i> Pesanan
                            </a>
                        @elseif(auth()->user()->role === 'owner')
                            <a href="{{ route('owner.dashboard') }}" class="text-white hover:text-yellow-300 transition font-medium">
                                <i class="fas fa-chart-pie"></i> Dashboard
                            </a>
                            <a href="{{ route('admin.products.index') }}" class="text-white hover:text-yellow-300 transition font-medium">
                                <i class="fas fa-boxes"></i> Produk
                            </a>
                            <a href="{{ route('admin.orders.index') }}" class="text-white hover:text-yellow-300 transition font-medium">
                                <i class="fas fa-shopping-cart"></i> Pesanan
                            </a>
                            <a href="{{ route('owner.reports.index') }}" class="text-white hover:text-yellow-300 transition font-medium">
                                <i class="fas fa-file-alt"></i> Laporan
                            </a>
                        @endif
                    @else
                        <a href="{{ route('about') }}" class="text-white hover:text-yellow-300 transition font-medium">
                            <i class="fas fa-info-circle"></i> Tentang
                        </a>
                    @endauth
                </div>

                <!-- Right Side Icons -->
                <div class="flex items-center gap-4">
                    @auth
                        @if(auth()->user()->role === 'customer')
                            <!-- Cart Icon -->
                            <a href="{{ route('customer.cart.index') }}" class="relative text-white hover:text-yellow-300 transition text-xl hidden sm:block">
                                <i class="fas fa-shopping-cart"></i>
                                @php
                                    $cartCount = auth()->user()->carts()->count();
                                @endphp
                                @if($cartCount > 0)
                                    <span class="cart-badge">{{ $cartCount }}</span>
                                @endif
                            </a>
                        @endif

                        <!-- User Menu -->
                        <div class="hidden sm:block text-white text-sm">
                            <i class="fas fa-user-circle text-2xl mr-2"></i>{{ auth()->user()->name }}
                        </div>

                        <!-- Logout -->
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-white hover:text-red-300 transition hidden sm:block">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 bg-white text-red-500 rounded-lg font-semibold hover:bg-yellow-400 hover:text-red-600 transition">
                            Login
                        </a>
                    @endauth

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden text-white text-2xl">
                        <i class="fas" :class="mobileMenuOpen ? 'fa-times' : 'fa-bars'"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div v-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" class="lg:hidden pb-4 border-t border-red-400 animate-fade-in">
                @auth
                    @if(auth()->user()->role === 'customer')
                        <a href="{{ route('customer.products.index') }}" class="block py-2 text-white hover:text-yellow-300">
                            <i class="fas fa-boxes"></i> Produk
                        </a>
                        <a href="{{ route('customer.cart.index') }}" class="block py-2 text-white hover:text-yellow-300">
                            <i class="fas fa-shopping-cart"></i> Keranjang
                        </a>
                        <a href="{{ route('customer.orders') }}" class="block py-2 text-white hover:text-yellow-300">
                            <i class="fas fa-history"></i> Pesanan
                        </a>
                        <a href="{{ route('customer.dashboard') }}" class="block py-2 text-white hover:text-yellow-300">
                            <i class="fas fa-user"></i> Dashboard
                        </a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="block w-full text-left py-2 text-red-300 hover:text-red-400">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block py-2 text-white hover:text-yellow-300">Login</a>
                    <a href="{{ route('register') }}" class="block py-2 text-white hover:text-yellow-300">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 m-4 rounded animate-fade-in">
            <div class="flex items-center gap-3">
                <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                <div>
                    <p class="text-green-800 font-semibold">Sukses!</p>
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 m-4 rounded animate-fade-in">
            <div class="flex items-center gap-3">
                <i class="fas fa-exclamation-circle text-red-600 text-2xl"></i>
                <div>
                    <p class="text-red-800 font-semibold">Error!</p>
                    <p class="text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('info'))
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 m-4 rounded animate-fade-in">
            <div class="flex items-center gap-3">
                <i class="fas fa-info-circle text-blue-600 text-2xl"></i>
                <div>
                    <p class="text-blue-800 font-semibold">Informasi</p>
                    <p class="text-blue-700">{{ session('info') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 text-white mt-16">
        <div class="container mx-auto px-4">
            <!-- Footer Content -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 py-12">
                <!-- About -->
                <div>
                    <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                        <i class="fas fa-shopping-bag text-emerald-400"></i> Grosir Berkat Ibu
                    </h3>
                    <p class="text-gray-400 text-sm mb-4">
                        Platform belanja grosir online terpercaya dengan harga terbaik dan layanan terbaik.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="text-gray-400 hover:text-emerald-400 transition"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-gray-400 hover:text-emerald-400 transition"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-400 hover:text-emerald-400 transition"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-bold mb-4">Link Cepat</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-emerald-400 transition">Home</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-emerald-400 transition">Tentang Kami</a></li>
                        @auth
                            @if(auth()->user()->role === 'customer')
                                <li><a href="{{ route('customer.products.index') }}" class="hover:text-emerald-400 transition">Produk</a></li>
                                <li><a href="{{ route('customer.orders') }}" class="hover:text-emerald-400 transition">Pesanan Saya</a></li>
                            @endif
                        @endauth
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h4 class="text-lg font-bold mb-4">Dukungan</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li class="flex items-center gap-2">
                            <i class="fas fa-phone text-emerald-400"></i> +62 812-3456-7890
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-envelope text-emerald-400"></i> info@grosirberkatibu.com
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-emerald-400"></i> Jl.timur, Ulak Karang Utara, Kec. Padang Utara, Kota Padang, Sumatera Barat 25000
                        </li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h4 class="text-lg font-bold mb-4">Newsletter</h4>
                    <p class="text-gray-400 text-sm mb-3">Dapatkan promo eksklusif setiap hari</p>
                    <form class="flex gap-2">
                        <input type="email" placeholder="Email Anda" class="flex-1 px-3 py-2 rounded bg-gray-700 text-white placeholder-gray-400 text-sm focus:outline-none focus:bg-gray-600">
                        <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded transition font-semibold text-sm">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-700"></div>

            <!-- Bottom Footer -->
            <div class="py-6 flex flex-col md:flex-row justify-between items-center gap-4 text-gray-400 text-sm">
                <p>&copy; 2025 Grosir Berkat Ibu. Semua hak dilindungi.</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-emerald-400 transition">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-emerald-400 transition">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-emerald-400 transition">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>

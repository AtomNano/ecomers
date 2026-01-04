<nav class="bg-white shadow-soft sticky top-0 z-50">
    <div class="container-custom">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-primary-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg">BI</span>
                    </div>
                    <div class="hidden sm:block">
                        <h1 class="text-xl font-bold text-primary-900">Grosir Berkat Ibu</h1>
                        <p class="text-xs text-neutral-600">Platform Grosir Digital</p>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-neutral-700 hover:text-primary-600 font-medium transition-colors">
                    Beranda
                </a>
                <a href="{{ route('products.index') }}" class="text-neutral-700 hover:text-primary-600 font-medium transition-colors">
                    Produk
                </a>
                <a href="{{ route('categories.index') }}" class="text-neutral-700 hover:text-primary-600 font-medium transition-colors">
                    Kategori
                </a>
                <a href="{{ route('contact') }}" class="text-neutral-700 hover:text-primary-600 font-medium transition-colors">
                    Kontak
                </a>
            </div>

            <!-- Search Bar -->
            <div class="hidden lg:flex items-center flex-1 max-w-md mx-8">
                <form action="{{ route('products.search') }}" method="GET" class="w-full">
                    <div class="relative">
                        <input 
                            type="text" 
                            name="q" 
                            placeholder="Cari produk..." 
                            value="{{ request('q') }}"
                            class="w-full pl-10 pr-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Right Side Actions -->
            <div class="flex items-center space-x-4">
                <!-- Cart -->
                <button 
                    @click="$store.cart.toggle()" 
                    class="relative p-2 text-neutral-700 hover:text-primary-600 transition-colors"
                >
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                    </svg>
                    <span class="absolute -top-1 -right-1 bg-primary-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center" x-text="$store.cart.count"></span>
                </button>

                <!-- User Menu -->
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button 
                            @click="open = !open" 
                            class="flex items-center space-x-2 text-neutral-700 hover:text-primary-600 transition-colors"
                        >
                            <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center">
                                <span class="text-primary-600 font-medium text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                            <span class="hidden sm:block font-medium">{{ auth()->user()->name }}</span>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div 
                            x-show="open" 
                            @click.away="open = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-strong border border-neutral-200 py-1 z-50"
                        >
                            <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50">Profil Saya</a>
                            <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50">Pesanan Saya</a>
                            <a href="{{ route('addresses.index') }}" class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50">Alamat</a>
                            <div class="border-t border-neutral-200 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Keluar</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('login') }}" class="text-neutral-700 hover:text-primary-600 font-medium transition-colors">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="btn-primary">
                            Daftar
                        </a>
                    </div>
                @endauth

                <!-- Mobile Menu Button -->
                <button 
                    @click="$store.mobileMenu.toggle()" 
                    class="md:hidden p-2 text-neutral-700 hover:text-primary-600 transition-colors"
                >
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Search -->
        <div class="lg:hidden border-t border-neutral-200 px-4 py-3">
            <form action="{{ route('products.search') }}" method="GET">
                <div class="relative">
                    <input 
                        type="text" 
                        name="q" 
                        placeholder="Cari produk..." 
                        value="{{ request('q') }}"
                        class="w-full pl-10 pr-4 py-2 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    >
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div 
        x-show="$store.mobileMenu.isOpen" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform -translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-2"
        class="md:hidden bg-white border-t border-neutral-200 shadow-lg"
    >
        <div class="px-4 py-2 space-y-1">
            <a href="{{ route('home') }}" class="block px-3 py-2 text-neutral-700 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors">
                Beranda
            </a>
            <a href="{{ route('products.index') }}" class="block px-3 py-2 text-neutral-700 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors">
                Produk
            </a>
            <a href="{{ route('categories.index') }}" class="block px-3 py-2 text-neutral-700 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors">
                Kategori
            </a>
            <a href="{{ route('contact') }}" class="block px-3 py-2 text-neutral-700 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors">
                Kontak
            </a>
        </div>
    </div>
</nav>

<script>
    // Alpine.js stores
    document.addEventListener('alpine:init', () => {
        Alpine.store('cart', {
            isOpen: false,
            count: 0,
            
            toggle() {
                this.isOpen = !this.isOpen;
            }
        });
        
        Alpine.store('mobileMenu', {
            isOpen: false,
            
            toggle() {
                this.isOpen = !this.isOpen;
            }
        });
    });
</script>
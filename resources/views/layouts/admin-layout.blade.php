<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Grosir Berkat Ibu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @keyframes slideIn {
            from { transform: translateX(-100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .animate-slide-in { animation: slideIn 0.3s ease-out; }
        .animate-fade-in { animation: fadeIn 0.3s ease-out; }
        
        /* Smooth scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #10b981; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #059669; }
        
        /* Sidebar nav link */
        .nav-link { transition: all 0.2s ease; }
        .nav-link:hover { transform: translateX(4px); }
        .nav-link.active { border-left: 3px solid white; background: rgba(255,255,255,0.1); }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-100" x-data="{ sidebarOpen: true, mobileMenuOpen: false }">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-emerald-600 via-emerald-700 to-teal-800 shadow-xl transform transition-transform duration-300 ease-in-out"
               :class="{ '-translate-x-full': !sidebarOpen && window.innerWidth >= 1024, '-translate-x-full': !mobileMenuOpen && window.innerWidth < 1024 }">
            
            <!-- Logo -->
            <div class="p-6 border-b border-emerald-500/30">
                <a href="{{ auth()->user()->role === 'owner' ? route('owner.dashboard') : route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-shopping-bag text-emerald-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-white font-bold text-lg">Grosir Berkat Ibu</h1>
                        <p class="text-emerald-200 text-xs">{{ auth()->user()->role === 'owner' ? 'Owner Panel' : 'Admin Panel' }}</p>
                    </div>
                </a>
            </div>

            <!-- User Profile Mini -->
            <div class="p-4 border-b border-emerald-500/30">
                <div class="flex items-center gap-3 p-3 bg-emerald-500/20 rounded-xl">
                    <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center text-white font-bold shadow-lg">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-white font-semibold text-sm truncate">{{ auth()->user()->name }}</p>
                        <p class="text-emerald-200 text-xs capitalize">{{ auth()->user()->role }}</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="p-4 space-y-2 overflow-y-auto" style="max-height: calc(100vh - 280px);">
                <!-- Dashboard -->
                <a href="{{ auth()->user()->role === 'owner' ? route('owner.dashboard') : route('admin.dashboard') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl text-white/90 hover:bg-white/10 {{ request()->routeIs('admin.dashboard') || request()->routeIs('owner.dashboard') ? 'active bg-white/10' : '' }}">
                    <i class="fas fa-chart-pie w-5"></i>
                    <span>Dashboard</span>
                </a>

                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'owner')
                <!-- Produk -->
                <a href="{{ route('admin.products.index') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl text-white/90 hover:bg-white/10 {{ request()->routeIs('admin.products.*') ? 'active bg-white/10' : '' }}">
                    <i class="fas fa-boxes w-5"></i>
                    <span>Produk</span>
                </a>

                <!-- Pesanan -->
                <a href="{{ route('admin.orders.index') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl text-white/90 hover:bg-white/10 {{ request()->routeIs('admin.orders.*') ? 'active bg-white/10' : '' }}">
                    <i class="fas fa-shopping-cart w-5"></i>
                    <span>Pesanan</span>
                    @php
                        $pendingCount = \App\Models\Order::where('payment_status', 'pending')->count();
                    @endphp
                    @if($pendingCount > 0)
                    <span class="ml-auto bg-amber-500 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $pendingCount }}</span>
                    @endif
                </a>
                @endif

                <!-- Laporan -->
                <a href="{{ auth()->user()->role === 'owner' ? route('owner.reports.index') : route('admin.reports.index') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl text-white/90 hover:bg-white/10 {{ request()->routeIs('admin.reports.*') || request()->routeIs('owner.reports.*') ? 'active bg-white/10' : '' }}">
                    <i class="fas fa-chart-bar w-5"></i>
                    <span>Laporan</span>
                </a>

                @if(auth()->user()->role === 'owner')
                <!-- Divider -->
                <div class="border-t border-emerald-500/30 my-4"></div>
                <p class="px-4 text-emerald-300 text-xs font-semibold uppercase tracking-wider">Owner Menu</p>

                <!-- Pelanggan -->
                <a href="{{ route('owner.customers.index') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl text-white/90 hover:bg-white/10 {{ request()->routeIs('owner.customers.*') ? 'active bg-white/10' : '' }}">
                    <i class="fas fa-users w-5"></i>
                    <span>Kelola Pelanggan</span>
                </a>
                @endif
            </nav>

            <!-- Logout Button -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-emerald-500/30 bg-emerald-800/50">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-500/20 hover:bg-red-500/30 text-red-100 rounded-xl transition">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Mobile Overlay -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition-opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileMenuOpen = false"
             class="lg:hidden fixed inset-0 z-40 bg-black/50"></div>

        <!-- Main Content -->
        <div class="flex-1 lg:ml-64 transition-all duration-300">
            <!-- Top Header -->
            <header class="sticky top-0 z-30 bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-4 lg:px-8 h-16">
                    <!-- Left: Mobile Menu Button + Breadcrumb -->
                    <div class="flex items-center gap-4">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden text-gray-600 hover:text-emerald-600">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <nav class="hidden sm:flex items-center gap-2 text-sm">
                            <a href="{{ auth()->user()->role === 'owner' ? route('owner.dashboard') : route('admin.dashboard') }}" class="text-gray-500 hover:text-emerald-600">
                                <i class="fas fa-home"></i>
                            </a>
                            <span class="text-gray-400">/</span>
                            <span class="text-gray-700 font-medium">@yield('breadcrumb', 'Dashboard')</span>
                        </nav>
                    </div>

                    <!-- Right: Search + Notifications -->
                    <div class="flex items-center gap-4">
                        <!-- Search -->
                        <div class="hidden md:flex items-center">
                            <div class="relative">
                                <input type="text" placeholder="Cari..." class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>

                        <!-- Notifications -->
                        <div x-data="{ notifOpen: false }" class="relative">
                            <button @click="notifOpen = !notifOpen" class="relative text-gray-500 hover:text-emerald-600 focus:outline-none mt-1">
                                <i class="fas fa-bell text-xl"></i>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center animate-bounce">
                                    {{ auth()->user()->unreadNotifications->count() > 9 ? '9+' : auth()->user()->unreadNotifications->count() }}
                                </span>
                                @endif
                            </button>

                            <!-- Dropdown -->
                            <div x-show="notifOpen" @click.away="notifOpen = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-gray-200 py-0 z-50 overflow-hidden">
                                
                                <div class="px-4 py-3 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                                    <h3 class="font-bold text-gray-800 text-sm">Notifikasi</h3>
                                    @if(auth()->user()->unreadNotifications->count() > 0)
                                    <span class="text-xs text-emerald-600 font-medium">{{ auth()->user()->unreadNotifications->count() }} baru</span>
                                    @endif
                                </div>

                                <div class="max-h-64 overflow-y-auto">
                                    @forelse(auth()->user()->unreadNotifications as $notification)
                                        <a href="{{ $notification->data['link'] ?? '#' }}?mark_as_read={{ $notification->id }}" class="block px-4 py-3 hover:bg-gray-50 transition border-b border-gray-50">
                                            <div class="flex gap-3">
                                                <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                                                    <i class="fas fa-shopping-bag text-xs"></i>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-semibold text-gray-800">{{ $notification->data['message'] ?? 'Notifikasi Baru' }}</p>
                                                    <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    @empty
                                        <div class="px-4 py-8 text-center text-gray-500">
                                            <i class="fas fa-bell-slash text-2xl mb-2 text-gray-300"></i>
                                            <p class="text-sm">Tidak ada notifikasi baru</p>
                                        </div>
                                    @endforelse
                                </div>
                                
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                <a href="#" class="block px-4 py-2 text-center text-xs font-bold text-emerald-600 hover:bg-gray-50 border-t border-gray-100">
                                    Tandai semua dibaca
                                </a>
                                @endif
                            </div>
                        </div>

                        <!-- User Menu -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-2 text-gray-700 hover:text-emerald-600">
                                <div class="w-8 h-8 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden lg:block text-sm font-medium">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div x-show="open" @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50">
                                @if(auth()->user()->role === 'owner')
                                <a href="{{ route('owner.settings.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-cog w-4"></i> Pengaturan Toko
                                </a>
                                @endif
                                <a href="{{ route('home') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-store w-4"></i> Lihat Toko
                                </a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-2 w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <i class="fas fa-sign-out-alt w-4"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Flash Messages -->
            @if(session('success'))
            <div class="mx-4 lg:mx-8 mt-4 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl animate-fade-in">
                <div class="flex items-center gap-3">
                    <i class="fas fa-check-circle text-emerald-600 text-xl"></i>
                    <div>
                        <p class="text-emerald-800 font-semibold">Berhasil!</p>
                        <p class="text-emerald-700 text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="mx-4 lg:mx-8 mt-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl animate-fade-in">
                <div class="flex items-center gap-3">
                    <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                    <div>
                        <p class="text-red-800 font-semibold">Error!</p>
                        <p class="text-red-700 text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Page Content -->
            <main class="p-4 lg:p-8">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="border-t border-gray-200 bg-white px-4 lg:px-8 py-4">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-2 text-sm text-gray-500">
                    <p>&copy; {{ date('Y') }} Grosir Berkat Ibu. All rights reserved.</p>
                    <p class="flex items-center gap-1">
                        Made with <i class="fas fa-heart text-red-500"></i> in Indonesia
                    </p>
                </div>
            </footer>
        </div>
    </div>

    @stack('scripts')
</body>
</html>

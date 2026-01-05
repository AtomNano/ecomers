<aside class="w-64 bg-white shadow-soft border-r border-neutral-200 min-h-screen" x-data="{ open: false }">
    <!-- Logo -->
    <div class="p-6 border-b border-neutral-200">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-primary-600 rounded-lg flex items-center justify-center">
                <span class="text-white font-bold text-lg">BI</span>
            </div>
            <div>
                <h1 class="text-xl font-bold text-primary-900">Grosir Berkat Ibu</h1>
                <p class="text-xs text-neutral-600">Admin Panel</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="mt-6">
        <div class="px-3 space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" 
               class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-primary-100 text-primary-700' : 'text-neutral-700 hover:bg-neutral-100 hover:text-neutral-900' }}">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                </svg>
                Dashboard
            </a>

            <!-- Products -->
            <div x-data="{ open: {{ request()->routeIs('admin.products.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" 
                        class="group flex items-center justify-between w-full px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-primary-100 text-primary-700' : 'text-neutral-700 hover:bg-neutral-100 hover:text-neutral-900' }}">
                    <div class="flex items-center">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Produk
                    </div>
                    <svg class="h-4 w-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" x-transition class="ml-6 space-y-1">
                    <a href="{{ route('admin.products.index') }}" 
                       class="block px-3 py-2 text-sm text-neutral-600 hover:text-neutral-900 hover:bg-neutral-100 rounded-lg transition-colors">
                        Daftar Produk
                    </a>
                    <a href="{{ route('admin.products.create') }}" 
                       class="block px-3 py-2 text-sm text-neutral-600 hover:text-neutral-900 hover:bg-neutral-100 rounded-lg transition-colors">
                        Tambah Produk
                    </a>
                </div>
            </div>

            <!-- Orders -->
            <a href="{{ route('admin.orders.index') }}" 
               class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-primary-100 text-primary-700' : 'text-neutral-700 hover:bg-neutral-100 hover:text-neutral-900' }}">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Pesanan
                @if($pendingOrdersCount ?? 0 > 0)
                <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-1">{{ $pendingOrdersCount }}</span>
                @endif
            </a>

            <!-- Reports -->
            <a href="{{ route('admin.reports.index') }}" 
               class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.reports.*') ? 'bg-primary-100 text-primary-700' : 'text-neutral-700 hover:bg-neutral-100 hover:text-neutral-900' }}">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Laporan
            </a>
        </div>

        <!-- Owner Only Section -->
        @if(auth()->user()->role === 'owner')
        <div class="px-3 mt-6">
            <div class="border-t border-neutral-200 pt-6">
                <h3 class="px-3 text-xs font-semibold text-neutral-500 uppercase tracking-wider mb-3">Owner</h3>
                
                <!-- Customer Management -->
                <a href="{{ route('owner.customers.index') }}" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('owner.customers.*') ? 'bg-primary-100 text-primary-700' : 'text-neutral-700 hover:bg-neutral-100 hover:text-neutral-900' }}">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    Manajemen Pelanggan
                </a>

                <!-- Advanced Reports -->
                <a href="{{ route('owner.reports.index') }}" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('owner.reports.*') ? 'bg-primary-100 text-primary-700' : 'text-neutral-700 hover:bg-neutral-100 hover:text-neutral-900' }}">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Laporan Lanjutan
                </a>
            </div>
        </div>
        @endif
    </nav>

    <!-- User Info -->
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-neutral-200">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center">
                <span class="text-primary-600 font-medium text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-neutral-900 truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-neutral-500 capitalize">{{ auth()->user()->role }}</p>
            </div>
        </div>
    </div>
</aside>

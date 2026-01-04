<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Grosir Berkat Ibu - Platform Grosir Digital Terpercaya')</title>
    <meta name="description" content="@yield('description', 'Platform grosir digital terpercaya dengan sistem harga bertingkat yang fleksibel. Transaksi mudah, harga kompetitif, dan pengiriman cepat.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700,800" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Additional Meta Tags -->
    <meta property="og:title" content="@yield('title', 'Grosir Berkat Ibu')">
    <meta property="og:description" content="@yield('description', 'Platform grosir digital terpercaya')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
</head>
<body class="font-sans antialiased bg-neutral-50">
    <div id="app" class="min-h-screen flex flex-col">
        <!-- Navigation -->
        @include('layouts.frontend.navbar')

        <!-- Main Content -->
        <main class="flex-1">
            @yield('content')
        </main>

        <!-- Footer -->
        @include('layouts.frontend.footer')
    </div>

    <!-- Cart Sidebar -->
    @include('layouts.frontend.cart-sidebar')

    <!-- Scripts -->
    <script>
        // Global cart management
        window.cart = {
            items: @json(session('cart', [])),
            
            add(productId, quantity = 1) {
                // Implementation will be added
                console.log('Adding to cart:', productId, quantity);
            },
            
            remove(productId) {
                // Implementation will be added
                console.log('Removing from cart:', productId);
            },
            
            update(productId, quantity) {
                // Implementation will be added
                console.log('Updating cart:', productId, quantity);
            }
        };
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NaldiStore - Your Premium Shopping Destination</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="font-sans antialiased">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg fixed w-full z-50" x-data="{ isOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex-shrink-0 flex items-center">
                        <span class="text-2xl font-bold text-indigo-600">NaldiStore</span>
                    </a>
                    <div class="hidden md:ml-6 md:flex md:space-x-8">
                        <a href="#" class="text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 border-indigo-500 text-sm font-medium">Home</a>
                        <a href="#" class="text-gray-500 hover:text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium">Products</a>
                        <a href="#" class="text-gray-500 hover:text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-gray-300 text-sm font-medium">Categories</a>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="/login" class="relative inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Login
                        </a>
                    </div>
                    <button class="ml-4 relative rounded-full bg-white p-1 text-gray-400 hover:text-gray-500">
                        <span class="absolute -inset-1.5"></span>
                        <i class="fas fa-shopping-cart"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Animation -->
    <div class="relative bg-white overflow-hidden" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 500)">
        <div class="pt-16 pb-80 sm:pt-24 sm:pb-40 lg:pt-40 lg:pb-48">
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 sm:static">
                <div class="sm:max-w-lg" x-show="shown" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                    <h1 class="text-4xl font font-extrabold tracking-tight text-gray-900 sm:text-6xl">
                        New Season Styles Are Here
                    </h1>
                    <p class="mt-4 text-xl text-gray-500">
                        Discover the latest trends and exclusive collections that define modern fashion.
                    </p>
                    <a href="#" class="mt-8 inline-block bg-indigo-600 border border-transparent rounded-md py-3 px-8 text-center font-medium text-white hover:bg-indigo-700">
                        Shop Collection
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Categories -->
    <div class="bg-gray-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 text-center mb-12">
                Shop by Category
            </h2>
            <div class="grid grid-cols-1 gap-y-10 sm:grid-cols-2 gap-x-6 lg:grid-cols-3">
                <!-- Category 1 -->
                <div class="group relative">
                    <div class="relative w-full h-80 bg-white rounded-lg overflow-hidden group-hover:opacity-75 sm:aspect-w-2 sm:aspect-h-1 lg:aspect-w-1 lg:aspect-h-1">
                        <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b" alt="Fashion" class="w-full h-full object-center object-cover">
                    </div>
                    <h3 class="mt-6 text-sm text-gray-500">
                        <a href="#">
                            <span class="absolute inset-0"></span>
                            Fashion
                        </a>
                    </h3>
                    <p class="text-base font-semibold text-gray-900">New Arrivals</p>
                </div>

                <!-- Category 2 -->
                <div class="group relative">
                    <div class="relative w-full h-80 bg-white rounded-lg overflow-hidden group-hover:opacity-75 sm:aspect-w-2 sm:aspect-h-1 lg:aspect-w-1 lg:aspect-h-1">
                        <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e" alt="Electronics" class="w-full h-full object-center object-cover">
                    </div>
                    <h3 class="mt-6 text-sm text-gray-500">
                        <a href="#">
                            <span class="absolute inset-0"></span>
                            Electronics
                        </a>
                    </h3>
                    <p class="text-base font-semibold text-gray-900">Best Sellers</p>
                </div>

                <!-- Category 3 -->
                <div class="group relative">
                    <div class="relative w-full h-80 bg-white rounded-lg overflow-hidden group-hover:opacity-75 sm:aspect-w-2 sm:aspect-h-1 lg:aspect-w-1 lg:aspect-h-1">
                        <img src="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f" alt="Accessories" class="w-full h-full object-center object-cover">
                    </div>
                    <h3 class="mt-6 text-sm text-gray-500">
                        <a href="#">
                            <span class="absolute inset-0"></span>
                            Accessories
                        </a>
                    </h3>
                    <p class="text-base font-semibold text-gray-900">Must Have</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
            <div class="grid grid-cols-2 gap-8 md:grid-cols-4">
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">About</h3>
                    <ul role="list" class="mt-4 space-y-4">
                        <li><a href="#" class="text-base text-gray-300 hover:text-white">Company</a></li>
                        <li><a href="#" class="text-base text-gray-300 hover:text-white">Careers</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Support</h3>
                    <ul role="list" class="mt-4 space-y-4">
                        <li><a href="#" class="text-base text-gray-300 hover:text-white">Help Center</a></li>
                        <li><a href="#" class="text-base text-gray-300 hover:text-white">Contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Legal</h3>
                    <ul role="list" class="mt-4 space-y-4">
                        <li><a href="#" class="text-base text-gray-300 hover:text-white">Privacy</a></li>
                        <li><a href="#" class="text-base text-gray-300 hover:text-white">Terms</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Social</h3>
                    <ul role="list" class="mt-4 space-y-4">
                        <li><a href="#" class="text-base text-gray-300 hover:text-white">Instagram</a></li>
                        <li><a href="#" class="text-base text-gray-300 hover:text-white">Twitter</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 border-t border-gray-700 pt-8">
                <p class="text-base text-gray-400 xl:text-center">
                    &copy; 2025 NaldiStore. All rights reserved.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Grosir Berkat Ibu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { height: 100%; overflow: hidden; }
    </style>
</head>
<body class="h-screen overflow-hidden" x-data="{ showRegister: {{ request()->routeIs('register') ? 'true' : 'false' }} }">
    
    <!-- Full Screen Container -->
    <div class="h-screen w-screen flex overflow-hidden">
        
        <!-- Left Panel - Branding (Hidden on mobile, visible on lg+) -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-orange-500 via-red-500 to-pink-600 relative">
            <!-- Animated Background -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-20 left-20 w-40 h-40 bg-yellow-300/20 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-20 right-10 w-60 h-60 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute top-1/2 left-1/4 w-32 h-32 bg-orange-300/20 rounded-full blur-2xl animate-bounce" style="animation-duration: 3s;"></div>
                <div class="absolute bottom-1/3 right-1/4 w-24 h-24 bg-pink-300/20 rounded-full blur-2xl animate-ping" style="animation-duration: 4s;"></div>
            </div>
            
            <!-- Content -->
            <div class="relative z-10 flex flex-col justify-center items-center w-full p-12 text-white">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-4 mb-12 group">
                    <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-2xl group-hover:scale-110 transition">
                        <i class="fas fa-store text-4xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black">Grosir Berkat Ibu</h1>
                        <p class="text-white/70">Belanja Grosir Hemat</p>
                    </div>
                </a>
                
                <!-- Tagline -->
                <div class="text-center max-w-md mb-12">
                    <h2 class="text-4xl font-black mb-4 leading-tight">
                        Belanja Grosir<br>
                        <span class="text-yellow-300">Lebih Hemat!</span>
                    </h2>
                    <p class="text-white/80 text-lg">
                        Dapatkan harga terbaik untuk kebutuhan usaha Anda dengan sistem harga bertingkat.
                    </p>
                </div>
                
                <!-- Features -->
                <div class="space-y-4 w-full max-w-sm">
                    <div class="flex items-center gap-4 bg-white/10 backdrop-blur-sm rounded-2xl p-5 hover:bg-white/20 transition">
                        <div class="w-14 h-14 bg-yellow-400 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                            <i class="fas fa-tags text-2xl text-red-600"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">Harga Grosir Terbaik</h3>
                            <p class="text-sm text-white/70">Hemat hingga 50% untuk pembelian banyak</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 bg-white/10 backdrop-blur-sm rounded-2xl p-5 hover:bg-white/20 transition">
                        <div class="w-14 h-14 bg-yellow-400 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                            <i class="fas fa-truck text-2xl text-red-600"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">Pengiriman Cepat</h3>
                            <p class="text-sm text-white/70">Sampai dalam 1-3 hari kerja</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 bg-white/10 backdrop-blur-sm rounded-2xl p-5 hover:bg-white/20 transition">
                        <div class="w-14 h-14 bg-yellow-400 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                            <i class="fas fa-shield-alt text-2xl text-red-600"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">100% Produk Original</h3>
                            <p class="text-sm text-white/70">Garansi keaslian barang</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Panel - Forms -->
        <div class="w-full lg:w-1/2 bg-white flex flex-col">
            
            <!-- Mobile Header -->
            <div class="lg:hidden bg-gradient-to-r from-orange-500 via-red-500 to-pink-500 p-6 text-white text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                        <i class="fas fa-store text-2xl"></i>
                    </div>
                    <span class="text-xl font-bold">Grosir Berkat Ibu</span>
                </a>
            </div>
            
            <!-- Form Container -->
            <div class="flex-1 flex items-center justify-center p-6 lg:p-12 overflow-y-auto">
                <div class="w-full max-w-md">
                    
                    <!-- Login Form -->
                    <div x-show="!showRegister" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform translate-x-8"
                         x-transition:enter-end="opacity-100 transform translate-x-0"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 transform translate-x-0"
                         x-transition:leave-end="opacity-0 transform -translate-x-8">
                        
                        <div class="text-center mb-8">
                            <h2 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang!</h2>
                            <p class="text-gray-500">Masuk ke akun Anda untuk melanjutkan</p>
                        </div>
                        
                        <form action="{{ route('login') }}" method="POST" class="space-y-5">
                            @csrf
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" name="email" value="{{ old('email') }}" 
                                           placeholder="nama@email.com"
                                           class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition" required>
                                </div>
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" name="password" id="login-password"
                                           placeholder="••••••••"
                                           class="w-full pl-12 pr-12 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition" required>
                                    <button type="button" onclick="togglePassword('login-password', 'login-icon')" 
                                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-eye" id="login-icon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" name="remember" class="w-5 h-5 text-red-500 border-2 border-gray-300 rounded focus:ring-red-500">
                                    <span class="ml-2 text-gray-600">Ingat saya</span>
                                </label>
                                <a href="{{ route('forgot-password') }}" class="text-red-500 hover:text-red-600 font-medium text-sm">
                                    Lupa password?
                                </a>
                            </div>
                            
                            <button type="submit" class="w-full py-4 bg-gradient-to-r from-orange-500 to-red-500 text-white font-bold rounded-xl hover:from-orange-600 hover:to-red-600 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-lg">
                                <i class="fas fa-sign-in-alt mr-2"></i> Masuk
                            </button>
                        </form>
                        
                        <div class="mt-8 text-center">
                            <p class="text-gray-600">
                                Belum punya akun? 
                                <button @click="showRegister = true" class="text-red-500 hover:text-red-600 font-bold hover:underline">
                                    Daftar Sekarang
                                </button>
                            </p>
                        </div>
                        
                        <!-- Quick Login Dev -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <p class="text-xs text-gray-400 text-center mb-3">🚀 Quick Login (Development)</p>
                            <div class="grid grid-cols-4 gap-2">
                                <button type="button" onclick="quickLogin('admin@grosir.com', 'password123')" 
                                        class="py-2.5 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-xs font-bold transition shadow">
                                    Admin
                                </button>
                                <button type="button" onclick="quickLogin('owner@grosir.com', 'password123')" 
                                        class="py-2.5 bg-purple-500 hover:bg-purple-600 text-white rounded-lg text-xs font-bold transition shadow">
                                    Owner
                                </button>
                                <button type="button" onclick="quickLogin('budi@example.com', 'password123')" 
                                        class="py-2.5 bg-green-500 hover:bg-green-600 text-white rounded-lg text-xs font-bold transition shadow">
                                    Budi
                                </button>
                                <button type="button" onclick="quickLogin('siti@example.com', 'password123')" 
                                        class="py-2.5 bg-pink-500 hover:bg-pink-600 text-white rounded-lg text-xs font-bold transition shadow">
                                    Siti
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Register Form -->
                    <div x-show="showRegister" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform translate-x-8"
                         x-transition:enter-end="opacity-100 transform translate-x-0"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 transform translate-x-0"
                         x-transition:leave-end="opacity-0 transform -translate-x-8">
                        
                        <div class="text-center mb-6">
                            <h2 class="text-3xl font-bold text-gray-800 mb-2">Buat Akun Baru</h2>
                            <p class="text-gray-500">Daftar gratis dan mulai berbelanja</p>
                        </div>
                        
                        <form action="{{ route('register') }}" method="POST" class="space-y-4">
                            @csrf
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <input type="text" name="name" value="{{ old('name') }}" 
                                               placeholder="Nama Anda"
                                               class="w-full pl-10 pr-3 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition text-sm" required>
                                    </div>
                                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">No. WhatsApp</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                            <i class="fab fa-whatsapp"></i>
                                        </span>
                                        <input type="tel" name="phone" value="{{ old('phone') }}" 
                                               placeholder="08123456789"
                                               class="w-full pl-10 pr-3 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition text-sm" required>
                                    </div>
                                    @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" name="email" value="{{ old('email') }}" 
                                           placeholder="nama@email.com"
                                           class="w-full pl-10 pr-3 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition text-sm" required>
                                </div>
                                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Lengkap</label>
                                <textarea name="address" rows="2" 
                                          placeholder="Jl. Contoh No. 123, Kota"
                                          class="w-full px-3 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition text-sm" required>{{ old('address') }}</textarea>
                                @error('address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" name="password"
                                               placeholder="Min. 8 karakter"
                                               class="w-full pl-10 pr-3 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition text-sm" required>
                                    </div>
                                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" name="password_confirmation"
                                               placeholder="Ulangi password"
                                               class="w-full pl-10 pr-3 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition text-sm" required>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="w-full py-4 bg-gradient-to-r from-pink-500 to-red-500 text-white font-bold rounded-xl hover:from-pink-600 hover:to-red-600 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-lg">
                                <i class="fas fa-user-plus mr-2"></i> Daftar Sekarang
                            </button>
                        </form>
                        
                        <div class="mt-6 text-center">
                            <p class="text-gray-600">
                                Sudah punya akun? 
                                <button @click="showRegister = false" class="text-red-500 hover:text-red-600 font-bold hover:underline">
                                    Masuk
                                </button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="p-4 text-center border-t border-gray-100">
                <a href="{{ route('home') }}" class="text-gray-400 hover:text-red-500 text-sm inline-flex items-center gap-2 transition">
                    <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
    
    <script>
        function quickLogin(email, password) {
            document.querySelector('input[name="email"]').value = email;
            document.querySelector('input[name="password"]').value = password;
            document.querySelector('form').submit();
        }
        
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>

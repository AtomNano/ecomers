<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Grosir Berkat Ibu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { height: 100%; overflow: hidden; }
    </style>
</head>
<body class="h-screen overflow-hidden" x-data="{ showRegister: true }">
    
    <!-- Full Screen Container -->
    <div class="h-screen w-screen flex overflow-hidden">
        
        <!-- Left Panel - Branding -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-orange-500 via-red-500 to-pink-600 relative">
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-20 left-20 w-40 h-40 bg-yellow-300/20 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-20 right-10 w-60 h-60 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute top-1/2 left-1/4 w-32 h-32 bg-orange-300/20 rounded-full blur-2xl animate-bounce" style="animation-duration: 3s;"></div>
            </div>
            
            <div class="relative z-10 flex flex-col justify-center items-center w-full p-12 text-white">
                <a href="{{ route('home') }}" class="flex items-center gap-4 mb-12 group">
                    <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-2xl group-hover:scale-110 transition">
                        <i class="fas fa-store text-4xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black">Grosir Berkat Ibu</h1>
                        <p class="text-white/70">Belanja Grosir Hemat</p>
                    </div>
                </a>
                
                <div class="text-center max-w-md mb-12">
                    <h2 class="text-4xl font-black mb-4 leading-tight">
                        Bergabung<br>
                        <span class="text-yellow-300">Sekarang!</span>
                    </h2>
                    <p class="text-white/80 text-lg">
                        Daftar gratis dan nikmati harga grosir terbaik untuk usaha Anda.
                    </p>
                </div>
                
                <div class="space-y-4 w-full max-w-sm">
                    <div class="flex items-center gap-4 bg-white/10 backdrop-blur-sm rounded-2xl p-5">
                        <div class="w-14 h-14 bg-yellow-400 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                            <i class="fas fa-gift text-2xl text-red-600"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">Gratis Registrasi</h3>
                            <p class="text-sm text-white/70">Tanpa biaya apapun</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 bg-white/10 backdrop-blur-sm rounded-2xl p-5">
                        <div class="w-14 h-14 bg-yellow-400 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                            <i class="fas fa-percent text-2xl text-red-600"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">Diskon Member Baru</h3>
                            <p class="text-sm text-white/70">Promo spesial untuk Anda</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Panel - Forms -->
        <div class="w-full lg:w-1/2 bg-white flex flex-col">
            <div class="lg:hidden bg-gradient-to-r from-orange-500 via-red-500 to-pink-500 p-6 text-white text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                        <i class="fas fa-store text-2xl"></i>
                    </div>
                    <span class="text-xl font-bold">Grosir Berkat Ibu</span>
                </a>
            </div>
            
            <div class="flex-1 flex items-center justify-center p-6 lg:p-12 overflow-y-auto">
                <div class="w-full max-w-md">
                    <!-- Login Form -->
                    <div x-show="!showRegister" x-transition>
                        <div class="text-center mb-8">
                            <h2 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang!</h2>
                            <p class="text-gray-500">Masuk ke akun Anda</p>
                        </div>
                        
                        <form action="{{ route('login') }}" method="POST" class="space-y-5">
                            @csrf
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" placeholder="nama@email.com" class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password" placeholder="••••••••" class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                                </div>
                            </div>
                            <button type="submit" class="w-full py-4 bg-gradient-to-r from-orange-500 to-red-500 text-white font-bold rounded-xl hover:from-orange-600 hover:to-red-600 transition shadow-lg text-lg">
                                <i class="fas fa-sign-in-alt mr-2"></i> Masuk
                            </button>
                        </form>
                        <div class="mt-8 text-center">
                            <p class="text-gray-600">Belum punya akun? <button @click="showRegister = true" class="text-red-500 font-bold">Daftar Sekarang</button></p>
                        </div>
                    </div>
                    
                    <!-- Register Form -->
                    <div x-show="showRegister" x-transition>
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
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i class="fas fa-user"></i></span>
                                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama Anda" class="w-full pl-10 pr-3 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm" required>
                                    </div>
                                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">No. WhatsApp</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i class="fab fa-whatsapp"></i></span>
                                        <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="08123456789" class="w-full pl-10 pr-3 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm" required>
                                    </div>
                                    @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" class="w-full pl-10 pr-3 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm" required>
                                </div>
                                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Lengkap</label>
                                <textarea name="address" rows="2" placeholder="Jl. Contoh No. 123, Kota" class="w-full px-3 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm" required>{{ old('address') }}</textarea>
                                @error('address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i class="fas fa-lock"></i></span>
                                        <input type="password" name="password" placeholder="Min. 8 karakter" class="w-full pl-10 pr-3 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm" required>
                                    </div>
                                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i class="fas fa-lock"></i></span>
                                        <input type="password" name="password_confirmation" placeholder="Ulangi password" class="w-full pl-10 pr-3 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="w-full py-4 bg-gradient-to-r from-pink-500 to-red-500 text-white font-bold rounded-xl hover:from-pink-600 hover:to-red-600 transition shadow-lg text-lg">
                                <i class="fas fa-user-plus mr-2"></i> Daftar Sekarang
                            </button>
                        </form>
                        <div class="mt-6 text-center">
                            <p class="text-gray-600">Sudah punya akun? <button @click="showRegister = false" class="text-red-500 font-bold">Masuk</button></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-4 text-center border-t border-gray-100">
                <a href="{{ route('home') }}" class="text-gray-400 hover:text-red-500 text-sm inline-flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</body>
</html>

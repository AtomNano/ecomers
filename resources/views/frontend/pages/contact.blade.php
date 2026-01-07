@extends('layouts.frontend.app')

@section('title', 'Kontak - Grosir Berkat Ibu')
@section('description', 'Hubungi kami untuk informasi lebih lanjut tentang produk dan layanan Grosir Berkat Ibu.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-orange-500 via-red-500 to-pink-500 py-20 pb-32 overflow-hidden">
    <!-- Animated Background Shapes -->
    <div class="absolute inset-0">
        <div class="absolute top-10 left-10 w-32 h-32 bg-yellow-300 opacity-20 rounded-full animate-bounce" style="animation-duration: 3s;"></div>
        <div class="absolute bottom-20 right-20 w-48 h-48 bg-white opacity-10 rounded-full animate-pulse"></div>
        <div class="absolute top-1/2 left-1/3 w-24 h-24 bg-orange-300 opacity-15 rounded-full animate-ping" style="animation-duration: 2s;"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10 text-center text-white">
        <h1 class="text-4xl md:text-5xl font-black mb-6">Hubungi Kami</h1>
        <p class="text-xl text-white/90 max-w-2xl mx-auto leading-relaxed">
            Ada pertanyaan atau butuh bantuan? Tim customer service kami siap membantu Anda 24/7 untuk kebutuhan bisnis grosir Anda.
        </p>
    </div>
    
    <!-- Wave Divider -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#f9fafb"/>
        </svg>
    </div>
</section>

<!-- Contact Content -->
<div class="bg-gray-50 min-h-screen relative z-10 -mt-20 pb-20">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
            
            <!-- Contact Form -->
            <div class="bg-white rounded-3xl shadow-xl p-8 lg:p-10 animate-fade-in-left">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center text-red-500 text-xl">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Kirim Pesan</h2>
                        <p class="text-gray-500 text-sm">Kami akan membalas secepatnya</p>
                    </div>
                </div>
                
                <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input 
                                type="text" 
                                name="name"
                                class="w-full px-4 py-3 rounded-xl bg-gray-50 border-gray-200 focus:border-red-500 focus:bg-white focus:ring-red-200 transition duration-200"
                                placeholder="Masukkan nama lengkap"
                                required
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                            <input 
                                type="email" 
                                name="email"
                                class="w-full px-4 py-3 rounded-xl bg-gray-50 border-gray-200 focus:border-red-500 focus:bg-white focus:ring-red-200 transition duration-200"
                                placeholder="contoh@email.com"
                                required
                            >
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Telepon</label>
                        <input 
                            type="tel" 
                            name="phone"
                            class="w-full px-4 py-3 rounded-xl bg-gray-50 border-gray-200 focus:border-red-500 focus:bg-white focus:ring-red-200 transition duration-200"
                            placeholder="08xxxxxxxxxx"
                        >
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Subjek <span class="text-red-500">*</span></label>
                        <select name="subject" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-gray-200 focus:border-red-500 focus:bg-white focus:ring-red-200 transition duration-200" required>
                            <option value="">Pilih subjek</option>
                            <option value="general">Pertanyaan Umum</option>
                            <option value="product">Informasi Produk</option>
                            <option value="order">Status Pesanan</option>
                            <option value="complaint">Keluhan</option>
                            <option value="suggestion">Saran</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Pesan <span class="text-red-500">*</span></label>
                        <textarea 
                            name="message" 
                            rows="5"
                            class="w-full px-4 py-3 rounded-xl bg-gray-50 border-gray-200 focus:border-red-500 focus:bg-white focus:ring-red-200 transition duration-200"
                            placeholder="Tuliskan pesan Anda di sini..."
                            required
                        ></textarea>
                    </div>
                    
                    <button type="submit" class="w-full py-4 bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 text-white font-bold rounded-full shadow-lg transform hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i> Kirim Pesan
                    </button>
                </form>
            </div>

            <!-- Info & Map -->
            <div class="space-y-8 animate-fade-in-right">
                
                <!-- Info Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-6">
                    <!-- Address Card -->
                    <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-red-500 hover:shadow-lg transition">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center text-red-500 text-xl flex-shrink-0">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-lg mb-2">Alamat Kantor</h3>
                                <p class="text-gray-600 leading-relaxed">
                                    Jl.timur, Ulak Karang Utara, Kec. Padang Utara,<br>
                                    Kota Padang, Sumatera Barat 25000
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Card -->
                    <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-xl flex-shrink-0">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-lg mb-2">Kontak Kami</h3>
                                <p class="text-gray-600 mb-1">WhatsApp: 0812-3456-7890</p>
                                <p class="text-gray-600">Email: info@grosirberkatibu.com</p>
                            </div>
                        </div>
                    </div>

                    <!-- Hours Card -->
                    <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-xl flex-shrink-0">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-lg mb-2">Jam Operasional</h3>
                                <div class="flex justify-between gap-8 mb-1">
                                    <span class="text-gray-600">Senin - Sabtu</span>
                                    <span class="font-bold text-gray-800">07:00 - 17:45</span>
                                </div>
                                <div class="flex justify-between gap-8">
                                    <span class="text-gray-600">Minggu</span>
                                    <span class="font-bold text-red-500">Tutup</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Map Section -->
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border-4 border-white">
                    <div class="relative h-80 w-full">
                        <iframe 
                            src="https://maps.google.com/maps?width=100%25&height=600&hl=en&q=Grosir%20Berkat%20Ibu&t=&z=14&ie=UTF8&iwloc=B&output=embed" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy"
                            class="absolute inset-0 grayscale hover:grayscale-0 transition-all duration-500"
                            title="Lokasi Grosir Berkat Ibu"
                        ></iframe>
                        <!-- Overlay Label -->
                        <div class="absolute bottom-4 left-4 bg-white/90 backdrop-blur-sm px-4 py-2 rounded-full shadow-lg flex items-center gap-2">
                            <i class="fas fa-map-pin text-red-500 animate-bounce"></i>
                            <span class="text-sm font-bold text-gray-800">Lokasi Kami</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fadeInLeft {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes fadeInRight {
        from { opacity: 0; transform: translateX(30px); }
        to { opacity: 1; transform: translateX(0); }
    }
    .animate-fade-in-left { animation: fadeInLeft 0.8s ease-out; }
    .animate-fade-in-right { animation: fadeInRight 0.8s ease-out 0.2s backwards; }
</style>
@endsection

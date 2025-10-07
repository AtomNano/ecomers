@extends('layouts.frontend.app')

@section('title', 'Tentang Kami - Grosir Berkat Ibu')
@section('description', 'Pelajari lebih lanjut tentang Grosir Berkat Ibu, platform grosir digital terpercaya dengan sistem harga bertingkat yang fleksibel.')

@section('content')
<div class="bg-white">
    <div class="container-custom section-padding">
        <!-- Hero Section -->
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-neutral-900 mb-6">Tentang Grosir Berkat Ibu</h1>
            <p class="text-xl text-neutral-600 max-w-3xl mx-auto">
                Platform grosir digital terpercaya yang mentransformasi proses penjualan grosir 
                dari basis WhatsApp menjadi sistem digital yang terstruktur, otomatis, dan profesional.
            </p>
        </div>

        <!-- Mission & Vision -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
            <div class="card p-8">
                <div class="w-16 h-16 bg-primary-600 rounded-xl flex items-center justify-center mb-6">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-neutral-900 mb-4">Misi Kami</h2>
                <p class="text-neutral-600 leading-relaxed">
                    Menyediakan platform grosir digital yang memudahkan pelanggan untuk mendapatkan 
                    produk berkualitas dengan harga terbaik melalui sistem harga bertingkat yang fleksibel, 
                    transaksi yang aman, dan pengiriman yang cepat.
                </p>
            </div>

            <div class="card p-8">
                <div class="w-16 h-16 bg-primary-600 rounded-xl flex items-center justify-center mb-6">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-neutral-900 mb-4">Visi Kami</h2>
                <p class="text-neutral-600 leading-relaxed">
                    Menjadi platform grosir digital terdepan di Indonesia yang dikenal karena 
                    inovasi sistem harga bertingkat, kualitas produk terjamin, dan layanan 
                    pelanggan yang excellent.
                </p>
            </div>
        </div>

        <!-- Our Story -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-neutral-900 text-center mb-12">Cerita Kami</h2>
            <div class="max-w-4xl mx-auto">
                <div class="prose prose-lg max-w-none">
                    <p class="text-neutral-600 leading-relaxed mb-6">
                        Grosir Berkat Ibu lahir dari kebutuhan untuk mentransformasi bisnis grosir tradisional 
                        yang masih mengandalkan WhatsApp dan komunikasi manual menjadi platform digital yang 
                        terstruktur dan profesional.
                    </p>
                    <p class="text-neutral-600 leading-relaxed mb-6">
                        Kami memahami tantangan yang dihadapi oleh pelaku bisnis grosir dalam mengelola 
                        harga yang berbeda untuk berbagai tingkat pembelian, mengatur stok, dan melayani 
                        pelanggan dengan efisien. Oleh karena itu, kami mengembangkan sistem harga bertingkat 
                        yang dinamis dan mudah dikelola.
                    </p>
                    <p class="text-neutral-600 leading-relaxed">
                        Dengan pengalaman bertahun-tahun di industri grosir, tim kami berkomitmen untuk 
                        memberikan solusi terbaik yang memudahkan pelanggan mendapatkan produk berkualitas 
                        dengan harga yang kompetitif.
                    </p>
                </div>
            </div>
        </div>

        <!-- Values -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-neutral-900 text-center mb-12">Nilai-Nilai Kami</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-primary-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-neutral-900 mb-2">Kualitas</h3>
                    <p class="text-neutral-600">Produk berkualitas tinggi dengan standar internasional</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-primary-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-neutral-900 mb-2">Transparansi</h3>
                    <p class="text-neutral-600">Harga yang transparan dan sistem yang jelas</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-primary-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-neutral-900 mb-2">Kepercayaan</h3>
                    <p class="text-neutral-600">Membangun kepercayaan melalui layanan yang konsisten</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-primary-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-neutral-900 mb-2">Inovasi</h3>
                    <p class="text-neutral-600">Terus berinovasi untuk memberikan solusi terbaik</p>
                </div>
            </div>
        </div>

        <!-- Team -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-neutral-900 text-center mb-12">Tim Kami</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-24 h-24 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-primary-600">BI</span>
                    </div>
                    <h3 class="text-xl font-semibold text-neutral-900 mb-2">Tim Development</h3>
                    <p class="text-neutral-600">Mengembangkan platform yang user-friendly dan reliable</p>
                </div>

                <div class="text-center">
                    <div class="w-24 h-24 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-primary-600">CS</span>
                    </div>
                    <h3 class="text-xl font-semibold text-neutral-900 mb-2">Customer Service</h3>
                    <p class="text-neutral-600">Melayani pelanggan dengan profesional dan responsif</p>
                </div>

                <div class="text-center">
                    <div class="w-24 h-24 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-primary-600">LG</span>
                    </div>
                    <h3 class="text-xl font-semibold text-neutral-900 mb-2">Logistics</h3>
                    <p class="text-neutral-600">Memastikan pengiriman tepat waktu dan aman</p>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="bg-primary-50 rounded-2xl p-8 text-center">
            <h2 class="text-2xl font-bold text-neutral-900 mb-4">Bergabunglah dengan Kami</h2>
            <p class="text-neutral-600 mb-6 max-w-2xl mx-auto">
                Dapatkan akses ke ribuan produk berkualitas dengan sistem harga bertingkat yang menguntungkan
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="btn-primary text-lg px-8 py-4">
                    Daftar Sekarang
                </a>
                <a href="{{ route('contact') }}" class="btn-outline text-lg px-8 py-4">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
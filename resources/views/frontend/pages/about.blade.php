@extends('layouts.frontend.app')

@section('title', 'Tentang Kami - Grosir Berkat Ibu')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Tentang Grosir Berkat Ibu</h1>
            <p class="mt-4 text-lg text-gray-500">Solusi kebutuhan harian Anda dengan harga grosir terbaik</p>
        </div>

        <div class="mt-16 grid grid-cols-1 gap-8 lg:grid-cols-2 lg:gap-16">
            <!-- Company Info -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Informasi Perusahaan</h2>
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Nama Tempat Grosir</h3>
                        <p class="mt-1 text-gray-600">Grosir Berkat Ibu</p>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Lokasi Grosir</h3>
                        <p class="mt-1 text-gray-600">
                            Jl. Contoh No. 123<br>
                            Padang, Sumatera Barat<br>
                            Indonesia 25111
                        </p>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Nomor Telepon</h3>
                        <p class="mt-1 text-gray-600">+62 812-3456-7890</p>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Email</h3>
                        <p class="mt-1 text-gray-600">info@grosirberkatibu.com</p>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Jam Operasional</h3>
                        <p class="mt-1 text-gray-600">
                            Senin - Jumat: 08:00 - 17:00<br>
                            Sabtu: 08:00 - 15:00<br>
                            Minggu: Tutup
                        </p>
                    </div>
                </div>
            </div>

            <!-- Map -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Lokasi Kami</h2>
                <div class="bg-gray-200 rounded-lg h-96 flex items-center justify-center">
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">Peta Lokasi</p>
                        <p class="text-xs text-gray-400">Integrasikan dengan Google Maps</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- About Us -->
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Tentang Kami</h2>
            <div class="prose prose-lg text-gray-600 max-w-none">
                <p>
                    Grosir Berkat Ibu adalah toko grosir yang telah melayani kebutuhan harian masyarakat Padang dan sekitarnya 
                    selama bertahun-tahun. Kami berkomitmen untuk menyediakan produk berkualitas dengan harga grosir yang terjangkau.
                </p>
                <p>
                    Dengan pengalaman yang luas dalam bidang grosir, kami memahami kebutuhan pelanggan dan selalu berusaha 
                    memberikan pelayanan terbaik. Produk-produk yang kami tawarkan meliputi berbagai kebutuhan sehari-hari 
                    dengan kualitas terjamin dan harga yang kompetitif.
                </p>
                <p>
                    Visi kami adalah menjadi grosir terpercaya yang dapat diandalkan oleh masyarakat untuk memenuhi 
                    kebutuhan harian mereka. Misi kami adalah menyediakan produk berkualitas dengan harga terjangkau 
                    dan pelayanan yang memuaskan.
                </p>
            </div>
        </div>

        <!-- Services -->
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Layanan Kami</h2>
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Harga Grosir</h3>
                    <p class="mt-2 text-gray-600">Harga terbaik untuk pembelian dalam jumlah besar</p>
                </div>
                
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Kualitas Terjamin</h3>
                    <p class="mt-2 text-gray-600">Produk berkualitas tinggi dengan standar terbaik</p>
                </div>
                
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Pelayanan 24/7</h3>
                    <p class="mt-2 text-gray-600">Customer service siap membantu kapan saja</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection





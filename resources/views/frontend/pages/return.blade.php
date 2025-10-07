@extends('layouts.frontend.app')

@section('title', 'Kebijakan Retur - Grosir Berkat Ibu')
@section('description', 'Informasi lengkap tentang kebijakan retur dan pengembalian produk di Grosir Berkat Ibu.')

@section('content')
<div class="bg-white">
    <div class="container-custom section-padding">
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-neutral-900 mb-6">Kebijakan Retur</h1>
            <p class="text-xl text-neutral-600 max-w-3xl mx-auto">
                Kami berkomitmen memberikan kepuasan pelanggan dengan kebijakan retur yang jelas dan mudah dipahami
            </p>
        </div>

        <!-- Return Policy Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
            <div>
                <h2 class="text-2xl font-bold text-neutral-900 mb-6">Syarat & Ketentuan Retur</h2>
                <div class="space-y-6">
                    <div class="card p-6">
                        <h3 class="text-lg font-semibold text-neutral-900 mb-4">Produk yang Dapat Dikembalikan</h3>
                        <ul class="space-y-2 text-neutral-600">
                            <li class="flex items-start">
                                <svg class="h-4 w-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Produk rusak saat diterima
                            </li>
                            <li class="flex items-start">
                                <svg class="h-4 w-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Produk tidak sesuai dengan pesanan
                            </li>
                            <li class="flex items-start">
                                <svg class="h-4 w-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Produk kadaluarsa atau mendekati kadaluarsa
                            </li>
                            <li class="flex items-start">
                                <svg class="h-4 w-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Produk tidak sesuai dengan deskripsi
                            </li>
                        </ul>
                    </div>

                    <div class="card p-6">
                        <h3 class="text-lg font-semibold text-neutral-900 mb-4">Produk yang Tidak Dapat Dikembalikan</h3>
                        <ul class="space-y-2 text-neutral-600">
                            <li class="flex items-start">
                                <svg class="h-4 w-4 text-red-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                Produk makanan yang sudah dibuka
                            </li>
                            <li class="flex items-start">
                                <svg class="h-4 w-4 text-red-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                Produk yang sudah digunakan
                            </li>
                            <li class="flex items-start">
                                <svg class="h-4 w-4 text-red-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                Produk yang rusak karena kelalaian customer
                            </li>
                            <li class="flex items-start">
                                <svg class="h-4 w-4 text-red-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                Produk yang sudah lewat masa retur (7 hari)
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-2xl font-bold text-neutral-900 mb-6">Proses Retur</h2>
                <div class="space-y-4">
                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <span class="text-sm font-medium text-primary-600">1</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-neutral-900 mb-1">Ajukan Retur</h3>
                            <p class="text-neutral-600 text-sm">Hubungi customer service atau ajukan melalui halaman pesanan dalam 7 hari setelah produk diterima</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <span class="text-sm font-medium text-primary-600">2</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-neutral-900 mb-1">Verifikasi</h3>
                            <p class="text-neutral-600 text-sm">Tim kami akan memverifikasi kelayakan retur dan memberikan nomor retur</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <span class="text-sm font-medium text-primary-600">3</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-neutral-900 mb-1">Kirim Produk</h3>
                            <p class="text-neutral-600 text-sm">Kirim produk kembali ke alamat yang telah ditentukan dengan nomor retur</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <span class="text-sm font-medium text-primary-600">4</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-neutral-900 mb-1">Proses & Refund</h3>
                            <p class="text-neutral-600 text-sm">Setelah produk diterima dan diverifikasi, kami akan memproses pengembalian dana dalam 3-5 hari kerja</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Return Form -->
        <div class="card p-8 mb-16">
            <h2 class="text-2xl font-bold text-neutral-900 mb-6">Formulir Retur</h2>
            <form class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">Nomor Pesanan *</label>
                        <input 
                            type="text" 
                            name="order_number"
                            class="input-field"
                            placeholder="Masukkan nomor pesanan"
                            required
                        >
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">Nama Lengkap *</label>
                        <input 
                            type="text" 
                            name="name"
                            class="input-field"
                            placeholder="Masukkan nama lengkap"
                            required
                        >
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">Email *</label>
                        <input 
                            type="email" 
                            name="email"
                            class="input-field"
                            placeholder="contoh@email.com"
                            required
                        >
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">Telepon *</label>
                        <input 
                            type="tel" 
                            name="phone"
                            class="input-field"
                            placeholder="08xxxxxxxxxx"
                            required
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-2">Produk yang Dikembalikan *</label>
                    <select name="product" class="input-field" required>
                        <option value="">Pilih produk</option>
                        <option value="product1">Beras Premium 5kg</option>
                        <option value="product2">Minyak Goreng 1L</option>
                        <option value="product3">Gula Pasir 1kg</option>
                        <option value="other">Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-2">Alasan Retur *</label>
                    <select name="reason" class="input-field" required>
                        <option value="">Pilih alasan</option>
                        <option value="damaged">Produk rusak saat diterima</option>
                        <option value="wrong">Produk tidak sesuai pesanan</option>
                        <option value="expired">Produk kadaluarsa</option>
                        <option value="description">Tidak sesuai deskripsi</option>
                        <option value="other">Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-2">Deskripsi Masalah *</label>
                    <textarea 
                        name="description" 
                        rows="4"
                        class="input-field"
                        placeholder="Jelaskan masalah yang Anda alami dengan detail..."
                        required
                    ></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-2">Upload Foto Produk</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-neutral-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-neutral-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-neutral-600">
                                <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                    <span>Upload foto</span>
                                    <input id="file-upload" name="file-upload" type="file" class="sr-only" multiple>
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-neutral-500">PNG, JPG, GIF hingga 10MB</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input 
                            id="terms" 
                            name="terms" 
                            type="checkbox" 
                            class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-neutral-300 rounded"
                            required
                        >
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="font-medium text-neutral-700">
                            Saya menyetujui <a href="#" class="text-primary-600 hover:text-primary-500">syarat dan ketentuan retur</a>
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn-primary">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    Ajukan Retur
                </button>
            </form>
        </div>

        <!-- Contact Information -->
        <div class="text-center">
            <h2 class="text-2xl font-bold text-neutral-900 mb-6">Butuh Bantuan?</h2>
            <p class="text-neutral-600 mb-8 max-w-2xl mx-auto">
                Jika Anda memiliki pertanyaan tentang proses retur atau membutuhkan bantuan, jangan ragu untuk menghubungi tim customer service kami
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="tel:+622112345678" class="btn-primary">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    +62 21 1234 5678
                </a>
                
                <a href="mailto:info@grosirberkatibu.com" class="btn-outline">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    info@grosirberkatibu.com
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

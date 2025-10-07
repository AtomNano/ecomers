@extends('layouts.frontend.app')

@section('title', 'Informasi Pengiriman - Grosir Berkat Ibu')
@section('description', 'Informasi lengkap tentang layanan pengiriman dan biaya pengiriman Grosir Berkat Ibu.')

@section('content')
<div class="bg-white">
    <div class="container-custom section-padding">
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-neutral-900 mb-6">Informasi Pengiriman</h1>
            <p class="text-xl text-neutral-600 max-w-3xl mx-auto">
                Kami menyediakan berbagai pilihan pengiriman yang aman, cepat, dan terjangkau untuk memastikan produk sampai dengan selamat
            </p>
        </div>

        <!-- Shipping Methods -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            <!-- GoSend -->
            <div class="card p-6 text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-neutral-900 mb-2">GoSend</h3>
                <p class="text-neutral-600 mb-4">Pengiriman same-day untuk area Jakarta dan sekitarnya</p>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-neutral-600">Waktu:</span>
                        <span class="font-medium">Same Day</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-neutral-600">Biaya:</span>
                        <span class="font-medium">Mulai Rp 8.000</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-neutral-600">Tracking:</span>
                        <span class="font-medium">Real-time</span>
                    </div>
                </div>
            </div>

            <!-- Self Pickup -->
            <div class="card p-6 text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-neutral-900 mb-2">Ambil Sendiri</h3>
                <p class="text-neutral-600 mb-4">Pengambilan langsung di gudang kami</p>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-neutral-600">Waktu:</span>
                        <span class="font-medium">Sesuai jam kerja</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-neutral-600">Biaya:</span>
                        <span class="font-medium">Gratis</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-neutral-600">Lokasi:</span>
                        <span class="font-medium">Gudang Jakarta</span>
                    </div>
                </div>
            </div>

            <!-- External Courier -->
            <div class="card p-6 text-center">
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-neutral-900 mb-2">Kurir Eksternal</h3>
                <p class="text-neutral-600 mb-4">JNE, TIKI, Pos Indonesia untuk seluruh Indonesia</p>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-neutral-600">Waktu:</span>
                        <span class="font-medium">1-7 hari</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-neutral-600">Biaya:</span>
                        <span class="font-medium">Sesuai tarif</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-neutral-600">Jangkauan:</span>
                        <span class="font-medium">Seluruh Indonesia</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delivery Areas & Costs -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
            <!-- Delivery Areas -->
            <div>
                <h2 class="text-2xl font-bold text-neutral-900 mb-6">Area Pengiriman</h2>
                <div class="space-y-6">
                    <div class="card p-6">
                        <h3 class="text-lg font-semibold text-neutral-900 mb-3">Jakarta & Sekitarnya</h3>
                        <ul class="space-y-2 text-neutral-600">
                            <li class="flex items-center">
                                <svg class="h-4 w-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Jakarta Pusat, Utara, Selatan, Timur, Barat
                            </li>
                            <li class="flex items-center">
                                <svg class="h-4 w-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Tangerang, Depok, Bekasi, Bogor
                            </li>
                            <li class="flex items-center">
                                <svg class="h-4 w-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Waktu pengiriman: 1-2 hari kerja
                            </li>
                        </ul>
                    </div>

                    <div class="card p-6">
                        <h3 class="text-lg font-semibold text-neutral-900 mb-3">Luar Jakarta</h3>
                        <ul class="space-y-2 text-neutral-600">
                            <li class="flex items-center">
                                <svg class="h-4 w-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Jawa Barat, Jawa Tengah, Jawa Timur
                            </li>
                            <li class="flex items-center">
                                <svg class="h-4 w-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Sumatera, Kalimantan, Sulawesi
                            </li>
                            <li class="flex items-center">
                                <svg class="h-4 w-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Waktu pengiriman: 3-7 hari kerja
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Shipping Costs -->
            <div>
                <h2 class="text-2xl font-bold text-neutral-900 mb-6">Estimasi Biaya Pengiriman</h2>
                <div class="card p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-neutral-200">
                                    <th class="text-left py-3 font-medium text-neutral-900">Area</th>
                                    <th class="text-left py-3 font-medium text-neutral-900">GoSend</th>
                                    <th class="text-left py-3 font-medium text-neutral-900">Kurir</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-100">
                                <tr>
                                    <td class="py-3 text-neutral-600">Jakarta Pusat</td>
                                    <td class="py-3 font-medium">Rp 8.000</td>
                                    <td class="py-3 font-medium">Rp 12.000</td>
                                </tr>
                                <tr>
                                    <td class="py-3 text-neutral-600">Jakarta Selatan</td>
                                    <td class="py-3 font-medium">Rp 10.000</td>
                                    <td class="py-3 font-medium">Rp 15.000</td>
                                </tr>
                                <tr>
                                    <td class="py-3 text-neutral-600">Tangerang</td>
                                    <td class="py-3 font-medium">Rp 12.000</td>
                                    <td class="py-3 font-medium">Rp 18.000</td>
                                </tr>
                                <tr>
                                    <td class="py-3 text-neutral-600">Bekasi</td>
                                    <td class="py-3 font-medium">Rp 15.000</td>
                                    <td class="py-3 font-medium">Rp 20.000</td>
                                </tr>
                                <tr>
                                    <td class="py-3 text-neutral-600">Bandung</td>
                                    <td class="py-3 font-medium">-</td>
                                    <td class="py-3 font-medium">Rp 25.000</td>
                                </tr>
                                <tr>
                                    <td class="py-3 text-neutral-600">Surabaya</td>
                                    <td class="py-3 font-medium">-</td>
                                    <td class="py-3 font-medium">Rp 35.000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <p class="text-xs text-neutral-500 mt-4">
                        * Biaya dapat berubah sesuai berat dan dimensi paket
                    </p>
                </div>
            </div>
        </div>

        <!-- Pickup Location -->
        <div class="card p-8 mb-16">
            <h2 class="text-2xl font-bold text-neutral-900 mb-6">Lokasi Pengambilan Sendiri</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-lg font-semibold text-neutral-900 mb-4">Alamat Gudang</h3>
                    <div class="space-y-3 text-neutral-600">
                        <p><strong>Grosir Berkat Ibu</strong></p>
                        <p>Jl. Raya No. 123, Jakarta Selatan<br>DKI Jakarta 12345</p>
                        <p>Telepon: +62 21 1234 5678</p>
                    </div>
                    
                    <div class="mt-6">
                        <h4 class="font-medium text-neutral-900 mb-2">Jam Operasional</h4>
                        <div class="space-y-1 text-sm text-neutral-600">
                            <p>Senin - Jumat: 08:00 - 17:00</p>
                            <p>Sabtu: 08:00 - 15:00</p>
                            <p>Minggu: Tutup</p>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold text-neutral-900 mb-4">Syarat Pengambilan</h3>
                    <ul class="space-y-2 text-neutral-600">
                        <li class="flex items-start">
                            <svg class="h-4 w-4 text-primary-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Bawa bukti pesanan (email atau screenshot)
                        </li>
                        <li class="flex items-start">
                            <svg class="h-4 w-4 text-primary-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Bawa identitas diri (KTP/SIM)
                        </li>
                        <li class="flex items-start">
                            <svg class="h-4 w-4 text-primary-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Konfirmasi pengambilan minimal 2 jam sebelumnya
                        </li>
                        <li class="flex items-start">
                            <svg class="h-4 w-4 text-primary-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Paket akan disimpan maksimal 7 hari
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Tracking Information -->
        <div class="text-center">
            <h2 class="text-2xl font-bold text-neutral-900 mb-6">Lacak Pengiriman</h2>
            <p class="text-neutral-600 mb-8">Masukkan nomor resi untuk melacak status pengiriman Anda</p>
            
            <div class="max-w-md mx-auto">
                <div class="flex space-x-2">
                    <input 
                        type="text" 
                        placeholder="Masukkan nomor resi"
                        class="input-field flex-1"
                    >
                    <button class="btn-primary">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Lacak
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

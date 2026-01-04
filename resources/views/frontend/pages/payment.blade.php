@extends('layouts.frontend.app')

@section('title', 'Metode Pembayaran - Grosir Berkat Ibu')
@section('description', 'Informasi lengkap tentang metode pembayaran yang tersedia di Grosir Berkat Ibu.')

@section('content')
<div class="bg-white">
    <div class="container-custom section-padding">
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-neutral-900 mb-6">Metode Pembayaran</h1>
            <p class="text-xl text-neutral-600 max-w-3xl mx-auto">
                Kami menyediakan berbagai metode pembayaran yang aman, mudah, dan terpercaya untuk kenyamanan berbelanja Anda
            </p>
        </div>

        <!-- Payment Methods -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            <!-- Virtual Account -->
            <div class="card p-6 text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-neutral-900 mb-2">Virtual Account</h3>
                <p class="text-neutral-600 mb-4">Transfer bank langsung tanpa kartu kredit</p>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-neutral-600">Bank:</span>
                        <span class="font-medium">BCA, Mandiri, BRI</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-neutral-600">Biaya:</span>
                        <span class="font-medium">Gratis</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-neutral-600">Waktu:</span>
                        <span class="font-medium">Instan</span>
                    </div>
                </div>
            </div>

            <!-- QRIS -->
            <div class="card p-6 text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-4v4m0-4h4m-4 0V9a2 2 0 012-2h2a2 2 0 012 2v2m-6 0h4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-neutral-900 mb-2">QRIS</h3>
                <p class="text-neutral-600 mb-4">Scan QR code dengan aplikasi e-wallet</p>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-neutral-600">E-wallet:</span>
                        <span class="font-medium">GoPay, OVO, DANA</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-neutral-600">Biaya:</span>
                        <span class="font-medium">Gratis</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-neutral-600">Waktu:</span>
                        <span class="font-medium">Instan</span>
                    </div>
                </div>
            </div>

            <!-- Bank Transfer -->
            <div class="card p-6 text-center">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-neutral-900 mb-2">Transfer Bank</h3>
                <p class="text-neutral-600 mb-4">Transfer manual ke rekening tujuan</p>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-neutral-600">Bank:</span>
                        <span class="font-medium">BCA, Mandiri, BRI</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-neutral-600">Biaya:</span>
                        <span class="font-medium">Sesuai bank</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-neutral-600">Waktu:</span>
                        <span class="font-medium">1-3 jam</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Process -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
            <!-- Automatic Payment -->
            <div>
                <h2 class="text-2xl font-bold text-neutral-900 mb-6">Pembayaran Otomatis</h2>
                <div class="space-y-6">
                    <div class="card p-6">
                        <h3 class="text-lg font-semibold text-neutral-900 mb-4">Virtual Account & QRIS</h3>
                        <div class="space-y-3">
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <span class="text-xs font-medium text-primary-600">1</span>
                                </div>
                                <p class="text-neutral-600">Pilih metode pembayaran Virtual Account atau QRIS</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <span class="text-xs font-medium text-primary-600">2</span>
                                </div>
                                <p class="text-neutral-600">Sistem akan menampilkan nomor VA atau QR code</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <span class="text-xs font-medium text-primary-600">3</span>
                                </div>
                                <p class="text-neutral-600">Lakukan pembayaran sesuai instruksi</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <span class="text-xs font-medium text-primary-600">4</span>
                                </div>
                                <p class="text-neutral-600">Status pesanan akan otomatis berubah menjadi "Dibayar"</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-start space-x-3">
                            <svg class="h-5 w-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <h4 class="font-medium text-green-800">Keamanan Terjamin</h4>
                                <p class="text-sm text-green-700">Semua transaksi dilindungi enkripsi SSL dan diproses melalui Midtrans yang bersertifikat PCI DSS</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Manual Payment -->
            <div>
                <h2 class="text-2xl font-bold text-neutral-900 mb-6">Pembayaran Manual</h2>
                <div class="space-y-6">
                    <div class="card p-6">
                        <h3 class="text-lg font-semibold text-neutral-900 mb-4">Transfer Bank Manual</h3>
                        <div class="space-y-3">
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <span class="text-xs font-medium text-primary-600">1</span>
                                </div>
                                <p class="text-neutral-600">Pilih metode "Transfer Bank Manual"</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <span class="text-xs font-medium text-primary-600">2</span>
                                </div>
                                <p class="text-neutral-600">Catat nomor rekening dan nominal yang harus dibayar</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <span class="text-xs font-medium text-primary-600">3</span>
                                </div>
                                <p class="text-neutral-600">Lakukan transfer sesuai nominal yang tertera</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <span class="text-xs font-medium text-primary-600">4</span>
                                </div>
                                <p class="text-neutral-600">Upload bukti transfer di halaman pesanan</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <span class="text-xs font-medium text-primary-600">5</span>
                                </div>
                                <p class="text-neutral-600">Tunggu konfirmasi dari admin (maksimal 24 jam)</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start space-x-3">
                            <svg class="h-5 w-5 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <h4 class="font-medium text-blue-800">Penting!</h4>
                                <p class="text-sm text-blue-700">Pastikan nominal transfer sesuai persis dengan yang tertera. Transfer dengan nominal berbeda akan ditolak.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bank Accounts -->
        <div class="card p-8 mb-16">
            <h2 class="text-2xl font-bold text-neutral-900 mb-6">Rekening Tujuan</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center p-4 border border-neutral-200 rounded-lg">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-lg font-bold text-blue-600">BCA</span>
                    </div>
                    <h3 class="font-semibold text-neutral-900 mb-2">Bank Central Asia</h3>
                    <p class="text-sm text-neutral-600 mb-1">No. Rekening:</p>
                    <p class="font-mono text-lg font-bold text-neutral-900">1234567890</p>
                    <p class="text-sm text-neutral-600">a.n. Grosir Berkat Ibu</p>
                </div>

                <div class="text-center p-4 border border-neutral-200 rounded-lg">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-lg font-bold text-red-600">MDR</span>
                    </div>
                    <h3 class="font-semibold text-neutral-900 mb-2">Bank Mandiri</h3>
                    <p class="text-sm text-neutral-600 mb-1">No. Rekening:</p>
                    <p class="font-mono text-lg font-bold text-neutral-900">0987654321</p>
                    <p class="text-sm text-neutral-600">a.n. Grosir Berkat Ibu</p>
                </div>

                <div class="text-center p-4 border border-neutral-200 rounded-lg">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-lg font-bold text-orange-600">BRI</span>
                    </div>
                    <h3 class="font-semibold text-neutral-900 mb-2">Bank Rakyat Indonesia</h3>
                    <p class="text-sm text-neutral-600 mb-1">No. Rekening:</p>
                    <p class="font-mono text-lg font-bold text-neutral-900">1122334455</p>
                    <p class="text-sm text-neutral-600">a.n. Grosir Berkat Ibu</p>
                </div>
            </div>
        </div>

        <!-- Payment Security -->
        <div class="text-center">
            <h2 class="text-2xl font-bold text-neutral-900 mb-6">Keamanan Pembayaran</h2>
            <p class="text-neutral-600 mb-8 max-w-3xl mx-auto">
                Kami menggunakan teknologi keamanan terdepan untuk melindungi setiap transaksi Anda
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-neutral-900 mb-2">Enkripsi SSL</h3>
                    <p class="text-sm text-neutral-600">Semua data transaksi dienkripsi dengan teknologi SSL 256-bit</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-neutral-900 mb-2">PCI DSS</h3>
                    <p class="text-sm text-neutral-600">Sertifikat keamanan internasional untuk perlindungan data kartu</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-neutral-900 mb-2">Real-time Monitoring</h3>
                    <p class="text-sm text-neutral-600">Sistem monitoring 24/7 untuk mendeteksi aktivitas mencurigakan</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

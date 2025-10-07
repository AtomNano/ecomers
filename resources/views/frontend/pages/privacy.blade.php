@extends('layouts.frontend.app')

@section('title', 'Kebijakan Privasi - Grosir Berkat Ibu')
@section('description', 'Kebijakan privasi dan perlindungan data pribadi di Grosir Berkat Ibu.')

@section('content')
<div class="bg-white">
    <div class="container-custom section-padding">
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-neutral-900 mb-6">Kebijakan Privasi</h1>
            <p class="text-xl text-neutral-600 max-w-3xl mx-auto">
                Kami menghargai privasi Anda dan berkomitmen melindungi informasi pribadi yang Anda berikan kepada kami
            </p>
            <p class="text-sm text-neutral-500 mt-4">Terakhir diperbarui: {{ date('d F Y') }}</p>
        </div>

        <div class="max-w-4xl mx-auto prose prose-lg">
            <!-- Introduction -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-neutral-900 mb-4">Pendahuluan</h2>
                <p class="text-neutral-600 leading-relaxed">
                    Grosir Berkat Ibu ("kami", "kita", atau "perusahaan") menghormati privasi pengunjung dan pengguna layanan kami. 
                    Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, menyimpan, dan melindungi informasi 
                    pribadi Anda ketika Anda menggunakan website dan layanan kami.
                </p>
            </div>

            <!-- Information We Collect -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-neutral-900 mb-4">Informasi yang Kami Kumpulkan</h2>
                
                <h3 class="text-xl font-semibold text-neutral-900 mb-3">Informasi yang Anda Berikan Langsung</h3>
                <ul class="list-disc list-inside text-neutral-600 space-y-2 mb-6">
                    <li>Nama lengkap dan informasi kontak (email, nomor telepon)</li>
                    <li>Alamat pengiriman dan penagihan</li>
                    <li>Informasi akun (username, password)</li>
                    <li>Informasi pembayaran (nomor kartu kredit, rekening bank)</li>
                    <li>Komunikasi dengan customer service</li>
                    <li>Review dan rating produk</li>
                </ul>

                <h3 class="text-xl font-semibold text-neutral-900 mb-3">Informasi yang Dikumpulkan Otomatis</h3>
                <ul class="list-disc list-inside text-neutral-600 space-y-2 mb-6">
                    <li>Alamat IP dan informasi perangkat</li>
                    <li>Jenis browser dan sistem operasi</li>
                    <li>Halaman yang dikunjungi dan waktu kunjungan</li>
                    <li>Data penggunaan website dan aplikasi</li>
                    <li>Cookies dan teknologi pelacakan serupa</li>
                </ul>

                <h3 class="text-xl font-semibold text-neutral-900 mb-3">Informasi dari Sumber Lain</h3>
                <ul class="list-disc list-inside text-neutral-600 space-y-2">
                    <li>Informasi dari media sosial (jika Anda login melalui media sosial)</li>
                    <li>Informasi dari mitra bisnis</li>
                    <li>Informasi dari layanan analitik pihak ketiga</li>
                </ul>
            </div>

            <!-- How We Use Information -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-neutral-900 mb-4">Bagaimana Kami Menggunakan Informasi</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="card p-6">
                        <h3 class="text-lg font-semibold text-neutral-900 mb-3">Layanan Utama</h3>
                        <ul class="list-disc list-inside text-neutral-600 space-y-1 text-sm">
                            <li>Memproses dan mengirimkan pesanan</li>
                            <li>Mengelola akun pengguna</li>
                            <li>Menyediakan customer service</li>
                            <li>Memproses pembayaran</li>
                        </ul>
                    </div>

                    <div class="card p-6">
                        <h3 class="text-lg font-semibold text-neutral-900 mb-3">Peningkatan Layanan</h3>
                        <ul class="list-disc list-inside text-neutral-600 space-y-1 text-sm">
                            <li>Menganalisis penggunaan website</li>
                            <li>Mengembangkan fitur baru</li>
                            <li>Meningkatkan pengalaman pengguna</li>
                            <li>Melakukan riset pasar</li>
                        </ul>
                    </div>

                    <div class="card p-6">
                        <h3 class="text-lg font-semibold text-neutral-900 mb-3">Komunikasi</h3>
                        <ul class="list-disc list-inside text-neutral-600 space-y-1 text-sm">
                            <li>Mengirim notifikasi pesanan</li>
                            <li>Mengirim newsletter dan promosi</li>
                            <li>Merespons pertanyaan dan keluhan</li>
                            <li>Mengirim update penting</li>
                        </ul>
                    </div>

                    <div class="card p-6">
                        <h3 class="text-lg font-semibold text-neutral-900 mb-3">Keamanan & Legal</h3>
                        <ul class="list-disc list-inside text-neutral-600 space-y-1 text-sm">
                            <li>Mencegah penipuan dan penyalahgunaan</li>
                            <li>Mematuhi kewajiban hukum</li>
                            <li>Melindungi hak dan properti</li>
                            <li>Menegakkan syarat dan ketentuan</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Information Sharing -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-neutral-900 mb-4">Berbagi Informasi</h2>
                <p class="text-neutral-600 leading-relaxed mb-4">
                    Kami tidak menjual, menyewakan, atau membagikan informasi pribadi Anda kepada pihak ketiga, kecuali dalam situasi berikut:
                </p>
                
                <div class="space-y-4">
                    <div class="card p-6">
                        <h3 class="text-lg font-semibold text-neutral-900 mb-2">Penyedia Layanan</h3>
                        <p class="text-neutral-600 text-sm">
                            Kami dapat membagikan informasi dengan penyedia layanan terpercaya yang membantu kami mengoperasikan website dan layanan, 
                            seperti penyedia hosting, layanan pembayaran, dan layanan pengiriman.
                        </p>
                    </div>

                    <div class="card p-6">
                        <h3 class="text-lg font-semibold text-neutral-900 mb-2">Kewajiban Hukum</h3>
                        <p class="text-neutral-600 text-sm">
                            Kami dapat mengungkapkan informasi jika diwajibkan oleh hukum, perintah pengadilan, atau untuk melindungi hak, 
                            properti, atau keselamatan kami dan pengguna lainnya.
                        </p>
                    </div>

                    <div class="card p-6">
                        <h3 class="text-lg font-semibold text-neutral-900 mb-2">Persetujuan</h3>
                        <p class="text-neutral-600 text-sm">
                            Kami dapat membagikan informasi dengan persetujuan eksplisit Anda untuk tujuan tertentu.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Data Security -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-neutral-900 mb-4">Keamanan Data</h2>
                <p class="text-neutral-600 leading-relaxed mb-4">
                    Kami menerapkan langkah-langkah keamanan teknis dan organisasi yang sesuai untuk melindungi informasi pribadi Anda:
                </p>
                
                <ul class="list-disc list-inside text-neutral-600 space-y-2">
                    <li>Enkripsi SSL/TLS untuk transmisi data</li>
                    <li>Penyimpanan data yang aman dengan enkripsi</li>
                    <li>Akses terbatas hanya untuk personel yang berwenang</li>
                    <li>Pemantauan keamanan 24/7</li>
                    <li>Pelatihan keamanan untuk staf</li>
                    <li>Audit keamanan berkala</li>
                </ul>
            </div>

            <!-- Cookies -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-neutral-900 mb-4">Cookies dan Teknologi Pelacakan</h2>
                <p class="text-neutral-600 leading-relaxed mb-4">
                    Kami menggunakan cookies dan teknologi serupa untuk meningkatkan pengalaman Anda di website kami:
                </p>
                
                <div class="space-y-4">
                    <div class="card p-6">
                        <h3 class="text-lg font-semibold text-neutral-900 mb-2">Cookies Esensial</h3>
                        <p class="text-neutral-600 text-sm">
                            Diperlukan untuk fungsi dasar website seperti navigasi, akses ke area aman, dan mengingat preferensi Anda.
                        </p>
                    </div>

                    <div class="card p-6">
                        <h3 class="text-lg font-semibold text-neutral-900 mb-2">Cookies Analitik</h3>
                        <p class="text-neutral-600 text-sm">
                            Membantu kami memahami bagaimana pengunjung berinteraksi dengan website melalui pengumpulan dan pelaporan informasi secara anonim.
                        </p>
                    </div>

                    <div class="card p-6">
                        <h3 class="text-lg font-semibold text-neutral-900 mb-2">Cookies Pemasaran</h3>
                        <p class="text-neutral-600 text-sm">
                            Digunakan untuk menampilkan iklan yang relevan dan mengukur efektivitas kampanye pemasaran.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Your Rights -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-neutral-900 mb-4">Hak Anda</h2>
                <p class="text-neutral-600 leading-relaxed mb-4">
                    Anda memiliki hak-hak berikut terkait informasi pribadi Anda:
                </p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-start space-x-3">
                        <svg class="h-5 w-5 text-primary-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-neutral-600">Akses ke informasi pribadi Anda</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <svg class="h-5 w-5 text-primary-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-neutral-600">Koreksi informasi yang tidak akurat</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <svg class="h-5 w-5 text-primary-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-neutral-600">Penghapusan informasi pribadi</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <svg class="h-5 w-5 text-primary-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-neutral-600">Pembatasan pemrosesan data</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <svg class="h-5 w-5 text-primary-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-neutral-600">Portabilitas data</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <svg class="h-5 w-5 text-primary-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-neutral-600">Keberatan terhadap pemrosesan</span>
                    </div>
                </div>
            </div>

            <!-- Data Retention -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-neutral-900 mb-4">Penyimpanan Data</h2>
                <p class="text-neutral-600 leading-relaxed">
                    Kami menyimpan informasi pribadi Anda selama diperlukan untuk memenuhi tujuan yang dijelaskan dalam Kebijakan Privasi ini, 
                    atau sesuai dengan kewajiban hukum kami. Data yang tidak lagi diperlukan akan dihapus secara aman.
                </p>
            </div>

            <!-- Children's Privacy -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-neutral-900 mb-4">Privasi Anak-anak</h2>
                <p class="text-neutral-600 leading-relaxed">
                    Layanan kami tidak ditujukan untuk anak-anak di bawah 13 tahun. Kami tidak secara sengaja mengumpulkan informasi pribadi 
                    dari anak-anak di bawah 13 tahun. Jika kami mengetahui bahwa kami telah mengumpulkan informasi pribadi dari anak di bawah 13 tahun, 
                    kami akan segera menghapus informasi tersebut.
                </p>
            </div>

            <!-- Changes to Policy -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-neutral-900 mb-4">Perubahan Kebijakan</h2>
                <p class="text-neutral-600 leading-relaxed">
                    Kami dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu. Perubahan material akan diberitahukan melalui email 
                    atau pemberitahuan di website kami. Kami mendorong Anda untuk meninjau Kebijakan Privasi ini secara berkala.
                </p>
            </div>

            <!-- Contact Information -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-neutral-900 mb-4">Kontak</h2>
                <p class="text-neutral-600 leading-relaxed mb-4">
                    Jika Anda memiliki pertanyaan tentang Kebijakan Privasi ini atau ingin menggunakan hak-hak Anda, 
                    silakan hubungi kami:
                </p>
                
                <div class="card p-6">
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <svg class="h-5 w-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-neutral-600">Email: privacy@grosirberkatibu.com</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg class="h-5 w-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span class="text-neutral-600">Telepon: +62 21 1234 5678</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg class="h-5 w-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-neutral-600">Alamat: Jl. Raya No. 123, Jakarta Selatan, DKI Jakarta 12345</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

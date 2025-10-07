@extends('layouts.frontend.app')

@section('title', 'FAQ - Grosir Berkat Ibu')
@section('description', 'Pertanyaan yang sering diajukan tentang produk dan layanan Grosir Berkat Ibu.')

@section('content')
<div class="bg-white">
    <div class="container-custom section-padding">
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-neutral-900 mb-6">Pertanyaan yang Sering Diajukan</h1>
            <p class="text-xl text-neutral-600 max-w-3xl mx-auto">
                Temukan jawaban untuk pertanyaan umum tentang produk, pengiriman, dan layanan kami
            </p>
        </div>

        <div class="max-w-4xl mx-auto">
            <!-- FAQ Categories -->
            <div class="flex flex-wrap justify-center gap-4 mb-12">
                <button class="faq-category active" data-category="general">
                    Umum
                </button>
                <button class="faq-category" data-category="product">
                    Produk
                </button>
                <button class="faq-category" data-category="order">
                    Pesanan
                </button>
                <button class="faq-category" data-category="shipping">
                    Pengiriman
                </button>
                <button class="faq-category" data-category="payment">
                    Pembayaran
                </button>
            </div>

            <!-- FAQ Items -->
            <div class="space-y-4">
                <!-- General FAQs -->
                <div class="faq-section" data-category="general">
                    <div class="faq-item">
                        <button class="faq-question">
                            <span>Apa itu Grosir Berkat Ibu?</span>
                            <svg class="faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <p>Grosir Berkat Ibu adalah platform e-commerce yang menyediakan berbagai produk kebutuhan sehari-hari dengan sistem harga bertingkat. Kami fokus pada kualitas produk dan pelayanan terbaik untuk memenuhi kebutuhan keluarga Indonesia.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question">
                            <span>Bagaimana cara mendaftar sebagai customer?</span>
                            <svg class="faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <p>Untuk mendaftar, klik tombol "Daftar" di pojok kanan atas website, isi formulir pendaftaran dengan data yang valid, verifikasi email Anda, dan akun Anda siap digunakan untuk berbelanja.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question">
                            <span>Apakah ada biaya pendaftaran?</span>
                            <svg class="faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <p>Tidak ada biaya pendaftaran sama sekali. Pendaftaran sebagai customer di Grosir Berkat Ibu adalah gratis dan tidak ada biaya tersembunyi.</p>
                        </div>
                    </div>
                </div>

                <!-- Product FAQs -->
                <div class="faq-section hidden" data-category="product">
                    <div class="faq-item">
                        <button class="faq-question">
                            <span>Bagaimana sistem harga bertingkat bekerja?</span>
                            <svg class="faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <p>Sistem harga bertingkat memberikan harga yang berbeda berdasarkan jumlah pembelian. Semakin banyak Anda membeli, semakin murah harga per unitnya. Misalnya: 1 pcs = Rp 10.000, 5 pcs = Rp 9.000/pcs, 12 pcs = Rp 8.500/pcs.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question">
                            <span>Apakah produk yang dijual original dan berkualitas?</span>
                            <svg class="faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <p>Ya, semua produk yang kami jual adalah original dan berkualitas tinggi. Kami bekerja sama dengan distributor resmi dan supplier terpercaya untuk memastikan kualitas produk yang terbaik.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question">
                            <span>Bagaimana jika produk yang saya terima rusak?</span>
                            <svg class="faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <p>Jika produk yang Anda terima rusak, segera hubungi customer service kami dengan menyertakan foto produk yang rusak. Kami akan mengganti produk tersebut atau mengembalikan uang Anda sesuai kebijakan garansi kami.</p>
                        </div>
                    </div>
                </div>

                <!-- Order FAQs -->
                <div class="faq-section hidden" data-category="order">
                    <div class="faq-item">
                        <button class="faq-question">
                            <span>Bagaimana cara memesan produk?</span>
                            <svg class="faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <p>Pilih produk yang diinginkan, tentukan jumlah pembelian, klik "Tambahkan ke Keranjang", lanjutkan ke checkout, isi data pengiriman, pilih metode pembayaran, dan selesaikan pembayaran. Pesanan Anda akan segera diproses.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question">
                            <span>Bisakah saya membatalkan pesanan?</span>
                            <svg class="faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <p>Pesanan dapat dibatalkan jika statusnya masih "Menunggu Pembayaran" atau "Belum Dibayar". Setelah status berubah menjadi "Diproses", pesanan tidak dapat dibatalkan. Silakan hubungi customer service untuk bantuan lebih lanjut.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question">
                            <span>Bagaimana cara melacak pesanan saya?</span>
                            <svg class="faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <p>Anda dapat melacak pesanan melalui halaman "Riwayat Pesanan" di akun Anda. Status pesanan akan diperbarui secara real-time, dan Anda akan menerima notifikasi email setiap ada perubahan status.</p>
                        </div>
                    </div>
                </div>

                <!-- Shipping FAQs -->
                <div class="faq-section hidden" data-category="shipping">
                    <div class="faq-item">
                        <button class="faq-question">
                            <span>Berapa lama waktu pengiriman?</span>
                            <svg class="faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <p>Waktu pengiriman bervariasi tergantung lokasi dan metode pengiriman yang dipilih. Untuk area Jakarta: 1-2 hari kerja, untuk area Jabodetabek: 2-3 hari kerja, untuk luar kota: 3-7 hari kerja.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question">
                            <span>Apakah ada opsi pengambilan sendiri?</span>
                            <svg class="faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <p>Ya, tersedia opsi "Ambil Sendiri" dengan biaya pengiriman Rp 0. Anda dapat mengambil pesanan langsung di gudang kami dengan membawa bukti pesanan dan identitas diri.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question">
                            <span>Berapa biaya pengiriman?</span>
                            <svg class="faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <p>Biaya pengiriman bervariasi tergantung lokasi, berat paket, dan metode pengiriman. Biaya akan ditampilkan saat checkout. Untuk pengiriman GoSend, biaya dihitung berdasarkan jarak dan berat paket.</p>
                        </div>
                    </div>
                </div>

                <!-- Payment FAQs -->
                <div class="faq-section hidden" data-category="payment">
                    <div class="faq-item">
                        <button class="faq-question">
                            <span>Metode pembayaran apa saja yang tersedia?</span>
                            <svg class="faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <p>Kami menyediakan berbagai metode pembayaran: Virtual Account (BCA, Mandiri, BRI), QRIS, Transfer Bank Manual, dan E-wallet (GoPay, OVO, DANA). Semua pembayaran diproses melalui Midtrans yang aman dan terpercaya.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question">
                            <span>Apakah pembayaran aman?</span>
                            <svg class="faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <p>Ya, semua transaksi dilindungi dengan enkripsi SSL dan diproses melalui Midtrans yang telah bersertifikat PCI DSS. Data kartu kredit tidak disimpan di server kami untuk keamanan maksimal.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-question">
                            <span>Bagaimana jika pembayaran gagal?</span>
                            <svg class="faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <p>Jika pembayaran gagal, pesanan akan otomatis dibatalkan. Anda dapat mencoba lagi dengan metode pembayaran yang sama atau berbeda. Pastikan saldo atau limit kartu Anda mencukupi sebelum melakukan pembayaran.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.faq-category {
    @apply px-6 py-3 rounded-full text-sm font-medium transition-colors duration-200;
    @apply bg-neutral-100 text-neutral-600 hover:bg-primary-100 hover:text-primary-600;
}

.faq-category.active {
    @apply bg-primary-600 text-white hover:bg-primary-700;
}

.faq-item {
    @apply bg-white rounded-lg border border-neutral-200 overflow-hidden;
}

.faq-question {
    @apply w-full px-6 py-4 text-left flex items-center justify-between;
    @apply hover:bg-neutral-50 transition-colors duration-200;
}

.faq-question span {
    @apply font-medium text-neutral-900;
}

.faq-icon {
    @apply h-5 w-5 text-neutral-500 transition-transform duration-200;
}

.faq-question[aria-expanded="true"] .faq-icon {
    @apply rotate-180;
}

.faq-answer {
    @apply px-6 pb-4 text-neutral-600 leading-relaxed;
    display: none;
}

.faq-answer.show {
    display: block;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // FAQ Category Tabs
    const categoryButtons = document.querySelectorAll('.faq-category');
    const faqSections = document.querySelectorAll('.faq-section');

    categoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            const category = this.dataset.category;
            
            // Update active category button
            categoryButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Show/hide FAQ sections
            faqSections.forEach(section => {
                if (section.dataset.category === category) {
                    section.classList.remove('hidden');
                } else {
                    section.classList.add('hidden');
                }
            });
        });
    });

    // FAQ Accordion
    const faqQuestions = document.querySelectorAll('.faq-question');

    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
            const answer = this.nextElementSibling;
            const isOpen = answer.classList.contains('show');
            
            // Close all other answers
            faqQuestions.forEach(q => {
                const a = q.nextElementSibling;
                a.classList.remove('show');
                q.setAttribute('aria-expanded', 'false');
            });
            
            // Toggle current answer
            if (!isOpen) {
                answer.classList.add('show');
                this.setAttribute('aria-expanded', 'true');
            }
        });
    });
});
</script>
@endsection

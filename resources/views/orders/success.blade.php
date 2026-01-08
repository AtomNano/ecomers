@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto p-4 mt-16 mb-12">

        <!-- Success Message -->
        <div class="text-center mb-8">
            <div class="text-green-500 mb-4">
                <svg class="w-20 h-20 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-800">Bukti Diterima!</h2>
            <p class="text-gray-600 mt-2">Invoice: <span
                    class="font-mono font-bold text-blue-600">{{ $order->invoice_number }}</span></p>
        </div>

        <!-- Dynamic 4-Step Progress Tracker -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 mb-6">
            <h3 class="font-bold text-gray-800 mb-6 text-center">Status Pesanan</h3>

            <div class="relative flex justify-between items-center w-full max-w-lg mx-auto">
                <!-- Progress Bar Line -->
                <div class="absolute top-1/2 left-0 w-full h-1 bg-gray-200 -z-10 transform -translate-y-1/2 rounded-full">
                </div>
                @php
                    $steps = [
                        'pending' => 1,
                        'payment_verified' => 2,
                        'processing' => 2, // Grouped with payment verified
                        'shipped' => 3,
                        'completed' => 4,
                        'cancelled' => 0
                    ];
                    $currentStep = $steps[$order->status] ?? 1;
                    $progressWidth = ($currentStep - 1) / 3 * 100;
                @endphp
                <div class="absolute top-1/2 left-0 h-1 bg-green-500 -z-10 transform -translate-y-1/2 rounded-full transition-all duration-1000"
                    style="width: {{ $progressWidth }}%"></div>

                <!-- Step 1: Menunggu Verifikasi -->
                <div class="flex flex-col items-center gap-2">
                    <div
                        class="w-10 h-10 rounded-full flex items-center justify-center border-4 {{ $currentStep >= 1 ? 'bg-green-500 border-green-500 text-white' : 'bg-white border-gray-200 text-gray-400' }} transition-colors">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <p class="text-xs font-bold {{ $currentStep >= 1 ? 'text-green-600' : 'text-gray-400' }}">Verifikasi</p>
                </div>

                <!-- Step 2: Diproses -->
                <div class="flex flex-col items-center gap-2">
                    <div
                        class="w-10 h-10 rounded-full flex items-center justify-center border-4 {{ $currentStep >= 2 ? 'bg-green-500 border-green-500 text-white' : 'bg-white border-gray-200 text-gray-400' }} transition-colors">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <p class="text-xs font-bold {{ $currentStep >= 2 ? 'text-green-600' : 'text-gray-400' }}">Diproses</p>
                </div>

                <!-- Step 3: Dikirim -->
                <div class="flex flex-col items-center gap-2">
                    <div
                        class="w-10 h-10 rounded-full flex items-center justify-center border-4 {{ $currentStep >= 3 ? 'bg-green-500 border-green-500 text-white' : 'bg-white border-gray-200 text-gray-400' }} transition-colors">
                        <i class="fas fa-truck"></i>
                    </div>
                    <p class="text-xs font-bold {{ $currentStep >= 3 ? 'text-green-600' : 'text-gray-400' }}">Dikirim</p>
                </div>

                <!-- Step 4: Selesai -->
                <div class="flex flex-col items-center gap-2">
                    <div
                        class="w-10 h-10 rounded-full flex items-center justify-center border-4 {{ $currentStep >= 4 ? 'bg-green-500 border-green-500 text-white' : 'bg-white border-gray-200 text-gray-400' }} transition-colors">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <p class="text-xs font-bold {{ $currentStep >= 4 ? 'text-green-600' : 'text-gray-400' }}">Selesai</p>
                </div>
            </div>

            <!-- Status Text Detail -->
            <div class="mt-8 text-center bg-gray-50 p-4 rounded-lg">
                <p class="font-semibold text-gray-800">
                    Status Saat Ini:
                    <span class="text-green-600">
                        @if($order->status == 'pending') Menunggu Verifikasi Pembayaran
                        @elseif($order->status == 'payment_verified' || $order->status == 'processing') Pesanan Sedang
                            Dikemas
                        @elseif($order->status == 'shipped') Pesanan Sedang Dikirim
                        @elseif($order->status == 'completed') Pesanan Selesai
                        @elseif($order->status == 'cancelled') Pesanan Dibatalkan
                        @endif
                    </span>
                </p>
                <p class="text-xs text-gray-500 mt-1">Terakhir update: {{ $order->updated_at->format('d M Y, H:i') }}</p>
            </div>
        </div>

        <!-- WhatsApp CTA Section -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 mb-6">
            <h3 class="font-semibold text-gray-800 mb-3">Perlu Bantuan?</h3>
            <p class="text-sm text-gray-600 mb-4">Klik tombol di bawah untuk hubungi admin kami via WhatsApp jika ada
                pertanyaan.</p>

            @php
                $adminPhone = '6281234567890'; // Ganti dengan nomor WhatsApp admin
                $message = "Halo Admin, saya sudah melakukan pembayaran dan upload bukti untuk Order ID: " . $order->invoice_number . ". Mohon segera diproses. Terima kasih! 🙏";
                $waLink = "https://wa.me/" . $adminPhone . "?text=" . urlencode($message);
            @endphp

            <a href="{{ $waLink }}" target="_blank"
                class="inline-flex w-full items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg transition shadow-lg">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.017-1.04 2.48 0 1.463 1.065 2.876 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                </svg>
                Chat Admin via WhatsApp
            </a>
        </div>

        <!-- Info Box -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <p class="text-xs text-blue-800">
                <strong>💡 Catatan:</strong> Status pesanan Anda dapat dilihat di halaman "Pesanan Saya". Kami akan
                memberitahu setiap update melalui WhatsApp atau SMS.
            </p>
        </div>

        <!-- Back to Orders -->
        <div class="mt-6 text-center">
            <a href="{{ route('customer.orders') }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm">
                ← Kembali ke Daftar Pesanan
            </a>
        </div>
    </div>

    <style>
        /* Animation untuk success icon */
        @keyframes scaleUp {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        svg.w-20 {
            animation: scaleUp 0.6s ease-out;
        }
    </style>
@endsection
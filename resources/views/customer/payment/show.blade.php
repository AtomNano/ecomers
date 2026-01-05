@extends('layouts.app')

@section('title', 'Pembayaran - Grosir Berkat Ibu')

@section('content')
<div class="max-w-xl mx-auto p-4 mt-8 mb-12">
    
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Selesaikan Pembayaran</h2>
        <p class="text-gray-500">Invoice: <span class="font-mono font-bold text-blue-600">#{{ $order->id }}</span></p>
    </div>

    <!-- Status Badge -->
    <div class="mb-6 flex justify-center">
        @if($payment->status === 'pending')
             <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full font-bold flex items-center gap-2 animate-pulse">
                <i class="fas fa-clock"></i> Menunggu Pembayaran
             </span>
        @elseif($payment->status === 'verified')
             <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full font-bold flex items-center gap-2">
                <i class="fas fa-check-circle"></i> Pembayaran Terverifikasi
             </span>
        @else
             <span class="px-4 py-2 bg-red-100 text-red-800 rounded-full font-bold flex items-center gap-2">
                <i class="fas fa-times-circle"></i> Pembayaran Ditolak
             </span>
        @endif
    </div>

    <!-- Total Amount Card -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6 border border-gray-200">
        <div class="bg-blue-50 p-4 border-b border-blue-100">
            <div class="flex justify-between items-center">
                <span class="text-sm text-blue-800 font-semibold">Total Tagihan</span>
                <span class="text-2xl font-bold text-blue-700">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
            <div class="text-xs text-blue-600 mt-1">*Mohon transfer tepat hingga 3 digit terakhir agar verifikasi otomatis.</div>
        </div>

        <!-- Bank Account & QRIS Section -->
        <div class="p-6 space-y-6">
            <!-- Bank Information -->
            @if(isset($storeSetting->bank_name) && isset($storeSetting->bank_account_number))
                <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:border-blue-400 transition">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-12 bg-blue-600 rounded flex items-center justify-center">
                            <span class="text-white font-bold text-lg"><i class="fas fa-university"></i></span>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">{{ $storeSetting->bank_name }}</div>
                            <div class="font-bold text-gray-800 tracking-wider text-lg" id="rek-bank">{{ $storeSetting->bank_account_number }}</div>
                            <div class="text-xs text-gray-400">a.n {{ $storeSetting->bank_account_holder }}</div>
                        </div>
                    </div>
                    <button onclick="copyToClipboard('rek-bank')" class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition font-medium">
                        <i class="far fa-copy"></i> Salin
                    </button>
                </div>
            @endif

            <!-- QRIS Section -->
            @if(isset($storeSetting->qris_image))
                <div class="text-center pt-4 border-t border-gray-100">
                    <p class="text-sm font-semibold text-gray-700 mb-3">Atau Scan QRIS Kami</p>
                    <div class="bg-gray-50 rounded-xl p-3 inline-block border border-gray-200 shadow-sm">
                        <img src="{{ asset('storage/' . $storeSetting->qris_image) }}" class="max-w-[250px] rounded-lg" alt="QRIS Code">
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Dukung semua E-Wallet & Mobile Banking via QRIS</p>
                </div>
            @endif
            
            @if(!isset($storeSetting->bank_name) && !isset($storeSetting->qris_image))
                <div class="text-center p-6 bg-yellow-50 text-yellow-700 rounded-xl border border-yellow-200 text-sm">
                    <i class="fas fa-exclamation-triangle text-xl mb-2 block"></i>
                    Informasi pembayaran belum diatur oleh admin. Silakan hubungi WA admin.
                </div>
            @endif
        </div>
    </div>

    <!-- Payment Proof Upload Card -->
    @if($payment->status === 'pending' || $payment->status === 'rejected')
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
        <h3 class="font-bold text-gray-800 mb-4 text-lg">Konfirmasi Pembayaran</h3>
        
        <form action="{{ route('customer.payment.uploadProof', $order->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Upload Bukti Transfer</label>
                <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-blue-500 transition text-center cursor-pointer bg-gray-50 hover:bg-blue-50" id="dropzone">
                    <input type="file" name="proof_image" id="file-upload" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*" required>
                    
                    <!-- Preview Container (Hidden by default) -->
                    <div id="preview-container" class="hidden">
                        <img id="preview-image" src="#" alt="Preview" class="max-h-48 mx-auto rounded shadow-sm">
                        <p class="text-xs text-green-600 mt-2 font-bold">✓ File terpilih. Klik tombol di bawah untuk kirim.</p>
                    </div>

                    <!-- Placeholder Text -->
                    <div id="placeholder-text">
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                        <p class="mt-2 text-sm text-gray-600 font-medium">Klik untuk upload foto struk/screenshot</p>
                        <p class="mt-1 text-xs text-gray-500">PNG, JPG, WebP up to 2MB</p>
                    </div>
                </div>
                @error('proof_image')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg shadow transition duration-200 flex items-center justify-center gap-2">
                <i class="fas fa-paper-plane"></i> Kirim Bukti Pembayaran
            </button>
        </form>

        <!-- Info Box -->
        <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-3">
            <p class="text-xs text-blue-800">
                <strong>💡 Tips:</strong> Pastikan struk/screenshot jelas terlihat nomor referensi dan nominal. Verifikasi admin membutuhkan waktu maksimal 1x24 jam.
            </p>
        </div>
    </div>
    @elseif($payment->status === 'verified')
    <div class="bg-green-50 border border-green-200 rounded-xl p-6 text-center">
        <i class="fas fa-check-circle text-5xl text-green-500 mb-4"></i>
        <h3 class="text-xl font-bold text-green-800 mb-2">Pembayaran Berhasil!</h3>
        <p class="text-green-700 mb-6">Terima kasih, pesanan Anda sedang diproses oleh tim kami.</p>
        <a href="{{ route('customer.dashboard') }}" class="inline-block bg-green-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-green-700 shadow-lg transition">
            Kembali ke Dashboard
        </a>
    </div>
    @endif
</div>

<script>
    // Fitur Copy to Clipboard
    function copyToClipboard(elementId) {
        const text = document.getElementById(elementId).innerText;
        navigator.clipboard.writeText(text).then(() => {
            const btn = event.currentTarget; // Use currentTarget to get the button element
            const originalContent = btn.innerHTML;
            
            btn.innerHTML = '<i class="fas fa-check"></i> Tersalin!';
            btn.classList.remove('bg-gray-100', 'text-gray-700');
            btn.classList.add('bg-green-100', 'text-green-700');
            
            setTimeout(() => {
                btn.innerHTML = originalContent;
                btn.classList.add('bg-gray-100', 'text-gray-700');
                btn.classList.remove('bg-green-100', 'text-green-700');
            }, 2000);
        }).catch(err => {
            console.error('Failed to copy text: ', err);
            alert('Gagal menyalin. Silakan coba lagi.');
        });
    }

    // Preview Image Logic
    const fileInput = document.getElementById('file-upload');
    const previewContainer = document.getElementById('preview-container');
    const previewImage = document.getElementById('preview-image');
    const placeholderText = document.getElementById('placeholder-text');
    const dropzone = document.getElementById('dropzone');

    if(fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                    placeholderText.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        // Drag and drop support
        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropzone.classList.add('border-blue-400', 'bg-blue-50');
        });

        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('border-blue-400', 'bg-blue-50');
        });

        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzone.classList.remove('border-blue-400', 'bg-blue-50');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                fileInput.dispatchEvent(new Event('change'));
            }
        });
    }
</script>
@endsection

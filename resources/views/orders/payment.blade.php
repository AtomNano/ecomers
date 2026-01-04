@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-4 mt-8 mb-12">
    
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Selesaikan Pembayaran</h2>
        <p class="text-gray-500">Invoice: <span class="font-mono font-bold text-blue-600">{{ $order->invoice_number }}</span></p>
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
            <!-- BCA Bank -->
            <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:border-blue-400 transition">
                <div class="flex items-center gap-3">
                    <div class="h-8 w-12 bg-blue-600 rounded flex items-center justify-center">
                        <span class="text-white font-bold text-xs">BCA</span>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Bank BCA</div>
                        <div class="font-bold text-gray-800" id="rek-bca">1234 5678 90</div>
                        <div class="text-xs text-gray-400">a.n Grosir Berkat Ibu</div>
                    </div>
                </div>
                <button onclick="copyToClipboard('rek-bca')" class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded transition font-medium">
                    Salin
                </button>
            </div>

            <!-- QRIS Section -->
            <div class="text-center">
                <p class="text-sm font-semibold text-gray-700 mb-3">Atau Scan QRIS Kami</p>
                <div class="bg-gray-100 rounded-lg p-4 inline-block border border-gray-300">
                    <svg class="w-32 h-32 text-gray-400" fill="currentColor" viewBox="0 0 100 100">
                        <rect x="10" y="10" width="30" height="30" fill="black"/>
                        <rect x="45" y="10" width="30" height="30" fill="black"/>
                        <rect x="80" y="10" width="10" height="30" fill="black"/>
                        <rect x="10" y="45" width="30" height="30" fill="black"/>
                        <rect x="45" y="45" width="30" height="30" fill="black"/>
                        <rect x="80" y="45" width="10" height="30" fill="black"/>
                        <rect x="10" y="80" width="30" height="20" fill="black"/>
                        <rect x="50" y="80" width="40" height="20" fill="black"/>
                    </svg>
                </div>
                <p class="text-xs text-gray-500 mt-2">Scan dengan aplikasi mobile banking Anda</p>
            </div>
        </div>
    </div>

    <!-- Payment Proof Upload Card -->
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
        <h3 class="font-bold text-gray-800 mb-4 text-lg">Konfirmasi Pembayaran</h3>
        
        <form action="{{ route('orders.upload', $order->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Upload Bukti Transfer</label>
                <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-blue-500 transition text-center cursor-pointer bg-gray-50 hover:bg-blue-50" id="dropzone">
                    <input type="file" name="payment_proof" id="file-upload" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*" required>
                    
                    <!-- Preview Container (Hidden by default) -->
                    <div id="preview-container" class="hidden">
                        <img id="preview-image" src="#" alt="Preview" class="max-h-48 mx-auto rounded shadow-sm">
                        <p class="text-xs text-green-600 mt-2 font-bold">✓ File terpilih. Klik tombol di bawah untuk kirim.</p>
                    </div>

                    <!-- Placeholder Text -->
                    <div id="placeholder-text">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-600 font-medium">Klik untuk upload foto struk/screenshot</p>
                        <p class="mt-1 text-xs text-gray-500">PNG, JPG, WebP up to 2MB</p>
                    </div>
                </div>
                @error('payment_proof')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg shadow transition duration-200 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                </svg>
                Kirim Bukti Pembayaran
            </button>
        </form>

        <!-- Info Box -->
        <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-3">
            <p class="text-xs text-blue-800">
                <strong>💡 Tips:</strong> Pastikan struk/screenshot jelas terlihat nomor referensi dan nominal. Verifikasi admin membutuhkan waktu maksimal 1x24 jam.
            </p>
        </div>
    </div>
</div>

<script>
    // Fitur Copy to Clipboard
    function copyToClipboard(elementId) {
        const text = document.getElementById(elementId).innerText;
        navigator.clipboard.writeText(text).then(() => {
            // Feedback visual
            event.target.textContent = 'Tersalin!';
            event.target.classList.add('bg-green-100', 'text-green-700');
            setTimeout(() => {
                event.target.textContent = 'Salin';
                event.target.classList.remove('bg-green-100', 'text-green-700');
                event.target.classList.add('bg-gray-100', 'text-gray-700');
            }, 2000);
        }).catch(() => {
            alert('Gagal menyalin. Silakan coba lagi.');
        });
    }

    // Preview Image Logic
    const fileInput = document.getElementById('file-upload');
    const previewContainer = document.getElementById('preview-container');
    const previewImage = document.getElementById('preview-image');
    const placeholderText = document.getElementById('placeholder-text');
    const dropzone = document.getElementById('dropzone');

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
</script>
@endsection

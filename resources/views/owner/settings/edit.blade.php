@extends('layouts.admin-layout')

@section('title', 'Pengaturan Toko')
@section('breadcrumb', 'Pengaturan')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Pengaturan Toko</h1>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <form action="{{ route('owner.settings.update') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-xl rounded-2xl overflow-hidden">
        @csrf
        @method('PUT')
        
        <div class="p-8 space-y-8">
            <!-- Store Information -->
            <div>
                <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b">Informasi Toko</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Nama Toko</label>
                        <input type="text" name="store_name" value="{{ old('store_name', $setting->store_name ?? 'Grosir Berkat Ibu') }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('store_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Nomor Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone', $setting->phone ?? '') }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 font-bold mb-2">Alamat Lengkap</label>
                        <textarea name="address" rows="3" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('address', $setting->address ?? '') }}</textarea>
                        @error('address') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <!-- Location Fields (Required by Controller validation) -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Provinsi</label>
                        <input type="text" name="province" value="{{ old('province', $setting->province ?? '') }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('province') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Kota/Kabupaten</label>
                        <input type="text" name="city" value="{{ old('city', $setting->city ?? '') }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('city') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Kecamatan</label>
                        <input type="text" name="district" value="{{ old('district', $setting->district ?? '') }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('district') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            <div>
                <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b">Informasi Pembayaran</h2>
                
                <!-- Bank Transfer -->
                <div class="mb-6 bg-gray-50 p-4 rounded-xl border border-gray-200">
                    <h3 class="font-bold text-gray-700 mb-4 flex items-center gap-2">
                        <i class="fas fa-university text-blue-500"></i> Transfer Bank
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-600 text-sm font-bold mb-1">Nama Bank</label>
                            <input type="text" name="bank_name" value="{{ old('bank_name', $setting->bank_name ?? '') }}" placeholder="Contoh: BCA" class="w-full border rounded-lg px-4 py-2">
                        </div>
                        <div>
                            <label class="block text-gray-600 text-sm font-bold mb-1">Nomor Rekening</label>
                            <input type="text" name="bank_account_number" value="{{ old('bank_account_number', $setting->bank_account_number ?? '') }}" placeholder="Contoh: 1234567890" class="w-full border rounded-lg px-4 py-2">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-gray-600 text-sm font-bold mb-1">Atas Nama</label>
                            <input type="text" name="bank_account_holder" value="{{ old('bank_account_holder', $setting->bank_account_holder ?? '') }}" placeholder="Contoh: CV Grosir Berkat Ibu" class="w-full border rounded-lg px-4 py-2">
                        </div>
                    </div>
                </div>

                <!-- QRIS -->
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                    <h3 class="font-bold text-gray-700 mb-4 flex items-center gap-2">
                        <i class="fas fa-qrcode text-blue-500"></i> QRIS
                    </h3>
                    <div class="flex flex-col md:flex-row gap-6 items-start">
                        <div class="flex-1">
                            <label class="block text-gray-600 text-sm font-bold mb-2">Upload Gambar QRIS</label>
                            <input type="file" name="qris_image" class="w-full border rounded-lg px-4 py-2 bg-white">
                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maks: 2MB.</p>
                        </div>
                        @if(isset($setting->qris_image))
                        <div class="w-40 flex-shrink-0">
                            <p class="text-xs font-bold mb-2 text-center">QRIS Saat Ini:</p>
                            <img src="{{ asset('storage/' . $setting->qris_image) }}" alt="QRIS" class="w-full rounded-lg shadow-md border">
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 px-8 py-4 flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg flex items-center gap-2">
                <i class="fas fa-save"></i> Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection

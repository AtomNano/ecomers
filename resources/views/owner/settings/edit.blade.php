@extends('layouts.admin-layout')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800">Pengaturan Toko</h1>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <form action="{{ route('owner.settings.update') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')

                <!-- Store Info -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b">Informasi Dasar Toko</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Toko</label>
                            <input type="text" name="store_name" value="{{ old('store_name', $setting->store_name ?? '') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                            <input type="text" name="phone" value="{{ old('phone', $setting->phone ?? '') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500"
                                required>
                        </div>
                    </div>
                </div>

                <!-- Address -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b">Alamat Toko</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                            <textarea name="address" rows="3"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500"
                                required>{{ old('address', $setting->address ?? '') }}</textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Provinsi</label>
                                <input type="text" name="province" value="{{ old('province', $setting->province ?? '') }}"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kota / Kabupaten</label>
                                <input type="text" name="city" value="{{ old('city', $setting->city ?? '') }}"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kecamatan</label>
                                <input type="text" name="district" value="{{ old('district', $setting->district ?? '') }}"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bank Account -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b">Metode Pembayaran (Transfer Bank)
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Bank</label>
                            <input type="text" name="bank_name" value="{{ old('bank_name', $setting->bank_name ?? '') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500"
                                placeholder="Contoh: BCA">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Rekening</label>
                            <input type="text" name="bank_account_number"
                                value="{{ old('bank_account_number', $setting->bank_account_number ?? '') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500"
                                placeholder="1234567890">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Atas Nama</label>
                            <input type="text" name="bank_account_holder"
                                value="{{ old('bank_account_holder', $setting->bank_account_holder ?? '') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500"
                                placeholder="Nama Pemilik Rekening">
                        </div>
                    </div>
                </div>

                <!-- QRIS -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b">QRIS (Opsional)</h2>
                    <div class="flex items-start gap-6">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload Gambar QRIS</label>
                            <input type="file" name="qris_image"
                                class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, WEBP. Max: 2MB.</p>
                        </div>
                        @if(isset($setting->qris_image) && $setting->qris_image)
                            <div class="w-32">
                                <p class="text-xs text-gray-500 mb-1">Preview Saat Ini:</p>
                                <img src="{{ asset('storage/' . $setting->qris_image) }}"
                                    class="w-full rounded-lg border shadow-sm">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex justify-end pt-6 border-t">
                    <button type="submit"
                        class="bg-red-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-red-700 transition shadow-lg flex items-center gap-2">
                        <i class="fas fa-save"></i> Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
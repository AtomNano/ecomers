@extends('layouts.admin.app')

@section('title', 'Tambah Admin - Grosir Berkat Ibu')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-neutral-900">Tambah Admin</h1>
                <p class="text-neutral-600 mt-2">Buat akun admin baru untuk mengelola sistem</p>
            </div>
            <a href="{{ route('owner.admins.index') }}" class="btn-outline">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="max-w-2xl">
        <form action="{{ route('owner.admins.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Informasi Dasar -->
            <div class="bg-white rounded-lg shadow-soft p-6">
                <h3 class="text-lg font-semibold text-neutral-900 mb-4">Informasi Dasar</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-neutral-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" 
                               class="input-field @error('name') border-red-500 @enderror" 
                               placeholder="Masukkan nama lengkap" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-neutral-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" 
                               class="input-field @error('email') border-red-500 @enderror" 
                               placeholder="Masukkan email" required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-neutral-700 mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password" name="password" 
                               class="input-field @error('password') border-red-500 @enderror" 
                               placeholder="Masukkan password" required>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-neutral-700 mb-2">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" 
                               class="input-field" 
                               placeholder="Konfirmasi password" required>
                    </div>
                </div>
            </div>

            <!-- Informasi Kontak -->
            <div class="bg-white rounded-lg shadow-soft p-6">
                <h3 class="text-lg font-semibold text-neutral-900 mb-4">Informasi Kontak</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-neutral-700 mb-2">
                            Nomor Telepon
                        </label>
                        <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" 
                               class="input-field @error('phone_number') border-red-500 @enderror" 
                               placeholder="Masukkan nomor telepon">
                        @error('phone_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-neutral-700 mb-2">
                            Alamat
                        </label>
                        <textarea id="address" name="address" rows="3" 
                                  class="input-field @error('address') border-red-500 @enderror" 
                                  placeholder="Masukkan alamat lengkap">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Informasi Lokasi -->
            <div class="bg-white rounded-lg shadow-soft p-6">
                <h3 class="text-lg font-semibold text-neutral-900 mb-4">Informasi Lokasi</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="province" class="block text-sm font-medium text-neutral-700 mb-2">
                            Provinsi
                        </label>
                        <select id="province" name="province" 
                                class="input-field @error('province') border-red-500 @enderror">
                            <option value="">Pilih Provinsi</option>
                            <option value="DKI Jakarta" {{ old('province') == 'DKI Jakarta' ? 'selected' : '' }}>DKI Jakarta</option>
                            <option value="Jawa Barat" {{ old('province') == 'Jawa Barat' ? 'selected' : '' }}>Jawa Barat</option>
                            <option value="Jawa Tengah" {{ old('province') == 'Jawa Tengah' ? 'selected' : '' }}>Jawa Tengah</option>
                            <option value="Jawa Timur" {{ old('province') == 'Jawa Timur' ? 'selected' : '' }}>Jawa Timur</option>
                            <option value="Banten" {{ old('province') == 'Banten' ? 'selected' : '' }}>Banten</option>
                            <option value="Yogyakarta" {{ old('province') == 'Yogyakarta' ? 'selected' : '' }}>Yogyakarta</option>
                            <option value="Bali" {{ old('province') == 'Bali' ? 'selected' : '' }}>Bali</option>
                            <option value="Sumatera Utara" {{ old('province') == 'Sumatera Utara' ? 'selected' : '' }}>Sumatera Utara</option>
                            <option value="Sumatera Barat" {{ old('province') == 'Sumatera Barat' ? 'selected' : '' }}>Sumatera Barat</option>
                            <option value="Sumatera Selatan" {{ old('province') == 'Sumatera Selatan' ? 'selected' : '' }}>Sumatera Selatan</option>
                            <option value="Lampung" {{ old('province') == 'Lampung' ? 'selected' : '' }}>Lampung</option>
                            <option value="Riau" {{ old('province') == 'Riau' ? 'selected' : '' }}>Riau</option>
                            <option value="Kepulauan Riau" {{ old('province') == 'Kepulauan Riau' ? 'selected' : '' }}>Kepulauan Riau</option>
                            <option value="Jambi" {{ old('province') == 'Jambi' ? 'selected' : '' }}>Jambi</option>
                            <option value="Bengkulu" {{ old('province') == 'Bengkulu' ? 'selected' : '' }}>Bengkulu</option>
                            <option value="Aceh" {{ old('province') == 'Aceh' ? 'selected' : '' }}>Aceh</option>
                            <option value="Kalimantan Barat" {{ old('province') == 'Kalimantan Barat' ? 'selected' : '' }}>Kalimantan Barat</option>
                            <option value="Kalimantan Tengah" {{ old('province') == 'Kalimantan Tengah' ? 'selected' : '' }}>Kalimantan Tengah</option>
                            <option value="Kalimantan Selatan" {{ old('province') == 'Kalimantan Selatan' ? 'selected' : '' }}>Kalimantan Selatan</option>
                            <option value="Kalimantan Timur" {{ old('province') == 'Kalimantan Timur' ? 'selected' : '' }}>Kalimantan Timur</option>
                            <option value="Kalimantan Utara" {{ old('province') == 'Kalimantan Utara' ? 'selected' : '' }}>Kalimantan Utara</option>
                            <option value="Sulawesi Utara" {{ old('province') == 'Sulawesi Utara' ? 'selected' : '' }}>Sulawesi Utara</option>
                            <option value="Sulawesi Tengah" {{ old('province') == 'Sulawesi Tengah' ? 'selected' : '' }}>Sulawesi Tengah</option>
                            <option value="Sulawesi Selatan" {{ old('province') == 'Sulawesi Selatan' ? 'selected' : '' }}>Sulawesi Selatan</option>
                            <option value="Sulawesi Tenggara" {{ old('province') == 'Sulawesi Tenggara' ? 'selected' : '' }}>Sulawesi Tenggara</option>
                            <option value="Gorontalo" {{ old('province') == 'Gorontalo' ? 'selected' : '' }}>Gorontalo</option>
                            <option value="Sulawesi Barat" {{ old('province') == 'Sulawesi Barat' ? 'selected' : '' }}>Sulawesi Barat</option>
                            <option value="Maluku" {{ old('province') == 'Maluku' ? 'selected' : '' }}>Maluku</option>
                            <option value="Maluku Utara" {{ old('province') == 'Maluku Utara' ? 'selected' : '' }}>Maluku Utara</option>
                            <option value="Papua" {{ old('province') == 'Papua' ? 'selected' : '' }}>Papua</option>
                            <option value="Papua Barat" {{ old('province') == 'Papua Barat' ? 'selected' : '' }}>Papua Barat</option>
                            <option value="Papua Selatan" {{ old('province') == 'Papua Selatan' ? 'selected' : '' }}>Papua Selatan</option>
                            <option value="Papua Tengah" {{ old('province') == 'Papua Tengah' ? 'selected' : '' }}>Papua Tengah</option>
                            <option value="Papua Pegunungan" {{ old('province') == 'Papua Pegunungan' ? 'selected' : '' }}>Papua Pegunungan</option>
                            <option value="Papua Barat Daya" {{ old('province') == 'Papua Barat Daya' ? 'selected' : '' }}>Papua Barat Daya</option>
                        </select>
                        @error('province')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-medium text-neutral-700 mb-2">
                            Kota/Kabupaten
                        </label>
                        <input type="text" id="city" name="city" value="{{ old('city') }}" 
                               class="input-field @error('city') border-red-500 @enderror" 
                               placeholder="Masukkan kota/kabupaten">
                        @error('city')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="district" class="block text-sm font-medium text-neutral-700 mb-2">
                            Kecamatan
                        </label>
                        <input type="text" id="district" name="district" value="{{ old('district') }}" 
                               class="input-field @error('district') border-red-500 @enderror" 
                               placeholder="Masukkan kecamatan">
                        @error('district')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('owner.admins.index') }}" class="btn-outline">
                    Batal
                </a>
                <button type="submit" class="btn-primary">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Admin
                </button>
            </div>
        </form>
    </div>
</div>
@endsection




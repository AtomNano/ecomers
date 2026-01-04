@extends('layouts.frontend.app')

@section('title', 'Profil Saya - Grosir Berkat Ibu')
@section('description', 'Kelola profil dan informasi akun Anda di Grosir Berkat Ibu.')

@section('content')
<div class="bg-white">
    <div class="container-custom section-padding">
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-neutral-900 mb-6">Profil Saya</h1>
            <p class="text-xl text-neutral-600 max-w-3xl mx-auto">
                Kelola informasi pribadi dan preferensi akun Anda
            </p>
        </div>

        <div class="max-w-4xl mx-auto">
            <!-- Profile Tabs -->
            <div class="mb-8">
                <nav class="flex space-x-8 border-b border-neutral-200">
                    <button class="profile-tab active" data-tab="profile">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profil
                    </button>
                    <button class="profile-tab" data-tab="addresses">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Alamat
                    </button>
                    <button class="profile-tab" data-tab="orders">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Pesanan
                    </button>
                </nav>
            </div>

            <!-- Profile Tab Content -->
            <div id="profile-tab" class="profile-tab-content">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Profile Info -->
                    <div class="lg:col-span-2">
                        <div class="card p-8">
                            <h2 class="text-2xl font-bold text-neutral-900 mb-6">Informasi Profil</h2>
                            
                            <form class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-neutral-700 mb-2">Nama Lengkap *</label>
                                        <input 
                                            type="text" 
                                            name="name"
                                            class="input-field"
                                            value="{{ auth()->user()->name ?? '' }}"
                                            required
                                        >
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-neutral-700 mb-2">Email *</label>
                                        <input 
                                            type="email" 
                                            name="email"
                                            class="input-field"
                                            value="{{ auth()->user()->email ?? '' }}"
                                            required
                                        >
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-neutral-700 mb-2">Nomor Telepon *</label>
                                        <input 
                                            type="tel" 
                                            name="phone_number"
                                            class="input-field"
                                            value="{{ auth()->user()->phone_number ?? '' }}"
                                            required
                                        >
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-neutral-700 mb-2">Tanggal Lahir</label>
                                        <input 
                                            type="date" 
                                            name="birth_date"
                                            class="input-field"
                                        >
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 mb-2">Alamat Lengkap *</label>
                                    <textarea 
                                        name="address" 
                                        rows="3"
                                        class="input-field"
                                        required
                                    >{{ auth()->user()->address ?? '' }}</textarea>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-neutral-700 mb-2">Provinsi *</label>
                                        <select name="province" class="input-field" required>
                                            <option value="">Pilih Provinsi</option>
                                            <option value="DKI Jakarta" {{ auth()->user()->province == 'DKI Jakarta' ? 'selected' : '' }}>DKI Jakarta</option>
                                            <option value="Jawa Barat" {{ auth()->user()->province == 'Jawa Barat' ? 'selected' : '' }}>Jawa Barat</option>
                                            <option value="Jawa Tengah" {{ auth()->user()->province == 'Jawa Tengah' ? 'selected' : '' }}>Jawa Tengah</option>
                                            <option value="Jawa Timur" {{ auth()->user()->province == 'Jawa Timur' ? 'selected' : '' }}>Jawa Timur</option>
                                            <option value="Banten" {{ auth()->user()->province == 'Banten' ? 'selected' : '' }}>Banten</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-neutral-700 mb-2">Kota *</label>
                                        <input 
                                            type="text" 
                                            name="city"
                                            class="input-field"
                                            value="{{ auth()->user()->city ?? '' }}"
                                            required
                                        >
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-neutral-700 mb-2">Kecamatan *</label>
                                        <input 
                                            type="text" 
                                            name="district"
                                            class="input-field"
                                            value="{{ auth()->user()->district ?? '' }}"
                                            required
                                        >
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit" class="btn-primary">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Profile Sidebar -->
                    <div class="space-y-6">
                        <!-- Profile Picture -->
                        <div class="card p-6 text-center">
                            <div class="w-24 h-24 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="h-12 w-12 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h3 class="font-semibold text-neutral-900 mb-2">{{ auth()->user()->name ?? 'User' }}</h3>
                            <p class="text-sm text-neutral-600 mb-4">{{ auth()->user()->email ?? 'user@example.com' }}</p>
                            <button class="btn-outline text-sm">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Ubah Foto
                            </button>
                        </div>

                        <!-- Account Stats -->
                        <div class="card p-6">
                            <h3 class="font-semibold text-neutral-900 mb-4">Statistik Akun</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-neutral-600">Total Pesanan</span>
                                    <span class="font-medium text-neutral-900">0</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-neutral-600">Pesanan Selesai</span>
                                    <span class="font-medium text-neutral-900">0</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-neutral-600">Total Belanja</span>
                                    <span class="font-medium text-neutral-900">Rp 0</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-neutral-600">Member Sejak</span>
                                    <span class="font-medium text-neutral-900">{{ auth()->user()->created_at ? auth()->user()->created_at->format('M Y') : 'N/A' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Change Password -->
                        <div class="card p-6">
                            <h3 class="font-semibold text-neutral-900 mb-4">Ubah Password</h3>
                            <form class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 mb-2">Password Lama</label>
                                    <input 
                                        type="password" 
                                        name="current_password"
                                        class="input-field"
                                        placeholder="Masukkan password lama"
                                    >
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 mb-2">Password Baru</label>
                                    <input 
                                        type="password" 
                                        name="new_password"
                                        class="input-field"
                                        placeholder="Masukkan password baru"
                                    >
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 mb-2">Konfirmasi Password</label>
                                    <input 
                                        type="password" 
                                        name="password_confirmation"
                                        class="input-field"
                                        placeholder="Konfirmasi password baru"
                                    >
                                </div>
                                <button type="submit" class="btn-outline w-full">
                                    Ubah Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Addresses Tab Content -->
            <div id="addresses-tab" class="profile-tab-content hidden">
                <div class="card p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-neutral-900">Daftar Alamat</h2>
                        <button class="btn-primary">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah Alamat
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Sample Address -->
                        <div class="border border-neutral-200 rounded-lg p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="font-semibold text-neutral-900">Rumah</h3>
                                    <span class="badge bg-primary-100 text-primary-800">Alamat Utama</span>
                                </div>
                                <div class="flex space-x-2">
                                    <button class="text-primary-600 hover:text-primary-700">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button class="text-red-600 hover:text-red-700">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="text-neutral-600 space-y-1">
                                <p><strong>John Doe</strong></p>
                                <p>Jl. Raya No. 123, RT 01/RW 02</p>
                                <p>Kelurahan ABC, Kecamatan XYZ</p>
                                <p>Jakarta Selatan, DKI Jakarta 12345</p>
                                <p>+62 812 3456 7890</p>
                            </div>
                        </div>

                        <!-- Add New Address Button -->
                        <div class="border-2 border-dashed border-neutral-300 rounded-lg p-6 flex items-center justify-center hover:border-primary-400 hover:bg-primary-50 transition-colors cursor-pointer">
                            <div class="text-center">
                                <svg class="h-12 w-12 text-neutral-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <p class="text-neutral-600 font-medium">Tambah Alamat Baru</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders Tab Content -->
            <div id="orders-tab" class="profile-tab-content hidden">
                <div class="card p-8">
                    <h2 class="text-2xl font-bold text-neutral-900 mb-6">Riwayat Pesanan</h2>
                    
                    <!-- Order Filters -->
                    <div class="flex flex-wrap gap-4 mb-6">
                        <button class="order-filter active">Semua</button>
                        <button class="order-filter">Menunggu Pembayaran</button>
                        <button class="order-filter">Diproses</button>
                        <button class="order-filter">Dikirim</button>
                        <button class="order-filter">Selesai</button>
                    </div>

                    <!-- Orders List -->
                    <div class="space-y-4">
                        <!-- Sample Order -->
                        <div class="border border-neutral-200 rounded-lg p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="font-semibold text-neutral-900">#ORD-2024-001</h3>
                                    <p class="text-sm text-neutral-600">15 Januari 2024</p>
                                </div>
                                <span class="badge bg-yellow-100 text-yellow-800">Menunggu Pembayaran</span>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <p class="text-sm text-neutral-600">Total Pesanan</p>
                                    <p class="font-semibold text-neutral-900">Rp 150.000</p>
                                </div>
                                <div>
                                    <p class="text-sm text-neutral-600">Jumlah Item</p>
                                    <p class="font-semibold text-neutral-900">3 produk</p>
                                </div>
                                <div>
                                    <p class="text-sm text-neutral-600">Metode Pembayaran</p>
                                    <p class="font-semibold text-neutral-900">Transfer Bank</p>
                                </div>
                            </div>

                            <div class="flex justify-between items-center">
                                <div class="text-sm text-neutral-600">
                                    <p>Beras Premium 5kg x 2</p>
                                    <p>Minyak Goreng 1L x 1</p>
                                </div>
                                <div class="flex space-x-2">
                                    <button class="btn-outline text-sm">
                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Detail
                                    </button>
                                    <button class="btn-primary text-sm">
                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                        Bayar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Empty State -->
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-neutral-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="h-8 w-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-neutral-900 mb-2">Belum Ada Pesanan</h3>
                            <p class="text-neutral-600 mb-6">Mulai berbelanja untuk melihat riwayat pesanan Anda di sini</p>
                            <a href="{{ route('products.index') }}" class="btn-primary">
                                Mulai Berbelanja
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-tab {
    @apply flex items-center px-4 py-3 text-sm font-medium text-neutral-600 border-b-2 border-transparent hover:text-neutral-800 hover:border-neutral-300 transition-colors duration-200;
}

.profile-tab.active {
    @apply text-primary-600 border-primary-600;
}

.profile-tab-content {
    display: block;
}

.profile-tab-content.hidden {
    display: none;
}

.order-filter {
    @apply px-4 py-2 text-sm font-medium text-neutral-600 bg-neutral-100 rounded-full hover:bg-neutral-200 transition-colors duration-200;
}

.order-filter.active {
    @apply bg-primary-600 text-white hover:bg-primary-700;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Profile Tabs
    const profileTabs = document.querySelectorAll('.profile-tab');
    const profileTabContents = document.querySelectorAll('.profile-tab-content');

    profileTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const targetTab = this.dataset.tab;
            
            // Update active tab
            profileTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Show/hide tab content
            profileTabContents.forEach(content => {
                if (content.id === targetTab + '-tab') {
                    content.classList.remove('hidden');
                } else {
                    content.classList.add('hidden');
                }
            });
        });
    });

    // Order Filters
    const orderFilters = document.querySelectorAll('.order-filter');

    orderFilters.forEach(filter => {
        filter.addEventListener('click', function() {
            orderFilters.forEach(f => f.classList.remove('active'));
            this.classList.add('active');
        });
    });
});
</script>
@endsection

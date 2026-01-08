@extends('layouts.app')

@section('title', 'Akun Saya - Grosir Berkat Ibu')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12" x-data="{ activeTab: 'overview' }">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Sidebar Navigation -->
                <div class="w-full md:w-1/4">
                    <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-24">
                        <div class="flex items-center gap-4 mb-8">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-red-500 to-orange-500 rounded-full flex items-center justify-center text-white text-2xl font-bold uppercase shadow-lg">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <div class="overflow-hidden">
                                <h3 class="font-bold text-gray-800 truncate" title="{{ auth()->user()->name }}">
                                    {{ auth()->user()->name }}</h3>
                                <p class="text-sm text-gray-500">Member Grosir</p>
                            </div>
                        </div>

                        <nav class="space-y-2">
                            <button @click="activeTab = 'overview'"
                                :class="activeTab === 'overview' ? 'bg-red-50 text-red-600' : 'text-gray-600 hover:bg-gray-50'"
                                class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition text-left">
                                <i class="fas fa-chart-pie w-5"></i> Ringkasan Akun
                            </button>

                            <button @click="activeTab = 'orders'"
                                :class="activeTab === 'orders' ? 'bg-red-50 text-red-600' : 'text-gray-600 hover:bg-gray-50'"
                                class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition text-left">
                                <i class="fas fa-shopping-bag w-5"></i> Pesanan Saya
                            </button>

                            <button @click="activeTab = 'settings'"
                                :class="activeTab === 'settings' ? 'bg-red-50 text-red-600' : 'text-gray-600 hover:bg-gray-50'"
                                class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition text-left">
                                <i class="fas fa-user-cog w-5"></i> Pengaturan Akun
                            </button>

                            <div class="pt-4 mt-4 border-t border-gray-100">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl font-medium transition text-left">
                                        <i class="fas fa-sign-out-alt w-5"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </nav>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="w-full md:w-3/4">

                    <!-- Tab: Overview -->
                    <div x-show="activeTab === 'overview'" x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="mb-8">
                            <h1 class="text-2xl font-bold text-gray-800">Halo, {{ auth()->user()->name }}! 👋</h1>
                            <p class="text-gray-500">Selamat datang kembali di Dashboard Member.</p>
                        </div>

                        <!-- Stats Summary -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                            <div
                                class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-yellow-400 hover:shadow-md transition">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-gray-500 text-sm font-medium">Pesanan Aktif</p>
                                        <h3 class="text-3xl font-bold text-gray-800 mt-2">
                                            {{ $orders->whereIn('status', ['pending', 'processing', 'shipped'])->count() }}
                                        </h3>
                                    </div>
                                    <div class="p-3 bg-yellow-100 rounded-xl text-yellow-600">
                                        <i class="fas fa-box-open text-xl"></i>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-red-500 hover:shadow-md transition">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-gray-500 text-sm font-medium">Total Belanja</p>
                                        <h3 class="text-2xl font-bold text-gray-800 mt-2">Rp
                                            {{ number_format($totalSpent ?? 0, 0, ',', '.') }}</h3>
                                    </div>
                                    <div class="p-3 bg-red-100 rounded-xl text-red-600">
                                        <i class="fas fa-wallet text-xl"></i>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-blue-500 hover:shadow-md transition">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-gray-500 text-sm font-medium">Riwayat Pesanan</p>
                                        <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalOrders ?? 0 }}</h3>
                                    </div>
                                    <div class="p-3 bg-blue-100 rounded-xl text-blue-600">
                                        <i class="fas fa-history text-xl"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Order History -->
                    <div x-show="activeTab === 'overview' || activeTab === 'orders'"
                        x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                            <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                                <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-list-alt text-red-500"></i> Daftar Transaksi Terakhir
                                </h2>
                            </div>

                            @if($orders->count() > 0)
                                <div class="divide-y divide-gray-100">
                                    @foreach($orders as $order)
                                        <div class="p-6 hover:bg-gray-50 transition group">
                                            <div class="flex flex-col md:flex-row justify-between gap-6">
                                                <!-- Order Info -->
                                                <div class="flex gap-4 w-full">
                                                    <div
                                                        class="hidden sm:flex p-4 bg-red-50 rounded-xl h-fit items-center justify-center">
                                                        <i class="fas fa-shopping-bag text-red-500 text-xl"></i>
                                                    </div>
                                                    <div class="flex-1">
                                                        <div class="flex flex-wrap items-center justify-between mb-2">
                                                            <div class="flex items-center gap-3">
                                                                <span class="font-bold text-gray-800">Order
                                                                    #{{ $order->invoice_number ?? $order->id }}</span>
                                                                <span class="text-xs text-gray-400">•</span>
                                                                <span
                                                                    class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</span>
                                                            </div>
                                                            <span class="px-3 py-1 rounded-full text-xs font-bold
                                                                    @if($order->status === 'pending') bg-yellow-100 text-yellow-700
                                                                    @elseif($order->status === 'payment_verified') bg-blue-100 text-blue-700
                                                                    @elseif($order->status === 'shipped') bg-purple-100 text-purple-700
                                                                    @elseif($order->status === 'completed') bg-green-100 text-green-700
                                                                    @else bg-red-100 text-red-700
                                                                    @endif">
                                                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                                            </span>
                                                        </div>

                                                        <div
                                                            class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-6 text-sm">
                                                            <div class="flex items-center gap-2 text-gray-600">
                                                                <i class="fas fa-wallet w-4 text-center"></i>
                                                                <span>Total: <span class="font-bold">Rp
                                                                        {{ number_format($order->total_amount, 0, ',', '.') }}</span></span>
                                                            </div>
                                                            <div class="flex items-center gap-2 text-gray-600">
                                                                <i class="fas fa-truck w-4 text-center"></i>
                                                                <span>{{ ucfirst($order->shipping_method) }}</span>
                                                            </div>
                                                        </div>

                                                        <!-- Payment Status Indicator -->
                                                        <div class="mt-3 flex items-center gap-2">
                                                            @if($order->payment_proof)
                                                                <span class="text-xs text-green-600 flex items-center gap-1">
                                                                    <i class="fas fa-check-circle"></i> Bukti Bayar Terkirim
                                                                </span>
                                                            @elseif($order->status == 'pending')
                                                                <span
                                                                    class="text-xs text-orange-600 flex items-center gap-1 animate-pulse">
                                                                    <i class="fas fa-exclamation-circle"></i> Menunggu Pembayaran
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Action Button -->
                                                <div class="flex items-center">
                                                    @if($order->status == 'pending' && !$order->payment_proof)
                                                        <a href="{{ route('orders.payment', $order->invoice_number ?? $order->id) }}"
                                                            class="w-full sm:w-auto px-6 py-2.5 bg-red-500 text-white font-medium rounded-xl hover:bg-red-600 transition shadow-sm text-center">
                                                            Bayar Sekarang
                                                        </a>
                                                    @else
                                                        <a href="{{ route('orders.success', $order->invoice_number ?? $order->id) }}"
                                                            class="w-full sm:w-auto px-6 py-2.5 bg-white border border-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-50 hover:border-gray-300 transition shadow-sm whitespace-nowrap text-center">
                                                            Lihat Detail
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <!-- Empty State -->
                                <div class="p-16 text-center">
                                    <div class="w-24 h-24 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                        <i class="fas fa-shopping-basket text-4xl text-red-300"></i>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Pesanan</h3>
                                    <p class="text-gray-500 mb-8 max-w-sm mx-auto">Anda belum pernah berbelanja. Yuk cari produk
                                        grosir termurah untuk warung Anda!</p>
                                    <a href="{{ route('home') }}"
                                        class="inline-flex items-center gap-2 px-8 py-3 bg-red-500 text-white font-bold rounded-xl hover:bg-red-600 transition shadow-lg hover:shadow-red-500/30">
                                        <i class="fas fa-shopping-bag"></i> Mulai Belanja
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Tab: Settings (Profile & Address) -->
                    <div x-show="activeTab === 'settings'" x-cloak
                        x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="bg-white rounded-2xl shadow-sm overflow-hidden p-8">
                            <div class="mb-8">
                                <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
                                    <i class="fas fa-user-cog text-red-500"></i> Pengaturan Akun
                                </h2>
                                <p class="text-gray-500">Kelola informasi profil dan alamat pengiriman Anda.</p>
                            </div>

                            @if (session('status') === 'profile-updated')
                                <div
                                    class="mb-6 bg-green-50 text-green-600 p-4 rounded-xl border border-green-100 flex items-center gap-3">
                                    <i class="fas fa-check-circle"></i>
                                    <span class="font-bold">Profil berhasil diperbarui.</span>
                                </div>
                            @endif

                            <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                                @csrf
                                @method('patch')

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Personal Info -->
                                    <div class="space-y-4">
                                        <h3 class="font-bold text-gray-700 border-b pb-2">Informasi Pribadi</h3>
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
                                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                                                class="w-full border-gray-200 rounded-xl focus:ring-red-500 focus:border-red-500 transition">
                                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                                            <input type="email" name="email"
                                                value="{{ old('email', auth()->user()->email) }}"
                                                class="w-full border-gray-200 rounded-xl focus:ring-red-500 focus:border-red-500 transition">
                                            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-1">Nomor Telepon</label>
                                            <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone) }}"
                                                class="w-full border-gray-200 rounded-xl focus:ring-red-500 focus:border-red-500 transition"
                                                placeholder="Contoh: 08123456789">
                                            @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Address Info -->
                                    <div class="space-y-4">
                                        <h3 class="font-bold text-gray-700 border-b pb-2">Alamat Pengiriman</h3>
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-1">Alamat Lengkap</label>
                                            <textarea name="address" rows="3"
                                                class="w-full border-gray-200 rounded-xl focus:ring-red-500 focus:border-red-500 transition"
                                                placeholder="Nama Jalan, No. Rumah">{{ old('address', auth()->user()->address) }}</textarea>
                                            @error('address') <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label
                                                    class="block text-sm font-bold text-gray-700 mb-1">Kota/Kabupaten</label>
                                                <input type="text" name="city"
                                                    value="{{ old('city', auth()->user()->city) }}"
                                                    class="w-full border-gray-200 rounded-xl focus:ring-red-500 focus:border-red-500 transition">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-bold text-gray-700 mb-1">Kecamatan</label>
                                                <input type="text" name="district"
                                                    value="{{ old('district', auth()->user()->district) }}"
                                                    class="w-full border-gray-200 rounded-xl focus:ring-red-500 focus:border-red-500 transition">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-1">Provinsi</label>
                                            <input type="text" name="province"
                                                value="{{ old('province', auth()->user()->province) }}"
                                                class="w-full border-gray-200 rounded-xl focus:ring-red-500 focus:border-red-500 transition">
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-end pt-4 border-t border-gray-100">
                                    <button type="submit"
                                        class="bg-red-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-red-700 transition shadow-lg hover:shadow-red-500/30">
                                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endsection
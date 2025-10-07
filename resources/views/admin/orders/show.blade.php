@extends('layouts.admin.app')

@section('title', 'Detail Pesanan #' . $order->id)
@section('page-title', 'Detail Pesanan')
@section('page-description', 'Informasi lengkap dan pengelolaan pesanan')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Order Information -->
        <div class="card p-6">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-neutral-900">Pesanan #{{ $order->id }}</h2>
                    <p class="text-neutral-600">Dibuat pada {{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div class="flex space-x-2">
                    <span class="badge {{ 
                        $order->status === 'pending' ? 'badge-warning' : 
                        ($order->status === 'processing' ? 'badge-primary' : 
                        ($order->status === 'shipped' ? 'badge-primary' : 
                        ($order->status === 'completed' ? 'badge-success' : 'badge-danger')))
                    }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-neutral-900 mb-3">Informasi Pelanggan</h3>
                    <div class="space-y-2">
                        <p><span class="text-sm text-neutral-500">Nama:</span> {{ $order->user->name ?? 'Guest' }}</p>
                        <p><span class="text-sm text-neutral-500">Email:</span> {{ $order->user->email ?? '-' }}</p>
                        <p><span class="text-sm text-neutral-500">Telepon:</span> {{ $order->phone_number }}</p>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold text-neutral-900 mb-3">Alamat Pengiriman</h3>
                    <div class="text-sm text-neutral-600">
                        {{ $order->shipping_address }}
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div>
                <h3 class="text-lg font-semibold text-neutral-900 mb-4">Item Pesanan</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-200">
                        <thead class="bg-neutral-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 uppercase">Produk</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 uppercase">Harga</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 uppercase">Qty</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 uppercase">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-neutral-200">
                            @foreach($order->items as $item)
                            <tr>
                                <td class="px-4 py-4">
                                    <div class="flex items-center">
                                        <img 
                                            src="{{ $item->product->image ? asset('storage/products/' . $item->product->image) : 'https://placehold.co/60x60/f3f4f6/374151?text=P' }}" 
                                            alt="{{ $item->product->name }}"
                                            class="w-12 h-12 object-cover rounded-lg mr-3"
                                        >
                                        <div>
                                            <div class="text-sm font-medium text-neutral-900">{{ $item->product->name }}</div>
                                            <div class="text-sm text-neutral-500">{{ $item->product->category->name ?? 'Kategori' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-sm text-neutral-900">Rp {{ number_format($item->price) }}</td>
                                <td class="px-4 py-4 text-sm text-neutral-900">{{ $item->quantity }}</td>
                                <td class="px-4 py-4 text-sm font-medium text-neutral-900">Rp {{ number_format($item->price * $item->quantity) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-neutral-900 mb-4">Informasi Pembayaran</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-neutral-500">Metode Pembayaran</p>
                    <p class="text-sm font-medium text-neutral-900">{{ ucfirst($order->payment_method) }}</p>
                </div>
                
                <div>
                    <p class="text-sm text-neutral-500">Status Pembayaran</p>
                    <span class="badge {{ 
                        $order->payment_status === 'paid' ? 'badge-success' : 
                        ($order->payment_status === 'pending' ? 'badge-warning' : 'badge-danger')
                    }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
                
                <div>
                    <p class="text-sm text-neutral-500">Kurir</p>
                    <p class="text-sm font-medium text-neutral-900">{{ ucfirst($order->courier) }}</p>
                </div>
                
                @if($order->tracking_number)
                <div>
                    <p class="text-sm text-neutral-500">Nomor Resi</p>
                    <p class="text-sm font-medium text-neutral-900">{{ $order->tracking_number }}</p>
                </div>
                @endif
            </div>

            @if($order->proof_of_payment)
            <div class="mt-4">
                <p class="text-sm text-neutral-500 mb-2">Bukti Pembayaran</p>
                <img 
                    src="{{ asset('storage/proofs/' . $order->proof_of_payment) }}" 
                    alt="Bukti Pembayaran"
                    class="w-48 h-32 object-cover rounded-lg border border-neutral-200"
                >
            </div>
            @endif
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Order Summary -->
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-neutral-900 mb-4">Ringkasan Pesanan</h3>
            
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm text-neutral-600">Subtotal</span>
                    <span class="text-sm font-medium text-neutral-900">Rp {{ number_format($order->total_price) }}</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-sm text-neutral-600">Ongkir</span>
                    <span class="text-sm font-medium text-neutral-900">Rp 0</span>
                </div>
                
                <div class="border-t border-neutral-200 pt-3">
                    <div class="flex justify-between">
                        <span class="text-lg font-semibold text-neutral-900">Total</span>
                        <span class="text-lg font-bold text-neutral-900">Rp {{ number_format($order->total_price) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Actions -->
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-neutral-900 mb-4">Aksi Pesanan</h3>
            
            <div class="space-y-3">
                @if($order->status === 'pending' && $order->payment_status === 'paid')
                <form action="{{ route('admin.orders.accept', $order) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-primary w-full" 
                            onclick="return confirm('Konfirmasi pembayaran pesanan ini?')">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Konfirmasi Pembayaran
                    </button>
                </form>
                @endif

                @if($order->status === 'processing')
                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="shipped">
                    <div class="mb-3">
                        <input 
                            type="text" 
                            name="tracking_number" 
                            placeholder="Nomor Resi"
                            class="input-field"
                        >
                    </div>
                    <button type="submit" class="btn-primary w-full">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Kirim Pesanan
                    </button>
                </form>
                @endif

                @if($order->status === 'shipped')
                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="completed">
                    <button type="submit" class="btn-primary w-full">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Tandai Selesai
                    </button>
                </form>
                @endif

                @if($order->status === 'pending')
                <form action="{{ route('admin.orders.reject', $order) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-outline w-full text-red-600 border-red-600 hover:bg-red-50" 
                            onclick="return confirm('Tolak pembayaran pesanan ini?')">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Tolak Pembayaran
                    </button>
                </form>
                @endif

                <a href="{{ route('admin.orders.index') }}" class="btn-outline w-full text-center">
                    Kembali ke Daftar
                </a>
            </div>
        </div>

        <!-- Order Timeline -->
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-neutral-900 mb-4">Timeline Pesanan</h3>
            
            <div class="space-y-4">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                    <div>
                        <p class="text-sm font-medium text-neutral-900">Pesanan Dibuat</p>
                        <p class="text-xs text-neutral-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                
                @if($order->status !== 'pending')
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                    <div>
                        <p class="text-sm font-medium text-neutral-900">Pembayaran Dikonfirmasi</p>
                        <p class="text-xs text-neutral-500">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                @endif
                
                @if(in_array($order->status, ['shipped', 'completed']))
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                    <div>
                        <p class="text-sm font-medium text-neutral-900">Pesanan Dikirim</p>
                        <p class="text-xs text-neutral-500">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                @endif
                
                @if($order->status === 'completed')
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                    <div>
                        <p class="text-sm font-medium text-neutral-900">Pesanan Selesai</p>
                        <p class="text-xs text-neutral-500">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Tentang Kami - Grosir Berkat Ibu')

@section('content')
<div class="bg-white rounded shadow p-8 max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Tentang Grosir Berkat Ibu</h1>
    
    <div class="space-y-4 text-gray-700">
        <p class="text-lg">
            Grosir Berkat Ibu adalah toko grosir terpercaya yang menjual berbagai kebutuhan pokok dengan harga yang kompetitif.
        </p>
        
        <p>
            Kami berkomitmen untuk memberikan pelayanan terbaik kepada pelanggan setia kami. Dengan pengalaman lebih dari sepuluh tahun, 
            kami memahami kebutuhan pelanggan grosir dan retail.
        </p>
        
        <h2 class="text-2xl font-bold mt-6 mb-3">Keunggulan Kami</h2>
        <ul class="list-disc list-inside space-y-2">
            <li>Harga grosir yang kompetitif</li>
            <li>Kualitas produk terjamin</li>
            <li>Pengiriman cepat dan aman</li>
            <li>Layanan pelanggan 24/7</li>
            <li>Program loyalitas pelanggan</li>
        </ul>
        
        <h2 class="text-2xl font-bold mt-6 mb-3">Kontak Kami</h2>
        @if($storeSetting)
            <p><strong>Alamat:</strong> {{ $storeSetting->address }}</p>
            <p><strong>Telepon:</strong> {{ $storeSetting->phone }}</p>
            <p><strong>Email:</strong> {{ $storeSetting->email }}</p>
        @else
            <p class="text-gray-500">Informasi kontak belum tersedia</p>
        @endif
    </div>
    
    <a href="{{ route('customer.home') }}" class="mt-6 inline-block bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Kembali ke Home</a>
</div>
@endsection

@extends('layouts.frontend.app')

@section('title', 'Halaman Tidak Ditemukan - Grosir Berkat Ibu')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-neutral-50">
    <div class="max-w-md w-full text-center">
        <div class="mb-8">
            <div class="w-24 h-24 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="h-12 w-12 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-1.009-5.824-2.709M15 6.75a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-neutral-900 mb-4">404</h1>
            <h2 class="text-2xl font-semibold text-neutral-700 mb-2">Halaman Tidak Ditemukan</h2>
            <p class="text-neutral-600 mb-8">
                Maaf, halaman yang Anda cari tidak ditemukan atau mungkin telah dipindahkan.
            </p>
        </div>
        
        <div class="space-y-4">
            <a href="{{ route('home') }}" class="btn-primary">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Kembali ke Beranda
            </a>
            
            <a href="{{ route('products.index') }}" class="btn-outline">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                Lihat Produk
            </a>
        </div>
    </div>
</div>
@endsection

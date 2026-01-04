@extends('layouts.frontend.app')

@section('title', 'Akses Ditolak - Grosir Berkat Ibu')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-neutral-50">
    <div class="max-w-md w-full text-center">
        <div class="mb-8">
            <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="h-12 w-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-neutral-900 mb-4">403</h1>
            <h2 class="text-2xl font-semibold text-neutral-700 mb-2">Akses Ditolak</h2>
            <p class="text-neutral-600 mb-8">
                Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.
            </p>
        </div>
        
        <div class="space-y-4">
            <a href="{{ route('home') }}" class="btn-primary">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Kembali ke Beranda
            </a>
            
            @auth
            <a href="{{ route('admin.dashboard') }}" class="btn-outline">
                Dashboard Admin
            </a>
            @else
            <a href="{{ route('login') }}" class="btn-outline">
                Masuk ke Akun
            </a>
            @endauth
        </div>
    </div>
</div>
@endsection

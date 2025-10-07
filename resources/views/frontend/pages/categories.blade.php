@extends('layouts.frontend.app')

@section('title', 'Kategori Produk - Grosir Berkat Ibu')
@section('description', 'Jelajahi berbagai kategori produk yang tersedia di Grosir Berkat Ibu.')

@section('content')
<div class="bg-white">
    <div class="container-custom section-padding">
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-neutral-900 mb-6">Kategori Produk</h1>
            <p class="text-xl text-neutral-600 max-w-3xl mx-auto">
                Temukan produk yang Anda butuhkan berdasarkan kategori yang telah kami sediakan
            </p>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            @forelse($categories as $category)
            <div class="group">
                <a href="{{ route('products.index', ['category' => $category->id]) }}" class="block">
                    <div class="card p-8 text-center group-hover:shadow-medium transition-all duration-300">
                        <!-- Category Icon -->
                        <div class="w-20 h-20 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-primary-200 transition-colors duration-300">
                            @if($category->name === 'Makanan & Minuman')
                                <svg class="h-10 w-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            @elseif($category->name === 'Sembako')
                                <svg class="h-10 w-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            @elseif($category->name === 'Perlengkapan Mandi')
                                <svg class="h-10 w-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M10.5 3L12 2l1.5 1H21v6H3V3h7.5z"></path>
                                </svg>
                            @elseif($category->name === 'Perlengkapan Rumah Tangga')
                                <svg class="h-10 w-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                                </svg>
                            @elseif($category->name === 'Kesehatan & Kecantikan')
                                <svg class="h-10 w-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            @else
                                <svg class="h-10 w-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            @endif
                        </div>

                        <!-- Category Name -->
                        <h3 class="text-xl font-semibold text-neutral-900 mb-2 group-hover:text-primary-600 transition-colors duration-300">
                            {{ $category->name }}
                        </h3>

                        <!-- Product Count -->
                        <p class="text-neutral-600 mb-4">
                            {{ $category->products_count }} {{ $category->products_count == 1 ? 'produk' : 'produk' }}
                        </p>

                        <!-- View Products Button -->
                        <div class="inline-flex items-center text-primary-600 font-medium group-hover:text-primary-700 transition-colors duration-300">
                            Lihat Produk
                            <svg class="h-4 w-4 ml-1 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <div class="w-16 h-16 bg-neutral-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-neutral-900 mb-2">Belum Ada Kategori</h3>
                <p class="text-neutral-600">Kategori produk akan segera ditambahkan.</p>
            </div>
            @endforelse
        </div>

        <!-- Featured Categories -->
        <div class="mb-16">
            <h2 class="text-2xl font-bold text-neutral-900 mb-8 text-center">Kategori Unggulan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @if($categories->count() > 0)
                @foreach($categories->take(2) as $category)
                <div class="card p-8 bg-gradient-to-r from-primary-50 to-primary-100">
                    <div class="flex items-center space-x-6">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center flex-shrink-0">
                            @if($category->name === 'Makanan & Minuman')
                                <svg class="h-8 w-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            @else
                                <svg class="h-8 w-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-neutral-900 mb-2">{{ $category->name }}</h3>
                            <p class="text-neutral-600 mb-4">
                                {{ $category->products_count }} {{ $category->products_count == 1 ? 'produk tersedia' : 'produk tersedia' }}
                            </p>
                            <a href="{{ route('products.index', ['category' => $category->id]) }}" class="btn-primary">
                                Jelajahi Kategori
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>

        <!-- Search Products -->
        <div class="text-center">
            <h2 class="text-2xl font-bold text-neutral-900 mb-6">Tidak Menemukan yang Anda Cari?</h2>
            <p class="text-neutral-600 mb-8 max-w-2xl mx-auto">
                Gunakan fitur pencarian untuk menemukan produk yang Anda butuhkan berdasarkan nama atau deskripsi
            </p>
            
            <div class="max-w-md mx-auto">
                <form action="{{ route('products.search') }}" method="GET" class="flex space-x-2">
                    <input 
                        type="text" 
                        name="q"
                        placeholder="Cari produk..."
                        class="input-field flex-1"
                        value="{{ request('q') }}"
                    >
                    <button type="submit" class="btn-primary">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Cari
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

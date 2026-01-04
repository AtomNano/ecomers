@extends('layouts.app')

@section('title', 'Kelola Produk - Admin')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Kelola Produk</h1>
        <a href="{{ route('admin.products.create') }}" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
            + Tambah Produk
        </a>
    </div>

    @if($products->count() > 0)
        <div class="bg-white rounded shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left">Nama Produk</th>
                        <th class="px-4 py-3 text-left">Kategori</th>
                        <th class="px-4 py-3 text-right">Harga (pcs)</th>
                        <th class="px-4 py-3 text-center">Stock</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3 font-semibold">{{ $product->name }}</td>
                            <td class="px-4 py-3">{{ $product->category->name }}</td>
                            <td class="px-4 py-3 text-right">Rp {{ number_format($product->price_unit, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-3 py-1 rounded text-sm font-bold
                                    @if($product->stock <= 10) bg-red-100 text-red-800
                                    @elseif($product->stock <= 20) bg-yellow-100 text-yellow-800
                                    @else bg-green-100 text-green-800
                                    @endif">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center space-x-2">
                                <a href="{{ route('admin.products.show', $product) }}" class="text-green-600 hover:text-green-700 text-sm font-bold">Detail</a>
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-700 text-sm font-bold">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-bold" onclick="return confirm('Hapus produk ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @else
        <div class="bg-white rounded shadow p-8 text-center">
            <p class="text-gray-600 mb-4">Belum ada produk</p>
            <a href="{{ route('admin.products.create') }}" class="inline-block bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                Tambah Produk Pertama
            </a>
        </div>
    @endif
</div>
@endsection

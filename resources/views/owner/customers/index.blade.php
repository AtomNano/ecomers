@extends('layouts.admin-layout')

@section('title', 'Kelola Pelanggan - Owner')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Kelola Pelanggan</h1>
        <a href="{{ route('owner.customers.create') }}" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
            + Tambah Pelanggan
        </a>
    </div>

    @if($customers->count() > 0)
        <div class="bg-white rounded shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">Telepon</th>
                        <th class="px-4 py-3 text-left">Alamat</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3 font-semibold">{{ $customer->name }}</td>
                            <td class="px-4 py-3">{{ $customer->email }}</td>
                            <td class="px-4 py-3">{{ $customer->phone }}</td>
                            <td class="px-4 py-3">{{ Str::limit($customer->address, 30) }}</td>
                            <td class="px-4 py-3 text-center space-x-2">
                                <a href="{{ route('owner.customers.edit', $customer) }}" class="text-blue-600 hover:text-blue-700 text-sm font-bold">Edit</a>
                                <form action="{{ route('owner.customers.destroy', $customer) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-bold" onclick="return confirm('Hapus pelanggan ini?')">
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
            {{ $customers->links() }}
        </div>
    @else
        <div class="bg-white rounded shadow p-8 text-center">
            <p class="text-gray-600 mb-4">Belum ada pelanggan</p>
            <a href="{{ route('owner.customers.create') }}" class="inline-block bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                Tambah Pelanggan Pertama
            </a>
        </div>
    @endif
</div>
@endsection

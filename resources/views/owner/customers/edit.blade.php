@extends('layouts.admin-layout')

@section('title', 'Edit Pelanggan - Owner')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Edit Pelanggan</h1>

    <form action="{{ route('owner.customers.update', $customer) }}" method="POST" class="bg-white rounded shadow p-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-bold mb-2">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name', $customer->name) }}" class="w-full border rounded px-3 py-2" required>
            @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-bold mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email', $customer->email) }}" class="w-full border rounded px-3 py-2" required>
            @error('email')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-bold mb-2">Telepon</label>
            <input type="tel" name="phone" value="{{ old('phone', $customer->phone) }}" class="w-full border rounded px-3 py-2" required>
            @error('phone')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-bold mb-2">Alamat</label>
            <textarea name="address" class="w-full border rounded px-3 py-2" rows="3" required>{{ old('address', $customer->address) }}</textarea>
            @error('address')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-bold mb-2">Password (Biarkan kosong jika tidak ingin mengubah)</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2">
            @error('password')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-bold mb-2">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2">
        </div>

        <div class="flex gap-4">
            <a href="{{ route('owner.customers.index') }}" class="flex-1 bg-gray-600 text-white py-2 rounded text-center hover:bg-gray-700">
                Batal
            </a>
            <button type="submit" class="flex-1 bg-green-600 text-white py-2 rounded font-bold hover:bg-green-700">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection

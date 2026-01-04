@extends('layouts.app')

@section('title', 'Daftar - Grosir Berkat Ibu')

@section('content')
<div class="flex items-center justify-center min-h-screen">
    <div class="bg-white rounded shadow p-8 max-w-md w-full">
        <h1 class="text-2xl font-bold text-center mb-6">Daftar Akun</h1>

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-bold mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2" required>
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2" required>
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold mb-2">Telepon</label>
                <input type="tel" name="phone" value="{{ old('phone') }}" class="w-full border rounded px-3 py-2" required>
                @error('phone')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold mb-2">Alamat</label>
                <textarea name="address" class="w-full border rounded px-3 py-2" required>{{ old('address') }}</textarea>
                @error('address')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2" required>
            </div>

            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded font-bold hover:bg-green-700">
                Daftar
            </button>
        </form>

        <div class="mt-4 text-center">
            <p class="text-sm">Sudah punya akun? <a href="{{ route('login') }}" class="text-green-600 hover:text-green-700 font-bold">Login di sini</a></p>
        </div>
    </div>
</div>
@endsection

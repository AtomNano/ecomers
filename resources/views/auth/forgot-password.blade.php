@extends('layouts.app')

@section('title', 'Lupa Password - Grosir Berkat Ibu')

@section('content')
<div class="flex items-center justify-center min-h-screen">
    <div class="bg-white rounded shadow p-8 max-w-md w-full">
        <h1 class="text-2xl font-bold text-center mb-6">Lupa Password</h1>

        <form action="{{ route('forgot-password-send') }}" method="POST" class="space-y-4">
            @csrf

            <p class="text-gray-600 text-sm mb-4">
                Masukkan email Anda dan kami akan mengirimkan link untuk reset password.
            </p>

            <div>
                <label class="block text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2" required>
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded font-bold hover:bg-green-700">
                Kirim Link Reset
            </button>
        </form>

        <div class="mt-4 text-center">
            <p class="text-sm"><a href="{{ route('login') }}" class="text-green-600 hover:text-green-700 font-bold">Kembali ke Login</a></p>
        </div>
    </div>
</div>
@endsection

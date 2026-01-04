@extends('layouts.app')

@section('title', 'Login - Grosir Berkat Ibu')

@section('content')
<div class="flex items-center justify-center min-h-screen">
    <div class="bg-white rounded shadow p-8 max-w-md w-full">
        <h1 class="text-2xl font-bold text-center mb-6">Login</h1>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2" required>
                @error('email')
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
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="rounded">
                    <span class="ml-2 text-sm">Ingat saya</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded font-bold hover:bg-green-700">
                Login
            </button>
        </form>

        <div class="mt-4 text-center space-y-2">
            <p class="text-sm">Belum punya akun? <a href="{{ route('register') }}" class="text-green-600 hover:text-green-700 font-bold">Daftar di sini</a></p>
            <p class="text-sm"><a href="{{ route('forgot-password') }}" class="text-blue-600 hover:text-blue-700">Lupa password?</a></p>
        </div>

        <!-- Quick Login untuk Development -->
        <div class="mt-8 pt-6 border-t">
            <p class="text-xs text-gray-500 text-center mb-3 font-semibold">🚀 QUICK LOGIN (Development)</p>
            <div class="space-y-2">
                <button type="button" onclick="quickLogin('admin@grosir.com', 'password123')" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded text-sm font-semibold transition">
                    👨‍💼 Admin Toko
                </button>
                <button type="button" onclick="quickLogin('owner@grosir.com', 'password123')" class="w-full bg-purple-500 hover:bg-purple-600 text-white py-2 rounded text-sm font-semibold transition">
                    👔 Owner Toko
                </button>
                <button type="button" onclick="quickLogin('budi@example.com', 'password123')" class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded text-sm font-semibold transition">
                    🛍️ Budi (Customer)
                </button>
                <button type="button" onclick="quickLogin('siti@example.com', 'password123')" class="w-full bg-pink-500 hover:bg-pink-600 text-white py-2 rounded text-sm font-semibold transition">
                    👩‍💼 Siti (Customer)
                </button>
            </div>
            <p class="text-xs text-gray-400 text-center mt-2">Password: password123</p>
        </div>
    </div>
</div>

<script>
    function quickLogin(email, password) {
        document.querySelector('input[name="email"]').value = email;
        document.querySelector('input[name="password"]').value = password;
        document.querySelector('form').submit();
    }
</script>
@endsection

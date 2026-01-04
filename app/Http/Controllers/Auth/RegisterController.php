<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'phone' => 'required|string',
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'address' => 'required|string',
        ]);
        
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'province' => $validated['province'],
            'city' => $validated['city'],
            'district' => $validated['district'],
            'address' => $validated['address'],
            'role' => 'customer',
            'password' => bcrypt($validated['password']),
        ]);
        
        Auth::login($user);
        
        return redirect()->route('customer.dashboard')->with('success', 'Registrasi berhasil!');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function showForm()
    {
        return view('auth.forgot-password');
    }

    public function sendReset(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users']);
        
        return back()->with('success', 'Link reset sudah dikirim ke email');
    }

    public function showReset($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
        
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->update(['password' => bcrypt($request->password)]);
        }
        
        return redirect('/login')->with('success', 'Password berhasil direset');
    }
}

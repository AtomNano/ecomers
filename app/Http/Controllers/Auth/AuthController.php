<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Coderflex\LaravelTurnstile\Facades\Turnstile;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];

        // Determine if captcha should be enforced
        $isDevBypass = app()->isLocal() && $request->has('bypass_captcha');
        $captchaEnabled = !empty(config('turnstile.turnstile_site_key')) && !empty(config('turnstile.turnstile_secret_key'));

        if ($captchaEnabled && !$isDevBypass) {
            $rules['cf-turnstile-response'] = 'required';
        }

        $validated = $request->validate($rules);

        // Validate Turnstile captcha only when enabled (and not bypassed)
        if ($captchaEnabled && !$isDevBypass && !Turnstile::validate($request->input('cf-turnstile-response'))) {
            return back()->withErrors(['captcha' => 'Captcha validation failed. Please try again.'])->withInput();
        }
        
        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            $user = Auth::user();
            $request->session()->regenerate();
            
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'owner') {
                return redirect()->route('owner.dashboard');
            } else {
                return redirect()->intended(route('home'));
            }
        }
        
        return back()->with('error', 'Email atau password salah');
    }

    /**
     * Redirect to Google OAuth provider
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user already exists
            $user = User::where('email', $googleUser->getEmail())->first();
            
            if ($user) {
                // Update existing user with Google info
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            } else {
                // Create new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'role' => 'customer',
                    'password' => null, // OAuth users don't need password
                ]);
            }
            
            // Log the user in
            Auth::login($user, true); // Remember user
            
            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'owner') {
                return redirect()->route('owner.dashboard');
            } else {
                return redirect()->route('home')->with('success', 'Berhasil login dengan Google!');
            }
            
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal login dengan Google. Silakan coba lagi.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Berhasil logout');
    }
}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        return view('pages.auth.login');
    }

    public function loginAction(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $key = 'login:' . $request->email;

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam ' . ceil($seconds / 60) . ' menit.',
            ]);
        }

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            RateLimiter::clear($key);

            $request->session()->regenerate();

            $request->user()->update(['last_login_at' => now()]);

            $role = $request->user()->user_role;
            if ($role === 'ADMIN') {
                return redirect()->route('admin.dashboard');
            } else if ($role === 'REVIEWER') {
                return redirect()->route('reviewer.dashboard');
            }
            return redirect()->route('author.dashboard');
        }

        RateLimiter::hit($key, 900);

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function register()
    {
        return view('pages.auth.register');
    }

    public function registerAction(Request $request)
    {
        $request->validate([
            'username' => 'required|max:30',
            'name' => 'required|max:100',
            'email' => 'required|email|max:50|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
            'contact' => 'required|max:30',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'contact' => $request->contact,
            'password' => Hash::make($request->password),
            'user_role' => 'AUTHOR',
        ]);

        Auth::login($user);

        return redirect()->route('author.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}

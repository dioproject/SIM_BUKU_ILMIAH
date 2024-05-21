<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login() {
        return view('pages.auth.login');
    }

    public function loginAction(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            $credentials = $request->only('email', 'password');

            $user = User::where('email', $credentials['email'])->first();

            if (!$user) {
                return back()->withErrors([
                    'email' => 'Email not registered.',
                ]);
            }

            if (!Hash::check($credentials['password'], $user->password)) {
                return back()->withErrors([
                    'password' => 'The password you entered is incorrect.',
                ]);
            }

            Auth::login($user);

            if ($user->user_role == 'ADMIN') {
                return redirect()->route('admin.dashboard');
            }else if ($user->user_role == 'EDITOR') {
                return redirect()->route('editor.dashboard');
            }else{
                return redirect()->route('author.dashboard');
            }

        }
        return view('pages.auth.login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}


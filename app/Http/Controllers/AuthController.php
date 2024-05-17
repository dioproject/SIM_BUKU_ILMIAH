<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;
  
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login() {
        return view('pages.auth.login');
    }
 
    public function loginAction(Request $request)
    {   
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        
        if(!auth()->attempt($credentials))
        {
            return redirect()->route('login')
                ->with('error','Email-Address And Password Are Wrong.');
        }
     
        if (auth()->user()->user_role == 'ADMIN') {
            return redirect()->route('admin.dashboard');
        }else if (auth()->user()->user_role == 'EDITOR') {
            return redirect()->route('editor.dashboard');
        }else{
            return redirect()->route('author.dashboard');
        }        
    }         
}
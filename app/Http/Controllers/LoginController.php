<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use AuthenticatesUsers;
  
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
 
    public function loginAction(Request $request)
    {   
        $input = $request->all();
     
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
     
        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))
        {
            if (auth()->user()->user_role == 'ADMIN') {
                return redirect()->route('pages.admin.dashboard');
            }else if (auth()->user()->user_role == 'EDITOR') {
                return redirect()->route('pages.editor.dashboard');
            }else{
                return redirect()->route('pages.author.dashboard');
            }
        }
        return redirect() -> route('pages.auth.login') -> with('error','Email Address And Password Are Wrong.');
          
    }
}

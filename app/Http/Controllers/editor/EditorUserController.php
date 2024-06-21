<?php

namespace App\Http\Controllers\editor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class EditorUserController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->input('search');
        if ($search) {
            $users = User::where('first_name', 'LIKE', '%' . $search . '%')
                         ->orWhere('last_name', 'LIKE', '%' . $search . '%')
                         ->paginate(10); 
        } else {
        $users = User::paginate(10);
        }
        return view('pages.editor.users.index', compact('users'));
    }
}

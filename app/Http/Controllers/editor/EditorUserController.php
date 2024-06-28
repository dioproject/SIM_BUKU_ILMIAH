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
        
        $query = User::where('user_role', 'AUTHOR');
        if ($search) {
            $query->where('first_name', 'LIKE', '%' . $search . '%')
                ->orWhere('last_name', 'LIKE', '%' . $search . '%');
        }

        $users = $query->paginate(10);

        return view('pages.editor.users.index', compact('users'));
    }
}

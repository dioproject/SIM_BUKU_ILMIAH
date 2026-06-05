<?php

namespace App\Http\Controllers\reviewer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewerUserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = User::where('user_role', 'AUTHOR');
        if ($search) {
            $query->where(function ($userQuery) use ($search) {
                $userQuery->where('username', 'LIKE', '%' . $search . '%')
                    ->orWhere('name', 'LIKE', '%' . $search . '%');
            });
        }

        $users = $query->paginate(10);

        return view('pages.reviewer.users.index', compact('users', 'search'));
    }
}

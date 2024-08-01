<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Histori;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        if ($search) {
            $users = User::where('username', 'LIKE', '%' . $search . '%')->paginate(5);
        } else {
            $users = User::paginate(5);
        }
        return view('pages.admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('pages.admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|max:30',
            'name' => 'required|max:100',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'required|min:8',
            'contact' => 'required|max:30',
            'user_role' => 'required|in:ADMIN,REVIEWER,AUTHOR',
        ]);

        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'password' => Hash::make($request->password),
            'user_role' => $request->user_role,
        ]);

        if ($user) {
            Histori::create([
                'detail' => Auth::user()->username . ' added user ' . $user->username,
            ]);
            return redirect()->route('admin.index.user')->with('success', Auth::user()->username . ' added user ' . $user->username . ' successfully.');
        }
        return redirect()->route('admin.create.book')->with('error', 'User not found.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('pages.admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|max:30',
            'name' => 'required|max:100',
            'password' => 'required|min:8',
            'contact' => 'required|max:30',
            'user_role' => 'required|in:ADMIN,REVIEWER,AUTHOR',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'username' => $request->username,
            'name' => $request->name,
            'contact' => $request->contact,
            'password' => Hash::make($request->password),
            'user_role' => $request->user_role,
            'updated_at' => now(),
        ]);

        if ($user) {
            Histori::create([
                'detail' => Auth::user()->username . ' updated user ' . $user->username,
            ]);
            return redirect()->route('admin.index.user')->with('success', Auth::user()->username . ' updated user ' . $user->username . ' successfully.');
        }
        return redirect()->route('admin.edit.book')->with('error', 'User not found.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        if ($user) {
            Histori::create([
                'detail' => Auth::user()->username . ' deleted user ' . $user->username,
            ]);
            return redirect()->route('admin.index.user');
        }
        return redirect()->route('admin.index.user');
    }
}

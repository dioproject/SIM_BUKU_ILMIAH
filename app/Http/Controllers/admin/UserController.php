<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gender;
use App\Models\Religion;
use App\Models\History;

class UserController extends Controller
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
        return view('pages.admin.users.index', compact('users'));
    }

    public function create()
    {
        $gender = Gender::all();
        $religion = Religion::all();

        return view('pages.admin.users.create', compact('gender', 'religion'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:100',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'required|min:8',
            'religion' => 'required',
            'gender' => 'required',
            'place_of_birth' => 'required|max:100',
            'date_of_birth' => 'required|date',
            'contact' => 'required|max:30',
            'user_role' => 'required|in:ADMIN,EDITOR,AUTHOR',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_role' => $request->user_role,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'place_of_birth' => $request->place_of_birth,
            'date_of_birth' => $request->date_of_birth,
            'contact' => $request->contact,
            'religion_id' => $request->religion,
            'gender_id' => $request->gender,
        ]);

        if ($user) {

            History::create([
                'change_detail' => Auth::user()->first_name . ' created user ' . $user->first_name . ' successfully.',
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('admin.index.user')->with('success', Auth::user()->first_name . ' created user ' . $user->first_name . ' successfully.');
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $gender = Gender::all();
        $religion = Religion::all();

        return view('pages.admin.users.edit', compact('user', 'gender', 'religion'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:100',
            'password' => 'required|min:8',
            'religion' => 'required',
            'gender' => 'required',
            'place_of_birth' => 'required|max:100',
            'date_of_birth' => 'required|date',
            'contact' => 'required|max:30',
            'user_role' => 'required|in:ADMIN,EDITOR,AUTHOR',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'password' => Hash::make($request->password),
            'user_role' => $request->user_role,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'place_of_birth' => $request->place_of_birth,
            'date_of_birth' => $request->date_of_birth,
            'contact' => $request->contact,
            'religion_id' => $request->religion,
            'gender_id' => $request->gender,
            'updated_at',
        ]);

        if ($user) {
            History::create([
                'change_detail' => Auth::user()->first_name . ' updated user ' . $user->first_name . ' successfully.',
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('admin.index.user')->with('success', Auth::user()->first_name . ' updated user ' . $user->first_name . ' successfully.');
        }
        return redirect()->route('admin.create.book')->with('error', 'User not found.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        if ($user) {
            History::create([
                'change_detail' => Auth::user()->first_name . ' deleted user ' . $user->first_name . ' successfully.',
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('admin.index.user');
        } 
        return redirect()->route('admin.index.user');
    }
}

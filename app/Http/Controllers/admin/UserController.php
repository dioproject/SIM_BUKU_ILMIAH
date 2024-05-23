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
    public function index() {
        $users = User::all();
        return view('pages.admin.users.index', compact('users'));
    }

    public function create() {
        $gender = Gender::all();
        $religion = Religion::all();

        return view('pages.admin.users.create', compact('gender', 'religion'));
    }

    public function store(Request $request) {
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

        $data = User::create([
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
            $userId = Auth::id();
            $history = History::create([
                'change_detail' => 'User created successfully.',
                'user_id' => $userId,
            ]);
            return redirect()->route('admin.index.user')->with('Success', 'User created successfully.');
        }
    }

    public function edit($id) {
        $user = User::findOrFail($id);
        $gender = Gender::all();
        $religion = Religion::all();

        return view('pages.admin.users.edit', compact('user', 'gender', 'religion'));
    }

    public function update(Request $request, $id) {
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
        ]);

        if ($user) {
            $userId = Auth::id();
            $history = History::create([
                'change_detail' => 'User updated successfully.',
                'user_id' => $userId,
            ]);
            return redirect()->route('admin.index.user')->with('Success', 'User updated successfully.');
        }
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();

        if($user) {
            $userId = Auth::id();
            $history = History::create([
                'change_detail' => 'User deleted successfully.',
                'user_id' => $userId,
            ]);
            return redirect()->route('admin.index.user')->with('Success', 'User deleted successfully.');
        } else {
            return redirect()->route('admin.index.user')->with('Error', 'User not found.');
        }
    }
}

<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index() {
        $users = User::all();
        return view('pages.admin.users.index', compact('users'));
    }

    public function create() {
        return view('pages.admin.users.create');
    }

    public function store(Request $request) {
        $request->validate([
            'first_name' => 'required|max:20',
            'last_name' => 'required|max:50',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'required|min:8',
            'religion' => 'required|in:ISLAM,HINDU,BUDHA,KONGHUCU,KRISTEN,KATOLIK',
            'gender' => 'required|in:MALE,FEMALE',
            'place_of_birth' => 'required|max:25',
            'date_of_birth' => 'required|date',
            'user_role' => 'required|in:ADMIN,EDITOR,AUTHOR',
        ]);

        $data = new User();
        $data->email = $request->email;
        $data->password = Hash::make($request->password);
        $data->user_role = $request->user_role;
        $data->first_name = $request->first_name;
        $data->last_name = $request->last_name;
        $data->place_of_birth = $request->place_of_birth;
        $data->date_of_birth = $request->date_of_birth;
        $data->religion = $request->religion;
        $data->gender = $request->gender;
        $data->save();

        return redirect()->route('admin.user.index')->with('Success', 'User created successfully.');
    }

    public function edit($id) {
        $user = User::findOrFail($id);

        return view('pages.admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'first_name' => 'required|max:20',
            'last_name' => 'required|max:50',
            'password' => 'required|min:8',
            'religion' => 'required|in:ISLAM,HINDU,BUDHA,KONGHUCU,KRISTEN,KATOLIK',
            'gender' => 'required|in:MALE,FEMALE',
            'place_of_birth' => 'required|max:25',
            'date_of_birth' => 'required|date',
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
            'religion' => $request->religion,
            'gender' => $request->gender,
        ]);
        return redirect()->route('admin.user.index')->with('Success', 'User updated successfully.');
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();

        if($user) {
            return redirect()->route('admin.user.index')->with('Success', 'User deleted successfully.');
        } else {
            return redirect()->route('admin.user.index')->with('Error', 'User not found.');
        }

    }
}

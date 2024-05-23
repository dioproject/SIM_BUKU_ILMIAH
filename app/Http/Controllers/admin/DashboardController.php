<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;

class DashboardController extends Controller
{
    public function index(){
        $users = User::all();
        $books = Book::all();
        return view('pages.admin.dashboard.index', compact('users', 'books'));
    }
}

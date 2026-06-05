<?php

namespace App\Http\Controllers\author;

use App\Http\Controllers\Controller;
use App\Models\Histori;
use Illuminate\Support\Facades\Auth;

class AuthorHistoryController extends Controller
{
    public function index() {
        $history = Histori::where('user_id', Auth::id())->latest()->paginate(10);

        return view('pages.author.history.index', compact('history'));
    }
}

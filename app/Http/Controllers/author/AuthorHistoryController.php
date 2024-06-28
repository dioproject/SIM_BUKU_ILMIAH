<?php

namespace App\Http\Controllers\author;

use App\Http\Controllers\Controller;
use App\Models\History;
use Illuminate\Support\Facades\Auth;

class AuthorHistoryController extends Controller
{
    public function index() {
        $history = History::where('user_id', Auth::id())->paginate(10);

        return view('pages.author.history.index', compact('history'));
    }
}

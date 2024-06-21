<?php

namespace App\Http\Controllers\author;

use App\Http\Controllers\Controller;
use App\Models\History;

class AuthorHistoryController extends Controller
{
    public function index() {
        $history = History::paginate(10);

        return view('pages.author.history.index', compact('history'));
    }
}

<?php

namespace App\Http\Controllers\author;

use App\Http\Controllers\Controller;
use App\Models\Histori;

class AuthorHistoryController extends Controller
{
    public function index() {
        $history = Histori::paginate(10);

        return view('pages.author.history.index', compact('history'));
    }
}

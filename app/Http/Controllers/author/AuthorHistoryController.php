<?php

namespace App\Http\Controllers\author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\History;
use App\Models\User;
use App\Models\Book;

class AuthorHistoryController extends Controller
{
    public function index() {
        $history = History::all();
        $name = User::select('first_name')->rightJoin('histories', 'users.id', '=', 'histories.user_id')->get();
        $title = History::select('histories.*', 'books.*', 'manuscripts.*')
            ->leftJoin('books', 'histories.book_id', '=', 'books.id')
            ->join('manuscripts', 'books.manuscript_id', '=', 'manuscripts.id')
            ->get();

        return view('pages.author.history.index', compact('history', 'name', 'title'));
    }
}

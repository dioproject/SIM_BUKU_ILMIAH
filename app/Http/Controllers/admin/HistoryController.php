<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\History;
use App\Models\User;
use App\Models\Book;

class HistoryController extends Controller
{
    public function index() {
        $history = History::all();
        $name = User::select('first_name')->rightJoin('histories', 'users.id', '=', 'histories.user_id')->get();
        $title = History::select('histories.book_id', 'books.manuscript_id', 'manuscripts.title')
            ->join('books', 'histories.book_id', '=', 'books.id')
            ->join('manuscripts', 'books.manuscript_id', '=', 'manuscripts.id')
            ->where('histories.id')
            ->first();

        return view('pages.admin.history.index', compact('history', 'name', 'title'));
    }
}

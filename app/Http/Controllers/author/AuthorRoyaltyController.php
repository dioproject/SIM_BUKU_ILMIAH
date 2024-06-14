<?php

namespace App\Http\Controllers\author;

use App\Http\Controllers\Controller;
use App\Models\Manuscript;
use App\Models\Royalty;
use App\Models\Status;
use App\Models\User;

class AuthorRoyaltyController extends Controller
{
    public function index()
    {
        $book = Manuscript::select('title')->rightJoin('books', 'manuscripts.id', '=', 'books.manuscript_id')->get();
        $author = User::select('first_name')->rightJoin('manuscripts', 'users.id', '=', 'manuscripts.author_id')->get();
        $royalty = Royalty::all();
        $status = Status::select('option')->rightJoin('royalties', 'statuses.id', '=', 'royalties.status_id')->get();

        return view('pages.author.royalty.index', compact('book', 'author', 'royalty', 'status'));
    }
}

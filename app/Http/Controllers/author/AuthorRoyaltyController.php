<?php

namespace App\Http\Controllers\author;

use App\Http\Controllers\Controller;
use App\Models\Manuscript;
use App\Models\Royalty;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;

class AuthorRoyaltyController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Royalty::query();

        if ($search) {
            $query->whereHas('book.manuscript', function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%');
            })->orWhereHas('book.manuscript.author', function ($q) use ($search) {
                $q->where('first_name', 'like', '%' . $search . '%');
            });
        }

        $royalty = $query->paginate(10);

        return view('pages.author.royalty.index', compact('royalty', 'search'));
    }
}

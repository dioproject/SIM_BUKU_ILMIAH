<?php

namespace App\Http\Controllers\author;

use App\Http\Controllers\Controller;
use App\Models\Royalty;
use Illuminate\Http\Request;

class AuthorReviewController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
    
        $royaltyQuery = Royalty::query();
        if ($search) {
            $royaltyQuery->whereHas('book.manuscript', function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%');
            })->orWhereHas('book.manuscript.author', function ($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%');
            });
        }
    
        $royalty = $royaltyQuery->with(['book.manuscript', 'status'])->paginate(10);
    
        return view('pages.author.royalty.index', compact('royalty', 'search'));
    }
}

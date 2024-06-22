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
    
        $reviewsQuery = Royalty::query();
        if ($search) {
            $reviewsQuery->whereHas('book.manuscript', function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%');
            })->orWhereHas('book.manuscript.author', function ($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%');
            });
        }
    
        $reviews = $reviewsQuery->with(['book.manuscript', 'status'])->paginate(10);
    
        return view('pages.author.reviews.index', compact('reviews', 'search'));
    }
}

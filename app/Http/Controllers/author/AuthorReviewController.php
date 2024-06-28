<?php

namespace App\Http\Controllers\author;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorReviewController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Review::with(['book', 'book.manuscript', 'book.manuscript.author'])
            ->whereHas('book.manuscript', function ($q) {
                $q->where('author_id', Auth::id());
            });

        if ($search) {
            $query->whereHas('book.manuscript', function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%');
            })->orWhere('content', 'like', '%' . $search . '%');
        }

        $reviews = $query->paginate(10);

        return view('pages.author.reviews.index', compact('reviews', 'search'));
    }
}

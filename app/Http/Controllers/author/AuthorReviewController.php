<?php

namespace App\Http\Controllers\author;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use Illuminate\Http\Request;

class AuthorReviewController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->input('search');
        $reviews = Chapter::with(['book'])->paginate(10);

        if ($search) {
            $reviews = Chapter::where('title', 'like', '%' . $search . '%')->paginate(10);
        }

        return view('pages.author.reviews.index', compact('reviews', 'search'));
    }
}

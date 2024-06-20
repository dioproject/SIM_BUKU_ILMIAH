<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Status;
use App\Models\Manuscript;
use App\Models\History;
use App\Models\Category;
use App\Models\Review;

class ReviewController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');
        if ($search) {
            $review = Review::where('name', 'like', '%' . $search . '%')->paginate(10);
        } else {
            $review = Review::paginate(10);
        }

        $title = Review::with('book.manuscript')->get();

        return view('pages.admin.title.index', compact('review', 'title'));
    }

    public function create()
    {
        $category = Category::all();
        $books = Book::with('manuscript')->get();

        return view('pages.admin.reviews.create', compact('category', 'books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required',
            'content' => 'required',
        ]);

        $review = Review::create([
            'book_id' => $request->book_id,
            'content' => $request->content,
            'reviewer_id' => Auth::id(),
        ]);

        if ($review) {
            $book = Book::findOrFail($request->book_id);
            History::create([
                'change_detail' => Auth::user()->first_name . ' created review ' . $book->manuscript->title . ' successfully.',
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('admin.index.review')->with('success', Auth::user()->first_name . ' created review ' . $book->manuscript->title . ' successfully.');
        }
        return redirect()->route('admin.create.review')->with('error', 'Review not found.');
    }

    public function edit($id)
    {
        $book = Book::with('manuscript')->get();
        $category = Category::all();
        $review = Review::findOrFail($id);
        return view('pages.admin.reviews.edit', compact('book', 'category', 'review'));
    }

    public function update(Request $request, $id)
    {
        $review = Review::create([
            'book_id' => $request->book_id,
            'content' => $request->content,
            'reviewer_id' => Auth::id(),
        ]);

        $review = Review::findOrFail($id);
        $review->update([
            'content' => $request->content,
            'reviewer_id' => Auth::id(),
            'updated_at' => now(),
        ]);

        if ($review) {
            $book = Book::findOrFail($review->book_id);
            $manuscript = Manuscript::findOrFail($book->manuscript_id);
            $book->update([
                'status_id' => Status::findOrFail(2)->id,
                'updated_at' => now(),
            ]);

            History::create([
                'change_detail' => Auth::user()->first_name . ' review ' . $manuscript->title . ' successfully.',
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('admin.index.review')->with('success', Auth::user()->first_name . ' review ' . $manuscript->title . ' successfully.');
        }
        return redirect()->route('admin.edit.review')->with('error', 'Book not found.');
    }
}

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
    public function index()
    {
        $review = Review::all();

        return view('pages.admin.reviews.index', compact('review'));
    }

    public function create()
    {
        $review = Review::all();
        $category = Category::all();
        $books = Book::with('manuscript')->get();

        return view('pages.admin.reviews.create', compact('review', 'category', 'books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'title' => 'required',
            'abstract' => 'required',
            'fill' => 'required',
        ]);

        $manuscript = Manuscript::create([
            'title' => $request->title,
            'abstract' => $request->abstract,
            'fill' => $request->fill,
            'author_id' => Auth::id(),
        ]);
        
        if ($manuscript) {
            $book = Book::create([
                'category_id' => $request->category,
                'manuscript_id' => $manuscript->id,
                'status_id' => Status::findOrFail(1)->id,
            ]);

            History::create([
                'change_detail' => Auth::user()->first_name . ' created book ' . $manuscript->title . ' successfully.',
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('admin.index.book')->with('success', Auth::user()->first_name . ' created book ' . $manuscript->title . ' successfully.');
        }
        return redirect()->route('admin.create.book')->with('error', 'Book not found.');
    }

    public function edit($id)
    {
        $book = Manuscript::select('manuscripts.*', 'books.*')->rightJoin('books', 'manuscripts.id', '=', 'books.manuscript_id')->where('books.id', $id)->first();
        $category = Category::all();
        $review = Review::where('book_id', $id)->first();
        return view('pages.admin.reviews.edit', compact('book', 'category', 'review'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required',
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

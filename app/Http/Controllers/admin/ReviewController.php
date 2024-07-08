<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\History;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Status;

class ReviewController extends Controller
{

    public function index(Request $request)
    {

        $search = $request->input('search');
        $reviews = Chapter::with(['book', 'book.status'])->paginate(10);

        if ($search) {
            $reviews = Chapter::where('title', 'like', '%' . $search . '%')->paginate(10);
        }

        return view('pages.admin.reviews.index', compact('reviews', 'search'));
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

        if (Chapter::where('book_id', $request->book_id)->exists()) {
            return redirect()->route('admin.create.review')->with('error', 'Chapter does not exist.');            
        }
        
        $review = Chapter::create([
            'book_id' => $request->book_id,
            'content' => $request->content,
            'reviewer_id' => Auth::id(),
        ]);

        if ($review) {
            $book = Book::findOrFail($request->book_id);
            $book->update([
                'status_id' => Status::findOrFail(2)->id,
            ]);
            
            History::create([
                'change_detail' => Auth::user()->first_name . ' created review ' . $book->manuscript->title . ' successfully.',
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('admin.index.review')->with('success', Auth::user()->first_name . ' created review ' . $book->manuscript->title . ' successfully.');
        }
        return redirect()->route('admin.create.review')->with('error', 'Chapter not found.');
    }

    public function edit($id)
    {        
        $review = Chapter::findOrFail($id);
        $books = Book::with('manuscript')->get();

        return view('pages.admin.reviews.edit', compact( 'review', 'books'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $review = Chapter::findOrFail($id);
        $review->update([
            'content' => $request->content,
            'reviewer_id' => Auth::id(),
            'updated_at' => now(),
        ]);

        if ($review) {
            $book = Book::findOrFail($id);            
            History::create([
                'change_detail' => Auth::user()->first_name . ' updated review ' . $book->manuscript->title . ' successfully.',
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('admin.index.review')->with('success', Auth::user()->first_name . ' updated review ' . $book->manuscript->title . ' successfully.');
        }
        return redirect()->route('admin.edit.review')->with('error', 'Chapter not found.');
    }

    public function destroy($id)
    {
        $review = Chapter::findOrFail($id);
        $review->delete();

        if ($review) {
            $book = $review->book;
            History::create([
                'change_detail' => Auth::user()->first_name . ' deleted review ' . $book->manuscript->title . ' successfully.',
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('admin.index.review');
        } 
        return redirect()->route('admin.index.review');
    }
}

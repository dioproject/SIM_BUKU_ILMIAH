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
    public function edit($id)
    {
        $book = Manuscript::select('manuscripts.*', 'books.*')->rightJoin('books', 'manuscripts.id', '=', 'books.manuscript_id')->where('books.id', $id)->first();
        $category = Category::all();
        $review = Review::all();
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
            'updated_at',
        ]);

        if ($review) {
            $manuscript = Manuscript::findOrFail($id);
            $book = Book::findOrFail($id);
            $book->update([
                'category_id' => $request->category,
                'manuscript_id' => $id,
                'status_id' => Status::findOrFail(1)->id,
                'updated_at',
            ]);

            History::create([
                'change_detail' => Auth::user()->first_name . ' review ' . $manuscript->title . ' successfully.',
                'user_id' => Auth::id(),
                'book_id' => $book->id,
            ]);
            return redirect()->route('admin.index.book')->with('success', Auth::user()->first_name . ' review ' . $manuscript->title . ' successfully.');
        }
        return redirect()->route('admin.create.book')->with('error', 'Book not found.');
    }
}

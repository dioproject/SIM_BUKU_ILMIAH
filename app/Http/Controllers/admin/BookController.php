<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Status;
use App\Models\Manuscript;
use App\Models\History;
use App\Models\Category;

class BookController extends Controller
{
    public function index(Request $request) {
        $request->validate([
            'search' => 'required',
        ]);

        $books = Book::all();
        $title = Manuscript::select('title')->rightJoin('books', 'manuscripts.id', '=', 'books.manuscript_id')->get();
        $status = Status::select('option')->rightJoin('books', 'statuses.id', '=', 'books.status_id')->get();
        $author = User::select('first_name')->rightJoin('manuscripts', 'users.id', '=', 'manuscripts.author_id')->get();
        $search  = Book::where('title', 'like', "%{$request->search}%")
        ->orWhere('author', 'like', "%{$request->search}%")
        ->paginate(10);

        return view('pages.admin.books.index', compact('books', 'title', 'status', 'author'));
    }

    public function create() {
        $category = Category::all();
        $manuscript = Manuscript::all();

        return view('pages.admin.books.create', compact('category', 'manuscript'));
    }

    public function store(Request $request) {
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
                'change_detail' => 'Book created successfully.',
                'user_id' => Auth::id(),
                'book_id' => $book->id,
            ]);
            return redirect()->route('admin.index.book')->with('Success', 'Book created successfully.');
        }
        return redirect()->route('admin.create.book')->with('Error', 'Book not found.');
    }

    public function edit($id) {
        $book = Manuscript::select('manuscripts.*', 'books.*')->rightJoin('books', 'manuscripts.id', '=', 'books.manuscript_id')->where('books.id', $id)->first();
        $category = Category::all();
        return view('pages.admin.books.edit', compact('book', 'category'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'category' => 'required',
            'title' => 'required',
            'abstract' => 'required',
            'fill' => 'required',
        ]);

        $manuscript = Manuscript::findOrFail($id);
        $manuscript->update([
            'title' => $request->title,
            'abstract' => $request->abstract,
            'fill' => $request->fill,
            'author_id' => Auth::id(),
            'updated_at',
        ]);

        if ($manuscript) {

            $book = Book::findOrFail($id);
            $book->update([
                'category_id' => $request->category,
                'manuscript_id' => $id,
                'status_id' => Status::findOrFail(1)->id,
                'updated_at',
            ]);

            History::create([
                'change_detail' => 'Book Updated successfully.',
                'user_id' => Auth::id(),
                'book_id' => $book->id,
            ]);
            return redirect()->route('admin.index.book')->with('Success', 'Book Updated successfully.');
        }
        return redirect()->route('admin.create.book')->with('Error', 'Book not found.');
    }

    public function destroy($id) {
        $manuscript = Manuscript::findOrFail($id);
        $manuscript->delete();

        if($manuscript) {
            $book = Book::where('manuscript_id', $id)->delete();

            History::where('book_id', $book)->update([
                'change_detail' => 'Book deleted successfully.',
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('admin.index.book')->with('Success', 'Book deleted successfully.');
        } else {
            return redirect()->route('admin.index.book')->with('Error', 'Failed to delete book.');
        }
    }
}

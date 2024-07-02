<?php

namespace App\Http\Controllers\editor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Status;

class EditorBookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $books = Book::paginate(10);
        if ($search) {
            $books = Book::where('title', 'like',  '%' . $search . '%')->paginate(10);
        }

        return view('pages.editor.books.index', compact('books', 'search'));
    }

    public function show($id)
    {
        $book = Book::with('status')->findOrFail($id);

        return view('pages.editor.books.show', compact('book'));
    }

    public function approve($id)
    {
        $book = Book::with('status')->findOrFail($id);
        $book->update(['status_id' => Status::findOrFail(4)->id]);

        return redirect()->route('editor.show.book', $id);
    }

    public function rejected($id)
    {
        $book = Book::with('status')->findOrFail($id);
        $book->update(['status_id' => Status::findOrFail(5)->id]);

        return redirect()->route('editor.show.book', $id);
    }
}

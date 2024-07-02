<?php

namespace App\Http\Controllers\editor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\History;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;

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

    public function review(Request $request, $id)
    {
        $request->validate([
            'review' => 'required|file|mimes:doc,docx',
        ]);

        if ($request->hasFile('review')) {
            $file = $request->file('review');
            $fileName = time() . '_' . 'review' . '_' . $file->getClientOriginalName();
            $file->storeAs('upload/books', $fileName, 'public');
        }

        $book = Book::findOrFail($id);
        $book->update([
            'review' => $fileName,
            'reviewer_id' => Auth::id(),
        ]);

        if ($book) {
            History::create([
                'change_detail' => Auth::user()->first_name . ' review book ' . $book->title,
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('editor.show.book', $id)->with('success', Auth::user()->first_name . ' review book ' . $book->title);
        }
        return redirect()->route('editor.show.book', $id)->with('error', 'Book not found.');
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

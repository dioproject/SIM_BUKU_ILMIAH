<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Status;
use App\Models\History;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $books = Book::paginate(10);
        if ($search) {
            $books = Book::where('title', 'like',  '%' . $search . '%')->paginate(10);
        }

        return view('pages.admin.books.index', compact('books', 'search'));
    }

    public function create()
    {
        return view('pages.admin.books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'template' => 'required|file|mimes:doc,docx',
        ]);

        if ($request->hasFile('template')) {
            $file = $request->file('template');
            $fileName = time() . '_' . 'template' . '_' . $file->getClientOriginalName();
            $file->storeAs('upload/books', $fileName, 'public');
        }

        $book = Book::create([
            'title' => $request->title,
            'template' => $fileName,
            'status_id' => Status::findOrFail(1)->id,
        ]);

        if ($book) {
            History::create([
                'change_detail' => Auth::user()->first_name . ' added ' . $book->title . ' book.',
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('admin.index.book')->with('success', Auth::user()->first_name . ' added ' . $book->title . ' book success.');
        }
        return redirect()->route('admin.create.book')->with('error', 'Book not found.');
    }

    public function show($id)
    {
        $book = Book::with('status')->findOrFail($id);

        return view('pages.admin.books.show', compact('book'));
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('pages.admin.books.edit', compact('book'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'template' => 'required|file|mimes:doc,docx',
        ]);

        $book = Book::findOrFail($id);
        $oldFile = $book->template;
        $fileName = $oldFile;

        if ($request->hasFile('template')) {
            $file = $request->file('template');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('upload/books', $fileName, 'public');
        }

        $book->update([
            'template' => $fileName,
            'updated_at' => now(),
        ]);

        if ($oldFile) {
            Storage::disk('public')->delete('upload/books/' . $oldFile);
        }

        if ($book) {
            History::create([
                'change_detail' => Auth::user()->first_name . ' updated book ' . $book->title,
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('admin.index.book')->with('success', Auth::user()->first_name . ' updated book ' . $book->title . ' successfully.');
        }
        return redirect()->route('admin.create.book')->with('error', 'Book not found.');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $script = $book->script;
        $template = $book->template;
        $book->delete();

        if ($book) {
            Storage::disk('public')->delete('upload/books/' . $script);
            Storage::disk('public')->delete('upload/books/' . $template);
        }

        if ($book) {
            $book->delete();

            History::create([
                'change_detail' => Auth::user()->first_name . ' deleted book ' . $book->title,
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('admin.index.book');
        }
        return redirect()->route('admin.index.book');
    }
}

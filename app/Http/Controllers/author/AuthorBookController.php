<?php

namespace App\Http\Controllers\author;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\Status;
use App\Models\History;
use Illuminate\Support\Facades\Storage;

class AuthorBookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $chapters = Chapter::with(['status'])->paginate(10);
        if ($search) {
            $chapters = Book::where('title', 'like',  '%' . $search . '%')->paginate(10);
        }

        return view('pages.author.books.index', compact('chapters', 'search'));
    }

    public function submit($id)
    {
        $chapter = Chapter::findOrFail($id);
        $chapter->update([
            'status_id' => Status::findOrFail(6)->id,
            'author_id  ' => Auth::id(),
        ]);

        return redirect()->route('author.index.book');
    }

    public function create()
    {
        $chapter_user = Chapter::where('status_id', 5)->where('author_id', Auth::id())->get();
        return view('pages.author.books.create', compact('chapter'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'title' => 'required|max:250',
            'script' => 'required|file|mimes:doc,docx',
        ]);

        $fileName = null;

        if ($request->hasFile('script')) {
            $file = $request->file('script');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('upload/books', $fileName, 'public');
        }

        $book = Book::create([
            'title' => $request->title,
            'script' => $fileName,
            'author_id' => Auth::id(),
            'category_id' => $request->category,
            'status_id' => Status::findOrFail(1)->id,
        ]);

        if ($book) {
            History::create([
                'change_detail' => Auth::user()->first_name . ' added ' . $book->title . ' book.',
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('author.index.book')->with('success', Auth::user()->first_name . ' created book ' . $book->title . ' successfully.');
        }
        return redirect()->route('author.create.book')->with('error', 'Book not found.');
    }

    public function show($id)
    {
        $book = Book::with('status')->findOrFail($id);

        return view('pages.author.books.show', compact('book'));
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('pages.author.books.edit', compact('book', 'category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'required',
            'title' => 'required|max:250',
            'script' => 'required|file|mimes:doc,docx',
        ]);

        $book = Book::findOrFail($id);
        $oldFile = $book->script;

        $fileName = $oldFile;

        if ($request->hasFile('script')) {
            $file = $request->file('script');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('upload/books', $fileName, 'public');            
        }
        
        $book->update([
            'title' => $request->title,
            'script' => $fileName,
            'category_id' => $request->category,
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
            return redirect()->route('author.index.book')->with('success', Auth::user()->first_name . ' updated book ' . $book->title . ' successfully.');
        }
        return redirect()->route('author.create.book')->with('error', 'Book not found.');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $manuscript = $book->manuscript;
        $manuscript->delete();

        if ($manuscript) {
            $book->delete();

            History::create([
                'change_detail' => Auth::user()->first_name . ' deleted book ' . $manuscript->title . ' successfully.',
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('author.index.book');
        }
        return redirect()->route('author.index.book');
    }
}

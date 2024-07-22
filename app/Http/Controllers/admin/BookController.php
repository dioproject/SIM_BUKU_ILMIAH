<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\Status;
use App\Models\History;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        if ($search) {
            $books = Book::where('title', 'like',  '%' . $search . '%')->paginate(10);
        }
        $books = Book::paginate(10);

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
            'total_chapter' => 'required|numeric',
            'template' => 'required|file|mimes:doc,docx',
        ]);

        if ($request->hasFile('template')) {
            $file = $request->file('template');
            $fileName = time() . '_template_' . $file->getClientOriginalName();
            $file->storeAs('upload/books', $fileName, 'public');
        }

        $book = Book::create([
            'title' => $request->title,
            'template' => $fileName,
            'total_chapter' => $request->total_chapter,
        ]);

        if ($book) {
            History::create([
                'change_detail' => Auth::user()->first_name . ' added ' . $book->title . ' book.',
            ]);
            return redirect()->route('admin.index.book')->with('success', Auth::user()->first_name . ' added ' . $book->title . ' book success.');
        }
        return redirect()->route('admin.create.book');
    }

    public function storeChapter(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $validatedData = $request->validate([
            'chapter' => 'required|array',
            'chapter.*' => 'required|string|max:100',
        ]);

        foreach ($validatedData['chapter'] as $chapter) {
            Chapter::create([
                'chapter' => $chapter,
                'book_id' => $book->id,
                'status_id' => Status::findOrFail(1)->id,
            ]);
        }

        return redirect()->route('admin.show.book', $book->id)->with('success', 'Chapters saved successfully!');
    }


    public function show($id)
    {
        $book = Book::findOrFail($id);
        $chapters = Chapter::where('book_id', $book->id)->get();

        return view('pages.admin.books.show', compact('book', 'chapters'));
    }

    public function approve($id)
    {
        $chapter = Chapter::with(['author', 'status', 'book'])->findOrFail($id);
        $chapter->update([
            'status_id' => Status::findOrFail(3)->id,
            'approvedAt' => now(),
            'deadline' => now()->addWeeks(2),
        ]);

        $book = $chapter->book_id;

        return redirect()->route('admin.show.book', $book);
    }

    public function reject($id)
    {
        $chapter = Chapter::with(['author', 'status', 'book'])->findOrFail($id);
        $chapter->update([
            'status_id' => Status::findOrFail(4)->id,
            'author_id' => null,
        ]);

        $book = $chapter->book_id;

        return redirect()->route('admin.show.book', $book);
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

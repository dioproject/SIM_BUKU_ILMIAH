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
        if ($search) {
            $books = Book::where('title', 'like',  '%' . $search . '%')->paginate(10);
        }
        $books = Book::paginate(10);
        $chapters = Chapter::all();
        $booksWithChaptersCount = $books->map(function ($book) use ($chapters) {
            $filledChaptersCount = $chapters->where('book_id', $book->id)->whereNotNull('chapter')->count();
            $book->filledChaptersCount = $filledChaptersCount;
            return $book;
        });

        return view('pages.author.books.index', compact('books', 'search', 'chapters'));
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        $chapters = Chapter::where('book_id', $book->id)->get();

        return view('pages.author.books.show', compact('book', 'chapters'));
    }

    public function submit($id)
    {
        $chapter = Chapter::findOrFail($id);
        $chapter->update([
            'status_id' => Status::findOrFail(2)->id,
            'author_id' => Auth::id(),
            'created_at' => now()
        ]);

        return redirect()->route('author.show.book', $chapter->book_id);
    }

    public function upload(Request $request, $id)
    {
        $request->validate([
            'file_chapter' => 'required|file|mimes:doc,docx',
        ]);
        dd($request->all());

        $chapter = Chapter::findOrFail($id);
        $oldFile = $chapter->file_chapter;
        $fileName = $oldFile;

        if ($request->hasFile('file_chapter')) {
            $file = $request->file('file_chapter');
            $fileName = time() . '_chapter_' . $file->getClientOriginalName();

            $filePath = $file->storeAs('upload/books', $fileName, 'public');

            if ($filePath) {
                $chapter->update([
                    'file_chapter' => $fileName,
                    'author_id' => Auth::id(),
                    'uploaded_at' => now(),
                ]);

                if ($oldFile) {
                    Storage::disk('public')->delete('upload/books/' . $oldFile);
                }

                return redirect()->route('author.show.book', $chapter->book_id)
                    ->with('success', 'Chapter uploaded successfully.');
            } else {
                return redirect()->back()->with('error', 'Failed to upload chapter file. Please try again.');
            }
        }

        return redirect()->back()->with('error', 'No file was uploaded.');
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
}

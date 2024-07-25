<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\File;
use App\Models\Status;
use App\Models\History;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $books = Book::query();

        if ($search) {
            $books = Book::where('title', 'like', '%' . $search . '%')->paginate(5);
        } else {
            $books = Book::paginate(5);
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
            'total_chapter' => 'required',
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
                'change_detail' => Auth::user()->username . ' added ' . $book->title . ' book.',
            ]);
            return redirect()->route('admin.index.book')->with('success', Auth::user()->username . ' added ' . $book->title . ' book successfully.');
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
            $newChapter = Chapter::create([
                'chapter' => $chapter,
                'book_id' => $book->id,
                'status_id' => Status::findOrFail(1)->id,
            ]);

            History::create([
                'change_detail' => 'Added chapter "' . $newChapter->chapter . '" to book "' . $book->title . '" by ' . Auth::user()->username,
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

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $templateId = $book->template_id;
        $chapters = Chapter::where('book_id', $book->id)->get();

        if ($templateId) {
            $templateFile = File::findOrFail($templateId);
            if ($templateFile) {
                Storage::disk('public')->delete('/upload/books/' . $templateFile->name);
                $templateFile->delete();
            }
        }

        foreach ($chapters as $chapter) {
            if ($chapter->chapter_id) {
                $chapterFile = File::findOrFail($chapter->chapter_id);
                if ($chapterFile) {
                    Storage::disk('public')->delete('/upload/books/' . $chapterFile->name);
                    $chapterFile->delete();
                }
            }

            if ($chapter->review_id) {
                $reviewFile = File::find($chapter->review_id);
                if ($reviewFile) {
                    Storage::disk('public')->delete('/upload/books/' . $reviewFile->name);
                    $reviewFile->delete();
                }
            }

            $chapter->delete();
        }

        $book->delete();

        History::create([
            'change_detail' => Auth::user()->username . ' deleted book ' . $book->title,
        ]);

        return redirect()->route('admin.index.book')->with('success', 'Book deleted successfully.');
    }
}

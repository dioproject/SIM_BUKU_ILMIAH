<?php

namespace App\Http\Controllers\reviewer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\History;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewerBookController extends Controller
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

        return view('pages.reviewer.books.index', compact('books', 'search', 'chapters'));
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        $chapters = Chapter::where('book_id', $book->id)->get();

        return view('pages.reviewer.books.show', compact('book', 'chapters'));
    }

    public function upload(Request $request, $id)
    {
        $request->validate([
            'file_review' => 'required|file|mimes:doc,docx|max:2048',
        ]);

        $chapter = Chapter::findOrFail($id);
        $oldFile = $chapter->file_review;
        $fileName = $oldFile;

        if ($request->hasFile('file_review')) {
            $file = $request->file('file_review');
            $fileName = time() . '_revisi_' . $file->getClientOriginalName();

            // Simpan file baru
            $filePath = $file->storeAs('upload/books', $fileName, 'public');

            if ($filePath) {
                $chapter->update([
                    'file_review' => $fileName,
                    'reviewer_id' => Auth::id(),
                    'reviewedAt' => now(),
                    'status_id' => Status::findOrFail(5)->id,
                ]);

                if ($oldFile) {
                    Storage::disk('public')->delete('upload/books/' . $oldFile);
                }

                return redirect()->route('reviewer.show.book', $chapter->book_id)
                    ->with('success', 'Review uploaded successfully.');
            } else {
                return redirect()->back()->with('error', 'Failed to upload review file. Please try again.');
            }
        }

        return redirect()->back()->with('error', 'No file was uploaded.');
    }

    public function notes(Request $request, $id)
    {
        $request->validate([
            'notes' => 'required|max:200',
        ]);

        $chapter = Chapter::findOrFail($id);

        if ($chapter->reviewer_id === Auth::id()) {
            $chapter->update([
                'notes' => $request->notes,
            ]);
        }

        return redirect()->route('reviewer.show.book', $chapter->book_id);
    }
}
<?php

namespace App\Http\Controllers\author;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\Status;
use App\Models\History;
use App\Models\Notification;
use App\Models\User;
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

                History::create([
                    'change_detail' => 'Uploaded chapter "' . $chapter->chapter . '" for book "' . $chapter->book->title . '" by ' . Auth::user()->username,
                ]);

                $users = User::whereIn('user_role', ['REVIEWER', 'ADMIN'])->get();

                foreach ($users as $user) {
                    Notification::create([
                        'user_id' => $user->id,
                        'type' => 'Chapter Uploaded',
                        'data' => [
                            'chapter' => $chapter->chapter,
                            'uploaded_by' => Auth::user()->username,
                        ],
                        'is_read' => false,
                    ]);
                }

                return redirect()->route('author.show.book', $chapter->book_id)
                    ->with('success', 'Chapter uploaded successfully.');
            } else {
                return redirect()->back()->with('error', 'Failed to upload chapter file. Please try again.');
            }
        }

        return redirect()->back()->with('error', 'No file was uploaded.');
    }
}

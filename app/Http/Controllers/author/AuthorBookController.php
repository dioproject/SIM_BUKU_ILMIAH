<?php

namespace App\Http\Controllers\author;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Bab;
use App\Models\Histori;
use App\Models\Status;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class AuthorBookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        if ($search) {
            $books = Buku::where('title', 'like',  '%' . $search . '%')->paginate(10);
        }
        $books = Buku::paginate(10);
        $chapters = Bab::all();
        $booksWithChaptersCount = $books->map(function ($book) use ($chapters) {
            $filledChaptersCount = $chapters->where('buku_id', $book->id)->whereNotNull('nama')->count();
            $book->filledChaptersCount = $filledChaptersCount;
            return $book;
        });

        return view('pages.author.books.index', compact('books', 'search', 'chapters'));
    }

    public function show($id)
    {
        $buku = Buku::findOrFail($id);
        $babs = Bab::with(['author', 'buku', 'status'])->where('buku_id', $buku->id)->get();

        return view('pages.author.books.show', compact('buku', 'babs'));
    }

    public function submit($id)
    {
        $chapter = Bab::findOrFail($id);
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
            'file_bab' => 'required|file|mimes:doc,docx',
        ]);

        $chapter = Bab::findOrFail($id);
        $oldFile = $chapter->file_bab;
        $fileName = $oldFile;

        if ($request->hasFile('file_bab')) {
            $file = $request->file('file_bab');
            $fileName = time() . '_bab_' . $file->getClientOriginalName();

            $filePath = $file->storeAs('upload/books', $fileName, 'public');

            if ($filePath) {
                $chapter->update([
                    'file_bab' => $fileName,
                    'author_id' => Auth::id(),
                    'uploaded_at' => now(),
                ]);

                if ($oldFile) {
                    Storage::disk('public')->delete('upload/books/' . $oldFile);
                }

                Histori::create([
                    'detail' => 'Mengunggah bab "' . $chapter->nama . '" dari buku "' . $chapter->buku->judul . '" oleh ' . Auth::user()->username,
                ]);

                $users = User::whereIn('user_role', ['REVIEWER', 'ADMIN'])->get();

                foreach ($users as $user) {
                    Notifikasi::create([
                        'user_id' => $user->id,
                        'data' => [
                            'chapter' => $chapter->nama,
                            'uploaded_by' => Auth::user()->username,
                        ],
                    ]);
                }

                return redirect()->back()
                    ->with('success', 'Berhasil mengunggah bab.');
            } else {
                return redirect()->back()->with('error', 'Gagal mengunggah file bab. Coba sekali lagi.');
            }
        }

        return redirect()->back()->with('error', 'No file was uploaded.');
    }
}

<?php

namespace App\Http\Controllers\reviewer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Bab;
use App\Models\Histori;
use App\Models\Notifikasi;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewerBookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        if ($search) {
            $books = Buku::where('judul', 'like',  '%' . $search . '%')->paginate(10);
        }
        $books = Buku::paginate(10);
        $chapters = Bab::all();
        $booksWithChaptersCount = $books->map(function ($book) use ($chapters) {
            $filledChaptersCount = $chapters->where('buku_id', $book->id)->whereNotNull('nama')->count();
            $book->filledChaptersCount = $filledChaptersCount;
            return $book;
        });

        return view('pages.reviewer.books.index', compact('books', 'search', 'chapters'));
    }

    public function show($id)
    {
        $buku = Buku::findOrFail($id);
        $babs = Bab::with(['author', 'buku', 'status'])->where('buku_id', $buku->id)->get();

        return view('pages.reviewer.books.show', compact('buku', 'babs'));
    }

    public function upload(Request $request, $id)
    {
        $request->validate([
            'file_revieu' => 'required|file|mimes:doc,docx',
        ]);

        $review = Bab::findOrFail($id);
        $oldFile = $review->file_revieu;
        $fileName = $oldFile;

        if ($request->hasFile('file_revieu')) {
            $file = $request->file('file_revieu');
            $fileName = time() . '_revieu_' . $file->getClientOriginalName();

            $filePath = $file->storeAs('upload/books', $fileName, 'public');

            if ($filePath) {
                $review->update([
                    'file_revieu' => $fileName,
                    'reviewer_id' => Auth::id(),
                    'updated_at' => now(),
                    'deadline' => now()->addWeeks(6),
                ]);

                if ($oldFile) {
                    Storage::disk('public')->delete('upload/books/' . $oldFile);
                }

                Histori::create([
                    'detail' => 'Reviewed chapter "' . $review->nama . '" for book "' . $review->buku->judul . '" by ' . Auth::user()->username,
                ]);

                Notifikasi::create([
                    'user_id' => $review->author_id,
                    'data' => [
                        'chapter' => $review->nama,
                        'status' => $review->status->option,
                    ],
                ]);

                return redirect()->back()
                    ->with('success', 'Berhasil mengunggah reviu.');
            } else {
                return redirect()->back()->with('error', 'Gagal mengunggah file reviu. Silahkan coba lagi.');
            }
        }

        return redirect()->back()->with('error', 'Tidak file yang diunggah.');
    }

    public function notes(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|max:200',
        ]);

        $chapter = Bab::findOrFail($id);

        if ($chapter->reviewer_id == Auth::id()) {
            $chapter->update([
                'catatan' => $request->catatan,
            ]);
        }

        return redirect()->back();
    }
}

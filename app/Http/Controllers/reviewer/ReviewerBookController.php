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
use App\Helpers\StatusHelper;

class ReviewerBookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $booksQuery = Buku::whereHas('bab', function ($query) {
            $query->where('reviewer_id', Auth::id());
        });

        if ($search) {
            $books = $booksQuery->where('judul', 'like',  '%' . $search . '%')->paginate(10);
        } else {
            $books = $booksQuery->paginate(10);
        }
        $books->appends(['search' => $search]);

        $chapters = Bab::where('reviewer_id', Auth::id())->get();
        $booksWithChaptersCount = $books->map(function ($book) use ($chapters) {
            $filledChaptersCount = $chapters->where('buku_id', $book->id)->whereNotNull('nama')->count();
            $book->filledChaptersCount = $filledChaptersCount;
            return $book;
        });

        return view('pages.reviewer.books.index', compact('books', 'search', 'chapters'));
    }

    public function show(Request $request, $id)
    {
        $chapterSearch = $request->input('chapter_search');
        $buku = Buku::whereHas('bab', function ($query) {
            $query->where('reviewer_id', Auth::id());
        })->findOrFail($id);
        $babs = Bab::with(['author', 'buku', 'status'])
            ->where('buku_id', $buku->id)
            ->where('reviewer_id', Auth::id())
            ->when($chapterSearch, function ($query) use ($chapterSearch) {
                $query->where(function ($subQuery) use ($chapterSearch) {
                    $subQuery->where('nama', 'like', '%' . $chapterSearch . '%')
                        ->orWhereHas('author', function ($authorQuery) use ($chapterSearch) {
                            $authorQuery->where('username', 'like', '%' . $chapterSearch . '%')
                                ->orWhere('name', 'like', '%' . $chapterSearch . '%');
                        })
                        ->orWhereHas('status', function ($statusQuery) use ($chapterSearch) {
                            $statusQuery->where('option', 'like', '%' . $chapterSearch . '%');
                        });
                });
            })
            ->paginate(10)
            ->appends(['chapter_search' => $chapterSearch]);

        return view('pages.reviewer.books.show', compact('buku', 'babs', 'chapterSearch'));
    }

    public function upload(Request $request, $id)
    {
        $request->validate([
            'file_revieu' => 'required|file|mimes:doc,docx',
        ]);

        $review = Bab::findOrFail($id);

        if ($review->reviewer_id !== Auth::id() || !$review->author_id || !$review->file_bab || !StatusHelper::canBeReviewed($review->status_id)) {
            return redirect()->back()->with('error', 'Bab ini belum siap untuk direview.');
        }

        $oldFile = $review->file_revieu;
        $fileName = $oldFile;

        if ($request->hasFile('file_revieu')) {
            $file = $request->file('file_revieu');
            $fileName = time() . '_revieu_' . $file->getClientOriginalName();

            $filePath = $file->storeAs('upload/books', $fileName, 'public');

                if ($filePath) {
                $newStatus = ($review->status_id == Status::DIKIRIM_AUTHOR) ? Status::DALAM_REVIEW : $review->status_id;

                $review->update([
                    'file_revieu' => $fileName,
                    'reviewer_id' => Auth::id(),
                    'status_id' => $newStatus,
                    'updated_at' => now(),
                    'deadline' => now()->addWeeks(6),
                ]);

                if ($oldFile) {
                    Storage::disk('public')->delete('upload/books/' . $oldFile);
                }

                Histori::create([
                    'user_id' => Auth::id(),
                    'bab_id' => $review->id,
                    'status_id' => $review->status_id,
                    'action' => 'upload_review',
                    'detail' => 'Reviewed chapter "' . $review->nama . '" for book "' . $review->buku->judul . '" by ' . Auth::user()->username,
                ]);

                Notifikasi::create([
                    'user_id' => $review->author_id,
                    'bab_id' => $review->id,
                    'data' => [
                        'chapter' => $review->nama,
                        'book' => $review->buku->judul,
                        'uploaded_by' => Auth::user()->username,
                        'status' => $review->status->option,
                    ],
                ]);

                return redirect()->back()
                    ->with('success', 'Berhasil mengunggah review.');
            } else {
                return redirect()->back()->with('error', 'Gagal mengunggah file review. Silakan coba lagi.');
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

            Notifikasi::create([
                'user_id' => $chapter->author_id,
                'bab_id' => $chapter->id,
                'data' => [
                    'chapter' => $chapter->nama,
                    'book' => $chapter->buku->judul,
                    'status' => 'Reviewer memberikan catatan',
                    'uploaded_by' => Auth::user()->username,
                    'message' => 'Reviewer memberikan catatan pada bab Anda.',
                ],
            ]);

            Histori::create([
                'user_id' => Auth::id(),
                'bab_id' => $chapter->id,
                'status_id' => $chapter->status_id,
                'action' => 'notes',
                'detail' => 'Reviewer menulis catatan untuk bab "' . $chapter->nama . '"',
            ]);
        }

        return redirect()->back()->with('success', 'Catatan berhasil disimpan.');
    }
}

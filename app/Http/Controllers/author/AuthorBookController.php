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
use App\Helpers\StatusHelper;

class AuthorBookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $booksQuery = Buku::whereHas('bab', function ($query) {
            $query->where('author_id', Auth::id());
        });

        if ($search) {
            $books = $booksQuery->where('judul', 'like',  '%' . $search . '%')->paginate(10);
        } else {
            $books = $booksQuery->paginate(10);
        }
        $chapters = Bab::where('author_id', Auth::id())->get();
        $booksWithChaptersCount = $books->map(function ($book) use ($chapters) {
            $filledChaptersCount = $chapters->where('buku_id', $book->id)->whereNotNull('nama')->count();
            $book->filledChaptersCount = $filledChaptersCount;
            return $book;
        });

        return view('pages.author.books.index', compact('books', 'search', 'chapters'));
    }

    public function show($id)
    {
        $buku = Buku::whereHas('bab', function ($query) {
            $query->where('author_id', Auth::id());
        })->findOrFail($id);
        $babs = Bab::with(['author', 'reviewer', 'buku', 'status'])
            ->where('buku_id', $buku->id)
            ->where('author_id', Auth::id())
            ->get();

        return view('pages.author.books.show', compact('buku', 'babs'));
    }

    public function upload(Request $request, $id)
    {
        $request->validate([
            'file_bab' => 'required|file|mimes:doc,docx',
        ]);

        $chapter = Bab::findOrFail($id);

        if ($chapter->author_id !== Auth::id() || !StatusHelper::canBeUploadedByAuthor($chapter->status_id)) {
            return redirect()->back()->with('error', 'Anda hanya bisa mengunggah bab yang ditugaskan kepada Anda atau perlu direvisi.');
        }

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
                    'status_id' => Status::DIKIRIM_AUTHOR,
                    'uploaded_at' => now(),
                ]);

                if ($oldFile) {
                    Storage::disk('public')->delete('upload/books/' . $oldFile);
                }

                Histori::create([
                    'user_id' => Auth::id(),
                    'bab_id' => $chapter->id,
                    'status_id' => Status::DIKIRIM_AUTHOR,
                    'action' => 'upload',
                    'detail' => 'Mengunggah bab "' . $chapter->nama . '" dari buku "' . $chapter->buku->judul . '" oleh ' . Auth::user()->username,
                ]);

                $users = User::where('user_role', 'ADMIN')->get();

                if ($chapter->reviewer_id) {
                    $reviewer = User::find($chapter->reviewer_id);
                    if ($reviewer) {
                        $users->push($reviewer);
                    }
                }

                foreach ($users->filter() as $user) {
                    Notifikasi::create([
                        'user_id' => $user->id,
                        'bab_id' => $chapter->id,
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

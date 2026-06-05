<?php

namespace App\Http\Controllers\author;

use App\Http\Controllers\Controller;
use App\Models\Bab;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorChapterController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $chaptersQuery = Bab::with(['buku', 'status', 'author'])
            ->where(function ($query) {
                $query->where('author_id', Auth::id())
                    ->orWhere(function ($availableQuery) {
                        $availableQuery->whereNull('author_id')
                            ->where('status_id', 2);
                    });
            });

        if ($search) {
            $chapters = $chaptersQuery
                ->where(function ($query) use ($search) {
                    $query->where('nama', 'like', '%' . $search . '%')
                        ->orWhereHas('buku', function ($bookQuery) use ($search) {
                            $bookQuery->where('judul', 'like', '%' . $search . '%');
                        });
                })
                ->paginate(10);
        } else {
            $chapters = $chaptersQuery->paginate(10);
        }

        return view('pages.author.chapters.index', compact('chapters', 'search'));
    }

    public function show($id)
    {
        $bab = Bab::with(['author', 'reviewer', 'buku', 'status'])
            ->where(function ($query) {
                $query->where('author_id', Auth::id())
                    ->orWhere(function ($availableQuery) {
                        $availableQuery->whereNull('author_id')
                            ->where('status_id', 2);
                    });
            })
            ->findOrFail($id);

        return view('pages.author.chapters.show', compact('bab'));
    }

    public function claimed($id)
    {
        $chapter = Bab::with(['author', 'status', 'buku'])->findOrFail($id);

        if ($chapter->author_id || $chapter->status_id !== 2) {
            return redirect()->back()->with('error', 'Bab ini sudah tidak tersedia untuk diklaim.');
        }

        $chapter->update([
            'status_id' => Status::findOrFail(4)->id,
            'author_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Bab berhasil diklaim.');
    }
}

<?php

namespace App\Http\Controllers\reviewer;

use App\Http\Controllers\Controller;
use App\Models\Bab;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewerChapterController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $chaptersQuery = Bab::with(['buku', 'status', 'author'])
            ->where('reviewer_id', Auth::id());

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

        return view('pages.reviewer.chapters.index', compact('chapters', 'search'));
    }

    public function show($id)
    {
        $bab = Bab::with(['author', 'reviewer', 'buku', 'status'])
            ->where('reviewer_id', Auth::id())
            ->findOrFail($id);

        return view('pages.reviewer.chapters.show', compact('bab'));
    }

    public function approve($id)
    {
        $chapter = Bab::with(['author', 'status', 'buku'])->findOrFail($id);

        if ($chapter->reviewer_id !== Auth::id() || !$chapter->author_id || !$chapter->file_bab || !$chapter->file_revieu || $chapter->status_id === 3) {
            return redirect()->back()->with('error', 'Bab ini belum siap untuk disetujui.');
        }

        $chapter->update([
            'status_id' => Status::findOrFail(3)->id,
            'approved_at' => now(),
        ]);
        return redirect()->back()->with('success', 'Bab berhasil disetujui.');
    }
}

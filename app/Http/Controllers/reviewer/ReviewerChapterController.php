<?php

namespace App\Http\Controllers\reviewer;

use App\Http\Controllers\Controller;
use App\Models\Bab;
use App\Models\Histori;
use App\Models\Notifikasi;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\StatusHelper;

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

        if ($chapter->reviewer_id !== Auth::id() || !$chapter->author_id || !$chapter->file_bab || !StatusHelper::canBeApproved($chapter->status_id)) {
            return redirect()->back()->with('error', 'Bab ini belum siap untuk disetujui.');
        }

        if (!$chapter->file_revieu && empty($chapter->catatan)) {
            return redirect()->back()->with('error', 'Silakan unggah file review atau berikan catatan sebelum menyetujui.');
        }

        $chapter->update([
            'status_id' => Status::DISETUJUI,
            'approved_at' => now(),
        ]);

        Histori::create([
            'user_id' => Auth::id(),
            'bab_id' => $chapter->id,
            'status_id' => Status::DISETUJUI,
            'action' => 'approve',
            'detail' => 'Bab "' . $chapter->nama . '" disetujui oleh ' . Auth::user()->username,
        ]);

        Notifikasi::create([
            'user_id' => $chapter->author_id,
            'bab_id' => $chapter->id,
            'data' => [
                'chapter' => $chapter->nama,
                'status' => 'Disetujui',
            ],
        ]);

        return redirect()->back()->with('success', 'Bab berhasil disetujui.');
    }

    public function revisi($id)
    {
        $chapter = Bab::with(['author', 'status', 'buku'])->findOrFail($id);

        if ($chapter->reviewer_id !== Auth::id() || !$chapter->author_id || !$chapter->file_bab || !StatusHelper::canBeMarkedForRevision($chapter->status_id)) {
            return redirect()->back()->with('error', 'Bab ini tidak dapat direvisi.');
        }

        if (!$chapter->file_revieu && empty($chapter->catatan)) {
            return redirect()->back()->with('error', 'Silakan unggah file review atau berikan catatan sebelum meminta revisi.');
        }

        $chapter->update([
            'status_id' => Status::REVISI,
        ]);

        Histori::create([
            'user_id' => Auth::id(),
            'bab_id' => $chapter->id,
            'status_id' => Status::REVISI,
            'action' => 'revisi',
            'detail' => 'Bab "' . $chapter->nama . '" diminta revisi oleh ' . Auth::user()->username,
        ]);

        Notifikasi::create([
            'user_id' => $chapter->author_id,
            'bab_id' => $chapter->id,
            'data' => [
                'chapter' => $chapter->nama,
                'status' => 'Revisi',
            ],
        ]);

        return redirect()->back()->with('success', 'Berhasil meminta revisi bab.');
    }
}

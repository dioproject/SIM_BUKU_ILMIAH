<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Bab;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Helpers\StatusHelper;
use App\Models\Histori;
use App\Models\User;

class ChapterController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $chapters = Bab::where('nama', 'like', '%' . $search . '%')
                ->orWhereHas('buku', function ($query) use ($search) {
                    $query->where('judul', 'like', '%' . $search . '%');
                })
                ->with(['buku', 'status', 'author', 'reviewer'])
                ->paginate(10);
        } else {
            $chapters = Bab::with(['buku', 'status', 'author', 'reviewer'])->paginate(10);
        }
        $chapters->appends(['search' => $search]);

        return view('pages.admin.chapters.index', compact('chapters', 'search'));
    }

    public function show($id)
    {
        $bab = Bab::with(['author', 'reviewer', 'buku', 'status'])->findOrFail($id);
        $authors = User::where('user_role', 'AUTHOR')->orderBy('username')->get();
        $reviewers = User::where('user_role', 'REVIEWER')->orderBy('username')->get();
        return view('pages.admin.chapters.show', compact('bab', 'authors', 'reviewers'));
    }

    public function approve($id)
    {
        $chapter = Bab::with(['buku', 'status'])->findOrFail($id);

        if (!$chapter->status_id || !StatusHelper::canBeApproved($chapter->status_id)) {
            return redirect()->back()->with('error', 'Bab ini belum siap untuk disetujui.');
        }

        if (!$chapter->file_bab) {
            return redirect()->back()->with('error', 'Bab harus memiliki file naskah sebelum disetujui.');
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
            'detail' => Auth::user()->username . ' menyetujui bab "' . $chapter->nama . '" dari buku "' . $chapter->buku->judul . '"',
        ]);

        return redirect()->back()->with('success', 'Bab berhasil disetujui.');
    }

    public function destroy($id)
    {
        $chapter = Bab::with('buku')->findOrFail($id);

        Histori::create([
            'user_id' => Auth::id(),
            'bab_id' => $chapter->id,
            'status_id' => $chapter->status_id,
            'action' => 'delete',
            'detail' => Auth::user()->username . ' menghapus bab "' . $chapter->nama . '" dari buku "' . ($chapter->buku->judul ?? 'N/A') . '"',
        ]);

        $chapter->delete();

        return redirect()->route('admin.index.chapter');
    }
}

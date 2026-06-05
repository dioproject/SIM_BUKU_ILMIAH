<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Bab;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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

        return view('pages.admin.chapters.index', compact('chapters', 'search'));
    }

    public function show($id)
    {
        $bab = Bab::with(['author', 'reviewer', 'buku', 'status'])->findOrFail($id);
        $authors = User::where('user_role', 'AUTHOR')->orderBy('username')->get();
        $reviewers = User::where('user_role', 'REVIEWER')->orderBy('username')->get();
        return view('pages.admin.chapters.show', compact('bab', 'authors', 'reviewers'));
    }

    public function destroy($id)
    {
        $chapter = Bab::findOrFail($id);
        $chapter->delete();

        if ($chapter) {
            Histori::create([
                'detail' => Auth::user()->username . ' menghapus bab "' . $chapter->nama . '" berhasil.',
            ]);
            return redirect()->route('admin.index.chapter');
        }
        return redirect()->route('admin.index.chapter');
    }
}

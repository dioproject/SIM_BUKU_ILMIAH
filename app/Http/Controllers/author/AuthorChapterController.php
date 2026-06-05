<?php

namespace App\Http\Controllers\author;

use App\Http\Controllers\Controller;
use App\Models\Bab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorChapterController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $chaptersQuery = Bab::with(['buku', 'status', 'author'])
            ->where('author_id', Auth::id());

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
            ->where('author_id', Auth::id())
            ->findOrFail($id);

        return view('pages.author.chapters.show', compact('bab'));
    }

}

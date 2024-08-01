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

        if ($search) {
            $chapters = Bab::where('chapter', 'like', '%' . $search . '%')
                ->orWhereHas('book', function ($query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%');
                })
                ->with(['book', 'status'])
                ->paginate(10);
        } else {
            $chapters = Bab::with(['book', 'status'])->paginate(10);
        }

        return view('pages.author.chapters.index', compact('chapters', 'search'));
    }

    public function show($id)
    {
        $bab = Bab::findOrFail($id);
        return view('pages.author.chapters.show', compact('bab'));
    }

    public function claimed($id)
    {
        $chapter = Bab::with(['author', 'status', 'buku'])->findOrFail($id);
        $chapter->update([
            'status_id' => Status::findOrFail(4)->id,
            'author_id' => Auth::id(),
        ]);

        return redirect()->back();
    }
}

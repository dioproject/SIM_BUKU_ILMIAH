<?php

namespace App\Http\Controllers\reviewer;

use App\Http\Controllers\Controller;
use App\Models\Bab;
use App\Models\Status;
use Illuminate\Http\Request;

class ReviewerChapterController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $chapters = Bab::where('nama', 'like', '%' . $search . '%')
                ->orWhereHas('book', function ($query) use ($search) {
                    $query->where('judul', 'like', '%' . $search . '%');
                })
                ->with(['buku', 'status'])
                ->paginate(10);
        } else {
            $chapters = Bab::with(['buku', 'status'])->paginate(10);
        }

        return view('pages.reviewer.chapters.index', compact('chapters', 'search'));
    }

    public function show($id)
    {
        $bab = Bab::findOrFail($id);
        return view('pages.reviewer.chapters.show', compact('bab'));
    }

    public function approve($id)
    {
        $chapter = Bab::with(['author', 'status', 'book'])->findOrFail($id);
        $chapter->update([
            'status_id' => Status::findOrFail(3)->id,
            'approved_at' => now(),
        ]);

        $book = $chapter->book_id;

        return redirect()->route('reviewer.index.chapter', $book);
    }
}

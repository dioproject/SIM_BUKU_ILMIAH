<?php

namespace App\Http\Controllers\reviewer;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Status;
use Illuminate\Http\Request;

class ReviewerChapterController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $chapters = Chapter::where('chapter', 'like', '%' . $search . '%')
                ->orWhereHas('book', function ($query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%');
                })
                ->with(['book', 'status'])
                ->paginate(10);
        } else {
            $chapters = Chapter::with(['book', 'status'])->paginate(10);
        }

        return view('pages.reviewer.chapters.index', compact('chapters', 'search'));
    }

    public function show($id)
    {
        $chapter = Chapter::with(['book', 'status'])->findOrFail($id);
        return view('pages.reviewer.chapters.show', compact('chapter'));
    }

    public function approve($id)
    {
        $chapter = Chapter::with(['author', 'status', 'book'])->findOrFail($id);
        $chapter->update([
            'status_id' => Status::findOrFail(3)->id,
            'approved_at' => now(),
        ]);

        $book = $chapter->book_id;

        return redirect()->route('reviewer.index.chapter', $book);
    }
}

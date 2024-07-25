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
            $chapters = Chapter::where('name', 'like', '%' . $search . '%')->paginate(10);
        } else {
            $chapters = Chapter::with(['book', 'status', 'fileChapter'])->paginate(10);
        }

        return view('pages.reviewer.chapters.index', compact('chapters', 'search'));
    }

    public function show($id)
    {
        $chapter = Chapter::with(['book', 'status'])->findOrFail($id);
        return view('pages.reviewer.chapters.show', compact('chapter'));
    }

    public function submit($id)
    {
        $chapter = Chapter::findOrFail($id);
        $chapter->update([
            'status_id' => Status::findOrFail(2)->id,
        ]);

        return redirect()->route('reviewer.show.chapter', $chapter->book_id);
    }
}

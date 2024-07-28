<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Models\File;
use App\Models\History;

class ChapterController extends Controller
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

        return view('pages.admin.chapters.index', compact('chapters', 'search'));
    }

    public function show($id)
    {
        $chapter = Chapter::findOrFail($id);

        $files = File::where('chapter_id', $chapter->id)->get();
        return view('pages.admin.chapters.show', compact('chapter', 'files'));
    }

    public function destroy($id)
    {
        $category = Chapter::findOrFail($id);
        $category->delete();

        if ($category) {
            History::create([
                'change_detail' => Auth::user()->first_name . ' deleted category ' . $category->name . ' successfully.',
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('admin.index.category');
        }
        return redirect()->route('admin.index.category');
    }
}

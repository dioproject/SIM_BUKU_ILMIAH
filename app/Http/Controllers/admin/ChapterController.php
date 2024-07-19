<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Models\History;
use App\Models\Status;

class ChapterController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $chapters = Chapter::with(['book', 'author'])->paginate(10);

        if ($search) {
            $chapters = Chapter::where('name', 'like', '%' . $search . '%')->paginate(10);
        }

        return view('pages.admin.chapters.index', compact('chapters', 'search'));
    }


    public function create()
    {
        $books = Book::all();
        $chapter = Chapter::all();

        return view('pages.admin.chapters.create', compact('chapter', 'books'));
    }

    public function store(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $validatedData = $request->validate([
            'chapters' => 'required|array',
            'chapters.*' => 'required|string|max:100',
        ]);

        foreach ($validatedData['chapters'] as $chapter) {
            Chapter::create([
                'chapter' => $chapter,
                'book_id' => $book->id,
                'status_id' => Status::findOrFail(1)->id,
            ]);
        }

        return redirect()->route('admin.show.book', $book->id)->with('success', 'Chapters saved successfully!');
    }

    public function show($id)
    {
        $chapter = Chapter::with(['book', 'status'])->findOrFail($id);
        return view('pages.admin.chapters.show', compact('chapter'));
    }

    public function edit($id)
    {
        $category = Chapter::findOrFail($id);

        return view('pages.admin.chapters.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category = Chapter::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'updated_at',
        ]);

        if ($category) {
            History::create([
                'change_detail' => Auth::user()->first_name . ' updated category ' . $category->name . ' successfully.',
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('admin.index.category')->with('success', Auth::user()->first_name . ' updated category ' . $category->name . ' successfully.');
        }
        return redirect()->route('admin.create.category')->with('error', 'Chapter not found.');
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

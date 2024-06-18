<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Manuscript;
use App\Models\History;
use App\Models\Catalog;
use App\Models\Status;
use App\Models\User;
use App\Models\Book;

class CatalogController extends Controller
{
  public function index(Request $request)
{
    $search = $request->input('search');

    $catalogQuery = Catalog::query();
    if ($search) {
        $catalogQuery->whereHas('book.manuscript', function ($query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        })->orWhereHas('book.manuscript.author', function ($query) use ($search) {
            $query->where('first_name', 'like', '%' . $search . '%');
        });
    }

    $catalog = $catalogQuery->paginate(10);
    $author = User::paginate(10);

    return view('pages.admin.catalogs.index', compact('catalog', 'author', 'search'));
}


public function create() {
    $books = Book::with('manuscript')->get();

    return view('pages.admin.catalogs.create', compact('books'));
}

    public function store(Request $request) {
        $request->validate([
            'book_id' => 'required',
            'path_foto' =>  'required|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'required',
        ]);

        if ($request->hasFile('path_foto')) {
            $file = $request->file('path_foto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('upload/catalogs', $fileName, 'public');
        }

        $catalog = Catalog::create([
            'book_id' => $request->book_id,
            'description' => $request->description,
            'path_foto' => $filePath,
            'status_id' => Status::findOrFail(1)->id,
        ]);

        if ($catalog) {
            $book = Book::findOrFail($request->book_id);
            $book->update([
                'status_id' => Status::findOrFail(3)->id,
            ]);

            History::create([
                'change_detail' => Auth::user()->first_name . ' created catalog ' . $book->manuscript->title . ' successfully.',
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('admin.index.catalog')->with('success', Auth::user()->first_name . ' created catalog ' . $book->manuscript->title . ' successfully.');
        }
        return redirect()->route('admin.create.catalog')->with('error', 'Catalog not found.');
    }
}

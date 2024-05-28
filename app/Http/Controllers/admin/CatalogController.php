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
    public function index() {
        $catalog = Catalog::all();
        $bookTitle = Catalog::select('catalogs.*', 'books.*', 'manuscripts.*')
            ->leftJoin('books', 'catalogs.book_id', '=', 'books.id')
            ->join('manuscripts', 'books.manuscript_id', '=', 'manuscripts.id')
            ->get();
        $author = User::select('first_name')->rightJoin('manuscripts', 'users.id', '=', 'manuscripts.author_id')->get();

        return view('pages.admin.catalogs.index', compact('catalog', 'bookTitle', 'author'));
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
                'change_detail' => 'Catalog created successfully.',
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('admin.index.catalog')->with('Success', 'Catalog created successfully.');
        }
        return redirect()->route('admin.create.catalog')->with('Error', 'Catalog not found.');
    }
}

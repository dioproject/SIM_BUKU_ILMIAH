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
        $title = Manuscript::all();

        return view('pages.admin.catalogs.create', compact('title'));
    }

    public function store(Request $request) {
        // dd($request->all());
        $request->validate([
            'title' => 'required',
            'path_foto' =>  'required|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'required',
        ]);

        if ($request->hasFile('path_foto')) {
            $file = $request->file('path_foto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('upload/catalogs', $fileName, 'public');
        }

        $catalog = Catalog::create([
            'book_id' => $request->title,
            'description' => $request->description,
            'path_foto' => $filePath,
            'status_id' => Status::findOrFail(1)->id,
        ]);

        if ($catalog) {
            History::create([
                'change_detail' => 'Catalog created successfully.',
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('admin.index.catalog')->with('Success', 'Catalog created successfully.');
        }
        return redirect()->route('admin.create.catalog')->with('Error', 'Book not found.');
    }

    public function edit($id) {

    }

    public function update(Request $request, $id) {

    }

    public function destroy($id) {

    }
}

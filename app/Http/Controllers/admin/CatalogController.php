<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalog;
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
        $bookTitle = Catalog::select('catalogs.*', 'books.*', 'manuscripts.*')
            ->leftJoin('books', 'catalogs.book_id', '=', 'books.id')
            ->join('manuscripts', 'books.manuscript_id', '=', 'manuscripts.id')
            ->get();

        return view('pages.admin.catalogs.create', compact('bookTitle'));
    }

    public function store() {

    }

    public function edit($id) {

    }

    public function update(Request $request, $id) {

    }

    public function destroy($id) {

    }
}

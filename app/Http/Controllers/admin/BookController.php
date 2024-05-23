<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function index() {
        $books = Book::all();

        return view('pages.admin.books.index', compact('books'));
    }

    public function create() {
        return view('pages.admin.books.create');
    }

    public function store(Request $request) {

    }

    public function destroy($id) {
        $book = Book::findOrFail($id);
        $book->delete();

        if($book) {
            return redirect()->route('admin.index.book')->with('Success', 'Book deleted successfully.');
        } else {
            return redirect()->route('admin.index.book')->with('Error', 'Boook not found.');
        }
    }
}

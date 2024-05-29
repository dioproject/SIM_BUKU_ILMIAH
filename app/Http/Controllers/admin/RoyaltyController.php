<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Manuscript;
use App\Models\Royalty;
use App\Models\Status;
use App\Models\Book;
use App\Models\User;

class RoyaltyController extends Controller
{
    public function index()
    {
        $book = Manuscript::select('title')->rightJoin('books', 'manuscripts.id', '=', 'books.manuscript_id')->get();
        $author = User::select('first_name')->rightJoin('manuscripts', 'users.id', '=', 'manuscripts.author_id')->get();
        $royalty = Royalty::all();
        $status = Status::select('option')->rightJoin('royalties', 'statuses.id', '=', 'royalties.status_id')->get();

        return view('pages.admin.royalty.index', compact('book', 'author', 'royalty', 'status'));
    }

    public function create()
    {
        $manuscripts = Manuscript::with('author')->get();
        $books = Book::with('manuscript')->get();
        $status = Status::all();

        return view('pages.admin.royalty.create', compact('manuscripts', 'books', 'status'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'author_id' => 'required',
            'book_id' =>'required',
            'amount' =>'required',
            'status_id' =>'required',
            'path_foto' =>  'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('path_foto')) {
            $file = $request->file('path_foto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('upload/royalties', $fileName, 'public');
        }

        $royalty = Royalty::create([
            'book_id' => $request->book_id,
            'amount' => $request->amount,
            'path_foto' => $filePath,
            'status_id' => $request->status_id,
            'author_id' => $request->author_id,
        ]);

        if ($royalty) {

            return redirect()->route('admin.index.royalty')->with('Success', 'Royalty created successfully.');
        }
        return redirect()->route('admin.create.royalty')->with('Error', 'Royalty not found.');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}

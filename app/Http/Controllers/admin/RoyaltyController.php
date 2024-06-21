<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Manuscript;
use App\Models\Royalty;
use App\Models\Status;
use App\Models\Book;

class RoyaltyController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
    
        $royaltyQuery = Royalty::query();
        if ($search) {
            $royaltyQuery->whereHas('book.manuscript', function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%');
            })->orWhereHas('book.manuscript.author', function ($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%');
            });
        }
    
        $royalty = $royaltyQuery->with(['book.manuscript', 'status'])->paginate(10);
    
        return view('pages.admin.royalty.index', compact('royalty', 'search'));
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

            return redirect()->route('admin.index.royalty')->with('success', 'Royalty created successfully.');
        }
        return redirect()->route('admin.create.royalty')->with('error', 'Royalty not found.');
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $royalty = Royalty::findOrFail($id);
        $manuscripts = Manuscript::with('author')->get();
        $books = Book::with('manuscript')->get();
        $status = Status::all();

        return view('pages.admin.royalty.edit', compact('royalty', 'manuscripts', 'books', 'status'));
    }

    public function update(Request $request, $id)
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

        $royalty = new Royalty();
        $royalty->update([
            'book_id' => $request->book_id,
            'amount' => $request->amount,
            'path_foto' => $filePath,
            'status_id' => $request->status_id,
            'author_id' => $request->author_id,
        ]);

        if ($royalty) {

            return redirect()->route('admin.index.royalty')->with('success', 'Royalty Updated successfully.');
        }
        return redirect()->route('admin.create.royalty')->with('error', 'Royalty not found.');
    }

    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Catalog;
use App\Models\Chapter;
use App\Models\History;
use App\Models\Royalty;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $catalogs = Catalog::with('book', 'author');

        if ($search) {
            $catalogs->whereHas('book', function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%');
            });
        }

        $catalogs = $catalogs->paginate(10);

        return view('pages.admin.catalogs.index', compact('catalogs', 'search'));
    }

    public function create()
    {
        $books = Book::all();
        return view('pages.admin.catalogs.create', compact('books'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|integer|exists:books,id',
            'cover' => 'required|image|mimes:jpeg,png,jpg',
            'size' => 'required|string|max:100',
            'thickness' => 'required',
            'stock' => 'required',
            'price' => 'required',
        ]);

        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $fileName = time() . '_cover_' . $file->getClientOriginalName();
            $file->storeAs('upload/catalogs', $fileName, 'public');
            $validated['cover'] = $fileName;
        }

        $chapter = Chapter::where('book_id', $validated['book_id'])->first();
        if ($chapter) {
            $validated['author_id'] = $chapter->author_id;
        } else {
            $validated['author_id'] = null;
        }

        $catalog = Catalog::create($validated);

        $royaltyPercentage = 0.15;
        $royaltyAmount = ($catalog->price * $catalog->stock) * $royaltyPercentage;

        if ($catalog->author_id) {
            Royalty::create([
                'catalog_id' => $catalog->id,
                'author_id' => $catalog->author_id,
                'amount' => $royaltyAmount,
                'month' => now()->format('Y-m-d'),
            ]);
        }

        History::create([
            'change_detail' => 'Catalog created with title: ' . $catalog->book->title,
        ]);

        return redirect()->route('admin.index.catalog')->with('success', 'Catalog created successfully.');
    }
}

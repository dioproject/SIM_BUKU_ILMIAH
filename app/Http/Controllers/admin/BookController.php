<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use App\Models\Book;
use App\Models\Status;
use App\Models\Manuscript;
use App\Models\History;
use App\Models\Category;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Book::with(['manuscript', 'manuscript.author', 'status']);

        if ($search) {
            $query->whereHas('manuscript', function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        }

        $books = $query->paginate(10);

        return view('pages.admin.books.index', compact('books', 'search'));
    }

    public function create()
    {
        $category = Category::all();
        return view('pages.admin.books.create', compact('category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'title' => 'required',
            'abstract' => 'required',
            'fill' => 'required',
        ]);

        $manuscript = Manuscript::create([
            'title' => $request->title,
            'abstract' => $request->abstract,
            'fill' => $request->fill,
            'author_id' => Auth::id(),
        ]);

        if ($manuscript) {
            Book::create([
                'category_id' => $request->category,
                'manuscript_id' => $manuscript->id,
                'status_id' => Status::findOrFail(1)->id,
            ]);

            History::create([
                'change_detail' => Auth::user()->first_name . ' created book ' . $manuscript->title . ' successfully.',
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('admin.index.book')->with('success', Auth::user()->first_name . ' created book ' . $manuscript->title . ' successfully.');
        }
        return redirect()->route('admin.create.book')->with('error', 'Book not found.');
    }

    public function show($id)
    {
        $book = Book::with('manuscript')->findOrFail($id);
        $data = [
            'title' => $book->manuscript->title,
            'abstract' => $book->manuscript->abstract,
            'fill' => $book->manuscript->fill,
        ];

        $html = view('pages.print.book', $data)->render();
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        return $dompdf->stream($book->manuscript->title . '.pdf', ["Attachment" => 1]);
    }

    public function edit($id)
    {
        $book = Book::with('manuscript')->findOrFail($id);
        $category = Category::all();
        return view('pages.admin.books.edit', compact('book', 'category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'required',
            'title' => 'required',
            'abstract' => 'required',
            'fill' => 'required',
        ]);

        $book = Book::findOrFail($id);
        $manuscript = $book->manuscript;
        $manuscript->update([
            'title' => $request->title,
            'abstract' => $request->abstract,
            'fill' => $request->fill,
            'author_id' => Auth::id(),
        ]);

        if ($manuscript) {
            $book->update([
                'category_id' => $request->category,
                'manuscript_id' => $manuscript->id,
                'status_id' => Status::findOrFail(1)->id,
                'updated_at' => now(),
            ]);

            History::create([
                'change_detail' => Auth::user()->first_name . ' updated book ' . $manuscript->title . ' successfully.',
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('admin.index.book')->with('success', Auth::user()->first_name . ' updated book ' . $manuscript->title . ' successfully.');
        }
        return redirect()->route('admin.create.book')->with('error', 'Book not found.');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $manuscript = $book->manuscript;
        $manuscript->delete();

        if ($manuscript) {
            $book->delete();

            History::create([
                'change_detail' => Auth::user()->first_name . ' deleted book ' . $manuscript->title . ' successfully.',
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('admin.index.book');
        }
        return redirect()->route('admin.index.book');
    }
}

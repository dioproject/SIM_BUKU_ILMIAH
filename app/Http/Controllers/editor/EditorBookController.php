<?php

namespace App\Http\Controllers\editor;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Dompdf\Dompdf;

class EditorBookController extends Controller
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

        return view('pages.editor.books.index', compact('books', 'search'));
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
}

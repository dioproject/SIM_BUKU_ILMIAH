<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Bab;
use App\Models\Status;
use App\Models\Histori;
use App\Models\Jenis;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $books = Buku::query();

        if ($search) {
            $books = Buku::where('judul', 'like', '%' . $search . '%')->paginate(10);
        } else {
            $books = Buku::paginate(10);
        }

        return view('pages.admin.books.index', compact('books', 'search'));
    }

    public function create()
    {
        $jenis = Jenis::all();
        return view('pages.admin.books.create', compact('jenis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_id' => 'required|exists:jenis,id',
            'judul' => 'required|string|max:250',
            'total_bab' => 'required|integer|min:1',
            'template' => 'required|file|mimes:doc,docx',
        ]);

        if ($request->hasFile('template')) {
            $file = $request->file('template');
            $fileName = time() . '_template_' . $file->getClientOriginalName();
            $file->storeAs('upload/books', $fileName, 'public');
        }

        $book = Buku::create([
            'judul' => $request->judul,
            'template' => $fileName,
            'total_bab' => $request->total_bab,
            'jenis_id' => $request->jenis_id,
        ]);

        if ($book) {
            Histori::create([
                'detail' => Auth::user()->username . ' tambah buku ' . $book->judul,
            ]);
            return redirect()->route('admin.index.book')->with('success', Auth::user()->username . ' tambah buku ' . $book->judul . ' sukses.');
        }

        return redirect()->route('admin.create.book');
    }

    public function storeChapter(Request $request, $id)
    {
        $book = Buku::findOrFail($id);

        $validatedData = $request->validate([
            'bab' => 'required|array',
            'bab.*' => 'required|string|max:100',
        ]);

        foreach ($validatedData['bab'] as $bab) {
            $newChapter = Bab::create([
                'nama' => $bab,
                'buku_id' => $book->id,
                'status_id' => Status::findOrFail(2)->id,
            ]);

            Histori::create([
                'detail' => 'Tambah bab "' . $newChapter->chapter . '" dari buku "' . $book->judul . '" oleh ' . Auth::user()->username,
            ]);
        }

        return redirect()->route('admin.show.book', $book->id)->with('success', 'Berhasil menyimpan bab.');
    }

    public function show($id)
    {
        $buku = Buku::findOrFail($id);
        $babs = Bab::with(['author', 'buku', 'status'])->where('buku_id', $buku->id)->get();

        return view('pages.admin.books.show', compact('buku', 'babs'));
    }

    public function mergeChapters($id)
    {
        $book = Buku::findOrFail($id);

        // Ambil semua chapter dengan status 'approved' dari buku
        $chapters = Bab::where('book_id', $book->id)
            ->where('status_id', 3) // Sesuaikan dengan field dan value yang tepat
            ->orderBy('created_at')
            ->get();

        // Buat objek PhpWord baru untuk dokumen yang digabung
        $phpWord = new PhpWord();

        foreach ($chapters as $chapter) {
            // Asumsikan bahwa field 'file_chapter' menyimpan path dokumen chapter
            $chapterPath = storage_path('app/public/upload/books/' . $chapter->file_chapter);

            if (file_exists($chapterPath)) {
                $this->addContentFromDocx($phpWord, $chapterPath);
            }
        }

        // Simpan dokumen yang digabungkan ke file sementara
        $mergedFilePath = storage_path('app/public/merged_book_' . $book->judul . '.docx');
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($mergedFilePath);

        // Unduh file gabungan
        return response()->download($mergedFilePath, 'Merged_Book_' . $book->judul . '.docx');
    }

    private function addContentFromDocx($phpWord, $filePath)
    {
        $source = IOFactory::load($filePath);

        foreach ($source->getSections() as $section) {
            $newSection = $phpWord->addSection();
            foreach ($section->getElements() as $element) {
                $this->copyElement($newSection, $element);
            }
        }
    }

    private function copyElement($newSection, $element)
    {
        $type = get_class($element);

        switch ($type) {
            case 'PhpOffice\PhpWord\Element\TextRun':
                $textRun = $newSection->addTextRun($element->getParagraphStyle());
                foreach ($element->getElements() as $childElement) {
                    if (method_exists($childElement, 'getText')) {
                        $textRun->addText($childElement->getText(), $childElement->getFontStyle(), $childElement->getParagraphStyle());
                    }
                }
                break;
            case 'PhpOffice\PhpWord\Element\Text':
                $newSection->addText($element->getText(), $element->getFontStyle(), $element->getParagraphStyle());
                break;
            case 'PhpOffice\PhpWord\Element\Title':
                $newSection->addTitle($element->getText(), $element->getDepth());
                break;
            case 'PhpOffice\PhpWord\Element\Image':
                $newSection->addImage($element->getSource(), $element->getStyle());
                break;
            case 'PhpOffice\PhpWord\Element\Link':
                $newSection->addLink($element->getSource(), $element->getText(), $element->getFontStyle(), $element->getParagraphStyle());
                break;
            case 'PhpOffice\PhpWord\Element\Table':
                $newTable = $newSection->addTable($element->getStyle());
                foreach ($element->getRows() as $row) {
                    $tableRow = $newTable->addRow();
                    foreach ($row->getCells() as $cell) {
                        $tableCell = $tableRow->addCell();
                        foreach ($cell->getElements() as $cellElement) {
                            $this->copyElement($tableCell, $cellElement);
                        }
                    }
                }
                break;
            default:
                // Handle other element types as needed
                break;
        }
    }
}

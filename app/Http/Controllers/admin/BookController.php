<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Bab;
use App\Models\Finalisasi;
use App\Models\Status;
use App\Models\Histori;
use App\Models\Jenis;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use App\Helpers\StatusHelper;

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
        $books->appends(['search' => $search]);

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
                'user_id' => Auth::id(),
                'action' => 'create_book',
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
                'status_id' => Status::DRAFT,
            ]);

            Histori::create([
                'user_id' => Auth::id(),
                'bab_id' => $newChapter->id,
                'status_id' => Status::DRAFT,
                'action' => 'create_chapter',
                'detail' => 'Tambah bab "' . $newChapter->nama . '" dari buku "' . $book->judul . '" oleh ' . Auth::user()->username,
            ]);
        }

        return redirect()->route('admin.show.book', $book->id)->with('success', 'Berhasil menyimpan bab.');
    }

    public function show(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);
        $chapterSearch = $request->input('chapter_search');
        $chapterStats = Bab::where('buku_id', $buku->id);
        $currentBabCount = (clone $chapterStats)->count();
        $assignedCount = (clone $chapterStats)->whereNotNull('author_id')->count();
        $approvedCount = (clone $chapterStats)->where('status_id', Status::DISETUJUI)->count();
        $babs = Bab::with(['author', 'reviewer', 'buku', 'status'])
            ->where('buku_id', $buku->id)
            ->when($chapterSearch, function ($query) use ($chapterSearch) {
                $query->where(function ($subQuery) use ($chapterSearch) {
                    $subQuery->where('nama', 'like', '%' . $chapterSearch . '%')
                        ->orWhereHas('author', function ($authorQuery) use ($chapterSearch) {
                            $authorQuery->where('username', 'like', '%' . $chapterSearch . '%')
                                ->orWhere('name', 'like', '%' . $chapterSearch . '%');
                        })
                        ->orWhereHas('reviewer', function ($reviewerQuery) use ($chapterSearch) {
                            $reviewerQuery->where('username', 'like', '%' . $chapterSearch . '%')
                                ->orWhere('name', 'like', '%' . $chapterSearch . '%');
                        })
                        ->orWhereHas('status', function ($statusQuery) use ($chapterSearch) {
                            $statusQuery->where('option', 'like', '%' . $chapterSearch . '%');
                        });
                });
            })
            ->paginate(10)
            ->appends(['chapter_search' => $chapterSearch]);
        $authors = User::where('user_role', 'AUTHOR')->orderBy('username')->get();
        $reviewers = User::where('user_role', 'REVIEWER')->orderBy('username')->get();

        return view('pages.admin.books.show', compact('buku', 'babs', 'authors', 'reviewers', 'chapterSearch', 'currentBabCount', 'assignedCount', 'approvedCount'));
    }

    public function assignChapter(Request $request, $id)
    {
        $request->validate([
            'author_id' => 'required|exists:users,id',
            'reviewer_id' => 'nullable|exists:users,id',
        ]);

        $chapter = Bab::with(['buku'])->findOrFail($id);
        
        // Validate chapter can be assigned
        if (!StatusHelper::canBeAssigned($chapter->status_id)) {
            $message = 'Bab ini tidak dapat ditugaskan karena statusnya tidak sesuai.';
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }
            return redirect()->back()->with('error', $message);
        }
        
        $author = User::where('user_role', 'AUTHOR')->findOrFail($request->author_id);
        $reviewerId = null;

        if ($request->filled('reviewer_id')) {
            $reviewer = User::where('user_role', 'REVIEWER')->findOrFail($request->reviewer_id);
            $reviewerId = $reviewer->id;
        }

        $chapter->update([
            'author_id' => $author->id,
            'reviewer_id' => $reviewerId,
            'status_id' => Status::DITUGASKAN,
        ]);

        Histori::create([
            'user_id' => Auth::id(),
            'bab_id' => $chapter->id,
            'status_id' => Status::DITUGASKAN,
            'action' => 'assign',
            'detail' => Auth::user()->username . ' menugaskan bab "' . $chapter->nama . '" kepada ' . $author->username,
        ]);

        Notifikasi::create([
            'user_id' => $author->id,
            'bab_id' => $chapter->id,
            'data' => [
                'chapter' => $chapter->nama,
                'book' => $chapter->buku->judul,
                'message' => 'Anda ditugaskan sebagai penulis bab.',
            ],
        ]);

        if ($reviewerId) {
            Notifikasi::create([
                'user_id' => $reviewerId,
                'bab_id' => $chapter->id,
                'data' => [
                    'chapter' => $chapter->nama,
                    'book' => $chapter->buku->judul,
                    'message' => 'Anda ditugaskan sebagai reviewer bab.',
                ],
            ]);
        }

        $message = 'Penugasan bab berhasil diperbarui.';
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => $message]);
        }
        return redirect()->back()->with('success', $message);
    }

    public function mergeBab($id)
    {
        $book = Buku::findOrFail($id);

        $chapters = Bab::where('buku_id', $book->id)
            ->where('status_id', Status::DISETUJUI)
            ->orderBy('created_at')
            ->get();

        if ($chapters->count() < $book->total_bab) {
            return redirect()->back()->with('error', 'Tidak dapat menggabungkan buku. Semua bab (' . $book->total_bab . ' bab) harus disetujui terlebih dahulu.');
        }

        // Validate all chapters are approved using StatusHelper
        $chapterStatuses = $chapters->pluck('status_id')->toArray();
        if (!StatusHelper::canBeMerged($chapterStatuses)) {
            return redirect()->back()->with('error', 'Tidak dapat menggabungkan buku. Semua bab harus dalam status Disetujui.');
        }

        // Buat objek PhpWord baru untuk dokumen yang digabung
        $phpWord = new PhpWord();

        foreach ($chapters as $chapter) {
            // Asumsikan bahwa field 'file_bab' menyimpan path dokumen chapter
            $chapterPath = storage_path('app/public/upload/books/' . $chapter->file_bab);

            if (file_exists($chapterPath)) {
                $this->addContentFromDocx($phpWord, $chapterPath);
            }
        }

        // Tentukan direktori dan nama file
        $directory = storage_path('app/public/upload/merge');
        $mergedFileName = 'merged_book_' . $book->judul . '_' . time() . '.docx';
        $mergedFilePath = $directory . '/' . $mergedFileName;

        // Pastikan direktori ada
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        // Simpan dokumen yang digabungkan ke file sementara
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($mergedFilePath);

        // Gunakan updateOrCreate untuk menyimpan nama file ke kolom 'merge' pada tabel 'finalisasi'
        Finalisasi::updateOrCreate(
            ['buku_id' => $book->id], // Kondisi untuk mencari entri yang ada
            ['merge' => $mergedFileName] // Data yang akan diperbarui atau dibuat
        );

        return redirect()->back()->with('success', 'Dokumen berhasil digabung dan disimpan.');
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

    public function destroy($id)
    {
        $book = Buku::findOrFail($id);

        // Menghapus file template
        $templatePath = 'public/upload/books/' . $book->template;
        if (Storage::exists($templatePath)) {
            if (!Storage::delete($templatePath)) {
                Log::error("Gagal menghapus file template: $templatePath");
            }
        } else {
            Log::info("File template tidak ditemukan: $templatePath");
        }

        // Menghapus bab dan file terkait
        $chapters = Bab::where('buku_id', $book->id)->get();
        foreach ($chapters as $chapter) {
            $chapterPath = 'public/upload/books/' . $chapter->file_bab;
            if (Storage::exists($chapterPath)) {
                if (!Storage::delete($chapterPath)) {
                    Log::error("Gagal menghapus file bab: $chapterPath");
                }
            } else {
                Log::info("File bab tidak ditemukan: $chapterPath");
            }

            $reviewPath = 'public/upload/books/' . $chapter->file_revieu;
            if (Storage::exists($reviewPath)) {
                if (!Storage::delete($reviewPath)) {
                    Log::error("Gagal menghapus file review: $reviewPath");
                }
            } else {
                Log::info("File review tidak ditemukan: $reviewPath");
            }

            $chapter->delete();
        }

        $book->delete();

        return redirect()->route('admin.index.book')->with('success', 'Buku dan bab-bab yang berelasi berhasil dihapus.');
    }
}

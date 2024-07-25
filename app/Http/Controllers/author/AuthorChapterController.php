<?php

namespace App\Http\Controllers\author;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorChapterController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $chapters = Chapter::where('chapter', 'like', '%' . $search . '%')
                ->orWhereHas('book', function ($query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%');
                })
                ->with(['book', 'status'])
                ->paginate(10);
        } else {
            $chapters = Chapter::with(['book', 'status'])->paginate(10);
        }

        return view('pages.author.chapters.index', compact('chapters', 'search'));
    }

    public function show($id)
    {
        $chapter = Chapter::with(['book', 'status'])->findOrFail($id);
        $files = File::where('chapter_id', $chapter->id)->get();
        return view('pages.author.chapters.show', compact('chapter', 'files'));
    }

    public function upload(Request $request, $id)
    {
        $request->validate([
            'file_chapter' => 'required|file|mimes:doc,docx',
        ]);

        $fileRecord = File::findOrFail($id);

        if ($request->hasFile('file_chapter')) {
            $uploadedFile = $request->file('file_chapter');
            $fileName = time() . '_chapter_' . $uploadedFile->getClientOriginalName();
            $filePath = $uploadedFile->storeAs('upload/books', $fileName, 'public');

            if ($filePath) {
                $fileRecord->update([
                    'name' => $fileName,
                    'chapter_id' => $fileRecord->chapter_id,
                    'user_id' => Auth::id(),
                    'uploaded_at' => now(),
                ]);

                return redirect()->route('author.show.chapter', $fileRecord->chapter_id)
                    ->with('success', 'File uploaded successfully.');
            } else {
                return redirect()->route('author.show.chapter', $fileRecord->chapter_id)
                    ->with('error', 'File upload failed. Please try again.');
            }
        }

        return redirect()->route('author.show.chapter', $fileRecord->chapter_id)
            ->with('error', 'No file was uploaded.');
    }
}

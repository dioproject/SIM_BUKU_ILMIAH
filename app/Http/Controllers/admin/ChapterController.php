<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Bab;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Histori;

class ChapterController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $chapters = Bab::where('nama', 'like', '%' . $search . '%')
                ->orWhereHas('buku', function ($query) use ($search) {
                    $query->where('judul', 'like', '%' . $search . '%');
                })
                ->with(['buku', 'status'])
                ->paginate(10);
        } else {
            $chapters = Bab::with(['buku', 'status'])->paginate(10);
        }

        return view('pages.admin.chapters.index', compact('chapters', 'search'));
    }

    public function show($id)
    {
        $bab = Bab::findOrFail($id);
        return view('pages.admin.chapters.show', compact('bab'));
    }

    public function destroy($id)
    {
        $category = Bab::findOrFail($id);
        $category->delete();

        if ($category) {
            Histori::create([
                'change_detail' => Auth::user()->first_name . ' deleted category ' . $category->name . ' successfully.',
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('admin.index.category');
        }
        return redirect()->route('admin.index.category');
    }
}

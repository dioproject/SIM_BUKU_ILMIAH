<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Katalog;
use App\Models\Finalisasi;
use App\Models\Status;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $catalogs = Katalog::with('final.buku')->whereHas('final.buku', function ($query) use ($search) {
                $query->where('judul', 'like', '%' . $search . '%');
            })->paginate(10);
        } else {            
            $catalogs = Katalog::with('final.buku')->paginate(10);
        }

        return view('pages.admin.catalogs.index', compact('catalogs', 'search'));
    }

    public function store(Request $request)
    {
        $final = Finalisasi::with('buku')->findOrFail($request->final_id);
        
        // Validasi: buku harus sudah finalisasi
        if ($final->buku->status_id != Status::FINALISASI && $final->buku->status_id != Status::TERBIT) {
            return back()->withErrors(['final_id' => 'Buku harus sudah finalisasi sebelum masuk katalog.']);
        }

        // Validasi: data final harus lengkap
        if (empty($final->isbn) || empty($final->cover) || empty($final->final_file)) {
            return back()->withErrors(['final_id' => 'Data final belum lengkap. ISBN, cover, dan file final PDF wajib diisi.']);
        }

        // Validasi: field katalog wajib
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string',
            'isbn' => 'required|string|max:30',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $validated['final_id'] = $final->id;
        $validated['cover'] = $final->cover;
        $validated['status_publish'] = true;

        Katalog::create($validated);

        return redirect()->route('admin.index.catalog')->with('success', 'Buku berhasil masuk katalog.');
    }
}

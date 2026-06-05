<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Bab;
use App\Models\Buku;
use App\Models\Produksi;
use App\Models\Royalti;
use App\Models\Status;
use Illuminate\Http\Request;

class RoyaltyController extends Controller
{
    public function index()
    {
        $royalties = Royalti::with(['penerbitan.final.buku', 'user', 'bab'])->paginate(10);

        return view('pages.admin.royalty.index', compact('royalties'));
    }

    public function create()
    {
        // Hanya tampilkan produksi yang sudah ada
        $produksi = Produksi::with(['final.buku'])->get();
        
        // Ambil semua author yang punya bab di buku terkait
        $authors = [];
        foreach ($produksi as $p) {
            $buku = $p->final->buku;
            if ($buku) {
                $babs = Bab::where('buku_id', $buku->id)
                    ->where('author_id', '!=', null)
                    ->with('author')
                    ->get();
                foreach ($babs as $bab) {
                    if ($bab->author && !isset($authors[$bab->author->id])) {
                        $authors[$bab->author->id] = $bab->author;
                    }
                }
            }
        }

        return view('pages.admin.royalty.create', compact('produksi', 'authors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'produksi_id' => 'required|exists:produksis,id',
            'user_id' => 'required|exists:users,id',
            'bab_id' => 'required|exists:babs,id',
            'persentase' => 'required|numeric|min:0|max:100',
        ]);

        // Validasi: produksi harus ada
        $produksi = Produksi::findOrFail($validated['produksi_id']);
        
        // Validasi: bab harus ada di buku yang sama dengan produksi
        $bab = Bab::findOrFail($validated['bab_id']);
        if ($bab->buku_id != $produksi->final->buku->id) {
            return back()->withErrors(['bab_id' => 'Bab tidak terkait dengan buku yang diproduksi.']);
        }

        // Validasi: author bab harus sesuai dengan user_id
        if ($bab->author_id != $validated['user_id']) {
            return back()->withErrors(['user_id' => 'User bukan author dari bab yang dipilih.']);
        }

        $total_royalti = ($produksi->harga_jual - $produksi->biaya_produksi) * $produksi->eksemplar * ($validated['persentase'] / 100);
        
        // Hitung royalti berdasarkan jumlah bab yang ditulis author
        $totalBab = Bab::where('buku_id', $bab->buku_id)->count();
        $royalti_per_bab = $total_royalti / $totalBab;

        Royalti::create([
            'produksi_id' => $validated['produksi_id'],
            'user_id' => $validated['user_id'],
            'bab_id' => $validated['bab_id'],
            'persentase' => $validated['persentase'],
            'total_royalti' => $total_royalti,
            'royalti_bab' => $royalti_per_bab,
        ]);

        return redirect()->route('admin.index.royalty')->with('success', 'Royalti berhasil ditambahkan.');
    }
}

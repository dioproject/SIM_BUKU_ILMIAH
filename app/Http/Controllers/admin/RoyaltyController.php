<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Produksi;
use App\Models\Royalti;
use Illuminate\Http\Request;

class RoyaltyController extends Controller
{
    public function index()
    {
        $royalties = Royalti::paginate(10);

        return view('pages.admin.royalty.index', compact('royalties'));
    }

    public function create()
    {
        $produksi = Produksi::with(['final.buku'])->get();
        return view('pages.admin.royalty.create', compact('produksi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produksi_id' => 'required|exists:produksis,id',
            'persentase' => 'required|numeric|min:0|max:100',
        ]);

        $produksi = Produksi::findOrFail($request->produksi_id);
        $buku = $produksi->final->buku;

        $total_royalti = ($produksi->harga_jual - $produksi->biaya_produksi) * $produksi->eksemplar * ($request->persentase / 100);
        $royalti_bab = $total_royalti / $buku->total_bab;

        Royalti::create([
            'produksi_id' => $request->produksi_id,
            'persentase' => $request->persentase,
            'total_royalti' => $total_royalti,
            'royalti_bab' => $royalti_bab,
        ]);

        return redirect()->route('admin.index.royalty')->with('success', 'Royalti berhasil ditambahkan.');
    }
}

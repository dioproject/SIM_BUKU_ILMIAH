<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Finalisasi;
use App\Models\Produksi;
use Illuminate\Http\Request;

class ProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produksis = Produksi::paginate(10);
        return view('pages.admin.produksi.index', compact('produksis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Hanya tampilkan buku yang data finalnya sudah lengkap.
        $finalisasis = Finalisasi::with(['buku'])
            ->whereNotNull('isbn')
            ->whereNotNull('cover')
            ->whereNotNull('final_file')
            ->get();

        return view('pages.admin.produksi.create', compact('finalisasis'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $validated = $request->validate([
            'final_id' => 'required|exists:finalisasis,id',
            'eksemplar' => 'required|integer|min:1',
            'biaya_produksi' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
        ]);

        // Validasi: data final harus lengkap sebelum masuk produksi.
        $final = Finalisasi::with('buku')->findOrFail($validated['final_id']);
        if (empty($final->isbn) || empty($final->cover) || empty($final->final_file)) {
            return back()->withErrors(['final_id' => 'Data final belum lengkap. ISBN, cover, dan file final PDF wajib diisi sebelum produksi.']);
        }

        // Buat entri baru di tabel produksi
        Produksi::create($validated);

        return redirect()->route('admin.index.produksi')->with('success', 'Produksi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

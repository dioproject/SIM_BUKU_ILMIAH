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
        $finalisasis = Finalisasi::with(['buku'])->get();

        // dd($finalisasis);

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
        $request->validate([
            'final_id' => 'required|exists:finalisasis,id',
            'eksemplar' => 'required|integer',
            'biaya_produksi' => 'required|numeric',
            'keuntungan' => 'required|numeric',
        ]);

        // Buat entri baru di tabel produksi
        Produksi::create([
            'final_id' => $request->final_id,
            'eksemplar' => $request->eksemplar,
            'biaya_produksi' => $request->biaya_produksi,
            'keuntungan' => $request->keuntungan,
        ]);

        // Redirect kembali ke halaman daftar produksi dengan pesan sukses
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

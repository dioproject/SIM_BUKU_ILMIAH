<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Finalisasi;
use App\Models\Katalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FinalisasiController extends Controller
{
    public function index()
    {
        $finalisasis = Finalisasi::paginate(10);
        return view('pages.admin.finalisasi.index', compact('finalisasis'));
    }

    public function edit($id)
    {
        $finalisasi = Finalisasi::findOrFail($id);

        return view('pages.admin.finalisasi.edit', compact('finalisasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'isbn' => 'required|string|max:13',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'final_file' => 'nullable|file|mimes:pdf|max:10000',
        ]);

        $finalisasi = Finalisasi::findOrFail($id);

        $data = $request->only('isbn');

        if ($request->hasFile('cover')) {
            // Delete old cover if exists
            if ($finalisasi->cover) {
                Storage::disk('public')->delete('upload/covers/' . $finalisasi->cover);
            }

            $cover = $request->file('cover');
            $coverName = time() . '_cover_' . $cover->getClientOriginalName();
            $cover->storeAs('upload/covers', $coverName, 'public');
            $data['cover'] = $coverName;
        }

        if ($request->hasFile('final_file')) {
            // Delete old final file if exists
            if ($finalisasi->final_file) {
                Storage::disk('public')->delete('upload/finals/' . $finalisasi->final_file);
            }

            $finalFile = $request->file('final_file');
            $finalFileName = time() . '_final_' . $finalFile->getClientOriginalName();
            $finalFile->storeAs('upload/finals', $finalFileName, 'public');
            $data['final_file'] = $finalFileName;
        }

        $finalisasi->update($data);

        if ($finalisasi) {
            Katalog::create([
                'final_id' => $finalisasi->id,
            ]);
        }

        return redirect()->route('admin.index.finalisasi')->with('success', 'Finalisasi berhasil diperbarui.');
    }
}

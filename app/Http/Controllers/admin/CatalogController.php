<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Katalog;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $catalogs =  Katalog::with('final.buku')->whereHas('final.buku', function ($query) use ($search) {
                $query->where('judul', 'like', '%' . $search . '%');
            })->paginate(10);
        } else {            
            $catalogs = Katalog::with('final.buku')->paginate(10);
        }

        return view('pages.admin.catalogs.index', compact('catalogs', 'search'));
    }
}

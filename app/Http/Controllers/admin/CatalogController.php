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
        $catalogs = Katalog::with('final');

        if ($search) {
            $catalogs->whereHas('final', function ($query) use ($search) {
                $query->where('judul', 'like', '%' . $search . '%');
            });
        } else {            
            $catalogs->paginate(10);
        }

        return view('pages.admin.catalogs.index', compact('catalogs', 'search'));
    }
}

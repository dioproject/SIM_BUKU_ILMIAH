<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Royalty;

class RoyaltyController extends Controller
{
    public function index()
    {
        // Ambil semua data royalty dari database
        $royalties = Royalty::with('catalog.book')->get();

        return view('pages.admin.royalty.index', compact('royalties'));
    }
}

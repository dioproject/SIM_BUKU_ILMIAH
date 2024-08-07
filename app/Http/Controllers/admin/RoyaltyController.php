<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Royalti;

class RoyaltyController extends Controller
{
    public function index()
    {
        // Ambil semua data royalty dari database
        $royalties = Royalti::paginate(10);

        return view('pages.admin.royalty.index', compact('royalties'));
    }
}

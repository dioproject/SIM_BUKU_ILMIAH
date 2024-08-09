<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Royalti;

class RoyaltyController extends Controller
{
    public function index()
    {
        $royalties = Royalti::paginate(10);

        return view('pages.admin.royalty.index', compact('royalties'));
    }

    public function create()
    {
        return view('pages.admin.royalty.create');
    }
}

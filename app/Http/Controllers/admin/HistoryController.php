<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Histori;

class HistoryController extends Controller
{
    public function index() {
        $history = Histori::paginate(10);

        return view('pages.admin.history.index', compact('history'));
    }
}

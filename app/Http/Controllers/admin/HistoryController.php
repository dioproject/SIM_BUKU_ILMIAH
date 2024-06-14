<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\History;

class HistoryController extends Controller
{
    public function index() {
        $history = History::all();

        return view('pages.admin.history.index', compact('history'));
    }
}

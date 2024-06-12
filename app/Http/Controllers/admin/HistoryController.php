<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\User;

class HistoryController extends Controller
{
    public function index() {
        $history = History::all();

        return view('pages.admin.history.index', compact('history'));
    }
}

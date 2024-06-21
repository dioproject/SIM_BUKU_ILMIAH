<?php

namespace App\Http\Controllers\editor;

use App\Http\Controllers\Controller;
use App\Models\History;

class EditorHistoryController extends Controller
{
    public function index() {
        $history = History::paginate(10);

        return view('pages.editor.history.index', compact('history'));
    }
}

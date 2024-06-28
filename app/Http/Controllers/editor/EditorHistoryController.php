<?php

namespace App\Http\Controllers\editor;

use App\Http\Controllers\Controller;
use App\Models\History;
use Illuminate\Support\Facades\Auth;

class EditorHistoryController extends Controller
{
    public function index() {
        $history = History::where('user_id', Auth::id())->paginate(10);

        return view('pages.editor.history.index', compact('history'));
    }
}

<?php

namespace App\Http\Controllers\reviewer;

use App\Http\Controllers\Controller;
use App\Models\History;
use Illuminate\Support\Facades\Auth;

class ReviewerHistoryController extends Controller
{
    public function index() {
        $history = History::where('user_id', Auth::id())->paginate(10);

        return view('pages.editor.history.index', compact('history'));
    }
}

<?php

namespace App\Http\Controllers\reviewer;

use App\Http\Controllers\Controller;
use App\Models\Histori;
use Illuminate\Support\Facades\Auth;

class ReviewerHistoryController extends Controller
{
    public function index() {
        $history = Histori::paginate(10);

        return view('pages.reviewer.history.index', compact('history'));
    }
}

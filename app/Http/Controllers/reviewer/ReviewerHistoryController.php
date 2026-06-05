<?php

namespace App\Http\Controllers\reviewer;

use App\Http\Controllers\Controller;
use App\Models\Histori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewerHistoryController extends Controller
{
    public function index(Request $request) {
        $search = $request->input('search');

        $history = Histori::where('user_id', Auth::id())
            ->latest()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($searchQuery) use ($search) {
                    $searchQuery->where('detail', 'like', '%' . $search . '%')
                        ->orWhere('action', 'like', '%' . $search . '%');
                });
            })
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('pages.reviewer.history.index', compact('history', 'search'));
    }
}

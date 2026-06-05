<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Histori;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request) {
        $search = $request->input('search');

        $history = Histori::latest()
            ->when($search, function ($query) use ($search) {
                $query->where('detail', 'like', '%' . $search . '%')
                    ->orWhere('action', 'like', '%' . $search . '%');
            })
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('pages.admin.history.index', compact('history', 'search'));
    }
}

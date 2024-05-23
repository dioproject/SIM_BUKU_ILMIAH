<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\History;
use App\Models\User;

class HistoryController extends Controller
{
    public function index() {
        $history = History::all();
        $name = User::select('first_name')->rightJoin('histories', 'users.id', '=', 'histories.user_id')->get();

        return view('pages.admin.history.index', compact('history', 'name'));
    }
}

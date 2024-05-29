<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\History;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = History::orderBy('created_at', 'desc')->take(5)->get();

        return view('components.admin.header', compact('notifications'));
    }
}

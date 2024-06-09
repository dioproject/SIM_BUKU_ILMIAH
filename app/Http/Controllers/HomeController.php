<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function adminPage()
    {
        return view('pages.admin.dashboard.index');
    }
    public function editorPage()
    {
        return view('pages.editor.dashboard.index');
    }
    public function authorPage()
    {
        return view('pages.author.dashboard.index');
    }
}

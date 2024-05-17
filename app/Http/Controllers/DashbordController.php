<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashbordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function adminPage()
    {
        return view('pages.admin.dashboard');
    }
    public function editorPage()
    {
        return view('pages.editor.dashboard');
    }
    public function authorPage()
    {
        return view('pages.author.dashboard');
    }
}

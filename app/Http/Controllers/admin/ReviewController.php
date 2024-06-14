<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    public function index()
    {
        return view('pages.admin.reviews.index');
    }
}

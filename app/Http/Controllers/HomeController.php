<?php

namespace App\Http\Controllers;

use App\Models\Bab;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function adminPage()
    {
        $statistics = Bab::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->get()
            ->toArray();

        $recentActivities = Bab::with('author')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('pages.admin.dashboard.index', compact('statistics', 'recentActivities'));
    }
    public function reviewerPage()
    {
        $statistics = Bab::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->get()
            ->toArray();

        $recentActivities = Bab::with('author')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        return view('pages.reviewer.dashboard.index', compact('statistics', 'recentActivities'));
    }
    public function authorPage()
    {
        $statistics = Bab::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->get()
            ->toArray();

        $recentActivities = Bab::with('author')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        return view('pages.author.dashboard.index', compact('statistics', 'recentActivities'));
    }
}

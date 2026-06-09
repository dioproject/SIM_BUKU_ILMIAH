<?php

namespace App\Http\Controllers;

use App\Models\Bab;
use App\Models\Buku;
use App\Models\User;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function adminPage()
    {
        $totalBooks = Buku::count();
        $totalAuthors = User::where('user_role', 'AUTHOR')->count();
        $totalReviewers = User::where('user_role', 'REVIEWER')->count();
        $totalUsers = User::count();
        $totalChapters = Bab::count();
        $chaptersByStatus = Bab::select('status_id', DB::raw('COUNT(*) as count'))
            ->groupBy('status_id')
            ->with('status')
            ->get();
        $chaptersNeedingReview = Bab::where('status_id', Status::DIKIRIM_AUTHOR)->count();
        $approvedChapters = Bab::where('status_id', Status::DISETUJUI)->count();

        $statistics = Bab::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->get()
            ->toArray();

        $recentActivities = Bab::with(['author', 'status'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('pages.admin.dashboard.index', compact(
            'statistics', 'recentActivities',
            'totalBooks', 'totalAuthors', 'totalReviewers', 'totalUsers',
            'totalChapters', 'chaptersByStatus', 'chaptersNeedingReview', 'approvedChapters'
        ));
    }

    public function reviewerPage()
    {
        $userId = Auth::id();
        $assignedChapters = Bab::where('reviewer_id', $userId)->count();
        $needsReview = Bab::where('reviewer_id', $userId)
            ->where('status_id', Status::DIKIRIM_AUTHOR)
            ->count();
        $inReview = Bab::where('reviewer_id', $userId)
            ->where('status_id', Status::DALAM_REVIEW)
            ->count();
        $revisi = Bab::where('reviewer_id', $userId)
            ->where('status_id', Status::REVISI)
            ->count();
        $approved = Bab::where('reviewer_id', $userId)
            ->where('status_id', Status::DISETUJUI)
            ->count();
        $reviewerBooks = Buku::whereHas('bab', function ($query) use ($userId) {
            $query->where('reviewer_id', $userId);
        })->count();

        $statistics = Bab::where('reviewer_id', $userId)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->get()
            ->toArray();

        $recentActivities = Bab::where('reviewer_id', $userId)
            ->with(['author', 'status'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('pages.reviewer.dashboard.index', compact(
            'statistics', 'recentActivities',
            'assignedChapters', 'needsReview', 'inReview', 'revisi', 'approved', 'reviewerBooks'
        ));
    }

    public function authorPage()
    {
        $userId = Auth::id();
        $assignedChapters = Bab::where('author_id', $userId)->count();
        $draftChapters = Bab::where('author_id', $userId)
            ->where('status_id', Status::DRAFT)
            ->count();
        $inProgress = Bab::where('author_id', $userId)
            ->where('status_id', Status::DITUGASKAN)
            ->count();
        $needsRevision = Bab::where('author_id', $userId)
            ->where('status_id', Status::REVISI)
            ->count();
        $submitted = Bab::where('author_id', $userId)
            ->where('status_id', Status::DIKIRIM_AUTHOR)
            ->count();
        $approved = Bab::where('author_id', $userId)
            ->where('status_id', Status::DISETUJUI)
            ->count();
        $authorBooks = Buku::whereHas('bab', function ($query) use ($userId) {
            $query->where('author_id', $userId);
        })->count();

        $statistics = Bab::where('author_id', $userId)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->get()
            ->toArray();

        $recentActivities = Bab::where('author_id', $userId)
            ->with(['status'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('pages.author.dashboard.index', compact(
            'statistics', 'recentActivities',
            'assignedChapters', 'draftChapters', 'inProgress', 'needsRevision', 'submitted', 'approved', 'authorBooks'
        ));
    }
}

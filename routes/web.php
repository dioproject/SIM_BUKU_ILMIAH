<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\HistoryController;
use App\Http\Controllers\admin\BookController;
use App\Http\Controllers\admin\ReviewController;
use App\Http\Controllers\admin\CatalogController;
use App\Http\Controllers\admin\ChapterController;
use App\Http\Controllers\admin\RoyaltyController;
use App\Http\Controllers\author\AuthorBookController;
use App\Http\Controllers\author\AuthorRoyaltyController;
use App\Http\Controllers\author\AuthorHistoryController;
use App\Http\Controllers\author\AuthorReviewController;
use App\Http\Controllers\editor\EditorBookController;
use App\Http\Controllers\editor\EditorHistoryController;
use App\Http\Controllers\editor\EditorUserController;

Route::redirect('/', '/login');

Route::controller(AuthController::class)->group(function () {
    //Login
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'loginAction')->name('login.action');
    //Logout
    Route::get('/logout', 'logout')->name('logout');
});

Route::middleware(['auth', 'user-role:ADMIN'])->group(function () {

    // Admin Page
    Route::get('/admin/dashboard', [HomeController::class, 'adminPage'])->name('admin.dashboard');
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.index.user');
    Route::get('/admin/create/user', [UserController::class, 'create'])->name('admin.create.user');
    Route::post('/admin/create/user', [UserController::class, 'store'])->name('admin.store.user');
    Route::get('/admin/edit/user/{id}', [UserController::class, 'edit'])->name('admin.edit.user');
    Route::put('/admin/edit/user/{id}', [UserController::class, 'update'])->name('admin.update.user');
    Route::delete('/admin/user/{id}', [UserController::class, 'destroy'])->name('admin.destroy.user');
    Route::get('/admin/books', [BookController::class, 'index'])->name('admin.index.book');
    Route::get('/admin/create/book', [BookController::class, 'create'])->name('admin.create.book');
    Route::post('/admin/create/book', [BookController::class, 'store'])->name('admin.store.book');
    Route::post('/admin/chapter/{id}', [BookController::class, 'storeChapter'])->name('admin.store.chapter');
    Route::get('/admin/book/{id}', [BookController::class, 'show'])->name('admin.show.book');
    Route::get('/admin/chapter/{id}/accept', [BookController::class, 'accept'])->name('admin.accept.chapter');
    Route::get('/admin/chapter/{id}/reject', [BookController::class, 'reject'])->name('admin.reject.chapter');
    Route::delete('/admin/book/{id}', [BookController::class, 'destroy'])->name('admin.destroy.book');
    Route::get('/admin/history', [HistoryController::class, 'index'])->name('admin.index.history');
});

Route::middleware(['auth', 'user-role:REVIEWER'])->group(function () {

    //Editor
    Route::get('/reviewer/dashboard', [HomeController::class, 'editorPage'])->name('reviewer.dashboard');
    Route::get('/reviewer/users', [EditorUserController::class, 'index'])->name('reviewer.index.user');
    Route::get('/reviewer/books', [EditorBookController::class, 'index'])->name('reviewer.index.book');
    Route::get('/reviewer/book/{id}', [EditorBookController::class, 'show'])->name('reviewer.show.book');
    Route::post('/reviewer/book/{id}/approve', [EditorBookController::class, 'approve'])->name('reviewer.approve.book');
    Route::post('/reviewer/book/{id}//rejected', [EditorBookController::class, 'rejected'])->name('reviewer.rejected.book');
    Route::post('/reviewer/book/{id}/review', [EditorBookController::class, 'review'])->name('reviewer.review.book');
    Route::get('/reviewer/history', [EditorHistoryController::class, 'index'])->name('reviewer.index.history');
});

Route::middleware(['auth', 'user-role:AUTHOR'])->group(function () {

    //Author
    Route::get('/author/dashboard', [HomeController::class, 'authorPage'])->name('author.dashboard');
    Route::get('/author/books', [AuthorBookController::class, 'index'])->name('author.index.book');
    Route::get('/author/book/{id}', [AuthorBookController::class, 'show'])->name('author.show.book');
    Route::put('/author/chapter/{id}/upload', [AuthorBookController::class, 'upload'])->name('author.upload.chapter');
    Route::get('/author/chapter/{id}/submit', [AuthorBookController::class, 'submit'])->name('author.submit.chapter');
    Route::get('/author/edit/book/{id}', [AuthorBookController::class, 'edit'])->name('author.edit.book');
    Route::put('/author/edit/book/{id}', [AuthorBookController::class, 'update'])->name('author.update.book');
    Route::get('/author/reviews', [AuthorReviewController::class, 'index'])->name('author.index.review');
    Route::get('/author/royalty', [AuthorRoyaltyController::class, 'index'])->name('author.index.royalty');
    Route::get('/author/history', [AuthorHistoryController::class, 'index'])->name('author.index.history');
});

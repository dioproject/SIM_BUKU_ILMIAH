<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\HistoryController;
use App\Http\Controllers\admin\BookController;
use App\Http\Controllers\author\AuthorBookController;
use App\Http\Controllers\author\AuthorRoyaltyController;
use App\Http\Controllers\author\AuthorHistoryController;
use App\Http\Controllers\author\AuthorReviewController;
use App\Http\Controllers\reviewer\ReviewerBookController;
use App\Http\Controllers\reviewer\ReviewerHistoryController;
use App\Http\Controllers\reviewer\ReviewerUserController;

Route::redirect('/', '/login');

Route::controller(AuthController::class)->group(function () {
    //Login
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'loginAction')->name('login.action');
    //Logout
    Route::get('/logout', 'logout')->name('logout');
});

// ADMIN ROUTE
Route::middleware(['auth', 'user-role:ADMIN'])->group(function () {

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
    Route::get('/admin/chapter/{id}/approve', [BookController::class, 'approve'])->name('admin.approve.chapter');
    Route::get('/admin/chapter/{id}/reject', [BookController::class, 'reject'])->name('admin.reject.chapter');
    Route::delete('/admin/book/{id}', [BookController::class, 'destroy'])->name('admin.destroy.book');
    Route::get('/admin/history', [HistoryController::class, 'index'])->name('admin.index.history');
});

//REVIEWER ROUTE
Route::middleware(['auth', 'user-role:REVIEWER'])->group(function () {

    Route::get('/reviewer/dashboard', [HomeController::class, 'reviewerPage'])->name('reviewer.dashboard');
    Route::get('/reviewer/users', [ReviewerUserController::class, 'index'])->name('reviewer.index.user');
    Route::get('/reviewer/books', [ReviewerBookController::class, 'index'])->name('reviewer.index.book');
    Route::get('/reviewer/book/{id}', [ReviewerBookController::class, 'show'])->name('reviewer.show.book');
    Route::put('/reviewer/{id}/review', [ReviewerBookController::class, 'upload'])->name('reviewer.upload.review');
    Route::put('/reviewer/{id}/notes', [ReviewerBookController::class, 'notes'])->name('reviewer.notes.review');
    Route::get('/reviewer/history', [ReviewerHistoryController::class, 'index'])->name('reviewer.index.history');
});

// AUTHOR ROUTE
Route::middleware(['auth', 'user-role:AUTHOR'])->group(function () {

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

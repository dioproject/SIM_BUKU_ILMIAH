<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\HistoryController;
use App\Http\Controllers\admin\BookController;
use App\Http\Controllers\admin\ReviewController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\CatalogController;
use App\Http\Controllers\admin\RoyaltyController;
use App\Http\Controllers\author\AuthorBookController;
use App\Http\Controllers\author\AuthorRoyaltyController;
use App\Http\Controllers\author\AuthorHistoryController;
use App\Http\Controllers\author\AuthorReviewController;
use App\Http\Controllers\editor\EditorBookController;
use App\Http\Controllers\editor\EditorHistoryController;
use App\Http\Controllers\editor\EditorUserController;

Route::redirect('/', '/login');

Route::controller(AuthController::class)->group(function() {
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
    Route::get('/admin/category', [CategoryController::class, 'index'])->name('admin.index.category');
    Route::get('/admin/create/category', [CategoryController::class, 'create'])->name('admin.create.category');
    Route::post('/admin/create/category', [CategoryController::class, 'store'])->name('admin.store.category');
    Route::get('/admin/edit/category/{id}', [CategoryController::class, 'edit'])->name('admin.edit.category');
    Route::put('/admin/edit/category/{id}', [CategoryController::class, 'update'])->name('admin.update.category');
    Route::delete('/admin/category/{id}', [CategoryController::class, 'destroy'])->name('admin.destroy.category');
    Route::get('/admin/books', [BookController::class, 'index'])->name('admin.index.book');
    Route::get('/admin/create/book', [BookController::class, 'create'])->name('admin.create.book');
    Route::post('/admin/create/book', [BookController::class, 'store'])->name('admin.store.book');
    Route::get('/admin/book/{id}', [BookController::class, 'show'])->name('admin.show.book');
    Route::get('/admin/edit/book/{id}', [BookController::class, 'edit'])->name('admin.edit.book');
    Route::put('/admin/edit/book/{id}', [BookController::class, 'update'])->name('admin.update.book');
    Route::delete('/admin/book/{id}', [BookController::class, 'destroy'])->name('admin.destroy.book');
    Route::get('/admin/reviews', [ReviewController::class, 'index'])->name('admin.index.review');
    Route::get('/admin/create/review', [ReviewController::class, 'create'])->name('admin.create.review');
    Route::post('/admin/create/review', [ReviewController::class, 'store'])->name('admin.store.review');
    Route::get('/admin/edit/review/{id}', [ReviewController::class, 'edit'])->name('admin.edit.review');
    Route::put('/admin/edit/review/{id}', [ReviewController::class, 'update'])->name('admin.update.review');
    Route::delete('/admin/review/{id}', [ReviewController::class, 'destroy'])->name('admin.destroy.review');
    Route::get('/admin/catalogs', [CatalogController::class, 'index'])->name('admin.index.catalog');
    Route::get('/admin/create/catalog', [CatalogController::class, 'create'])->name('admin.create.catalog');
    Route::post('/admin/create/catalog', [CatalogController::class, 'store'])->name('admin.store.catalog');
    Route::get('/admin/royalty', [RoyaltyController::class, 'index'])->name('admin.index.royalty');
    Route::get('/admin/create/royalty', [RoyaltyController::class, 'create'])->name('admin.create.royalty');
    Route::post('/admin/create/royalty', [RoyaltyController::class, 'store'])->name('admin.store.royalty');
    Route::get('/admin/edit/royalty/{id}', [RoyaltyController::class, 'edit'])->name('admin.edit.royalty');
    Route::put('/admin/edit/royalty/{id}', [RoyaltyController::class, 'update'])->name('admin.update.royalty');
    Route::get('/admin/history', [HistoryController::class, 'index'])->name('admin.index.history');
});

Route::middleware(['auth', 'user-role:EDITOR'])->group(function() {
    
    //Editor
    Route::get('/editor/dashboard', [HomeController::class, 'editorPage'])->name('editor.dashboard');
    Route::get('/editor/users', [EditorUserController::class, 'index'])->name('editor.index.user');
    Route::get('/editor/books', [EditorBookController::class, 'index'])->name('editor.index.book');
    Route::get('/editor/book/{id}', [EditorBookController::class, 'show'])->name('editor.show.book');
    Route::post('/editor/book/{id}/approve', [EditorBookController::class, 'approve'])->name('editor.approve.book');
    Route::post('/editor/book/{id}//rejected', [EditorBookController::class, 'rejected'])->name('editor.rejected.book');
    Route::post('/editor/book/{id}/review', [EditorBookController::class, 'review'])->name('editor.review.book');    
    Route::get('/editor/history', [EditorHistoryController::class, 'index'])->name('editor.index.history');
});

Route::middleware(['auth', 'user-role:AUTHOR'])->group(function() {
    
    //Author
    Route::get('/author/dashboard', [HomeController::class, 'authorPage'])->name('author.dashboard');
    Route::get('/author/books', [AuthorBookController::class, 'index'])->name('author.index.book');
    Route::get('/author/create/book', [AuthorBookController::class, 'create'])->name('author.create.book');
    Route::post('/author/create/book', [AuthorBookController::class, 'store'])->name('author.store.book');
    Route::get('/author/book/{id}', [AuthorBookController::class, 'show'])->name('author.show.book');
    Route::get('/author/edit/book/{id}', [AuthorBookController::class, 'edit'])->name('author.edit.book');
    Route::put('/author/edit/book/{id}', [AuthorBookController::class, 'update'])->name('author.update.book');
    Route::get('/author/reviews', [AuthorReviewController::class, 'index'])->name('author.index.review');
    Route::get('/author/royalty', [AuthorRoyaltyController::class, 'index'])->name('author.index.royalty');
    Route::get('/author/history', [AuthorHistoryController::class, 'index'])->name('author.index.history');
});

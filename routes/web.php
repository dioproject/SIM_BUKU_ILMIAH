<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\HistoryController;
use App\Http\Controllers\admin\BookController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\CatalogController;
use App\Http\Controllers\admin\RoyaltyController;
use App\Http\Controllers\author\AuthorBookController;
use App\Http\Controllers\author\AuthorRoyaltyController;
use App\Http\Controllers\author\AuthorHistoryController;

Route::redirect('/', '/login');

Route::controller(AuthController::class)->group(function() {
    //Login
    Route::get('/login', 'login')->name('login');
    Route::post('/login/action', 'loginAction')->name('login.action');
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
    Route::delete('/admin/delete/user/{id}', [UserController::class, 'destroy'])->name('admin.destroy.user');
    Route::get('/admin/category', [CategoryController::class, 'index'])->name('admin.index.category');
    Route::get('/admin/create/category', [CategoryController::class, 'create'])->name('admin.create.category');
    Route::post('/admin/create/category', [CategoryController::class, 'store'])->name('admin.store.category');
    Route::get('/admin/edit/category/{id}', [CategoryController::class, 'edit'])->name('admin.edit.category');
    Route::put('/admin/edit/category/{id}', [CategoryController::class, 'update'])->name('admin.update.category');
    Route::delete('/admin/delete/category/{id}', [CategoryController::class, 'destroy'])->name('admin.destroy.category');
    Route::get('/admin/books', [BookController::class, 'index'])->name('admin.index.book');
    Route::get('/admin/create/book', [BookController::class, 'create'])->name('admin.create.book');
    Route::post('/admin/create/book', [BookController::class, 'store'])->name('admin.store.book');
    Route::get('/admin/edit/book/{id}', [BookController::class, 'edit'])->name('admin.edit.book');
    Route::put('/admin/edit/book/{id}', [BookController::class, 'update'])->name('admin.update.book');
    Route::delete('/admin/delete/book/{id}', [BookController::class, 'destroy'])->name('admin.destroy.book');
    Route::get('/admin/catalogs', [CatalogController::class, 'index'])->name('admin.index.catalog');
    Route::get('/admin/create/catalog', [CatalogController::class, 'create'])->name('admin.create.catalog');
    Route::post('/admin/create/catalog', [CatalogController::class, 'store'])->name('admin.store.catalog');
    Route::get('/admin/royalty', [RoyaltyController::class, 'index'])->name('admin.index.royalty');
    Route::get('/admin/create/royalty', [RoyaltyController::class, 'create'])->name('admin.create.royalty');
    Route::post('/admin/create/royalty', [RoyaltyController::class, 'store'])->name('admin.store.royalty');
    Route::get('/admin/edit/royalty/{id}', [RoyaltyController::class, 'edit'])->name('admin.edit.royalty');
    Route::put('/admin/edit/royalty/{id}', [RoyaltyController::class, 'update'])->name('admin.update.royalty');
    Route::get('/admin/history', [HistoryController::class, 'index'])->name('history.index');
});

Route::middleware(['auth', 'user-role:EDITOR'])->group(function() {

    //Editor
    Route::get('/editor/dashboard', [HomeController::class, 'editorPage'])->name('editor.dashboard');
});

Route::middleware(['auth', 'user-role:AUTHOR'])->group(function() {

    //Author
    Route::get('/author/dashboard', [HomeController::class, 'authorPage'])->name('author.dashboard');
    Route::get('/author/books', [AuthorBookController::class, 'index'])->name('author.index.book');
    Route::get('/author/create/book', [AuthorBookController::class, 'create'])->name('author.create.book');
    Route::post('/author/create/book', [AuthorBookController::class, 'store'])->name('author.store.book');
    Route::get('/author/edit/book/{id}', [AuthorBookController::class, 'edit'])->name('author.edit.book');
    Route::put('/author/edit/book/{id}', [AuthorBookController::class, 'update'])->name('author.update.book');
    Route::get('/author/royalty', [AuthorRoyaltyController::class, 'index'])->name('author.index.royalty');
    Route::get('/author/history', [AuthorHistoryController::class, 'index'])->name('author.index.history');
});

<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\HistoryController;

Route::redirect('/', '/login');

Route::controller(AuthController::class)->group(function() {
    //Login
    Route::get('/login', 'login')->name('login');
    Route::post('/login/action', 'loginAction')->name('login.action');
    //Register
    Route::get('/register', 'register')->name('register');
    Route::post('/register/action', 'registerAction')->name('register.action');
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
    Route::get('/admin/books', [BookController::class, 'index'])->name('admin.index.book');
    Route::delete('/admin/delete/book/{id}', [BookController::class, 'destroy'])->name('admin.destroy.book');
    Route::get('/admin/history', [HistoryController::class, 'index'])->name('history.index');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

});

Route::middleware(['auth', 'user-role:EDITOR'])->group(function() {

    //Editor
    Route::get('/editor/dashboard', [HomeController::class, 'editorPage'])->name('editor.dashboard');
    Route::get('/editor/users', function () {
        return view('pages.editor.user-data', ['type_menu' => 'data']);
    });
    Route::get('/editor/bookdata', function () {
        return view('pages.editor.book-data', ['type_menu' => 'data']);
    });
    Route::get('/editor/bookdata/review', function () {
        return view('pages.editor.review-book', ['type_menu' => 'data']);
    });
    Route::get('/editor/history', function () {
        return view('pages.editor.history', ['type_menu' => 'history']);
    });

});

Route::middleware(['auth', 'user-role:AUTHOR'])->group(function() {

    //Author
    Route::get('/author/dashboard', [HomeController::class, 'authorPage'])->name('author.dashboard');
    Route::get('/author/bookdata', function () {
        return view('pages.author.book-data', ['type_menu' => 'data']);
    });
    Route::get('/author/bookdata/create', function () {
        return view('pages.author.create-book', ['type_menu' => 'data']);
    });
    Route::get('/author/royalty', function () {
        return view('pages.author.royalty', ['type_menu' => 'royalty']);
    });
    Route::get('/author/history', function () {
        return view('pages.author.history', ['type_menu' => 'history']);
    });
});

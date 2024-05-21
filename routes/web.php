<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\HeaderController;

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
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.user.index');
    Route::get('/admin/create/user', [UserController::class, 'create'])->name('admin.user.create');
    Route::post('/admin/create/user', [UserController::class, 'store'])->name('admin.user.store');
    Route::get('/admin/edit/user/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::put('/admin/edit/user/{id}', [UserController::class, 'update'])->name('admin.user.update');
    Route::delete('/admin/delete/user/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');
    Route::get('/admin/bookdata', function () {
        return view('pages.admin.book-data', ['type_menu' => 'data']);
    });
    Route::get('/admin/bookdata/create', function () {
        return view('pages.admin.create-book', ['type_menu' => 'data']);
    });
    Route::get('/admin/bookdata/edit', function () {
        return view('pages.admin.edit-book', ['type_menu' => 'data']);
    });
    Route::get('/admin/katalog', function () {
        return view('pages.admin.katalog', ['type_menu' => 'katalog']);
    });
    Route::get('/admin/katalog/create', function () {
        return view('pages.admin.create-katalog', ['type_menu' => 'katalog']);
    });
    Route::get('/admin/royalty', function () {
        return view('pages.admin.royalty', ['type_menu' => 'royalty']);
    });
    Route::get('/admin/royalty/create', function () {
        return view('pages.admin.create-royalty', ['type_menu' => 'royalty']);
    });
    Route::get('/admin/history', function () {
        return view('pages.admin.history', ['type_menu' => 'history']);
    });
    Route::get('/admin/profile', [HeaderController::class, 'name'])->name('admin.profile');
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

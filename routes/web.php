<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

Route::get('/', function() {
    return view('pages.auth.login');
})->middleware('auth');

Auth::routes();

Route::controller(AuthController::class)->group(function() {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'loginAction')->name('login.action');
});

Route::middleware(['auth', 'user-role:ADMIN'])->group(function () {
  
    // Admin Page
    Route::get('/admin/dashboard', [DashbordController::class, 'adminPage'])->name('admin.dashboard');
    Route::get('/admin/userdata', function () {
        return view('pages.admin.user-data', ['type_menu' => 'data']);
    });
    Route::get('/admin/userdata/create', function () {
        return view('pages.admin.create-user', ['type_menu' => 'data']);
    });
    Route::get('/admin/userdata/edit', function () {
        return view('pages.admin.edit-user', ['type_menu' => 'data']);
    });
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

});

Route::middleware(['auth', 'user-role:EDITOR'])->group(function() {

    //Editor
    Route::get('/editor/dashboard', [DashbordController::class, 'editorPage'])->name('editor.dashboard');
    Route::get('/editor/userdata', function () {
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

Route::middleware(['auth', 'user-role:EDITOR'])->group(function() {

    //Author
    Route::get('/author/dashboard', [DashbordController::class, 'authorPage'])->name('author.dashboard');
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
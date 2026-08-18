<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\FollowController;

Route::get('/', function () {
    return view('index');
});

// Public routes
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile/get', [ProfileController::class, 'getProfile'])->name('profile.get');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile', [ProfileController::class, 'ownerProfile'])->name('profile.show');
    Route::get('/profile/{user}', [ProfileController::class, 'othersProfile'])->name('profile.others');
    // User-specific actions
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy')->middleware('auth');
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::patch('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::post('/articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');

    // Like Article and Comment
    Route::post('/like/{type}/{id}', [UserController::class, 'like'])->name('like');


    // Follow
    Route::post('/follow/{type}/{id}', [FollowController::class, 'follow'])->name('follow');


});








Route::get('/api-news', [NewsController::class, 'apiNews'])->name('api.news');

Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
// Route::get('/api-news', [ArticleController::class, 'apiNews'])->name('api.news');

// Authenticated routes


// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    // Route::resource('articles', ArticleController::class);

    // User management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/register', [UserController::class, 'create'])->name('users.register');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

require __DIR__ . '/auth.php';

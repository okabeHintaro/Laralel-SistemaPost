<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SavePostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\NotificationController;


use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('posts.index');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::get('/meus-posts', [PostController::class, 'myPosts'])->name('posts.my');
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/usuarios/{user}/seguir', [FollowController::class, 'toggle'])->name('usuarios.seguir');
    Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])->name('posts.like');
     Route::post('/posts/{post}/salvar', [SavePostController::class, 'toggle'])->name('posts.save');
    Route::get('/salvos', [SavePostController::class, 'index'])->name('posts.saved');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])
    ->name('notifications.markAsRead');
});

    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/usuarios/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/tags/{tag}', [\App\Http\Controllers\TagController::class, 'show'])->name('tags.show');
    Route::get('/busca', [\App\Http\Controllers\PostController::class, 'search'])->name('posts.search');
    Route::get('/autocomplete', [\App\Http\Controllers\PostController::class, 'autocomplete'])->name('posts.autocomplete');









require __DIR__.'/auth.php';

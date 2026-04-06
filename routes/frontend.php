<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\PageController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/post/{slug}', [PostController::class, 'show'])->name('post.show');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

Route::post('/post/{slug}/comments', [PostController::class, 'storeComment'])->name('post.comments.store');
Route::post('/post/{slug}/comments/{comment}/reply', [PostController::class, 'storeReply'])->name('post.comments.reply');
Route::delete('/post/{slug}/comments/{comment}/reply', [PostController::class, 'destroyReply'])->name('post.comments.reply.destroy');
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'submitContact'])->name('contact.submit');


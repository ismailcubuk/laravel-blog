<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\UserPostController;
use App\Http\Controllers\Admin\Auth\AuthController as PublicAuthController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/post/{slug}', [PostController::class, 'show'])->name('post.show');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

Route::post('/post/{slug}/comments', [PostController::class, 'storeComment'])->middleware('throttle:6,1')->name('post.comments.store');
Route::post('/post/{slug}/comments/{comment}/reply', [PostController::class, 'storeReply'])->name('post.comments.reply');
Route::delete('/post/{slug}/comments/{comment}/reply', [PostController::class, 'destroyReply'])->name('post.comments.reply.destroy');
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/blog/kategori/{category:slug}', [PageController::class, 'category'])->name('blog.category');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'submitContact'])->middleware('throttle:3,1')->name('contact.submit');
Route::get('/login', [PublicAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [PublicAuthController::class, 'login'])->middleware('throttle:6,1')->name('login.post');
Route::get('/register', [PublicAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [PublicAuthController::class, 'register'])->middleware('throttle:5,10')->name('register.post');
Route::get('/forget-password', [PublicAuthController::class, 'showForgotForm'])->name('password.request');
Route::post('/forget-password', [PublicAuthController::class, 'sendPasswordResetLink'])->middleware('throttle:4,10')->name('password.email');
Route::get('/reset-password/{token}', [PublicAuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PublicAuthController::class, 'resetPassword'])->middleware('throttle:6,10')->name('password.update');

Route::get('/profile/email-change/{requestId}', [ProfileController::class, 'verifyEmailChange'])
    ->name('profile.email.verify');
Route::put('/profile/mode', [ProfileController::class, 'updateMode'])->name('profile.mode');

Route::middleware('auth')->group(function () {
    Route::get('/blog/my-posts', [UserPostController::class, 'index'])->name('user.posts.index');
    Route::get('/blog/drafts', [UserPostController::class, 'drafts'])->name('user.posts.drafts');
    Route::get('/blog/drafts/{post}/edit', [UserPostController::class, 'edit'])->name('user.posts.drafts.edit');
    Route::put('/blog/drafts/{post}', [UserPostController::class, 'update'])->name('user.posts.drafts.update');
    Route::put('/blog/drafts/{post}/publish', [UserPostController::class, 'publishDraft'])->name('user.posts.drafts.publish');
    Route::get('/blog/my-comments', [UserPostController::class, 'comments'])->name('user.posts.comments');
    Route::get('/blog/create', [UserPostController::class, 'create'])->name('user.posts.create');
    Route::post('/blog', [UserPostController::class, 'store'])->name('user.posts.store');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

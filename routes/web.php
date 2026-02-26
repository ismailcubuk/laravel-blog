<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\AdminPostController; 
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\PageController;

// ================= FRONTEND =================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/post/{slug}', [PostController::class, 'show'])->name('post.show');
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// ================= ADMIN =================
Route::prefix('admin')->name('admin.')->group(function () {

    // AUTH
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('password.request');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');

    // Admin Panel (Auth Required)
    Route::middleware('auth')->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

 // Posts (tek blade üzerinden)
    Route::get('/posts', [AdminPostController::class, 'index'])->name('content.posts'); // Liste
    Route::post('/posts', [AdminPostController::class, 'store'])->name('content.posts.store'); // Create
    Route::get('/posts/{post}/edit', [AdminPostController::class, 'edit'])->name('content.posts.edit'); // Edit form
    Route::put('/posts/{post}', [AdminPostController::class, 'update'])->name('content.posts.update'); // Update
    Route::delete('/posts/{post}', [AdminPostController::class, 'destroy'])->name('content.posts.destroy'); // Delete
        
    Route::get('/categories', function() {
            return view('admin.content.categories');
        })->name('content.categories');

        Route::get('/comments', function() {
            return view('admin.content.comments');
        })->name('content.comments');

        // Pages
        Route::get('/about-us', [AdminPageController::class, 'about'])->name('pages.about');
        Route::put('/about-us', [AdminPageController::class, 'updateAbout'])->name('pages.about.update');

        Route::get('/contact-us', [AdminPageController::class, 'contact'])->name('pages.contact');
        Route::put('/contact-us', [AdminPageController::class, 'updateContact'])->name('pages.contact.update');

        Route::view('/privacy-policy', 'admin.pages.privacy')->name('pages.privacy');

        // Users
        Route::view('/users/roles', 'admin.users.roles')->name('users.roles');
        Route::view('/users/permissions', 'admin.users.permissions')->name('users.permissions');

        // Analytics
        Route::view('/analytics', 'admin.analytics.index')->name('analytics.index');

        // Settings
        Route::view('/settings/general', 'admin.settings.general')->name('settings.general');
        Route::view('/settings/social', 'admin.settings.social')->name('settings.social');
        Route::view('/settings/mail', 'admin.settings.mail')->name('settings.mail');

    });
});
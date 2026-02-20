<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/post/{slug}', [PostController::class, 'show'])->name('post.show');

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');


Route::prefix('admin')->name('admin.')->group(function () {

    // ================= AUTH =================
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('password.request');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');


    // ================= ADMIN PANEL =================
    Route::middleware('auth')->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Content
        Route::view('/posts', 'admin.content.posts')->name('content.posts');
        Route::view('/categories', 'admin.content.categories')->name('content.categories');
        Route::view('/comments', 'admin.content.comments')->name('content.comments');

        // Pages
        Route::view('/about-us', 'admin.pages.about')->name('pages.about');
        Route::view('/contact-us', 'admin.pages.contact')->name('pages.contact');
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
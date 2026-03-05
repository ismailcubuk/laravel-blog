<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Content\AdminPostController;
use App\Http\Controllers\Admin\Content\AdminCategoryController;
use App\Http\Controllers\Admin\Pages\AdminPageController;
use App\Http\Controllers\Admin\Settings\SettingController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('password.request');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/posts', [AdminPostController::class, 'index'])->name('content.posts.index');
        Route::get('/posts/create', [AdminPostController::class, 'create'])->name('content.posts.create');
        Route::post('/posts', [AdminPostController::class, 'store'])->name('content.posts.store');
        Route::get('/posts/{post}/edit', [AdminPostController::class, 'edit'])->name('content.posts.edit');
        Route::put('/posts/{post}', [AdminPostController::class, 'update'])->name('content.posts.update');
        Route::delete('/posts/{post}', [AdminPostController::class, 'destroy'])->name('content.posts.destroy');

        Route::get('/categories', [AdminCategoryController::class, 'index'])->name('content.categories.index');
        Route::post('/categories', [AdminCategoryController::class, 'store'])->name('content.categories.store');

        Route::view('/comments', 'admin.content.comments')->name('content.comments');

        Route::get('/about-us', [AdminPageController::class, 'about'])->name('pages.about');
        Route::put('/about-us', [AdminPageController::class, 'updateAbout'])->name('pages.about.update');
        Route::get('/contact-us', [AdminPageController::class, 'contact'])->name('pages.contact');
        Route::put('/contact-us', [AdminPageController::class, 'updateContact'])->name('pages.contact.update');
        Route::view('/privacy-policy', 'admin.pages.privacy')->name('pages.privacy');

        Route::view('/users/roles', 'admin.users.roles')->name('users.roles');
        Route::view('/users/permissions', 'admin.users.permissions')->name('users.permissions');

        Route::view('/analytics', 'admin.analytics.index')->name('analytics.index');

        Route::get('/settings/general', [SettingController::class, 'general'])->name('settings.general');
        Route::put('/settings/general', [SettingController::class, 'update'])->name('settings.general.update');
        Route::view('/settings/social', 'admin.settings.social')->name('settings.social');
        Route::view('/settings/mail', 'admin.settings.mail')->name('settings.mail');
    });
});

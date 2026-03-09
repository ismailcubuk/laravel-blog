<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Content\AdminPostController;
use App\Http\Controllers\Admin\Content\AdminCategoryController;
use App\Http\Controllers\Admin\Content\AdminCommentController;
use App\Http\Controllers\Admin\Pages\AdminPageController;
use App\Http\Controllers\Admin\Settings\SettingController;
use App\Http\Controllers\Admin\Users\PermissionController;
use App\Http\Controllers\Admin\Users\RoleController;
use App\Http\Controllers\Admin\Users\UserController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('password.request');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');

    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/posts', [AdminPostController::class, 'index'])->name('content.posts.index');
        Route::get('/posts/create', [AdminPostController::class, 'create'])->name('content.posts.create');
        Route::post('/posts', [AdminPostController::class, 'store'])->name('content.posts.store');
        Route::get('/posts/{post}/edit', [AdminPostController::class, 'edit'])->name('content.posts.edit');
        Route::put('/posts/{post}', [AdminPostController::class, 'update'])->name('content.posts.update');
        Route::delete('/posts/{post}', [AdminPostController::class, 'destroy'])->name('content.posts.destroy');

        Route::get('/categories', [AdminCategoryController::class, 'index'])->name('content.categories.index');
        Route::post('/categories', [AdminCategoryController::class, 'store'])->name('content.categories.store');
        Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('content.categories.update');
        Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('content.categories.destroy');

        Route::get('/comments', [AdminCommentController::class, 'index'])->name('content.comments');
        Route::post('/comments/{comment}/reply', [AdminCommentController::class, 'storeReply'])->name('content.comments.reply');
        Route::delete('/comments/{comment}/reply', [AdminCommentController::class, 'destroyReply'])->name('content.comments.reply.destroy');
        Route::put('/comments/{comment}/status', [AdminCommentController::class, 'updateStatus'])->name('content.comments.status');
        Route::delete('/comments/{comment}', [AdminCommentController::class, 'destroy'])->name('content.comments.destroy');

        Route::get('/about-us', [AdminPageController::class, 'about'])->name('pages.about');
        Route::put('/about-us', [AdminPageController::class, 'updateAbout'])->name('pages.about.update');
        Route::get('/contact-us', [AdminPageController::class, 'contact'])->name('pages.contact');
        Route::put('/contact-us', [AdminPageController::class, 'updateContact'])->name('pages.contact.update');
        Route::view('/privacy-policy', 'admin.pages.privacy')->name('pages.privacy');

        Route::get('/users', [UserController::class, 'index'])->name('users.list');
        Route::put('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.role.update');
        Route::get('/users/roles', [RoleController::class, 'index'])->name('users.roles');
        Route::post('/users/roles', [RoleController::class, 'store'])->name('users.roles.store');
        Route::put('/users/roles/{role}', [RoleController::class, 'update'])->name('users.roles.update');
        Route::delete('/users/roles/{role}', [RoleController::class, 'destroy'])->name('users.roles.destroy');
        Route::get('/users/permissions', function () {
            return redirect()->route('admin.users.roles');
        })->name('users.permissions');
        Route::post('/users/permissions', [PermissionController::class, 'store'])->name('users.permissions.store');
        Route::put('/users/permissions/{permission}', [PermissionController::class, 'update'])->name('users.permissions.update');
        Route::delete('/users/permissions/{permission}', [PermissionController::class, 'destroy'])->name('users.permissions.destroy');
        Route::put('/users/permissions/{permission}/roles', [PermissionController::class, 'syncRoles'])->name('users.permissions.roles.sync');

        Route::view('/analytics', 'admin.analytics.index')->name('analytics.index');

        Route::get('/settings/general', [SettingController::class, 'general'])->name('settings.general');
        Route::put('/settings/general', [SettingController::class, 'update'])->name('settings.general.update');
        Route::view('/settings/social', 'admin.settings.social')->name('settings.social');
        Route::view('/settings/mail', 'admin.settings.mail')->name('settings.mail');
    });
});

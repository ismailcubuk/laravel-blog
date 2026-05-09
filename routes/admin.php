<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Content\AdminPostController;
use App\Http\Controllers\Admin\Content\AdminUserPostController;
use App\Http\Controllers\Admin\Content\AdminCategoryController;
use App\Http\Controllers\Admin\Content\AdminCommentController;
use App\Http\Controllers\Admin\Content\AdminContactMessageController;
use App\Http\Controllers\Admin\Pages\AdminPageController;
use App\Http\Controllers\Admin\Settings\SettingController;
use App\Http\Controllers\Admin\Users\PermissionController;
use App\Http\Controllers\Admin\Users\ProfileController;
use App\Http\Controllers\Admin\Users\RoleController;
use App\Http\Controllers\Admin\Users\UserController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:6,1')->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,10')->name('register.post');
    Route::get('/verify-email', [AuthController::class, 'verifyEmail'])->name('email.verify');
    Route::get('/users/profile/email-change/{requestId}', [ProfileController::class, 'verifyEmailChange'])->name('users.profile.email.verify');

    Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendPasswordResetLink'])->middleware('throttle:4,10')->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->middleware('throttle:6,10')->name('password.update');

    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/posts', [AdminPostController::class, 'index'])->name('content.posts.index');
        Route::get('/posts/create', [AdminPostController::class, 'create'])->name('content.posts.create');
        Route::post('/posts', [AdminPostController::class, 'store'])->name('content.posts.store');
        Route::get('/posts/{post}/edit', [AdminPostController::class, 'edit'])->name('content.posts.edit');
        Route::put('/posts/{post}', [AdminPostController::class, 'update'])->name('content.posts.update');
        Route::delete('/posts/{post}', [AdminPostController::class, 'destroy'])->name('content.posts.destroy');

        Route::get('/user-posts', [AdminUserPostController::class, 'index'])->name('content.user-posts.index');
        Route::put('/user-posts/{post}/status', [AdminUserPostController::class, 'updateStatus'])->name('content.user-posts.status');
        Route::delete('/user-posts/{post}', [AdminUserPostController::class, 'destroy'])->name('content.user-posts.destroy');

        Route::get('/categories', [AdminCategoryController::class, 'index'])->name('content.categories.index');
        Route::post('/categories', [AdminCategoryController::class, 'store'])->name('content.categories.store');
        Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('content.categories.update');
        Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('content.categories.destroy');

        Route::get('/comments', [AdminCommentController::class, 'index'])->name('content.comments');
        Route::post('/comments/{comment}/reply', [AdminCommentController::class, 'storeReply'])->name('content.comments.reply');
        Route::delete('/comments/{comment}/reply', [AdminCommentController::class, 'destroyReply'])->name('content.comments.reply.destroy');
        Route::put('/comments/{comment}/status', [AdminCommentController::class, 'updateStatus'])->name('content.comments.status');
        Route::delete('/comments/{comment}', [AdminCommentController::class, 'destroy'])->name('content.comments.destroy');

        Route::get('/contact-messages', [AdminContactMessageController::class, 'index'])->name('content.contact-messages.index');
        Route::post('/contact-messages/{contactMessage}/reply', [AdminContactMessageController::class, 'reply'])->name('content.contact-messages.reply');
        Route::put('/contact-messages/{contactMessage}/read', [AdminContactMessageController::class, 'markRead'])->name('content.contact-messages.read');
        Route::put('/contact-messages/{contactMessage}/unread', [AdminContactMessageController::class, 'markUnread'])->name('content.contact-messages.unread');
        Route::delete('/contact-messages/{contactMessage}', [AdminContactMessageController::class, 'destroy'])->name('content.contact-messages.destroy');

        Route::get('/about-us', [AdminPageController::class, 'about'])->name('pages.about');
        Route::put('/about-us', [AdminPageController::class, 'updateAbout'])->name('pages.about.update');
        Route::get('/contact-us', [AdminPageController::class, 'contact'])->name('pages.contact');
        Route::put('/contact-us', [AdminPageController::class, 'updateContact'])->name('pages.contact.update');
        Route::get('/terms', [AdminPageController::class, 'terms'])->name('pages.terms');
        Route::put('/terms', [AdminPageController::class, 'updateTerms'])->name('pages.terms.update');

        Route::get('/users', [UserController::class, 'index'])->name('users.list');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::get('/users/profile', [ProfileController::class, 'edit'])->name('users.profile');
        Route::put('/users/profile', [ProfileController::class, 'update'])->name('users.profile.update');
        Route::put('/users/profile/password', [ProfileController::class, 'updatePassword'])->name('users.profile.password');
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
        Route::get('/settings/social', [SettingController::class, 'social'])->name('settings.social');
        Route::put('/settings/social', [SettingController::class, 'updateSocial'])->name('settings.social.update');
        Route::get('/settings/mail', [SettingController::class, 'mail'])->name('settings.mail');
        Route::put('/settings/mail', [SettingController::class, 'updateMail'])->name('settings.mail.update');
    });
});

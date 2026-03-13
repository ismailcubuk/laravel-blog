<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Services\Admin\DashboardActivityService;

class DashboardController extends Controller
{
    private DashboardActivityService $dashboardActivityService;

    public function __construct(DashboardActivityService $dashboardActivityService)
    {
        $this->dashboardActivityService = $dashboardActivityService;
    }

    public function index()
    {
        $totalPosts = Post::count();
        $totalUsers = User::count();
        $totalCategories = Category::count();
        $totalComments = Comment::count();
        $pendingComments = Comment::where('status', 'pending')->count();

        $allPosts = Post::query()
            ->with(['user:id,name'])
            ->latest()
            ->get(['id', 'title', 'slug', 'content', 'image', 'user_id', 'created_at']);

        $allUsers = User::query()
            ->latest()
            ->get(['id', 'name', 'email', 'role', 'avatar_path', 'created_at']);

        $allCategories = Category::query()
            ->withCount('posts')
            ->latest()
            ->get(['id', 'name', 'slug', 'created_at']);

        $allComments = Comment::query()
            ->with(['post:id,title,slug'])
            ->latest()
            ->get(['id', 'post_id', 'name', 'email', 'message', 'status', 'created_at']);

        $latestPosts = Post::query()
            ->with(['user:id,name', 'category:id,name'])
            ->latest()
            ->take(3)
            ->get(['id', 'title', 'slug', 'content', 'image', 'user_id', 'category_id', 'created_at']);

        $activityData = $this->dashboardActivityService->buildWeeklyActivity(7);

        return view('admin.dashboard.index', array_merge(
            [
                'allPosts' => $allPosts,
                'allUsers' => $allUsers,
                'allCategories' => $allCategories,
                'allComments' => $allComments,
                'latestPosts' => $latestPosts,
                'totalPosts' => $totalPosts,
                'totalUsers' => $totalUsers,
                'totalCategories' => $totalCategories,
                'totalComments' => $totalComments,
                'pendingComments' => $pendingComments,
            ],
            $activityData
        ));
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $bannerPosts = Post::with('category')
            ->published()
            ->withCount(['comments as approved_comments_count' => fn ($query) => $query->approved()])
            ->latest()
            ->take(5)
            ->get();
        $posts = Post::with('category')
            ->published()
            ->withCount(['comments as approved_comments_count' => fn ($query) => $query->approved()])
            ->latest()
            ->paginate(6);
        $recentPosts = Post::with('category')
            ->published()
            ->withCount(['comments as approved_comments_count' => fn ($query) => $query->approved()])
            ->latest()
            ->take(5)
            ->get();
        $categories = Category::query()
            ->withCount(['posts' => fn ($query) => $query->published()])
            ->having('posts_count', '>', 0)
            ->orderByDesc('posts_count')
            ->orderBy('name')
            ->get();

        return view('pages.home', compact('bannerPosts', 'posts', 'recentPosts', 'categories'));
    }
}

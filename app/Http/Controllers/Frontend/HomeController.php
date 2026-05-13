<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $bannerPosts = Post::query()
            ->withAvailableRelations(['category', 'tags'])
            ->published()
            ->withCount(['comments as approved_comments_count' => fn ($query) => $query->approved()])
            ->latest()
            ->take(5)
            ->get();
        $posts = Post::query()
            ->withAvailableRelations(['category', 'user', 'tags'])
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
            ->whereHas('posts', fn ($query) => $query->published())
            ->orderByDesc('posts_count')
            ->orderBy('name')
            ->get();
        $featuredPostQuery = Post::query()
            ->withAvailableRelations(['category', 'user', 'tags'])
            ->published()
            ->withCount(['comments as approved_comments_count' => fn ($query) => $query->approved()]);

        if (Post::featuredColumnsExist()) {
            $featuredPostQuery->where('is_featured', true)->orderByDesc('featured_at');
        } else {
            $featuredPostQuery->whereRaw('1 = 0');
        }

        $featuredPost = $featuredPostQuery->latest()->first() ?: $bannerPosts->first();
        $editorPicks = Post::query()
            ->withAvailableRelations(['category', 'user', 'tags'])
            ->published()
            ->withCount(['comments as approved_comments_count' => fn ($query) => $query->approved()])
            ->when($featuredPost, fn ($query) => $query->whereKeyNot($featuredPost->id))
            ->latest()
            ->take(3)
            ->get();
        $mostCommentedPosts = Post::with(['category', 'user'])
            ->published()
            ->withCount(['comments as approved_comments_count' => fn ($query) => $query->approved()])
            ->orderByDesc('approved_comments_count')
            ->latest()
            ->take(3)
            ->get();

        return view('pages.home', compact(
            'bannerPosts',
            'posts',
            'recentPosts',
            'categories',
            'featuredPost',
            'editorPicks',
            'mostCommentedPosts'
        ));
    }
}

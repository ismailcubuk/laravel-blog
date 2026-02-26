<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    // Blog listesi (ana sayfa değilse)
    public function index()
    {
        $bannerPosts = Post::with('category')->latest()->take(5)->get();
        $posts = Post::with('category')->latest()->paginate(6);

        return view('pages.posts.index', compact('bannerPosts', 'posts'));
    }

    // Tekil post
    public function show($slug)
    {
        $post = Post::with('category')->where('slug', $slug)->firstOrFail();
        $recentPosts = Post::with('category')->latest()->take(5)->get();
        $categories = Category::all();

        return view('pages.posts.show', compact('post', 'recentPosts', 'categories'));
    }
}
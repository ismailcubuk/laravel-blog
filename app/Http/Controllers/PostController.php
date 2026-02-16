<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        // banner posts
        $bannerPosts = Post::with('category')
            ->latest()
            ->take(5)
            ->get();

        // normal posts
        $posts = Post::with('category')
            ->latest()
            ->get();

        return view('welcome', compact('posts', 'bannerPosts'));
    }
}

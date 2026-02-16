<?php

namespace App\Http\Controllers;

use App\Models\Post;

class HomeController extends Controller
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
            ->paginate(6);

        return view('pages.home', compact('posts', 'bannerPosts'));
    }
}

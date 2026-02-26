<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $bannerPosts = Post::with('category')->latest()->take(5)->get();
        $posts = Post::with('category')->latest()->paginate(6);
        $recentPosts = Post::with('category')->latest()->take(5)->get();
        $categories = Category::all();

        return view('pages.home', compact('bannerPosts', 'posts', 'recentPosts', 'categories'));
    }
}
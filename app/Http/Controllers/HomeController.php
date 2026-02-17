<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category; // Bunu eklemeyi unutma

class HomeController extends Controller
{
    public function index()
    {
        // Banner posts
        $bannerPosts = Post::with('category')
            ->latest()
            ->take(5)
            ->get();

        // Normal posts
        $posts = Post::with('category')
            ->latest()
            ->paginate(6);

        // Sidebar verileri
        $recentPosts = Post::latest()->take(5)->get();
        $categories = Category::all();               

        return view('pages.home', compact(
            'posts',
            'bannerPosts',
            'recentPosts',
            'categories'
        ));
    }
}

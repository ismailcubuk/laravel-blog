<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;

class PostController extends Controller

{

    // MAİN
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

        return view('welcome', compact('posts', 'bannerPosts'));
    }



    // POST DETAİL

public function show($slug)
{
    $post = Post::with('category')
        ->where('slug', $slug)
        ->firstOrFail();

    $recentPosts = Post::latest()
        ->take(5)
        ->get();

    $categories = Category::all();

    return view('posts.show', compact(
        'post',
        'recentPosts',
        'categories'
    ));
}


}

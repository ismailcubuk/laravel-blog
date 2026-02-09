<?php

namespace App\Http\Controllers;

use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(6);
        return view('pages.home', compact('posts'));
    }
}
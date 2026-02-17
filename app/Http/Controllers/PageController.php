<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }


public function blog()
    {
        $posts = Post::with('category')
            ->latest()
            ->paginate(6);

        return view('pages.blog', compact('posts'));
    }
}
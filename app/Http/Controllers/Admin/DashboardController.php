<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;

class DashboardController extends Controller
{
    public function index()
    {
        $latestPosts = Post::latest()->take(4)->get();

        return view('admin.dashboard', compact('latestPosts'));
    }
}

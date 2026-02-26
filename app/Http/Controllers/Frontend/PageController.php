<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\Post;

class PageController extends Controller
{
    // BLOG PAGE
    public function blog()
    {
        $posts = Post::with('category')->latest()->paginate(6);
        $recentPosts = Post::with('category')->latest()->take(5)->get();
        $categories = Category::all();

        return view('pages.blog', compact('posts', 'recentPosts', 'categories'));
    }

    // CONTACT PAGE
    public function contact()
    {
        $page = Page::firstOrCreate(
            ['slug' => 'contact'],
            [
                'title' => 'Contact',
                'contact_phone' => '',
                'contact_email' => '',
                'contact_address' => '',
                'contact_map_iframe' => ''
            ]
        );

        return view('pages.contact', compact('page'));
    }

    // ABOUT PAGE
    public function about()
    {
        $page = Page::firstOrCreate(
            ['slug' => 'about-us'],
            [
                'title' => 'About Us',
                'description' => 'ABOUT US',
                'hero_image' => '/assets/images/about-us.jpg'
            ]
        );

        $sections = PageSection::where('page_id', $page->id)
            ->orderBy('section_order')
            ->orderBy('column_index')
            ->get()
            ->groupBy('section_order');

        return view('pages.about', compact('page', 'sections'));
    }
}
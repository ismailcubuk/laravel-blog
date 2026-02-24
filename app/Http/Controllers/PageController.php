<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\Post;

class PageController extends Controller
{
    public function blog()
    {
        $posts = Post::with('category')
            ->latest()
            ->paginate(6);

        return view('pages.blog', compact('posts'));
    }
    public function contact()
{
    return view('pages.contact');
}

    public function about()
    {

        // PAGE
        $page = Page::firstOrCreate(
            ['slug' => 'about-us'],
            [
                'title' => 'About Us',
                'description' => 'ABOUT US',
                'hero_image' => '/assets/images/about-us.jpg'
            ]
        );


        // SECTİONS
        $sections = PageSection::where('page_id', $page->id)
            ->orderBy('section_order')
            ->orderBy('column_index')
            ->get()
            ->groupBy('section_order');


        // VİEWS
       return view('pages.about', compact('page', 'sections'));

    }

}
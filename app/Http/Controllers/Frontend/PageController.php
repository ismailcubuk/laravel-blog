<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\Post;

class PageController extends Controller
{
    // BLOG PAGE
    public function blog(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $categoryId = $request->query('category');

        $posts = Post::with('category')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('title', 'like', '%' . $search . '%')
                        ->orWhere('content', 'like', '%' . $search . '%');
                });
            })
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->latest()
            ->paginate(6)
            ->withQueryString();

        $recentPosts = Post::with('category')->latest()->take(5)->get();
        $categories = Category::query()
            ->withCount('posts')
            ->having('posts_count', '>', 0)
            ->orderByDesc('posts_count')
            ->orderBy('name')
            ->get();

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

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\Post;
use App\Models\Setting;
use App\Services\Mail\MailWorkflowService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function blog(Request $request)
    {
        return $this->renderBlog($request);
    }

    public function category(Request $request, Category $category)
    {
        return $this->renderBlog($request, $category);
    }

    protected function renderBlog(Request $request, ?Category $activeCategory = null)
    {
        $search = trim((string) $request->query('search', ''));
        $categoryId = $activeCategory?->id ?: $request->query('category');

        $posts = Post::with(['category', 'user'])
            ->published()
            ->withCount(['comments as approved_comments_count' => fn ($query) => $query->approved()])
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

        $recentPosts = Post::with(['category', 'user'])
            ->published()
            ->withCount(['comments as approved_comments_count' => fn ($query) => $query->approved()])
            ->latest()
            ->take(5)
            ->get();
        $categories = Category::query()
            ->withCount(['posts' => fn ($query) => $query->published()])
            ->whereHas('posts', fn ($query) => $query->published())
            ->orderByDesc('posts_count')
            ->orderBy('name')
            ->get();
        $activeCategory = $activeCategory ?: ($categoryId ? $categories->firstWhere('id', (int) $categoryId) : null);

        return view('pages.blog', compact('posts', 'recentPosts', 'categories', 'search', 'activeCategory'));
    }

    public function contact()
    {
        $page = Page::firstOrCreate(
            ['slug' => 'contact'],
            [
                'title' => 'Contact',
                'contact_phone' => '',
                'contact_email' => '',
                'contact_address' => '',
                'contact_map_src' => '',
            ]
        );

        return view('pages.contact', compact('page'));
    }

    public function submitContact(Request $request, MailWorkflowService $mailWorkflow): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:3000'],
            'website' => ['nullable', 'prohibited'],
        ]);

        $contactPage = Page::firstWhere('slug', 'contact');
        $fallbackEmail = Setting::get('mail_from_address', config('mail.from.address'));
        $toEmail = $contactPage?->contact_email ?: $fallbackEmail;

        ContactMessage::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'user_id' => auth()->id(),
            'subject' => $data['subject'] ?? null,
            'message' => $data['message'],
        ]);

        $mailWorkflow->sendContactFormMessageToSite($toEmail, [
            'name' => $data['name'],
            'email' => $data['email'],
            'subject' => $data['subject'] ?? null,
            'message' => $data['message'],
        ]);

        return back()->with('success', 'Mesajınız başarıyla gönderildi.');
    }

    public function about()
    {
        $page = Page::firstOrCreate(
            ['slug' => 'about-us'],
            [
                'title' => 'About Us',
                'description' => 'ABOUT US',
                'hero_image' => '/assets/images/about-us.jpg',
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

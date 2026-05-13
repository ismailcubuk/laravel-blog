<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class UserPostController extends Controller
{
    public function index(Request $request)
    {
        $filters = $this->postFilters($request);

        $posts = Post::query()
            ->withAvailableRelations(['category', 'tags'])
            ->withCount(['comments as approved_comments_count' => fn ($query) => $query->approved()])
            ->where('user_id', $request->user()->id)
            ->whereIn('status', ['pending', 'published'])
            ->when($filters['search'] !== '', fn ($query) => $query->where(function ($inner) use ($filters) {
                $inner->where('title', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('content', 'like', '%' . $filters['search'] . '%');
            }))
            ->when($filters['category_id'] !== '', fn ($query) => $query->where('category_id', $filters['category_id']))
            ->orderBy($filters['sort_column'], $filters['sort_direction'])
            ->paginate(8)
            ->withQueryString();

        return view('pages.posts.mine', [
            'posts' => $posts,
            'mode' => 'published',
            'categories' => $this->userPostCategories($request),
            'filters' => $filters,
        ]);
    }

    public function drafts(Request $request)
    {
        $filters = $this->postFilters($request, 'updated_desc');

        $posts = Post::query()
            ->withAvailableRelations(['category', 'tags'])
            ->where('user_id', $request->user()->id)
            ->where('status', 'draft')
            ->when($filters['search'] !== '', fn ($query) => $query->where(function ($inner) use ($filters) {
                $inner->where('title', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('content', 'like', '%' . $filters['search'] . '%');
            }))
            ->when($filters['category_id'] !== '', fn ($query) => $query->where('category_id', $filters['category_id']))
            ->orderBy($filters['sort_column'], $filters['sort_direction'])
            ->paginate(8)
            ->withQueryString();

        return view('pages.posts.mine', [
            'posts' => $posts,
            'mode' => 'draft',
            'categories' => $this->userPostCategories($request),
            'filters' => $filters,
        ]);
    }

    public function comments(Request $request)
    {
        $comments = Comment::query()
            ->with(['post.category', 'post.user'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('pages.posts.comments', compact('comments'));
    }

    public function publishDraft(Request $request, Post $post)
    {
        abort_unless((int) $post->user_id === (int) $request->user()->id, 403);
        abort_unless($post->status === 'draft', 404);

        $post->update([
            'status' => 'pending',
        ]);

        return redirect()
            ->route('user.posts.index')
            ->with('success', 'Taslak admin onayina gonderildi.');
    }

    public function create()
    {
        $categories = Category::query()
            ->orderBy('name')
            ->get();
        $tags = Post::tagsTableExists() ? Tag::query()->orderBy('name')->get() : collect();

        return view('pages.posts.create', compact('categories', 'tags'));
    }

    public function edit(Request $request, Post $post)
    {
        abort_unless((int) $post->user_id === (int) $request->user()->id, 403);
        abort_unless($post->status === 'draft', 404);

        if (Post::tagsTableExists()) {
            $post->loadMissing('tags');
        }

        $categories = Category::query()
            ->orderBy('name')
            ->get();
        $tags = Post::tagsTableExists() ? Tag::query()->orderBy('name')->get() : collect();

        return view('pages.posts.create', compact('categories', 'tags', 'post'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'category_id' => ['required', 'exists:categories,id'],
            'content' => ['required', 'string', 'min:20', 'max:20000'],
            'tags' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:10240', 'dimensions:max_width=5000,max_height=5000'],
            'status' => ['required', 'in:published,draft'],
        ]);

        $post = new Post([
            'title' => trim($validated['title']),
            'slug' => $this->uniqueSlug($validated['title']),
            'category_id' => $validated['category_id'],
            'content' => $this->normalizeContent($validated['content']),
            'user_id' => $request->user()->id,
            'status' => $validated['status'] === 'published' ? 'pending' : 'draft',
        ]);

        if ($request->hasFile('image')) {
            $post->image = $this->storePublicUpload($request->file('image'));
        }

        $post->save();
        $this->syncTags($post, $validated['tags'] ?? '');

        if ($post->status === 'pending') {
            return redirect()
                ->route('user.posts.index')
                ->with('success', 'Yazınız admin onayına gönderildi.');
        }

        return redirect()
            ->route('user.posts.drafts')
            ->with('success', 'Taslak kaydedildi.');
    }

    public function update(Request $request, Post $post)
    {
        abort_unless((int) $post->user_id === (int) $request->user()->id, 403);
        abort_unless($post->status === 'draft', 404);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'category_id' => ['required', 'exists:categories,id'],
            'content' => ['required', 'string', 'min:20', 'max:20000'],
            'tags' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:10240', 'dimensions:max_width=5000,max_height=5000'],
            'status' => ['required', 'in:published,draft'],
        ]);

        $post->fill([
            'title' => trim($validated['title']),
            'category_id' => $validated['category_id'],
            'content' => $this->normalizeContent($validated['content']),
            'status' => $validated['status'] === 'published' ? 'pending' : 'draft',
        ]);

        if ($request->hasFile('image')) {
            $post->image = $this->storePublicUpload($request->file('image'));
        }

        $post->save();
        $this->syncTags($post, $validated['tags'] ?? '');

        if ($post->status === 'pending') {
            return redirect()
                ->route('user.posts.index')
                ->with('success', 'Taslak admin onayına gönderildi.');
        }

        return redirect()
            ->route('user.posts.drafts')
            ->with('success', 'Taslak güncellendi.');
    }

    private function uniqueSlug(string $title): string
    {
        $baseSlug = Str::slug($title) ?: 'yazi-' . now()->format('YmdHis');
        $slug = $baseSlug;
        $suffix = 2;

        while (Post::query()->where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $suffix;
            $suffix++;
        }

        return $slug;
    }

    private function normalizeContent(string $content): string
    {
        return trim(str_replace(["\r\n", "\r"], "\n", $content));
    }

    private function syncTags(Post $post, string $tagInput): void
    {
        if (!Post::tagsTableExists()) {
            return;
        }

        $tagIds = collect(preg_split('/[,;\n]+/', $tagInput) ?: [])
            ->map(fn ($tag) => trim($tag))
            ->filter()
            ->unique(fn ($tag) => Str::lower($tag))
            ->take(12)
            ->map(function (string $name) {
                $slug = Str::slug($name);

                if ($slug === '') {
                    return null;
                }

                return Tag::firstOrCreate(['slug' => $slug], ['name' => $name])->id;
            })
            ->filter()
            ->values()
            ->all();

        $post->tags()->sync($tagIds);
    }

    private function storePublicUpload(UploadedFile $file): string
    {
        $filename = $file->hashName();
        $destination = $this->resolveUploadDestination();

        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $file->move($destination, $filename);

        return 'storage/uploads/' . $filename;
    }

    private function resolveUploadDestination(): string
    {
        $preferred = base_path('../storage/uploads');
        $fallback = public_path('storage/uploads');

        return is_dir(dirname($preferred)) ? $preferred : $fallback;
    }

    private function postFilters(Request $request, string $defaultSort = 'newest'): array
    {
        $sort = (string) $request->query('sort', $defaultSort);
        $allowedSorts = [
            'newest' => ['created_at', 'desc'],
            'oldest' => ['created_at', 'asc'],
            'updated_desc' => ['updated_at', 'desc'],
            'title_asc' => ['title', 'asc'],
        ];

        if (!array_key_exists($sort, $allowedSorts)) {
            $sort = $defaultSort;
        }

        [$sortColumn, $sortDirection] = $allowedSorts[$sort];

        return [
            'search' => trim((string) $request->query('search', '')),
            'category_id' => trim((string) $request->query('category_id', '')),
            'sort' => $sort,
            'sort_column' => $sortColumn,
            'sort_direction' => $sortDirection,
        ];
    }

    private function userPostCategories(Request $request)
    {
        return Category::query()
            ->whereHas('posts', fn ($query) => $query->where('user_id', $request->user()->id))
            ->orderBy('name')
            ->get();
    }
}

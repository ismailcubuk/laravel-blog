<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminPostController extends Controller
{
    // Listeleme
    public function index(Request $request)
    {
        $allowedSorts = ['title', 'author', 'category', 'created_at'];
        $sort = (string) $request->query('sort', 'created_at');
        $direction = strtolower((string) $request->query('direction', 'desc'));

        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'desc';
        }

        $sortColumn = match ($sort) {
            'author' => 'users.name',
            'category' => 'categories.name',
            default => 'posts.' . $sort,
        };

        $posts = Post::query()
            ->leftJoin('users', 'users.id', '=', 'posts.user_id')
            ->leftJoin('categories', 'categories.id', '=', 'posts.category_id')
            ->select('posts.*')
            ->withAvailableRelations(['category', 'user', 'tags'])
            ->where('posts.status', 'published')
            ->where('users.role', 'admin')
            ->orderBy($sortColumn, $direction)
            ->paginate(10)
            ->withQueryString();

        return view('admin.content.posts.index', [
            'posts' => $posts,
            'sort' => $sort,
            'direction' => $direction,
        ]);
    }

    // Create form
    public function create()
    {
        $categories = Category::all();
        $tags = Post::tagsTableExists() ? Tag::query()->orderBy('name')->get() : collect();

        return view('admin.content.posts.create', [
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    // Edit form
    public function edit(Post $post)
    {
        $categories = Category::all();
        $post->loadMissing(['category', 'user']);
        if (Post::tagsTableExists()) {
            $post->loadMissing('tags');
        }

        $tags = Post::tagsTableExists() ? Tag::query()->orderBy('name')->get() : collect();

        return view('admin.content.posts.edit', [
            'post' => $post,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    // Store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:posts,slug',
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:320',
            'canonical_url' => 'nullable|url|max:255',
            'og_image' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240|dimensions:max_width=5000,max_height=5000',
            'tags' => 'nullable|string|max:500',
            'is_featured' => 'nullable|boolean',
        ]);

        $validated['user_id'] = auth()->id();
        if (Post::featuredColumnsExist()) {
            $validated['is_featured'] = $request->boolean('is_featured');
            $validated['featured_at'] = $validated['is_featured'] ? now() : null;
        } else {
            unset($validated['is_featured']);
        }

        if (!Post::seoColumnsExist()) {
            unset($validated['meta_title'], $validated['meta_description'], $validated['canonical_url'], $validated['og_image']);
        }

        $tagInput = $validated['tags'] ?? '';
        unset($validated['tags']);

        $post = new Post($validated);

        if ($request->hasFile('image')) {
            $post->image = $this->storePublicUpload($request->file('image'));
        }

        $post->save();
        $this->syncTags($post, $tagInput);

        return redirect()->route('admin.content.posts.index')
            ->with('success', 'Yazı başarıyla oluşturuldu.');
    }

    // Update
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:posts,slug,'.$post->id,
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:320',
            'canonical_url' => 'nullable|url|max:255',
            'og_image' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240|dimensions:max_width=5000,max_height=5000',
            'tags' => 'nullable|string|max:500',
            'is_featured' => 'nullable|boolean',
        ]);

        if (Post::featuredColumnsExist()) {
            $validated['is_featured'] = $request->boolean('is_featured');
            $validated['featured_at'] = $validated['is_featured']
                ? ($post->featured_at ?: now())
                : null;
        } else {
            unset($validated['is_featured']);
        }

        if (!Post::seoColumnsExist()) {
            unset($validated['meta_title'], $validated['meta_description'], $validated['canonical_url'], $validated['og_image']);
        }

        $tagInput = $validated['tags'] ?? '';
        unset($validated['tags']);

        $post->update($validated);
        $this->syncTags($post, $tagInput);

        if ($request->hasFile('image')) {
            $this->deleteStorageAsset($post->image);
            $post->image = $this->storePublicUpload($request->file('image'));
            $post->save();
        }

        return redirect()->route('admin.content.posts.index')
            ->with('success', 'Yazı başarıyla güncellendi.');
    }

    // Delete
    public function destroy(Post $post)
    {
        $this->deleteStorageAsset($post->image);
        $post->delete();

        return redirect()->route('admin.content.posts.index')
            ->with('success', 'Yazı silindi.');
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
                $slug = Str::slug($name) ?: Str::slug(Str::limit($name, 30, ''));

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

    private function deleteStorageAsset(?string $assetPath): void
    {
        if (!$assetPath || !str_starts_with($assetPath, 'storage/')) {
            return;
        }

        $relativePath = ltrim(substr($assetPath, 8), '/');
        if ($relativePath === '' || str_contains($relativePath, '..')) {
            return;
        }

        $candidates = [
            base_path('../storage/' . $relativePath),
            public_path('storage/' . $relativePath),
            storage_path('app/public/' . $relativePath),
        ];

        foreach ($candidates as $candidate) {
            if (is_file($candidate)) {
                @unlink($candidate);
            }
        }
    }

    private function storePublicUpload(\Illuminate\Http\UploadedFile $file): string
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
}

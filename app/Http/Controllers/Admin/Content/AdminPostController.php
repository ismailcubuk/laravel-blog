<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

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
            ->with(['category', 'user'])
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

        return view('admin.content.posts.create', [
            'categories' => $categories
        ]);
    }

    // Edit form
    public function edit(Post $post)
    {
        $categories = Category::all();

        return view('admin.content.posts.edit', [
            'post' => $post,
            'categories' => $categories
        ]);
    }

    // Store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:posts,slug',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240|dimensions:max_width=5000,max_height=5000'
        ]);

        $validated['user_id'] = auth()->id();

        $post = new Post($validated);

        if ($request->hasFile('image')) {
            $post->image = $this->storePublicUpload($request->file('image'));
        }

        $post->save();

        return redirect()->route('admin.content.posts.index')
            ->with('success', 'Post created successfully');
    }

    // Update
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:posts,slug,'.$post->id,
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240|dimensions:max_width=5000,max_height=5000'
        ]);

        $post->update($validated);

        if ($request->hasFile('image')) {
            $this->deleteStorageAsset($post->image);
            $post->image = $this->storePublicUpload($request->file('image'));
            $post->save();
        }

        return redirect()->route('admin.content.posts.index')
            ->with('success', 'Post updated successfully');
    }

    // Delete
    public function destroy(Post $post)
    {
        $this->deleteStorageAsset($post->image);
        $post->delete();

        return redirect()->route('admin.content.posts.index')
            ->with('success', 'Post deleted successfully');
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

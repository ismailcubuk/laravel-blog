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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $validated['user_id'] = auth()->id();

        $post = new Post($validated);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $post->image = '/uploads/'.$filename;
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $post->update($validated);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $post->image = '/uploads/'.$filename;
            $post->save();
        }

        return redirect()->route('admin.content.posts.index')
            ->with('success', 'Post updated successfully');
    }

    // Delete
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.content.posts.index')
            ->with('success', 'Post deleted successfully');
    }
}


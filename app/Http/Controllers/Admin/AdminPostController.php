<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    // Listeleme
    public function index()
    {
        $posts = Post::latest()->paginate(10);

        return view('admin.content.posts.index', [
            'posts' => $posts
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
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    // Listeleme ve form
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        $categories = Category::all();

        return view('admin.content.posts', [
            'posts' => $posts,
            'categories' => $categories
        ]);
    }

    // Edit form için
    public function edit(Post $post)
    {
        $posts = Post::latest()->paginate(10);
        $categories = Category::all();

        // Önemli: 'editPost' olarak gönderiyoruz
        return view('admin.content.posts', [
            'posts' => $posts,
            'categories' => $categories,
            'editPost' => $post
        ]);
    }

    // Create
    public function store(Request $request)
    {
        // 1️⃣ Validate
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:posts,slug',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        // 2️⃣ user_id ekle
        $validated['user_id'] = auth()->id();

        // 3️⃣ Post oluştur
        $post = new Post($validated);

        // 4️⃣ Image varsa kaydet
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $post->image = '/uploads/'.$filename;
        }

        $post->save();

        return redirect()->route('admin.content.posts')->with('success', 'Post created successfully');
    }

    // Update
    public function update(Request $request, Post $post)
    {
        // Validate
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:posts,slug,'.$post->id,
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        // Update user_id is optional; genelde değiştirmeyiz
        $post->update($validated);

        // Image varsa kaydet
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $post->image = '/uploads/'.$filename;
            $post->save();
        }

        return redirect()->route('admin.content.posts')->with('success', 'Post updated successfully');
    }

    // Delete
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.content.posts')->with('success', 'Post deleted successfully');
    }
}
<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected function isAdminViewer(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function index()
    {
        $bannerPosts = Post::with('category')
            ->withCount(['comments as approved_comments_count' => fn ($query) => $query->approved()])
            ->latest()
            ->take(5)
            ->get();

        $posts = Post::with('category')
            ->withCount(['comments as approved_comments_count' => fn ($query) => $query->approved()])
            ->latest()
            ->paginate(6);

        return view('pages.posts.index', compact('bannerPosts', 'posts'));
    }

    public function show(string $slug)
    {
        $commentStatuses = $this->isAdminViewer()
            ? ['approved', 'pending']
            : ['approved'];

        $post = Post::with([
                'category',
                'user',
                'comments' => fn ($query) => $query
                    ->whereIn('status', $commentStatuses)
                    ->latest(),
                'comments.user',
            ])
            ->withCount(['comments as approved_comments_count' => fn ($query) => $query->approved()])
            ->where('slug', $slug)
            ->firstOrFail();

        $recentPosts = Post::with('category')
            ->withCount(['comments as approved_comments_count' => fn ($query) => $query->approved()])
            ->latest()
            ->take(5)
            ->get();

        $categories = Category::all();

        return view('pages.posts.show', compact('post', 'recentPosts', 'categories'));
    }

    public function storeComment(Request $request, string $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:3|max:2000',
        ]);

        Comment::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'message' => $validated['message'],
            'status' => 'pending',
        ]);

        return redirect()->to(route('post.show', $post->slug) . '#comment-form')
            ->with('success', 'Your comment was submitted and is waiting for admin approval.');
    }

    public function storeReply(Request $request, string $slug, Comment $comment)
    {
        abort_unless($this->isAdminViewer(), 403);

        $post = Post::where('slug', $slug)->firstOrFail();
        abort_unless((int) $comment->post_id === (int) $post->id, 404);

        $validated = $request->validate([
            'reply_message' => 'required|string|min:2|max:2000',
        ]);

        $comment->update([
            'reply_message' => $validated['reply_message'],
            'replied_by_user_id' => auth()->id(),
            'replied_at' => now(),
        ]);

        return redirect()->to(route('post.show', $post->slug) . '#comments')
            ->with('success', 'Reply saved successfully.');
    }

    public function destroyReply(string $slug, Comment $comment)
    {
        abort_unless($this->isAdminViewer(), 403);

        $post = Post::where('slug', $slug)->firstOrFail();
        abort_unless((int) $comment->post_id === (int) $post->id, 404);

        $comment->update([
            'reply_message' => null,
            'replied_by_user_id' => null,
            'replied_at' => null,
        ]);

        return redirect()->to(route('post.show', $post->slug) . '#comments')
            ->with('success', 'Reply deleted successfully.');
    }
}

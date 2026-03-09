<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class AdminCommentController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $postId = $request->query('post');
        $search = trim((string) $request->query('search', ''));

        $comments = Comment::with(['post.category', 'post.user', 'user', 'repliedBy'])
            ->when(in_array($status, ['pending', 'approved'], true), function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($postId, function ($query) use ($postId) {
                $query->where('post_id', $postId);
            })
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('message', 'like', '%' . $search . '%')
                        ->orWhereHas('post', function ($postQuery) use ($search) {
                            $postQuery->where('title', 'like', '%' . $search . '%');
                        });
                });
            })
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.content.comments', [
            'comments' => $comments,
            'posts' => Post::query()->orderBy('title')->get(['id', 'title']),
            'filters' => [
                'status' => $status,
                'post' => $postId,
                'search' => $search,
            ],
            'stats' => [
                'total' => Comment::count(),
                'pending' => Comment::where('status', 'pending')->count(),
                'approved' => Comment::where('status', 'approved')->count(),
            ],
        ]);
    }

    public function updateStatus(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved',
        ]);

        $comment->update([
            'status' => $validated['status'],
        ]);

        return redirect()->back()->with('success', 'Comment status updated.');
    }

    public function storeReply(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'reply_message' => 'required|string|min:2|max:2000',
        ]);

        $comment->update([
            'reply_message' => $validated['reply_message'],
            'replied_by_user_id' => auth()->id(),
            'replied_at' => now(),
        ]);

        return redirect()->route('admin.content.comments', $request->query())
            ->with('success', 'Reply published successfully.');
    }

    public function destroyReply(Request $request, Comment $comment)
    {
        $comment->update([
            'reply_message' => null,
            'replied_by_user_id' => null,
            'replied_at' => null,
        ]);

        return redirect()->route('admin.content.comments', $request->query())
            ->with('success', 'Reply deleted successfully.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted.');
    }
}

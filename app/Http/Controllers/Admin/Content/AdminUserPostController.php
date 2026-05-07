<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class AdminUserPostController extends Controller
{
    public function index(Request $request)
    {
        $status = (string) $request->query('status', '');
        $search = trim((string) $request->query('search', ''));

        $posts = Post::query()
            ->with(['user:id,name,email,avatar_path,role', 'category:id,name'])
            ->whereHas('user', fn ($query) => $query->where('role', 'user'))
            ->whereIn('status', ['pending', 'published'])
            ->when(in_array($status, ['pending', 'published'], true), fn ($query) => $query->where('status', $status))
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('title', 'like', '%' . $search . '%')
                        ->orWhere('content', 'like', '%' . $search . '%')
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%');
                        });
                });
            })
            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        $baseQuery = Post::query()
            ->whereHas('user', fn ($query) => $query->where('role', 'user'))
            ->whereIn('status', ['pending', 'published']);

        return view('admin.content.user-posts', [
            'posts' => $posts,
            'filters' => [
                'status' => $status,
                'search' => $search,
            ],
            'stats' => [
                'total' => (clone $baseQuery)->count(),
                'pending' => (clone $baseQuery)->where('status', 'pending')->count(),
                'approved' => (clone $baseQuery)->where('status', 'published')->count(),
            ],
        ]);
    }

    public function updateStatus(Request $request, Post $post)
    {
        abort_unless($post->user && $post->user->role === 'user', 404);

        $validated = $request->validate([
            'status' => ['required', 'in:pending,published'],
        ]);

        $post->update([
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'User post status updated.');
    }

    public function destroy(Post $post)
    {
        abort_unless($post->user && $post->user->role === 'user', 404);

        $post->delete();

        return back()->with('success', 'User post deleted.');
    }
}

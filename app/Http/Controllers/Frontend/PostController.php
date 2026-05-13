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
        $bannerPosts = Post::query()
            ->withAvailableRelations(['category', 'user', 'tags'])
            ->published()
            ->withCount(['comments as approved_comments_count' => fn ($query) => $query->approved()])
            ->latest()
            ->take(5)
            ->get();

        $posts = Post::query()
            ->withAvailableRelations(['category', 'user', 'tags'])
            ->published()
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

        $post = Post::query()
            ->withAvailableRelations([
                'category',
                'user',
                'tags',
            ])
            ->withCount(['comments as approved_comments_count' => fn ($query) => $query->approved()])
            ->where('slug', $slug)
            ->firstOrFail();

        abort_unless(
            $post->isPublished()
                || $this->isAdminViewer()
                || (auth()->check() && (int) auth()->id() === (int) $post->user_id),
            404
        );

        $comments = $post->comments()
            ->with(['user', 'repliedBy'])
            ->whereIn('status', $commentStatuses)
            ->oldest()
            ->orderBy('id')
            ->get();

        $commentsByParent = $comments->groupBy(fn (Comment $comment) => $comment->parent_id ?: 0);
        $attachReplies = function ($items) use (&$attachReplies, $commentsByParent) {
            return $items->map(function (Comment $comment) use (&$attachReplies, $commentsByParent) {
                $comment->setRelation('threadReplies', $attachReplies($commentsByParent->get($comment->id, collect())));

                return $comment;
            });
        };

        $topLevelComments = $commentsByParent->get(0, collect())
            ->sort(function (Comment $first, Comment $second) {
                return $second->created_at->getTimestamp() <=> $first->created_at->getTimestamp() ?: $second->id <=> $first->id;
            })
            ->values();

        $post->setRelation('comments', $attachReplies($topLevelComments));
        $post->setAttribute('visible_comments_count', $comments->count());

        $recentPosts = Post::with('category')
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
        $postTags = $post->relationLoaded('tags') ? $post->tags : collect();
        $relatedPosts = Post::query()
            ->withAvailableRelations(['category', 'user', 'tags'])
            ->published()
            ->withCount(['comments as approved_comments_count' => fn ($query) => $query->approved()])
            ->whereKeyNot($post->id)
            ->when($post->category_id || $postTags->isNotEmpty(), function ($query) use ($post, $postTags) {
                $query->where(function ($inner) use ($post, $postTags) {
                    $inner->when($post->category_id, fn ($categoryQuery) => $categoryQuery->where('category_id', $post->category_id))
                        ->when($postTags->isNotEmpty() && Post::tagsTableExists(), fn ($tagQuery) => $tagQuery->orWhereHas('tags', fn ($tagInner) => $tagInner->whereIn('tags.id', $postTags->pluck('id'))));
                });
            })
            ->latest()
            ->take(3)
            ->get();

        return view('pages.posts.show', compact('post', 'recentPosts', 'categories', 'relatedPosts'));
    }

    public function storeComment(Request $request, string $slug)
    {
        abort_unless(auth()->check() && in_array(auth()->user()->role, ['user', 'admin'], true), 403);

        $post = Post::published()->where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'message' => 'required|string|min:3|max:2000',
            'parent_id' => 'nullable|integer|exists:comments,id',
            'website' => 'nullable|prohibited',
        ]);

        $parent = null;
        if (!empty($validated['parent_id'])) {
            $parentQuery = Comment::query()->where('post_id', $post->id);

            if (auth()->user()->role !== 'admin') {
                $parentQuery->where('status', 'approved');
            }

            $parent = $parentQuery->findOrFail($validated['parent_id']);
        }

        Comment::create([
            'post_id' => $post->id,
            'parent_id' => $parent?->id,
            'user_id' => auth()->id(),
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'message' => $validated['message'],
            'status' => auth()->user()->role === 'admin' ? 'approved' : 'pending',
        ]);

        $message = auth()->user()->role === 'admin'
            ? 'Reply published successfully.'
            : 'Your comment has been submitted and is awaiting moderation.';

        $redirectAnchor = auth()->user()->role === 'admin' || $parent ? '#comments' : '#comment-form';

        return redirect()->to(route('post.show', $post->slug) . $redirectAnchor)
            ->with('success', $message);
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


<div class="col-12">
    <section class="dashboard-panel recent-comments-panel">
        <header class="dashboard-panel-header">
            <div>
                <h3 class="dashboard-panel-title">Latest Comments</h3>
                <p class="activity-panel-subtitle mb-0">Fast moderation from the latest user feedback.</p>
            </div>

            <div class="recent-comments-header-actions">
                <span class="badge recent-comments-pending-badge" id="recentCommentsPendingBadge" data-pending-count="{{ $pendingComments }}">
                    Pending: {{ $pendingComments }}
                </span>
                <a href="{{ route('admin.content.comments') }}" class="dashboard-panel-link">Manage All</a>
            </div>
        </header>

        <div class="recent-comments-list">
            @forelse($recentComments as $comment)
                <article class="recent-comment-item" data-comment-item data-comment-id="{{ $comment->id }}" data-status="{{ $comment->status }}">
                    <div class="recent-comment-main">
                        <div class="recent-comment-topline">
                            <strong class="recent-comment-author">{{ $comment->name }}</strong>
                            <span class="recent-comment-email">{{ $comment->email }}</span>
                            <span class="badge recent-comment-status {{ $comment->status === 'approved' ? 'is-approved' : 'is-pending' }}" data-role="status-badge">
                                {{ $comment->status === 'approved' ? 'Approved' : 'Pending' }}
                            </span>
                        </div>

                        <p class="recent-comment-message">
                            {{ \Illuminate\Support\Str::limit($comment->message, 170) }}
                        </p>

                        <div class="recent-comment-meta">
                            <span class="recent-comment-time">
                                <i class="fa fa-clock"></i>
                                {{ optional($comment->created_at)->diffForHumans() }}
                            </span>

                            @if($comment->post)
                                <a href="{{ route('post.show', $comment->post->slug) }}" class="recent-comment-post-link" target="_blank" rel="noopener">
                                    <i class="fa fa-file-text-o"></i>
                                    {{ \Illuminate\Support\Str::limit($comment->post->title, 58) }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="recent-comment-actions">
                        <form method="POST" action="{{ route('admin.content.comments.status', $comment) }}" class="js-comment-status-form {{ $comment->status === 'approved' ? 'd-none' : '' }}" data-target-status="approved">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="btn btn-sm btn-success" data-role="approve-btn">Approve</button>
                        </form>

                        <form method="POST" action="{{ route('admin.content.comments.status', $comment) }}" class="js-comment-status-form {{ $comment->status === 'pending' ? 'd-none' : '' }}" data-target-status="pending">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="pending">
                            <button type="submit" class="btn btn-sm btn-warning" data-role="pending-btn">Set Pending</button>
                        </form>

                        <a href="{{ route('admin.content.comments', ['search' => $comment->email]) }}" class="btn btn-sm btn-outline-primary">
                            Details
                        </a>
                    </div>
                </article>
            @empty
                <div class="latest-post-empty p-3">No comments found yet.</div>
            @endforelse
        </div>
    </section>
</div>

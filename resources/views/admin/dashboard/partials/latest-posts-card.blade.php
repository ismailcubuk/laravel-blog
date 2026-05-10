<div class="col-lg-4">
    <section class="dashboard-panel latest-panel h-100">
        <header class="dashboard-panel-header">
            <h3 class="dashboard-panel-title">Latest Blog Posts</h3>
            <a href="{{ route('admin.content.posts.index') }}" class="dashboard-panel-link">Manage</a>
        </header>

        <div class="latest-posts-list">
            @forelse($latestPosts as $post)
                <a href="{{ route('post.show', $post->slug) }}" class="latest-post-item">
                    <img
                        src="{{ $post->image ? asset(ltrim($post->image, '/')) : asset('assets/images/default-post.jpg') }}"
                        alt="{{ $post->title }}"
                        class="latest-post-thumb"
                    >
                    <div class="latest-post-content">
                        <h4 class="latest-post-title">{{ $post->title }}</h4>
                        <p class="latest-post-meta">
                            <span>{{ optional($post->category)->name ?? 'Uncategorized' }}</span>
                            <span>-</span>
                            <span>{{ optional($post->created_at)->format('d.m.Y') }}</span>
                        </p>
                        <p class="latest-post-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 96) }}</p>
                    </div>
                </a>
            @empty
                <div class="latest-post-empty">No blog posts yet.</div>
            @endforelse
        </div>
    </section>
</div>

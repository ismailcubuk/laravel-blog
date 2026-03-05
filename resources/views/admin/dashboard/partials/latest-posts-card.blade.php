<div class="col-lg-6">
    <div class="card card-primary h-100 dashboard-card">
        <div class="card-header">
            <h3 class="card-title">Latest Blog Posts</h3>
        </div>
        <div class="card-body p-0 latest-posts-body">
            @forelse($latestPosts as $post)
                <div class="d-flex p-3 border-bottom">
                    <div class="me-3">
                        <img
                            src="{{ $post->image ? asset(ltrim($post->image, '/')) : 'https://picsum.photos/seed/' . $post->id . '/200/300' }}"
                            width="80"
                            height="80"
                            style="object-fit:cover; border-radius:6px;"
                        >
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="mb-1">{{ $post->title }}</h5>
                        <p class="mb-1 text-muted latest-post-excerpt">
                            {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 90) }}
                        </p>
                        <small class="text-secondary">
                            <i class="fa fa-calendar"></i> {{ optional($post->created_at)->format('d.m.Y') }}
                        </small>
                        <a href="{{ route('post.show', $post->slug) }}" class="d-inline-block ms-2">View</a>
                    </div>
                </div>
            @empty
                <div class="p-3 text-muted">Henüz blog yazısı bulunmuyor.</div>
            @endforelse
        </div>
    </div>
</div>

<div class="modal fade" id="allBlogPostsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content all-posts-modal-content">
            <div class="modal-header all-posts-modal-header">
                <h5 class="modal-title mb-0">All Blog Posts</h5>
                <div class="ms-auto me-2" style="width: 320px; max-width: 50vw;">
                    <input type="text" id="allPostsSearchInput" class="form-control form-control-sm" placeholder="Search posts...">
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="list-group list-group-flush" id="allPostsList">
                    @forelse($allPosts as $post)
                        <a
                            href="{{ route('post.show', $post->slug) }}"
                            class="list-group-item list-group-item-action all-posts-item"
                            data-search="{{ mb_strtolower($post->title . ' ' . strip_tags($post->content)) }}"
                        >
                            <div class="d-flex align-items-start">
                                <img
                                    src="{{ $post->image ? asset(ltrim($post->image, '/')) : asset('assets/images/blog-post-01.jpg') }}"
                                    alt="{{ $post->title }}"
                                    width="52"
                                    height="52"
                                    class="rounded me-3 flex-shrink-0"
                                    style="object-fit: cover;"
                                >
                                <div class="flex-grow-1">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $post->title }}</h6>
                                        <small class="text-muted">{{ optional($post->created_at)->format('d.m.Y') }}</small>
                                    </div>
                                    <p class="mb-1 text-muted small">by <strong>{{ optional($post->user)->name ?? 'Unknown Admin' }}</strong></p>
                                    <p class="mb-0 text-muted small">{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 120) }}</p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="p-4 text-center text-muted">No blog posts found.</div>
                    @endforelse
                </div>
                <div id="allPostsEmptyState" class="p-4 text-center text-muted d-none">
                    No posts match your search.
                </div>
            </div>
        </div>
    </div>
</div>

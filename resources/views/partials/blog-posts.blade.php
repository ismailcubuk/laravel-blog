<div class="front-post-list">
    @push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/extracted/partials-blog-posts.css') }}">
@endpush

    @forelse($posts as $post)
        <article class="front-post-card">
            <a class="front-post-image" href="{{ route('post.show', $post->slug) }}">
                <img src="{{ $post->image_url }}" alt="{{ $post->title }}" loading="{{ $loop->first ? 'eager' : 'lazy' }}" fetchpriority="{{ $loop->first ? 'high' : 'low' }}" decoding="async">
            </a>

            <div class="front-post-content">
                <span class="front-post-category">{{ $post->category->name ?? 'Genel' }}</span>

                <a class="front-post-title" href="{{ route('post.show', $post->slug) }}">
                    <h4>{{ $post->title }}</h4>
                </a>

                <ul class="front-post-meta">
                    <li>{{ $post->created_at->format('d.m.Y') }}</li>
                    <li>{{ $post->reading_time }} dk okuma</li>
                    <li>{{ $post->approved_comments_count ?? 0 }} yorum</li>
                </ul>

                <p class="front-post-excerpt">{{ Str::limit(strip_tags($post->content), 170) }}</p>

                <div class="front-post-footer">
                    <a href="{{ route('post.show', $post->slug) }}" class="front-btn">Devam Et</a>
                </div>
            </div>
        </article>
    @empty
        <article class="front-card p-4">
            <h5 class="mb-2">Henüz yazı bulunmuyor</h5>
            <p class="mb-0 text-muted">Yeni yazı eklendiğinde burada listelenecek.</p>
        </article>
    @endforelse
</div>



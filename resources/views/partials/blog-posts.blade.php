<div class="front-post-list">
    <style>
        .front-post-list .front-post-card {
            border: 1px solid var(--front-border);
            border-radius: 16px;
            background: var(--front-surface);
            box-shadow: 0 12px 26px rgba(16, 34, 63, 0.08);
            overflow: hidden;
            margin-bottom: 1rem;
        }

        .front-post-list .front-post-image {
            position: relative;
            display: block;
            overflow: hidden;
            background: var(--front-soft-bg);
        }

        .front-post-list .front-post-image img {
            width: 100%;
            height: 228px;
            object-fit: cover;
            display: block;
            transition: transform 0.25s ease;
        }

        .front-post-list .front-post-card:hover .front-post-image img {
            transform: scale(1.03);
        }

        .front-post-list .front-post-content {
            padding: 1rem 1.05rem;
        }

        .front-post-list .front-post-category {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            border: 1px solid var(--front-soft-border);
            background: var(--front-soft-bg);
            color: var(--front-primary);
            font-size: 0.74rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            padding: 0.34rem 0.68rem;
            margin-bottom: 0.65rem;
        }

        .front-post-list .front-post-title {
            color: var(--front-text);
            display: block;
            text-decoration: none;
        }

        .front-post-list .front-post-title h4 {
            margin: 0;
            font-size: 1.18rem;
            line-height: 1.35;
            font-weight: 800;
            color: inherit;
        }

        .front-post-list .front-post-title:hover {
            color: var(--front-primary);
            text-decoration: none;
        }

        .front-post-list .front-post-meta {
            margin: 0.75rem 0;
            padding: 0;
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .front-post-list .front-post-meta li {
            color: var(--front-muted);
            font-size: 0.82rem;
            font-weight: 700;
            position: relative;
            display: inline-flex;
            align-items: center;
        }

        .front-post-list .front-post-meta li + li {
            padding-left: 0.7rem;
        }

        .front-post-list .front-post-meta li + li::before {
            content: "";
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 1px;
            height: 0.9em;
            background: var(--front-soft-border);
        }

        .front-post-list .front-post-excerpt {
            margin: 0;
            color: var(--front-muted);
            font-size: 0.92rem;
            line-height: 1.7;
        }

        .front-post-list .front-post-footer {
            margin-top: 0.9rem;
        }
    </style>

    @forelse($posts as $post)
        <article class="front-post-card">
            <a class="front-post-image" href="{{ route('post.show', $post->slug) }}">
                <img src="{{ $post->image_url }}" alt="{{ $post->title }}">
            </a>

            <div class="front-post-content">
                <span class="front-post-category">{{ $post->category->name ?? 'Genel' }}</span>

                <a class="front-post-title" href="{{ route('post.show', $post->slug) }}">
                    <h4>{{ $post->title }}</h4>
                </a>

                <ul class="front-post-meta">
                    <li>{{ $post->created_at->format('d M Y') }}</li>
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
            <h5 class="mb-2">Henuz yazi bulunmuyor</h5>
            <p class="mb-0 text-muted">Yeni yazi eklendiginde burada listelenecek.</p>
        </article>
    @endforelse
</div>

<section class="front-hero-slider main-banner header-text">
    <style>
        .front-hero-slider {
            margin-bottom: 1.3rem;
        }

        .front-hero-slider .owl-stage-outer {
            border-radius: 18px;
        }

        .front-hero-slider .item {
            position: relative;
            min-height: 380px;
            border: 1px solid #dce4f2;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 16px 32px rgba(15, 31, 58, 0.2);
            background: #0f1f3a;
        }

        .front-hero-slider .item > img {
            width: 100%;
            height: 380px;
            object-fit: cover;
            display: block;
        }

        .front-hero-slider .item::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(10, 21, 40, 0.12) 0%, rgba(10, 21, 40, 0.78) 100%);
            pointer-events: none;
        }

        .front-hero-slider .item-content {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 2;
            padding: 1.2rem 1.2rem 1.35rem;
        }

        .front-hero-slider .meta-category span {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.24);
            color: #fff;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            padding: 0.35rem 0.7rem;
            margin-bottom: 0.75rem;
        }

        .front-hero-slider .main-content h4 {
            margin: 0;
            font-size: 1.65rem;
            line-height: 1.25;
            font-weight: 800;
            letter-spacing: -0.01em;
            color: #fff;
        }

        .front-hero-slider .post-info {
            margin-top: 0.8rem;
            list-style: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 0.7rem;
        }

        .front-hero-slider .post-info li,
        .front-hero-slider .post-info li a {
            color: rgba(255, 255, 255, 0.88);
            font-size: 0.82rem;
            font-weight: 700;
        }

        .front-hero-slider .post-info li a:hover,
        .front-hero-slider .main-content h4:hover {
            color: #d4e4ff;
            text-decoration: none;
        }

        @media (max-width: 991.98px) {
            .front-hero-slider .item,
            .front-hero-slider .item > img {
                height: 320px;
                min-height: 320px;
            }

            .front-hero-slider .main-content h4 {
                font-size: 1.25rem;
            }
        }
    </style>

    <div class="container-fluid">
        <div class="owl-banner owl-carousel">
            @foreach($bannerPosts as $post)
                <div class="item">
                    <a href="{{ route('post.show', $post->slug) }}">
                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}">
                    </a>

                    <div class="item-content">
                        <div class="main-content">
                            <div class="meta-category">
                                <span>{{ $post->category->name ?? 'Genel' }}</span>
                            </div>

                            <a href="{{ route('post.show', $post->slug) }}">
                                <h4>{{ $post->title }}</h4>
                            </a>

                            <ul class="post-info">
                                <li><a href="#">{{ $post->created_at->format('d M Y') }}</a></li>
                                <li><a href="{{ route('post.show', $post->slug) }}#comments">{{ $post->approved_comments_count ?? 0 }} yorum</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

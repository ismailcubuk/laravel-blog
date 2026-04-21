@extends('layouts.main')

@section('title', 'Blog')

@section('content')

    <style>
        .blog-grid .blog-card-col {
            display: flex;
            margin-bottom: 1.2rem;
        }

        .blog-grid .blog-post {
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 100%;
            border: 1px solid var(--front-border);
            border-radius: 18px;
            overflow: hidden;
            background: var(--front-surface);
            box-shadow: 0 14px 28px rgba(10, 22, 42, 0.16);
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .blog-grid .blog-post:hover {
            transform: translateY(-3px);
            box-shadow: 0 18px 34px rgba(10, 22, 42, 0.22);
            border-color: var(--front-soft-border);
        }

        .blog-grid .blog-thumb {
            display: block;
            width: 100%;
            aspect-ratio: 16 / 10;
            overflow: hidden;
            background: var(--front-soft-bg);
        }

        .blog-grid .blog-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.25s ease;
        }

        .blog-grid .blog-post:hover .blog-thumb img {
            transform: scale(1.04);
        }

        .blog-grid .down-content {
            display: flex;
            flex-direction: column;
            flex: 1;
            padding: 1rem 1rem 1.05rem;
        }

        .blog-grid .down-content > span {
            align-self: flex-start;
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            border: 1px solid var(--front-soft-border);
            background: var(--front-soft-bg);
            color: var(--front-primary);
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            padding: 0.32rem 0.62rem;
            margin-bottom: 0.7rem;
        }

        .blog-grid .down-content h4 {
            margin: 0;
            color: var(--front-text);
            font-size: 1.3rem;
            font-weight: 800;
            line-height: 1.35;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 3.5rem;
        }

        .blog-grid .down-content .post-info {
            margin: 0.72rem 0 0.85rem;
            padding: 0;
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            gap: 0.6rem;
        }

        .blog-grid .down-content .post-info li,
        .blog-grid .down-content .post-info li a {
            color: var(--front-muted);
            font-size: 0.82rem;
            font-weight: 700;
            text-decoration: none;
        }

        .blog-grid .down-content p {
            margin: 0;
            color: var(--front-muted);
            line-height: 1.7;
            font-size: 0.93rem;
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 6.35rem;
        }

        .blog-grid .post-options {
            margin-top: auto;
            padding-top: 0.95rem;
            border-top: 1px solid var(--front-border);
        }

        .blog-grid .post-tags {
            margin: 0;
            padding: 0;
            list-style: none;
            display: flex;
            align-items: center;
            gap: 0.48rem;
            color: var(--front-muted);
            font-size: 0.83rem;
            font-weight: 700;
        }

        .blog-grid .post-tags li {
            margin: 0;
        }

        .blog-grid .post-tags li a {
            color: var(--front-primary);
            text-decoration: none;
            font-weight: 700;
        }

        .blog-grid .post-tags li a:hover {
            text-decoration: underline;
        }
    </style>

    <div class="heading-page header-text">
        <section class="page-heading">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-content">
                            <h4>Recent Posts</h4>
                            <h2>Our Recent Blog Entries</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <section class="blog-posts grid-system">
        <div class="container">
            <div class="row">

                {{-- POSTS --}}
                <div class="col-lg-8">
                    <div class="all-blog-posts">
                        <div class="row blog-grid">

                            @foreach($posts as $post)

                                <div class="col-lg-6 blog-card-col">
                                    <div class="blog-post">

                                        {{-- image --}}
                                        <a class="blog-thumb" href="{{ route('post.show', $post->slug) }}">
                                            <img src="{{ $post->image_url }}" alt="{{ $post->title }}">
                                        </a>

                                        <div class="down-content">

                                            {{-- category --}}
                                            <span>
                                                {{ $post->category->name ?? 'No Category' }}
                                            </span>

                                            {{-- title --}}
                                            <a href="{{ route('post.show', $post->slug) }}">
                                                <h4>{{ $post->title }}</h4>
                                            </a>

                                            {{-- info --}}
                                            <ul class="post-info">
                                                <li><a href="#">Admin</a></li>
                                                <li>
                                                    <a href="#">
                                                        {{ $post->created_at->format('d M Y') }}
                                                    </a>
                                                </li>
                                            </ul>

                                            {{-- content --}}
                                            <p>
                                                {{ Str::limit(strip_tags((string) $post->content), 140) }}
                                            </p>
                                            <div class="post-options">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <ul class="post-tags">
                                                            <li><i class="fa fa-tags"></i></li>
                                                            <li><a href="{{ route('blog', ['category' => $post->category_id]) }}">{{ $post->category->name ?? 'Genel' }}</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                            @endforeach

                            {{-- PAGINATION --}}
                            {{ $posts->links('vendor.pagination.templatemo') }}

                        </div>
                    </div>
                </div>


                {{-- SIDEBAR --}}
                <div class="col-lg-4">
                    <div class="sidebar">
                        <div class="row">

                            {{-- search --}}
                            <div class="col-lg-12">
                                <div class="sidebar-item search">
                                    <form method="GET" action="{{ route('blog') }}">
                                        <input type="text" name="search" class="searchText" placeholder="Search..." value="{{ request('search') }}">
                                    </form>
                                </div>
                            </div>


                            {{-- recent posts --}}
                            <div class="col-lg-12">
                                <div class="sidebar-item recent-posts">
                                    <div class="sidebar-heading">
                                        <h2>Recent Posts</h2>
                                    </div>

                                    <div class="content">
                                        <ul>

                                            @foreach($posts->take(5) as $recent)

                                                <li>
                                                    <a href="{{ route('post.show', $recent->slug) }}">
                                                        <h5>{{ $recent->title }}</h5>
                                                        <span>
                                                            {{ $recent->created_at->format('d M Y') }}
                                                        </span>
                                                    </a>
                                                </li>

                                            @endforeach

                                        </ul>
                                    </div>

                                </div>
                            </div>


                            {{-- categories --}}
                            <div class="col-lg-12">
                                <div class="sidebar-item categories">
                                    <div class="sidebar-heading">
                                        <h2>Categories</h2>
                                    </div>

                                    <div class="content">
                                        <ul>

                                            @foreach($categories as $category)

                                                <li>
                                                    <a href="{{ route('blog', ['category' => $category->id]) }}">
                                                        - {{ $category->name }} ({{ $category->posts_count ?? 0 }})
                                                    </a>
                                                </li>

                                            @endforeach

                                        </ul>
                                    </div>

                                </div>
                            </div>


                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>

@endsection

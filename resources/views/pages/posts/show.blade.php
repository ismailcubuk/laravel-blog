@extends('layouts.main')

@section('title', $post->title)
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags((string) $post->content), 155))
@section('canonical', route('post.show', $post->slug))
@section('og_type', 'article')
@section('og_image', $post->image_url)

@php($postSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'BlogPosting',
        'headline' => $post->title,
        'description' => \Illuminate\Support\Str::limit(strip_tags((string) $post->content), 155),
        'image' => $post->image_url,
        'datePublished' => optional($post->created_at)->toIso8601String(),
        'dateModified' => optional($post->updated_at)->toIso8601String(),
        'author' => [
            '@type' => 'Person',
            'name' => $post->user->name ?? 'Admin',
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => $settings['site_name'] ?? config('app.name'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => asset(($settings['site_logo'] ?? null) ?: 'default-logo.png'),
            ],
        ],
        'mainEntityOfPage' => route('post.show', $post->slug),
    ])

@push('head')
<script type="application/ld+json">{!! json_encode($postSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

@section('content')
    @php($isAdminViewer = auth()->check() && auth()->user()->role === 'admin')

    @push('styles')
@php($postShowCssPath = public_path('assets/css/extracted/pages-posts-show.css'))
<link rel="stylesheet" href="{{ asset('assets/css/extracted/pages-posts-show.css') }}{{ file_exists($postShowCssPath) ? '?v=' . filemtime($postShowCssPath) : '' }}">
@endpush

    <div class="heading-page header-text">
        <section class="page-heading">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-content">
                            <h4>Yazı Detayı</h4>
                            <h2>{{ $post->title }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <section class="blog-posts grid-system">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="all-blog-posts">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="blog-post">
                                    <div class="blog-thumb">
                                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}" loading="eager" fetchpriority="high" decoding="async">
                                    </div>

                                    <div class="down-content">
                                        <span>{{ $post->category->name ?? 'Genel' }}</span>
                                        <h4>{{ $post->title }}</h4>

                                        <ul class="post-info">
                                            <li><a href="#">{{ $post->user->name ?? 'Admin' }}</a></li>
                                            <li><a href="#">{{ $post->created_at->format('d.m.Y') }}</a></li>
                                            <li><a href="#">{{ $post->reading_time }} dk okuma</a></li>
                                            <li><a href="#comments">{{ $post->approved_comments_count }} yorum</a></li>
                                        </ul>

                                        <div class="post-content-body">
                                            {!! \App\Support\PostContentFormatter::toHtml($post->content) !!}
                                        </div>

                                        @if(session('success'))
                                            <div class="alert alert-success mt-4">
                                                {{ session('success') }}
                                            </div>
                                        @endif

                                        @if($errors->any())
                                            <div class="alert alert-danger mt-4">
                                                <ul class="mb-0">
                                                    @foreach($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                    </div>
                                </div>

                                <div class="post-comments-panel mt-4" id="comments">
                                    <div class="sidebar-heading">
                                        <h2>{{ $post->visible_comments_count }} yorum</h2>
                                    </div>
                                    <div class="content">
                                        <div class="post-comment-list">
                                            @forelse($post->comments as $comment)
                                                @include('pages.posts.partials.comment-thread', ['comment' => $comment, 'post' => $post, 'isAdminViewer' => $isAdminViewer])
                                            @empty
                                                <div class="post-comment-empty">
                                                    <h4>Henüz yorum yok <span>İlk yorumu siz yazın</span></h4>
                                                    <p>Bu yazı için onaylanmış yorum bulunmuyor.</p>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>

                                @if(auth()->check() && auth()->user()->role === 'user')
                                            <div class="sidebar-item submit-comment post-comment-form-panel mt-4" id="comment-form">
                                                <div class="sidebar-heading">
                                                    <h2>Yorum Yaz</h2>
                                                </div>
                                                <div class="content">
                                                    <form method="POST" action="{{ route('post.comments.store', $post->slug) }}">
                                                        @csrf
                                                        <input type="text" name="website" value="" tabindex="-1" autocomplete="off" class="d-none" aria-hidden="true">
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-12">
                                                                <input
                                                                    type="text"
                                                                    value="{{ auth()->user()->name }}"
                                                                    placeholder="Adınız"
                                                                    readonly
                                                                >
                                                            </div>
                                                            <div class="col-md-6 col-sm-12">
                                                                <input
                                                                    type="email"
                                                                    value="{{ auth()->user()->email }}"
                                                                    placeholder="E-posta adresiniz"
                                                                    readonly
                                                                >
                                                            </div>
                                                            <div class="col-md-12 col-sm-12 mt-2">
                                                                <textarea name="message" rows="6" placeholder="Yorumunuzu yazın" required>{{ old('message') }}</textarea>
                                                            </div>
                                                            <div class="col-md-12 mt-2">
                                                                <button type="submit" class="main-button">Gönder</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="sidebar">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="sidebar-item search">
                                    <form method="GET" action="{{ route('blog') }}">
                                        <input type="text" name="search" class="searchText" placeholder="Yazı ara...">
                                    </form>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="sidebar-item recent-posts">
                                    <div class="sidebar-heading">
                                        <h2>Son Yazılar</h2>
                                    </div>
                                    <div class="content">
                                        <ul>
                                            @foreach($recentPosts as $recent)
                                                <li>
                                                    <a href="{{ route('post.show', $recent->slug) }}">
                                                        <h5>{{ $recent->title }}</h5>
                                                        <span>{{ $recent->created_at->format('d.m.Y') }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="sidebar-item categories">
                                    <div class="sidebar-heading">
                                        <h2>Kategoriler</h2>
                                    </div>
                                    <div class="content">
                                        <ul>
                                            @foreach($categories as $category)
                                                <li><a href="{{ route('blog.category', $category) }}">{{ $category->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="sidebar-item tags">
                                    <div class="sidebar-heading">
                                        <h2>Etiketler</h2>
                                    </div>
                                    <div class="content">
                                        <ul>
                                            <li><a href="#">Laravel</a></li>
                                            <li><a href="#">PHP</a></li>
                                            <li><a href="#">Web</a></li>
                                            <li><a href="#">Geliştirme</a></li>
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

    @if($relatedPosts->isNotEmpty())
        <section class="blog-posts pt-0">
            <div class="container">
                <div class="sidebar-heading mb-4">
                    <h2>İlgili Yazılar</h2>
                </div>
                <div class="row">
                    @foreach($relatedPosts as $related)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <article class="blog-post">
                                <div class="blog-thumb">
                                    <a href="{{ route('post.show', $related->slug) }}">
                                        <img src="{{ $related->image_url }}" alt="{{ $related->title }}" loading="lazy" decoding="async">
                                    </a>
                                </div>
                                <div class="down-content">
                                    <span>{{ $related->category->name ?? 'Genel' }}</span>
                                    <a href="{{ route('post.show', $related->slug) }}"><h4>{{ $related->title }}</h4></a>
                                    <ul class="post-info">
                                        <li><a href="#">{{ $related->reading_time }} dk okuma</a></li>
                                        <li><a href="#">{{ $related->approved_comments_count ?? 0 }} yorum</a></li>
                                    </ul>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @push('scripts')
<script src="{{ asset('assets/js/extracted/pages-posts-show.js') }}"></script>
@endpush

@endsection

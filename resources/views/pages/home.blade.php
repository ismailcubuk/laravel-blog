@extends('layouts.main')

@section('title', 'Ana Sayfa')
@section('meta_description', ($settings['site_tagline'] ?? null) ?: 'Öne çıkan yazılar, popüler kategoriler ve güncel blog içerikleri.')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/frontend/home.css') }}?v={{ filemtime(public_path('assets/css/frontend/home.css')) }}">
@endpush

@section('content')
    <section class="home-hero">
        <div class="container">
            <div class="home-hero-grid">
                <div class="home-hero-copy">
                    <span class="home-eyebrow">Güncel ve seçilmiş içerikler</span>
                    <h1>{{ $settings['site_name'] ?? config('app.name') }}</h1>
                    <p>{{ $settings['site_tagline'] ?: 'Okuması kolay, güncel ve özenle hazırlanmış blog yazıları.' }}</p>
                    <div class="home-hero-actions">
                        <a href="{{ route('blog') }}" class="home-primary-link">Yazıları Keşfet</a>
                        <a href="{{ route('contact') }}" class="home-secondary-link">İletişime Geç</a>
                    </div>
                </div>

                @if($featuredPost)
                    <article class="home-featured-card">
                        <a href="{{ route('post.show', $featuredPost->slug) }}" class="home-featured-image">
                            <img src="{{ $featuredPost->image_url }}" alt="{{ $featuredPost->title }}" loading="eager" fetchpriority="high" decoding="async">
                        </a>
                        <div class="home-featured-body">
                            <span>{{ $featuredPost->category->name ?? 'Genel' }}</span>
                            <a href="{{ route('post.show', $featuredPost->slug) }}"><h2>{{ $featuredPost->title }}</h2></a>
                            <p>{{ $featuredPost->excerpt }}</p>
                            <ul>
                                <li>{{ $featuredPost->reading_time }} dk okuma</li>
                                <li>{{ $featuredPost->approved_comments_count ?? 0 }} yorum</li>
                            </ul>
                        </div>
                    </article>
                @endif
            </div>
        </div>
    </section>

    @if($editorPicks->isNotEmpty() || $categories->isNotEmpty())
        <section class="home-section">
            <div class="container">
                <div class="home-section-heading">
                    <span>Editörün seçtikleri</span>
                    <h2>Okumaya değer başlıklar</h2>
                </div>

                <div class="home-editor-grid">
                    @foreach($editorPicks as $post)
                        <article class="home-editor-card">
                            <a href="{{ route('post.show', $post->slug) }}">
                                <img src="{{ $post->image_url }}" alt="{{ $post->title }}" loading="lazy" decoding="async">
                                <span>{{ $post->category->name ?? 'Genel' }}</span>
                                <h3>{{ $post->title }}</h3>
                                <p>{{ $post->reading_time }} dk okuma</p>
                            </a>
                        </article>
                    @endforeach
                </div>

                <div class="home-category-strip" aria-label="Popüler kategoriler">
                    @foreach($categories->take(6) as $category)
                        <a href="{{ route('blog.category', $category) }}">
                            {{ $category->name }}
                            <strong>{{ $category->posts_count }}</strong>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="blog-posts">
        <div class="container">
            <div class="home-section-heading">
                <span>Son yazılar</span>
                <h2>Yeni yayınlananlar</h2>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    @include('partials.blog-posts')

                    <div class="mt-4 d-flex justify-content-center">
                        {{ $posts->links('vendor.pagination.templatemo') }}
                    </div>
                </div>

                <div class="col-lg-4 mt-4 mt-lg-0">
                    @if($mostCommentedPosts->isNotEmpty())
                        <aside class="home-popular-card">
                            <h2>Çok yorumlananlar</h2>
                            @foreach($mostCommentedPosts as $post)
                                <a href="{{ route('post.show', $post->slug) }}">
                                    <span>{{ $post->approved_comments_count ?? 0 }} yorum</span>
                                    <strong>{{ $post->title }}</strong>
                                </a>
                            @endforeach
                        </aside>
                    @endif

                    @include('partials.sidebar')
                </div>
            </div>
        </div>
    </section>
@endsection

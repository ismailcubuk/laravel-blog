@extends('layouts.main')

@section('title', 'Blog')
@section('meta_description', trim(($search ?? '') . ' ' . optional($activeCategory)->name) ? 'Blog arama ve kategori sonuçları.' : 'Güncel blog yazıları, kategoriler ve son yayınlanan içerikler.')

@section('content')

    @push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/extracted/pages-blog.css') }}">
@endpush

    <div class="heading-page header-text">
        <section class="page-heading">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-content">
                            <h4>Blog</h4>
                            <h2>{{ $activeCategory ? $activeCategory->name : 'Son Yazılar' }}</h2>
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
                        <div class="blog-results-summary mb-4">
                            <strong>{{ $resultCount }}</strong> sonuç bulundu
                            @if($search !== '')
                                <span>“{{ $search }}” araması için</span>
                            @endif
                            @if($activeCategory)
                                <span>{{ $activeCategory->name }} kategorisinde</span>
                            @endif
                        </div>
                        <div class="row blog-grid">

                            @forelse($posts as $post)

                                <div class="col-lg-6 blog-card-col">
                                    <div class="blog-post">

                                        {{-- image --}}
                                        <a class="blog-thumb" href="{{ route('post.show', $post->slug) }}">
                                            <img src="{{ $post->image_url }}" alt="{{ $post->title }}" loading="{{ $loop->first ? 'eager' : 'lazy' }}" fetchpriority="{{ $loop->first ? 'high' : 'low' }}" decoding="async">
                                        </a>

                                        <div class="down-content">

                                            {{-- category --}}
                                            <span>
                                                {{ $post->category->name ?? 'Genel' }}
                                            </span>

                                            {{-- title --}}
                                            <a href="{{ route('post.show', $post->slug) }}">
                                                <h4>{{ $post->title }}</h4>
                                            </a>

                                            {{-- info --}}
                                            <ul class="post-info">
                                                <li><a href="#">{{ $post->user->name ?? 'Admin' }}</a></li>
                                                <li>
                                                    <a href="#">
                                                        {{ $post->created_at->format('d.m.Y') }}
                                                    </a>
                                                </li>
                                                <li><a href="#">{{ $post->reading_time }} dk okuma</a></li>
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
                                                            <li><a href="{{ $post->category ? route('blog.category', $post->category) : route('blog') }}">{{ $post->category->name ?? 'Genel' }}</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                            @empty
                                <div class="col-12">
                                    <div class="alert alert-info">Bu kriterlere uygun yazı bulunamadı.</div>
                                </div>
                            @endforelse

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
                                        <input type="text" name="search" class="searchText" placeholder="Yazı ara..." value="{{ request('search') }}">
                                    </form>
                                </div>
                            </div>


                            {{-- recent posts --}}
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
                                                        <span>
                                                            {{ $recent->created_at->format('d.m.Y') }}
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
                                        <h2>Kategoriler</h2>
                                    </div>

                                    <div class="content">
                                        <ul>

                                            @foreach($categories as $category)

                                                <li>
                                                    <a href="{{ route('blog.category', $category) }}">
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



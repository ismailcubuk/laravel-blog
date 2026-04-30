@extends('layouts.main')

@section('title', 'Blog')

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
                                            <img src="{{ $post->image_url }}" alt="{{ $post->title }}" loading="{{ $loop->first ? 'eager' : 'lazy' }}" fetchpriority="{{ $loop->first ? 'high' : 'low' }}" decoding="async">
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



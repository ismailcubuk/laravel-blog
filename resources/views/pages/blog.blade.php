@extends('layouts.main')

@section('title', 'Blog')

@section('content')

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
                        <div class="row">

                            @foreach($posts as $post)

                                <div class="col-lg-6">
                                    <div class="blog-post">

                                        {{-- image --}}
                                        <div class="blog-thumb">
                                            <img src="{{ asset('assets/images/blog-thumb-01.jpg') }}" alt="">
                                        </div>

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
                                                {{ Str::limit($post->content, 120) }}
                                            </p>
                                            {{---------------------------------------------------------- dummy tags --}}
                                            <div class="post-options">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <ul class="post-tags">

                                                            <li><i class="fa fa-tags"></i></li>

                                                            <li><a href="#">Best Templates</a>,</li>
                                                            <li><a href="#">TemplateMo</a></li>

                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            {{---------------------------------------------------------- dummy tags --}}

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

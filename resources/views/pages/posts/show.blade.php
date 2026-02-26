@extends('layouts.main')

@section('title', $post->title)

@section('content')

    <div class="heading-page header-text">
        <section class="page-heading">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-content">
                            <h4>Post Details</h4>
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

                {{-- POST --}}
                <div class="col-lg-8">
                    <div class="all-blog-posts">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="blog-post">

                                    {{-- image --}}
                                    @if($post->image)
                                        <div class="blog-thumb">
                                            <img src="{{ asset($post->image) }}" alt="{{ $post->title }}">
                                        </div>
                                    @endif

                                    <div class="down-content">

                                        {{-- category --}}
                                        <span>{{ $post->category->name ?? 'No Category' }}</span>

                                        {{-- title --}}
                                        <h4>{{ $post->title }}</h4>

                                        {{-- info --}}
                                        <ul class="post-info">
                                            <li><a href="#">{{ $post->user->name ?? 'Admin' }}</a></li>
                                            <li><a href="#">{{ $post->created_at->format('d M Y') }}</a></li>
                                        </ul>

                                        {{-- content --}}
                                        <p>{!! nl2br(e($post->content)) !!}</p>

                                        {{-- tags dynamic if you have a tags table --}}
                                        @if($post->tags && $post->tags->count())
                                            <div class="post-options">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <ul class="post-tags">
                                                            <li><i class="fa fa-tags"></i></li>
                                                            @foreach($post->tags as $tag)
                                                                <li><a href="#">{{ $tag->name }}</a>@if(!$loop->last),@endif</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- COMMENTS --}}
                                        <div class="sidebar-item comments mt-5">
                                            <div class="sidebar-heading">
                                                <h2>4 comments</h2>
                                            </div>
                                            <div class="content">
                                                <ul>
                                                    {{-- Dummy comment --}}
                                                    <li>
                                                        <div class="author-thumb">
                                                            <img src="{{ asset('assets/images/comment-author-01.jpg') }}"
                                                                alt="">
                                                        </div>
                                                        <div class="right-content">
                                                            <h4>John Doe <span>Feb 17, 2026</span></h4>
                                                            <p>This is a dummy comment. Laravel comment system henüz
                                                                eklenmedi.</p>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="author-thumb">
                                                            <img src="{{ asset('assets/images/comment-author-01.jpg') }}"
                                                                alt="">
                                                        </div>
                                                        <div class="right-content">
                                                            <h4>John Doe <span>Feb 17, 2026</span></h4>
                                                            <p>This is a dummy comment. Laravel comment system henüz
                                                                eklenmedi.</p>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        {{-- COMMENT FORM --}}
                                        <div class="sidebar-item submit-comment mt-4">
                                            <div class="sidebar-heading">
                                                <h2>Leave a Comment</h2>
                                            </div>
                                            <div class="content">
                                                <form >
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <input type="text" name="name" placeholder="Your Name" required>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <input type="email" name="email" placeholder="Your Email"
                                                                required>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 mt-2">
                                                            <textarea name="message" rows="6"
                                                                placeholder="Type your comment" required></textarea>
                                                        </div>
                                                        <div class="col-md-12 mt-2">
                                                            <button type="submit" class="main-button">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                    </div> {{-- down-content end --}}
                                </div> {{-- blog-post end --}}
                            </div>
                        </div>
                    </div>
                </div> {{-- col-lg-8 end --}}

                {{-- SIDEBAR --}}
                <div class="col-lg-4">
                    <div class="sidebar">
                        <div class="row">

                            {{-- search --}}
                            <div class="col-lg-12">
                                <div class="sidebar-item search">
                                    <form method="GET" action="{{ route('blog') }}">
                                        <input type="text" name="search" class="searchText" placeholder="Search...">
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
                                            @foreach($recentPosts as $recent)
                                                <li>
                                                    <a href="{{ route('post.show', $recent->slug) }}">
                                                        <h5>{{ $recent->title }}</h5>
                                                        <span>{{ $recent->created_at->format('d M Y') }}</span>
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
                                                <li><a href="#">{{ $category->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            {{-- tag clouds --}}
                            <div class="col-lg-12">
                                <div class="sidebar-item tags">
                                    <div class="sidebar-heading">
                                        <h2>Tag Clouds</h2>
                                    </div>
                                    <div class="content">
                                        <ul>
                                            <li><a href="#">Laravel</a></li>
                                            <li><a href="#">PHP</a></li>
                                            <li><a href="#">Web</a></li>
                                            <li><a href="#">Development</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div> {{-- col-lg-4 end --}}

            </div>
        </div>
    </section>

@endsection
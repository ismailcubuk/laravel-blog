@extends('layouts.main')

@section('title', $post->title)

@section('content')
    @php($isAdminViewer = auth()->check() && auth()->user()->role === 'admin')

    @push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/extracted/pages-posts-show.css') }}?v={{ filemtime(public_path('assets/css/extracted/pages-posts-show.css')) }}">
@endpush

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
                <div class="col-lg-8">
                    <div class="all-blog-posts">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="blog-post">
                                    <div class="blog-thumb">
                                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}" loading="eager" fetchpriority="high" decoding="async">
                                    </div>

                                    <div class="down-content">
                                        <span>{{ $post->category->name ?? 'No Category' }}</span>
                                        <h4>{{ $post->title }}</h4>

                                        <ul class="post-info">
                                            <li><a href="#">{{ $post->user->name ?? 'Admin' }}</a></li>
                                            <li><a href="#">{{ $post->created_at->format('d M Y') }}</a></li>
                                            <li><a href="#comments">{{ $post->approved_comments_count }} Comments</a></li>
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
                                        <h2>{{ $post->visible_comments_count }} comments</h2>
                                    </div>
                                    <div class="content">
                                        <div class="post-comment-list">
                                            @forelse($post->comments as $comment)
                                                @include('pages.posts.partials.comment-thread', ['comment' => $comment, 'post' => $post, 'isAdminViewer' => $isAdminViewer])
                                            @empty
                                                <div class="post-comment-empty">
                                                    <h4>No comments yet <span>Be the first</span></h4>
                                                    <p>This post does not have any approved comments yet.</p>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>

                                @if(auth()->check() && auth()->user()->role === 'user')
                                            <div class="sidebar-item submit-comment post-comment-form-panel mt-4" id="comment-form">
                                                <div class="sidebar-heading">
                                                    <h2>Leave a Comment</h2>
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
                                                                    placeholder="Your Name"
                                                                    readonly
                                                                >
                                                            </div>
                                                            <div class="col-md-6 col-sm-12">
                                                                <input
                                                                    type="email"
                                                                    value="{{ auth()->user()->email }}"
                                                                    placeholder="Your Email"
                                                                    readonly
                                                                >
                                                            </div>
                                                            <div class="col-md-12 col-sm-12 mt-2">
                                                                <textarea name="message" rows="6" placeholder="Type your comment" required>{{ old('message') }}</textarea>
                                                            </div>
                                                            <div class="col-md-12 mt-2">
                                                                <button type="submit" class="main-button">Submit</button>
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
                                        <input type="text" name="search" class="searchText" placeholder="Search...">
                                    </form>
                                </div>
                            </div>

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
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
<script src="{{ asset('assets/js/extracted/pages-posts-show.js') }}"></script>
@endpush

@endsection

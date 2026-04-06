@extends('layouts.main')

@section('title', 'Posts')

@section('content')
<div class="heading-page header-text">
    <section class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-content">
                        <h4>Latest Articles</h4>
                        <h2>All Posts</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<section class="blog-posts">
    <div class="container">
        @if($bannerPosts->isNotEmpty())
            <div class="owl-banner owl-carousel mb-4">
                @foreach($bannerPosts as $bannerPost)
                    <a class="item" href="{{ route('post.show', $bannerPost->slug) }}" style="text-decoration:none;">
                        <img src="{{ $bannerPost->image_url }}" alt="{{ $bannerPost->title }}" style="width:100%;height:260px;object-fit:cover;border-radius:14px;">
                        <div class="item-content mt-2">
                            <h5 class="mb-1">{{ $bannerPost->title }}</h5>
                            <small class="text-muted">{{ optional($bannerPost->created_at)->format('d.m.Y') }} · {{ $bannerPost->approved_comments_count }} yorum</small>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        <div class="row">
            @forelse($posts as $post)
                <div class="col-lg-4 col-md-6 mb-4">
                    <article class="blog-post">
                        <div class="blog-thumb">
                            <img src="{{ $post->image_url }}" alt="{{ $post->title }}">
                        </div>
                        <div class="down-content">
                            <span>{{ optional($post->category)->name ?? 'Genel' }}</span>
                            <a href="{{ route('post.show', $post->slug) }}"><h4>{{ $post->title }}</h4></a>
                            <ul class="post-info">
                                <li><a href="#">{{ optional($post->created_at)->format('d.m.Y') }}</a></li>
                                <li><a href="#">{{ $post->approved_comments_count }} yorum</a></li>
                            </ul>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-danger">Henüz gönderi bulunmuyor.</div>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-2">
            {{ $posts->links() }}
        </div>
    </div>
</section>
@endsection

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
            @include('partials.banner', ['bannerPosts' => $bannerPosts])
        @endif

        <div class="row">
            @forelse($posts as $post)
                <div class="col-lg-4 col-md-6 mb-4">
                    <article class="blog-post">
                        <div class="blog-thumb">
                            <img src="{{ $post->image_url }}" alt="{{ $post->title }}" loading="{{ $loop->first ? 'eager' : 'lazy' }}" fetchpriority="{{ $loop->first ? 'high' : 'low' }}" decoding="async">
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


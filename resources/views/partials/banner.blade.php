<section class="front-hero-slider main-banner header-text">
    @push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/extracted/partials-banner.css') }}">
@endpush

    <div class="container-fluid">
        <div class="owl-banner owl-carousel">
            @foreach($bannerPosts as $post)
                <div class="item">
                    <a href="{{ route('post.show', $post->slug) }}">
                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}" loading="{{ $loop->first ? 'eager' : 'lazy' }}" fetchpriority="{{ $loop->first ? 'high' : 'low' }}" decoding="async">
                    </a>

                    <div class="item-content">
                        <div class="main-content">
                            <div class="meta-category">
                                <span>{{ $post->category->name ?? 'Genel' }}</span>
                            </div>

                            <a href="{{ route('post.show', $post->slug) }}">
                                <h4>{{ $post->title }}</h4>
                            </a>

                            <ul class="post-info">
                                <li><a href="#">{{ $post->created_at->format('d M Y') }}</a></li>
                                <li><a href="{{ route('post.show', $post->slug) }}#comments">{{ $post->approved_comments_count ?? 0 }} yorum</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>


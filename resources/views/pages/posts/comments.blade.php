@extends('layouts.main')

@section('title', 'Yorumlarim')

@section('content')
<section class="author-dashboard-page">
    <div class="container">
        <div class="author-dashboard-header">
            <div>
                <p>Yorum gecmisi</p>
                <h1>Yorumlarim</h1>
            </div>
            <a href="{{ route('blog') }}">
                <i class="fa fa-search" aria-hidden="true"></i>
                Bloga Git
            </a>
        </div>

        <div class="author-comment-list">
            @forelse($comments as $comment)
                @php($commentTarget = $comment->post ? route('post.show', $comment->post->slug) . '#comments' : null)
                <article class="author-comment-item" @if($commentTarget) data-click-url="{{ $commentTarget }}" tabindex="0" role="link" @endif>
                    <div class="author-comment-post">
                        <span class="author-comment-thumb" aria-label="{{ $comment->post->title ?? 'Yazi' }}">
                            <img src="{{ $comment->post?->image_url ?? asset('assets/images/blog-post-01.jpg') }}" alt="{{ $comment->post->title ?? 'Yazi' }}" loading="lazy" decoding="async">
                        </span>
                        <h2>{{ $comment->post->title ?? 'Silinmis yazi' }}</h2>
                    </div>
                    <div class="author-comment-body">
                        <div class="author-comment-title-row">
                            <div class="author-comment-person">
                                @if($comment->post)
                                    <img
                                        src="{{ $comment->post->user?->avatar_path ? asset($comment->post->user->avatar_path) : asset('adminlte/img/avatar.png') }}"
                                        alt="{{ $comment->post->user->name ?? 'Yazar' }}"
                                        loading="lazy"
                                        decoding="async"
                                    >
                                @endif
                                <span>{{ $comment->post->user->name ?? 'Yazar' }}</span>
                            </div>
                            <time>{{ $comment->created_at->format('d.m.Y H:i') }}</time>
                        </div>
                        <blockquote>{{ $comment->message }}</blockquote>
                    </div>
                </article>
            @empty
                <div class="author-empty-state">
                    <h2>Henuz yorumunuz yok.</h2>
                    <p>Okudugunuz yazilara yorum biraktikca burada listelenir.</p>
                    <a href="{{ route('blog') }}">Bloglari Kesfet</a>
                </div>
            @endforelse
        </div>

        {{ $comments->links('vendor.pagination.templatemo') }}
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/extracted/pages-posts-comments.js') }}"></script>
@endpush


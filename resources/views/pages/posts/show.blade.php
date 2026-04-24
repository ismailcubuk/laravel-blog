@extends('layouts.main')

@section('title', $post->title)

@section('content')
    @php($isAdminViewer = auth()->check() && auth()->user()->role === 'admin')

    @push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/extracted/pages-posts-show.css') }}">
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
                                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}">
                                    </div>

                                    <div class="down-content">
                                        <span>{{ $post->category->name ?? 'No Category' }}</span>
                                        <h4>{{ $post->title }}</h4>

                                        <ul class="post-info">
                                            <li><a href="#">{{ $post->user->name ?? 'Admin' }}</a></li>
                                            <li><a href="#">{{ $post->created_at->format('d M Y') }}</a></li>
                                            <li><a href="#comments">{{ $post->approved_comments_count }} Comments</a></li>
                                        </ul>

                                        <p>{!! nl2br(e($post->content)) !!}</p>

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

                                        <div class="sidebar-item comments mt-5" id="comments">
                                            <div class="sidebar-heading">
                                                <h2>{{ $isAdminViewer ? $post->comments->count() : $post->approved_comments_count }} comments</h2>
                                            </div>
                                            <div class="content">
                                                <ul>
                                                    @forelse($post->comments as $comment)
                                                        <li>
                                                            <div class="author-thumb">
                                                                <img src="{{ optional($comment->user)->avatar_path ? asset($comment->user->avatar_path) : asset('assets/images/comment-author-01.jpg') }}" alt="{{ $comment->name }}">
                                                            </div>
                                                            <div class="right-content">
                                                                <h4>
                                                                    {{ $comment->name }}
                                                                    <span>{{ $comment->created_at->format('M d, Y') }}</span>
                                                                    @if($isAdminViewer)
                                                                        <details class="comment-status-menu">
                                                                            <summary class="comment-status-badge comment-status-trigger {{ $comment->status }}">
                                                                                {{ $comment->status }}
                                                                            </summary>
                                                                            <div class="comment-status-dropdown">
                                                                                <form method="POST" action="{{ route('admin.content.comments.status', $comment) }}">
                                                                                    @csrf
                                                                                    @method('PUT')
                                                                                    <input type="hidden" name="status" value="approved">
                                                                                    <button type="submit" class="comment-status-option approved-option {{ $comment->status === 'approved' ? 'is-current' : '' }}">Approved</button>
                                                                                </form>
                                                                                <form method="POST" action="{{ route('admin.content.comments.status', $comment) }}">
                                                                                    @csrf
                                                                                    @method('PUT')
                                                                                    <input type="hidden" name="status" value="pending">
                                                                                    <button type="submit" class="comment-status-option pending-option {{ $comment->status === 'pending' ? 'is-current' : '' }}">Pending</button>
                                                                                </form>
                                                                            </div>
                                                                        </details>
                                                                    @endif
                                                                </h4>
                                                                @php($commentUser = $comment->user)
                                                                @if($commentUser && count($commentUser->socialLinks()) > 0)
                                                                    <div class="comment-social-links" aria-label="{{ $comment->name }} social links">
                                                                        @foreach($commentUser->socialLinks() as $social)
                                                                            <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer" title="{{ $social['label'] }}">
                                                                                <i class="fa fa-{{ $social['icon'] }}"></i>
                                                                            </a>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                                <p>{{ $comment->message }}</p>

                                                                @if($isAdminViewer && !$comment->reply_message)
                                                                    <div class="reply-view-actions text-end" id="reply-trigger-{{ $comment->id }}">
                                                                        <button
                                                                            type="button"
                                                                            class="reply-edit-button"
                                                                            onclick="toggleReplyCreate({{ $comment->id }}, true)"
                                                                        >
                                                                            Reply
                                                                        </button>
                                                                    </div>

                                                                    <form
                                                                        method="POST"
                                                                        action="{{ route('post.comments.reply', [$post->slug, $comment]) }}"
                                                                        class="reply-inline-edit d-none"
                                                                        id="reply-create-{{ $comment->id }}"
                                                                    >
                                                                        @csrf
                                                                        <textarea
                                                                            id="reply_message_{{ $comment->id }}"
                                                                            name="reply_message"
                                                                            placeholder="Write admin reply"
                                                                            required
                                                                        >{{ old('reply_message') }}</textarea>
                                                                        <div class="reply-inline-edit-actions">
                                                                            <button
                                                                                type="button"
                                                                                class="reply-modern-button cancel"
                                                                                onclick="toggleReplyCreate({{ $comment->id }}, false)"
                                                                            >
                                                                                Cancel
                                                                            </button>
                                                                            <button type="submit" class="reply-modern-button save">
                                                                                Save
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        </li>

                                                        @if($comment->reply_message)
                                                            <li class="replied">
                                                                <div class="author-thumb">
                                                                    <img src="{{ optional($comment->repliedBy)->avatar_path ? asset($comment->repliedBy->avatar_path) : asset('assets/images/comment-author-02.jpg') }}" alt="Admin Reply">
                                                                </div>
                                                                <div class="right-content">
                                                                    <h4>
                                                                        {{ optional($comment->repliedBy)->name ?: 'Admin' }}
                                                                        <span>{{ optional($comment->replied_at)->format('M d, Y') }}</span>
                                                                    </h4>

                                                                    <div id="reply-view-body-{{ $comment->id }}">
                                                                        <p id="reply-text-{{ $comment->id }}">{{ $comment->reply_message }}</p>

                                                                        @if($isAdminViewer)
                                                                            <div class="reply-view-actions" id="reply-actions-{{ $comment->id }}">
                                                                                <button
                                                                                    type="button"
                                                                                    class="reply-edit-button"
                                                                                    onclick="toggleReplyEdit({{ $comment->id }}, true)"
                                                                                >
                                                                                    Duzenle
                                                                                </button>
                                                                            </div>
                                                                        @endif
                                                                    </div>

                                                                    @if($isAdminViewer)
                                                                        <form
                                                                            method="POST"
                                                                            action="{{ route('post.comments.reply', [$post->slug, $comment]) }}"
                                                                            class="reply-inline-edit d-none"
                                                                            id="reply-edit-{{ $comment->id }}"
                                                                        >
                                                                            @csrf
                                                                            <textarea
                                                                                id="reply_edit_message_{{ $comment->id }}"
                                                                                name="reply_message"
                                                                                placeholder="Write admin reply"
                                                                                required
                                                                            >{{ $comment->reply_message }}</textarea>
                                                                            <div class="reply-inline-edit-actions">
                                                                                <button
                                                                                    type="button"
                                                                                    class="reply-modern-button cancel"
                                                                                    onclick="toggleReplyEdit({{ $comment->id }}, false)"
                                                                                >
                                                                                    Iptal
                                                                                </button>
                                                                                <button
                                                                                    type="submit"
                                                                                    form="reply-delete-{{ $comment->id }}"
                                                                                    class="reply-modern-button delete"
                                                                                    onclick="return confirm('Delete this reply?')"
                                                                                >
                                                                                    Delete
                                                                                </button>
                                                                                <button type="submit" class="reply-modern-button save">
                                                                                    Kaydet
                                                                                </button>
                                                                            </div>
                                                                        </form>

                                                                        <form
                                                                            method="POST"
                                                                            action="{{ route('post.comments.reply.destroy', [$post->slug, $comment]) }}"
                                                                            id="reply-delete-{{ $comment->id }}"
                                                                            class="d-none"
                                                                        >
                                                                            @csrf
                                                                            @method('DELETE')
                                                                        </form>
                                                                    @endif
                                                                </div>
                                                            </li>
                                                        @endif
                                                    @empty
                                                        <li>
                                                            <div class="right-content">
                                                                <h4>No comments yet <span>Be the first</span></h4>
                                                                <p>This post does not have any approved comments yet.</p>
                                                            </div>
                                                        </li>
                                                    @endforelse
                                                </ul>
                                            </div>
                                        </div>

                                        @if(auth()->check() && auth()->user()->role === 'user')
                                            <div class="sidebar-item submit-comment mt-4" id="comment-form">
                                                <div class="sidebar-heading">
                                                    <h2>Leave a Comment</h2>
                                                </div>
                                                <div class="content">
                                                    <form method="POST" action="{{ route('post.comments.store', $post->slug) }}">
                                                        @csrf
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

    @if($isAdminViewer)
        @push('scripts')
<script src="{{ asset('assets/js/extracted/pages-posts-show.js') }}"></script>
@endpush
    @endif

@endsection



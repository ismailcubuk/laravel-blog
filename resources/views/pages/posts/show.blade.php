@extends('layouts.main')

@section('title', $post->title)

@section('content')
    @php($isAdminViewer = auth()->check() && auth()->user()->role === 'admin')

    <style>
        .d-none {
            display: none !important;
        }

        .comments ul li,
        .comments ul li.replied {
            overflow: hidden;
        }

        .sidebar-item.submit-comment {
            clear: both;
            margin-top: 36px !important;
            padding-top: 24px;
        }

        .submit-comment .sidebar-heading h2 {
            margin-top: 0;
        }

        .comments .right-content p,
        .comments .right-content h4,
        .comments .right-content span,
        .comments .right-content textarea,
        .comments .right-content form {
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        .comments .right-content p {
            margin: 0;
            padding: 0;
            white-space: pre-wrap;
        }

        .comments .right-content {
            min-width: 0;
        }

        .reply-view-actions,
        .reply-inline-edit-actions {
            margin-top: 10px;
        }

        .replied .right-content h4 {
            padding-bottom: 10px;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .comments ul li:not(.replied) .right-content h4 {
            padding-bottom: 10px;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .reply-edit-button {
            border: 0;
            background: transparent;
            color: #f48840;
            font-size: 12px;
            font-weight: 700;
            padding: 0;
            cursor: pointer;
        }

        .reply-edit-button:hover {
            text-decoration: underline;
        }

        .reply-inline-edit {
            margin-top: 10px;
            width: 100%;
            max-width: 100%;
        }

        .reply-inline-edit textarea {
            width: 100%;
            max-width: 100%;
            min-height: 90px;
            padding: 10px 12px;
            margin: 0;
            border: 1px solid rgba(244, 136, 64, 0.4);
            border-radius: 8px;
            background: rgba(244, 136, 64, 0.04);
            resize: vertical;
            box-sizing: border-box;
            font: inherit;
            color: inherit;
            line-height: inherit;
            white-space: pre-wrap;
        }

        .reply-inline-edit textarea:focus {
            outline: none;
            border-color: #f48840;
            background: rgba(244, 136, 64, 0.06);
        }

        .reply-inline-edit-actions {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 12px;
            flex-wrap: wrap;
            max-width: 100%;
        }

        .down-content .reply-inline-edit,
        .down-content .reply-inline-edit textarea,
        .down-content .reply-inline-edit-actions {
            max-width: 100%;
            box-sizing: border-box;
        }

        .reply-modern-button {
            border: 0;
            border-radius: 999px;
            padding: 10px 18px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.03em;
        }

        .reply-modern-button.cancel {
            background: #f4efe9;
            color: #6e6258;
        }

        .reply-modern-button.save {
            background: #f48840;
            color: #fff;
        }

        .reply-modern-button.delete {
            background: #dc3545;
            color: #fff;
        }
    </style>

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
                                                                <img src="{{ asset('assets/images/comment-author-01.jpg') }}" alt="{{ $comment->name }}">
                                                            </div>
                                                            <div class="right-content">
                                                                <h4>{{ $comment->name }} <span>{{ $comment->created_at->format('M d, Y') }}</span></h4>
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
                                                                    <img src="{{ asset('assets/images/comment-author-02.jpg') }}" alt="Admin Reply">
                                                                </div>
                                                                <div class="right-content">
                                                                    <h4>{{ optional($comment->user)->name ?: 'Thirteen Man' }} <span>{{ optional($comment->replied_at)->format('M d, Y') }}</span></h4>

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
                                                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Your Name" required>
                                                            </div>
                                                            <div class="col-md-6 col-sm-12">
                                                                <input type="email" name="email" value="{{ old('email') }}" placeholder="Your Email" required>
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
        <script>
            function toggleReplyCreate(commentId, shouldShow) {
                const trigger = document.getElementById('reply-trigger-' + commentId);
                const form = document.getElementById('reply-create-' + commentId);
                if (!form || !trigger) {
                    return;
                }

                if (shouldShow) {
                    trigger.classList.add('d-none');
                    form.classList.remove('d-none');
                    const textarea = form.querySelector('textarea[name="reply_message"]');
                    if (textarea) {
                        textarea.focus();
                    }
                    return;
                }

                trigger.classList.remove('d-none');
                form.classList.add('d-none');
            }

            function toggleReplyEdit(commentId, shouldEdit) {
                const replyText = document.getElementById('reply-text-' + commentId);
                const replyActions = document.getElementById('reply-actions-' + commentId);
                const form = document.getElementById('reply-edit-' + commentId);

                if (!replyText || !replyActions || !form) {
                    return;
                }

                if (shouldEdit) {
                    replyText.classList.add('d-none');
                    replyActions.classList.add('d-none');
                    form.classList.remove('d-none');
                    const textarea = form.querySelector('textarea[name="reply_message"]');
                    if (textarea) {
                        textarea.focus();
                        textarea.setSelectionRange(textarea.value.length, textarea.value.length);
                    }
                    return;
                }

                replyText.classList.remove('d-none');
                replyActions.classList.remove('d-none');
                form.classList.add('d-none');
            }
        </script>
    @endif

@endsection

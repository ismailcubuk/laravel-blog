@extends('admin.layouts.app')

@section('title', ' Comments')

@section('content')
<div class="container-fluid py-4">
    <style>
        .admin-comments-wrap {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .admin-comments-table {
            width: 100%;
            table-layout: fixed;
            margin-bottom: 0;
        }

        .admin-comments-table th,
        .admin-comments-table td {
            vertical-align: middle;
            padding: 0.95rem 0.85rem;
            border-color: #edf1f5;
            background: transparent;
        }

        .admin-comments-table th {
            white-space: nowrap;
            font-size: 0.77rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.92);
        }

        .admin-comments-table tbody tr {
            background: #fff;
        }

        .admin-comments-table tbody tr:hover {
            background: #fbfcfe;
        }

        .admin-comments-post {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            min-width: 0;
        }

        .admin-comments-post-thumb {
            width: 40px;
            height: 40px;
            flex: 0 0 40px;
            object-fit: cover;
            border-radius: 10px;
            background: #eef2f6;
            box-shadow: 0 0 0 1px rgba(15, 23, 42, 0.05);
        }

        .admin-comments-post-title {
            display: block;
            min-width: 0;
            color: #1f2937;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.88rem;
            line-height: 1.4;
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        .admin-comments-post-title:hover {
            color: #0d6efd;
        }

        .admin-comments-reply-badge {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            border: 0;
            padding: 0.25rem 0.5rem;
            font-size: 0.7rem;
            font-weight: 600;
            white-space: nowrap;
            line-height: 1.2;
            text-decoration: none;
        }

        .admin-comments-reply-badge.replied {
            background: #e8f7ee;
            color: #198754;
        }

        .admin-comments-reply-badge.pending {
            background: #fff3cd;
            color: #997404;
        }

        .admin-comments-reply-badge.has-reply {
            cursor: pointer;
        }

        .admin-comments-reply-badge.open-reply-modal {
            cursor: pointer;
        }

        .admin-comments-reply-popover {
            max-width: 320px;
            border: 0;
            border-radius: 14px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.18);
        }

        .admin-comments-reply-popover .popover-body {
            padding: 0;
        }

        .admin-comments-reply-card {
            padding: 0.9rem;
        }

        .admin-comments-reply-card-head {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 0;
        }

        .admin-comments-reply-card-avatar {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            object-fit: cover;
            flex: 0 0 48px;
        }

        .admin-comments-reply-card-title {
            display: flex;
            align-items: baseline;
            gap: 0.45rem;
            flex-wrap: wrap;
            margin: 0 0 0.5rem;
        }

        .admin-comments-reply-card-name {
            font-size: 0.92rem;
            font-weight: 700;
            color: #111827;
            line-height: 1.2;
        }

        .admin-comments-reply-card-date {
            font-size: 0.76rem;
            color: #9ca3af;
            line-height: 1.2;
        }

        .admin-comments-reply-card-text {
            margin: 0;
            font-size: 0.84rem;
            line-height: 1.5;
            color: #374151;
            white-space: pre-wrap;
            overflow-wrap: anywhere;
        }

        .admin-comments-author-name {
            font-weight: 600;
            color: #1f2937;
            line-height: 1.35;
            font-size: 0.9rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .admin-comments-author-mail {
            font-size: 0.8rem;
            color: #6b7280;
            line-height: 1.4;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .admin-comments-comment {
            width: 100%;
            max-width: none;
            margin: 0;
            color: #4b5563;
            line-height: 1.5;
            font-size: 0.875rem;
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        .admin-comments-comment-card {
            width: 100%;
            border: 1px solid #edf1f5;
            border-radius: 14px;
            padding: 0.8rem 0.85rem;
            background: #fbfcfe;
        }

        .admin-comments-comment-trigger {
            text-align: left;
            cursor: pointer;
            transition: background-color 0.18s ease, border-color 0.18s ease, box-shadow 0.18s ease;
        }

        .admin-comments-comment-trigger:hover {
            background: #f8fafc;
            border-color: #d9e2ec;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.06);
        }

        .admin-comments-comment-line + .admin-comments-comment-line {
            margin-top: 0.55rem;
            padding-top: 0.55rem;
            border-top: 1px solid #edf1f5;
        }

        .admin-comments-comment-row {
            display: flex;
            align-items: flex-start;
            gap: 0.35rem;
            min-width: 0;
        }

        .admin-comments-comment-label {
            font-size: 0.82rem;
            font-weight: 700;
            color: #1f2937;
            line-height: 1.3;
            white-space: nowrap;
        }

        .admin-comments-comment-label.admin {
            color: #198754;
        }

        .admin-comments-actions {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 0.25rem;
            flex-wrap: nowrap;
        }

        .admin-comments-actions .btn {
            white-space: nowrap;
            padding: 0.28rem 0.42rem;
            font-size: 0.68rem;
            line-height: 1.2;
            border-radius: 0.5rem;
        }

        .admin-comments-actions form {
            display: block;
        }

        .admin-comments-status .badge {
            padding: 0.25rem 0.45rem;
            font-size: 0.7rem;
            line-height: 1.2;
            white-space: nowrap;
            border-radius: 999px;
        }

        .admin-comments-submitted-date,
        .admin-comments-submitted-time {
            display: block;
            white-space: nowrap;
        }

        .admin-comments-submitted-date {
            line-height: 1.2;
            font-size: 0.84rem;
            font-weight: 600;
            color: #1f2937;
        }

        .admin-comments-submitted-time {
            margin-top: 0.15rem;
            font-size: 0.76rem;
            color: #6b7280;
            line-height: 1.2;
        }

        .admin-comments-footer {
            gap: 1rem;
        }

        .admin-comment-reply-modal .modal-dialog {
            max-width: 560px;
        }

        .admin-comment-reply-modal .modal-content {
            border: 0;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.18);
        }

        .admin-comment-reply-modal .modal-header,
        .admin-comment-reply-modal .modal-footer {
            border: 0;
        }

        .admin-comment-reply-modal .modal-header {
            padding: 1rem 1rem 0.5rem;
        }

        .admin-comment-reply-modal .modal-body {
            padding: 0.5rem 1rem 1rem;
        }

        .admin-comment-reply-modal .modal-footer {
            padding: 0 1rem 1rem;
            gap: 0.5rem;
        }

        .admin-comment-reply-block {
            border: 1px solid #edf1f5;
            border-radius: 14px;
            padding: 0.9rem;
            background: #fbfcfe;
        }

        .admin-comment-modal-post {
            border: 1px solid #edf1f5;
            border-radius: 16px;
            overflow: hidden;
            background: #fff;
        }

        .admin-comment-modal-post-thumb img {
            display: block;
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .admin-comment-modal-post-body {
            padding: 1rem;
        }

        .admin-comment-modal-post-category {
            display: inline-block;
            margin-bottom: 0.5rem;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #f48840;
            letter-spacing: 0.03em;
        }

        .admin-comment-modal-post-title {
            margin: 0 0 0.7rem;
            font-size: 1.05rem;
            font-weight: 700;
            line-height: 1.35;
            color: #111827;
        }

        .admin-comment-modal-post-info {
            display: flex;
            flex-wrap: wrap;
            gap: 0.85rem;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .admin-comment-modal-post-info li,
        .admin-comment-modal-post-info a {
            font-size: 0.82rem;
            color: #6b7280;
            text-decoration: none;
        }

        .admin-comment-reply-label {
            display: block;
            margin-bottom: 0.4rem;
            font-size: 0.74rem;
            font-weight: 700;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            color: #6b7280;
        }

        .admin-comment-reply-post {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 700;
            color: #111827;
            line-height: 1.35;
        }

        .admin-comment-reply-author {
            margin: 0 0 0.35rem;
            font-size: 0.84rem;
            font-weight: 600;
            color: #1f2937;
        }

        .admin-comment-reply-author-line {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0 0 0.35rem;
            flex-wrap: wrap;
        }

        .admin-comment-reply-status {
            display: inline-flex;
            align-items: center;
            padding: 0.24rem 0.5rem;
            border-radius: 999px;
            font-size: 0.7rem;
            font-weight: 700;
            line-height: 1.2;
            text-transform: capitalize;
        }

        .admin-comment-reply-status.approved {
            background: #e8f7ee;
            color: #198754;
        }

        .admin-comment-reply-status.pending {
            background: #fff3cd;
            color: #997404;
        }

        .admin-comment-reply-message {
            margin: 0;
            font-size: 0.9rem;
            color: #4b5563;
            line-height: 1.55;
            white-space: pre-wrap;
            overflow-wrap: anywhere;
        }

        .admin-comment-reply-textarea {
            min-height: 130px;
            border-radius: 14px;
            border: 1px solid #d9e2ec;
            resize: vertical;
        }

        .admin-comment-reply-textarea:focus {
            border-color: #f48840;
            box-shadow: 0 0 0 0.2rem rgba(244, 136, 64, 0.16);
        }
        .admin-dark .admin-comments-table th,
        .admin-dark .admin-comments-table td {
            border-color: #334155 !important;
            color: #e2e8f0 !important;
            background: #0f172a !important;
        }

        .admin-dark .admin-comments-table tbody tr {
            background: #0f172a !important;
        }

        .admin-dark .admin-comments-table tbody tr:hover {
            background: #111b2f !important;
        }

        .admin-dark .admin-comments-comment-card,
        .admin-dark .admin-comments-comment-trigger,
        .admin-dark .admin-comment-reply-block,
        .admin-dark .admin-comment-modal-post,
        .admin-dark .admin-comments-reply-popover,
        .admin-dark .admin-comment-reply-modal .modal-content {
            background: #111b2f !important;
            border-color: #334155 !important;
            color: #e2e8f0 !important;
        }

        .admin-dark .admin-comments-author-name,
        .admin-dark .admin-comments-post-title,
        .admin-dark .admin-comment-modal-post-title,
        .admin-dark .admin-comment-reply-post,
        .admin-dark .admin-comment-reply-author {
            color: #f8fafc !important;
        }

        .admin-dark .admin-comments-author-mail,
        .admin-dark .admin-comments-submitted-time,
        .admin-dark .admin-comment-reply-label,
        .admin-dark .admin-comment-modal-post-info li,
        .admin-dark .admin-comment-modal-post-info a,
        .admin-dark .admin-comments-comment,
        .admin-dark .admin-comment-reply-message {
            color: #cbd5e1 !important;
        }

        .admin-dark .card-footer.bg-white.admin-comments-footer {
            background: #0b1220 !important;
            border-top-color: #334155 !important;
        }

        @media (max-width: 1599.98px) {
            .admin-comments-wrap {
                overflow-x: visible;
            }

            .admin-comments-post-thumb {
                width: 34px;
                height: 34px;
                flex-basis: 34px;
            }

            .admin-comments-table {
                table-layout: auto;
            }

            .admin-comments-table colgroup {
                display: none;
            }

            .admin-comments-table thead {
                display: none;
            }

            .admin-comments-table,
            .admin-comments-table tbody,
            .admin-comments-table td {
                display: block;
                width: 100%;
            }

            .admin-comments-table tbody tr {
                display: grid;
                grid-template-columns: minmax(180px, 1fr) minmax(180px, 0.95fr) minmax(260px, 1.45fr) minmax(180px, 1fr);
                grid-template-areas:
                    "post author comment comment"
                    "reply status submitted actions";
                gap: 0.9rem 1rem;
                padding: 1rem;
                border: 1px solid #edf1f5;
                border-radius: 16px;
                box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
                margin-bottom: 0.9rem;
            }

            .admin-comments-table td {
                padding: 0;
                border: 0;
            }

            .admin-comments-table td::before {
                content: attr(data-label);
                display: block;
                margin-bottom: 0.4rem;
                font-size: 0.72rem;
                font-weight: 700;
                letter-spacing: 0.02em;
                text-transform: uppercase;
                color: #6b7280;
            }

            .admin-comments-table td[data-label="Post"] {
                grid-area: post;
            }

            .admin-comments-table td[data-label="Author"] {
                grid-area: author;
            }

            .admin-comments-table td[data-label="Comment"] {
                grid-area: comment;
            }

            .admin-comments-table td[data-label="Reply"] {
                grid-area: reply;
            }

            .admin-comments-table td[data-label="Status"] {
                grid-area: status;
            }

            .admin-comments-table td[data-label="Submitted"] {
                grid-area: submitted;
            }

            .admin-comments-table td[data-label="Actions"] {
                grid-area: actions;
            }

            .admin-comments-post-title {
                font-size: 0.84rem;
            }

            .admin-comments-author-name,
            .admin-comments-author-mail {
                white-space: normal;
                overflow: visible;
                text-overflow: unset;
            }

            .admin-comments-actions {
                display: flex;
                justify-content: flex-start;
                align-items: center;
                gap: 0.3rem;
                flex-wrap: wrap;
            }

            .admin-comments-actions form {
                display: inline-block;
            }

            .admin-comments-actions .btn {
                width: auto;
            }

            .admin-comments-footer {
                align-items: stretch !important;
            }

            .admin-comments-footer nav,
            .admin-comments-footer .pagination {
                width: 100%;
            }

            .admin-comments-footer .pagination {
                justify-content: center;
                flex-wrap: wrap;
            }
        }

        @media (max-width: 1199.98px) {
            .admin-comments-table tbody tr {
                grid-template-columns: minmax(180px, 1fr) minmax(180px, 1fr);
                grid-template-areas:
                    "post author"
                    "comment comment"
                    "reply status"
                    "submitted actions";
            }
        }

        @media (max-width: 575.98px) {
            .admin-comments-post {
                gap: 0.6rem;
            }

            .admin-comments-table tbody tr {
                display: block;
                padding: 0.85rem 0.8rem 0.35rem;
            }

            .admin-comments-comment-card {
                padding: 0.7rem 0.75rem;
            }

            .admin-comments-table td {
                padding: 0 0 0.75rem;
            }

            .admin-comments-table td:last-child {
                padding-bottom: 0;
            }

            .admin-comments-actions {
                display: block;
                text-align: left;
            }

            .admin-comments-actions form {
                display: block;
                margin-top: 0.3rem;
            }

            .admin-comments-actions form:first-child {
                margin-top: 0;
            }

            .admin-comments-actions .btn {
                width: 100%;
            }

            .admin-comments-submitted-date,
            .admin-comments-submitted-time {
                display: inline;
            }

            .admin-comments-submitted-time::before {
                content: " ";
            }

            .admin-comments-post-title {
                font-size: 0.83rem;
            }

            .admin-comment-reply-modal .modal-body,
            .admin-comment-reply-modal .modal-footer,
            .admin-comment-reply-modal .modal-header {
                padding-left: 0.85rem;
                padding-right: 0.85rem;
            }
        }
    </style>

    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="mb-1 text-primary">Comments Management</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <span class="text-muted small text-uppercase">Total</span>
                    <div class="display-6 fw-semibold">{{ $stats['total'] }}</div>
                    <div class="text-muted small">All comments</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <span class="text-muted small text-uppercase">Pending</span>
                    <div class="display-6 fw-semibold text-warning">{{ $stats['pending'] }}</div>
                    <div class="text-muted small">Awaiting review</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <span class="text-muted small text-uppercase">Approved</span>
                    <div class="display-6 fw-semibold text-success">{{ $stats['approved'] }}</div>
                    <div class="text-muted small">Visible on posts</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Filter Comments</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.content.comments') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" value="{{ $filters['search'] }}" class="form-control" placeholder="Author, email, content, post title">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All statuses</option>
                            <option value="pending" {{ $filters['status'] === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $filters['status'] === 'approved' ? 'selected' : '' }}>Approved</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Post</label>
                        <select name="post" class="form-select">
                            <option value="">All posts</option>
                            @foreach($posts as $post)
                                <option value="{{ $post->id }}" {{ (string) $filters['post'] === (string) $post->id ? 'selected' : '' }}>
                                    {{ $post->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary w-100">Apply</button>
                        <a href="{{ route('admin.content.comments') }}" class="btn btn-outline-secondary w-100">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Comments List</h5>
            <span class="badge bg-light text-dark">{{ $comments->total() }} results</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive admin-comments-wrap">
                <table class="table align-middle mb-0 admin-comments-table">
                    <colgroup>
                        <col style="width: 24%;">
                        <col style="width: 11%;">
                        <col>
                        <col style="width: 8%;">
                        <col style="width: 8%;">
                        <col style="width: 9%;">
                        <col style="width: 15%;">
                    </colgroup>
                    <thead class="table-dark">
                        <tr>
                            <th>Post</th>
                            <th>Author</th>
                            <th>Comment</th>
                            <th>Reply</th>
                            <th>Status</th>
                            <th>Submitted</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($comments as $comment)
                            <tr>
                                <td data-label="Post">
                                    @if($comment->post)
                                        <div class="admin-comments-post">
                                            <img
                                                src="{{ $comment->post->image_url }}"
                                                alt="{{ $comment->post->title }}"
                                                class="admin-comments-post-thumb"
                                            >
                                            <a href="{{ route('post.show', $comment->post->slug) }}#comments" target="_blank" class="admin-comments-post-title">
                                                {{ \Illuminate\Support\Str::limit($comment->post->title, 55) }}
                                            </a>
                                        </div>
                                    @else
                                        <span class="text-muted">Deleted post</span>
                                    @endif
                                </td>
                                <td data-label="Author">
                                    <div class="admin-comments-author-name">{{ $comment->name }}</div>
                                    <div class="admin-comments-author-mail">{{ $comment->email }}</div>
                                </td>
                                <td data-label="Comment">
                                    <button
                                        type="button"
                                        class="admin-comments-comment-card admin-comments-comment-trigger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#adminCommentReplyModal"
                                        data-modal-mode="{{ $comment->reply_message ? 'edit' : 'create' }}"
                                        data-reply-action="{{ route('admin.content.comments.reply', $comment) }}?{{ http_build_query(request()->query()) }}"
                                        data-reply-delete-action="{{ $comment->reply_message ? route('admin.content.comments.reply.destroy', $comment) . '?' . http_build_query(request()->query()) : '' }}"
                                        data-post-image="{{ $comment->post?->image_url }}"
                                        data-post-category="{{ $comment->post->category->name ?? 'No Category' }}"
                                        data-post-title="{{ $comment->post->title ?? 'Deleted post' }}"
                                        data-post-author="{{ $comment->post->user->name ?? 'Admin' }}"
                                        data-post-date="{{ $comment->post->created_at?->format('d M Y') }}"
                                        data-post-comments="{{ $comment->post ? $comment->post->comments()->approved()->count() : 0 }}"
                                        data-comment-author="{{ $comment->name }}"
                                        data-comment-status="{{ $comment->status }}"
                                        data-comment-message="{{ $comment->message }}"
                                        data-reply-message="{{ $comment->reply_message }}"
                                    >
                                        <div class="admin-comments-comment-line">
                                            <div class="admin-comments-comment-row">
                                                <span class="admin-comments-comment-label">{{ $comment->name }}:</span>
                                                <p class="admin-comments-comment">{{ \Illuminate\Support\Str::limit($comment->message, 60) }}</p>
                                            </div>
                                        </div>
                                        @if($comment->reply_message)
                                            <div class="admin-comments-comment-line">
                                                <div class="admin-comments-comment-row">
                                                    <span class="admin-comments-comment-label admin">Admin {{ optional($comment->repliedBy)->name ?: 'Admin' }}:</span>
                                                    <p class="admin-comments-comment">{{ \Illuminate\Support\Str::limit($comment->reply_message, 60) }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </button>
                                </td>
                                <td data-label="Reply">
                                    @if($comment->reply_message)
                                        <span class="admin-comments-reply-badge replied">
                                            Replied
                                        </span>
                                    @elseif($comment->post)
                                        <span class="admin-comments-reply-badge pending">
                                            No reply
                                        </span>
                                    @else
                                        <span class="admin-comments-reply-badge pending">No reply</span>
                                    @endif
                                </td>
                                <td data-label="Status" class="admin-comments-status">
                                    @php
                                        $badgeClass = match ($comment->status) {
                                            'approved' => 'bg-success',
                                            default => 'bg-warning text-dark',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ ucfirst($comment->status) }}</span>
                                </td>
                                <td data-label="Submitted">
                                    <span class="admin-comments-submitted-date">{{ $comment->created_at->format('d M Y') }}</span>
                                    <span class="admin-comments-submitted-time">{{ $comment->created_at->format('H:i') }}</span>
                                </td>
                                <td data-label="Actions" class="text-end">
                                    <div class="admin-comments-actions">
                                        <form method="POST" action="{{ route('admin.content.comments.status', $comment) }}" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="btn btn-sm btn-success" {{ $comment->status === 'approved' ? 'disabled' : '' }}>
                                                Approve
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.content.comments.status', $comment) }}" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="pending">
                                            <button type="submit" class="btn btn-sm btn-warning" {{ $comment->status === 'pending' ? 'disabled' : '' }}>
                                                Pending
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.content.comments.destroy', $comment) }}" class="d-inline" onsubmit="return confirm('Delete this comment?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">No comments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white d-flex flex-column flex-md-row align-items-center justify-content-between admin-comments-footer">
            <small class="text-muted">
                Showing {{ $comments->firstItem() ?? 0 }}-{{ $comments->lastItem() ?? 0 }} of {{ $comments->total() }} comments
            </small>

            @if ($comments->hasPages())
                <nav aria-label="Comments pagination">
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item {{ $comments->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $comments->previousPageUrl() ?? '#' }}" aria-label="Previous">
                                &laquo;
                            </a>
                        </li>

                        @foreach ($comments->getUrlRange(1, $comments->lastPage()) as $page => $url)
                            <li class="page-item {{ $page == $comments->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        <li class="page-item {{ $comments->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link" href="{{ $comments->nextPageUrl() ?? '#' }}" aria-label="Next">
                                &raquo;
                            </a>
                        </li>
                    </ul>
                </nav>
            @endif
        </div>
    </div>
</div>

<div class="modal fade admin-comment-reply-modal" id="adminCommentReplyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adminCommentReplyModalTitle">Write Reply</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="adminCommentReplyForm">
                @csrf
                <div class="modal-body">
                    <div class="admin-comment-modal-post mb-3">
                        <div class="admin-comment-modal-post-thumb">
                            <img src="" alt="" id="adminCommentReplyPostImage">
                        </div>
                        <div class="admin-comment-modal-post-body">
                            <span class="admin-comment-modal-post-category" id="adminCommentReplyPostCategory">-</span>
                            <h4 class="admin-comment-modal-post-title" id="adminCommentReplyPost">-</h4>
                            <ul class="admin-comment-modal-post-info">
                                <li><a href="#" id="adminCommentReplyPostAuthor">-</a></li>
                                <li><a href="#" id="adminCommentReplyPostDate">-</a></li>
                                <li><a href="#" id="adminCommentReplyPostComments">-</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="admin-comment-reply-block mb-3">
                        <span class="admin-comment-reply-label">User Comment</span>
                        <div class="admin-comment-reply-author-line">
                            <p class="admin-comment-reply-author" id="adminCommentReplyAuthor">-</p>
                            <span class="admin-comment-reply-status" id="adminCommentReplyStatus">-</span>
                        </div>
                        <p class="admin-comment-reply-message" id="adminCommentReplyMessage">-</p>
                    </div>

                    <div>
                        <label for="adminCommentReplyInput" class="admin-comment-reply-label">Admin Reply</label>
                        <textarea
                            id="adminCommentReplyInput"
                            name="reply_message"
                            class="form-control admin-comment-reply-textarea"
                            placeholder="Write admin reply"
                            required
                        ></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <div class="d-flex align-items-center gap-2">
                        <button type="submit" form="adminCommentReplyDeleteForm" id="adminCommentReplyDeleteButton" class="btn btn-danger d-none" onclick="return confirm('Delete this reply?')">Delete Reply</button>
                        <button type="submit" class="btn btn-primary">Publish Reply</button>
                    </div>
                </div>
            </form>
            <form method="POST" id="adminCommentReplyDeleteForm" class="d-none">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const replyModalElement = document.getElementById('adminCommentReplyModal');
    if (replyModalElement) {
        replyModalElement.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget;
            if (!trigger) {
                return;
            }

            const modalTitleTarget = document.getElementById('adminCommentReplyModalTitle');
            const replyForm = document.getElementById('adminCommentReplyForm');
            const replyDeleteForm = document.getElementById('adminCommentReplyDeleteForm');
            const replyDeleteButton = document.getElementById('adminCommentReplyDeleteButton');
            const postImageTarget = document.getElementById('adminCommentReplyPostImage');
            const postCategoryTarget = document.getElementById('adminCommentReplyPostCategory');
            const postTarget = document.getElementById('adminCommentReplyPost');
            const postAuthorTarget = document.getElementById('adminCommentReplyPostAuthor');
            const postDateTarget = document.getElementById('adminCommentReplyPostDate');
            const postCommentsTarget = document.getElementById('adminCommentReplyPostComments');
            const authorTarget = document.getElementById('adminCommentReplyAuthor');
            const statusTarget = document.getElementById('adminCommentReplyStatus');
            const messageTarget = document.getElementById('adminCommentReplyMessage');
            const inputTarget = document.getElementById('adminCommentReplyInput');

            if (replyForm) {
                replyForm.action = trigger.getAttribute('data-reply-action') || '';
            }

            if (replyDeleteForm) {
                const deleteAction = trigger.getAttribute('data-reply-delete-action') || '';
                replyDeleteForm.action = deleteAction;
                if (replyDeleteButton) {
                    replyDeleteButton.classList.toggle('d-none', deleteAction === '');
                }
            }

            if (modalTitleTarget) {
                modalTitleTarget.textContent = trigger.getAttribute('data-modal-mode') === 'edit'
                    ? 'Edit Reply'
                    : 'Write Reply';
            }

            if (postImageTarget) {
                postImageTarget.src = trigger.getAttribute('data-post-image') || '';
                postImageTarget.alt = trigger.getAttribute('data-post-title') || 'Post image';
            }

            if (postCategoryTarget) {
                postCategoryTarget.textContent = trigger.getAttribute('data-post-category') || '-';
            }

            if (postTarget) {
                postTarget.textContent = trigger.getAttribute('data-post-title') || '-';
            }

            if (postAuthorTarget) {
                postAuthorTarget.textContent = trigger.getAttribute('data-post-author') || '-';
            }

            if (postDateTarget) {
                postDateTarget.textContent = trigger.getAttribute('data-post-date') || '-';
            }

            if (postCommentsTarget) {
                const count = trigger.getAttribute('data-post-comments') || '0';
                postCommentsTarget.textContent = count + ' Comments';
            }

            if (authorTarget) {
                authorTarget.textContent = trigger.getAttribute('data-comment-author') || '-';
            }

            if (statusTarget) {
                const status = trigger.getAttribute('data-comment-status') || '-';
                statusTarget.textContent = status;
                statusTarget.className = 'admin-comment-reply-status ' + status;
            }

            if (messageTarget) {
                messageTarget.textContent = trigger.getAttribute('data-comment-message') || '-';
            }

            if (inputTarget) {
                inputTarget.value = trigger.getAttribute('data-reply-message') || '';
            }
        });

        replyModalElement.addEventListener('shown.bs.modal', function () {
            const inputTarget = document.getElementById('adminCommentReplyInput');
            if (inputTarget) {
                inputTarget.focus();
            }
        });

        replyModalElement.addEventListener('hidden.bs.modal', function () {
            const replyForm = document.getElementById('adminCommentReplyForm');
            const replyDeleteForm = document.getElementById('adminCommentReplyDeleteForm');
            const replyDeleteButton = document.getElementById('adminCommentReplyDeleteButton');
            const inputTarget = document.getElementById('adminCommentReplyInput');

            if (replyForm) {
                replyForm.action = '';
            }

            if (replyDeleteForm) {
                replyDeleteForm.action = '';
            }

            if (replyDeleteButton) {
                replyDeleteButton.classList.add('d-none');
            }

            if (inputTarget) {
                inputTarget.value = '';
            }
        });
    }
});
</script>
@endsection


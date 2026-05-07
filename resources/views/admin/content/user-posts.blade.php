@extends('admin.layouts.app')

@section('title', 'User Posts')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/extracted/admin-content-user-posts.css') }}">
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="mb-1 text-primary">User Posts Management</h1>
            <p class="text-muted mb-0">Review, approve, and inspect posts submitted by users.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4 mb-4 user-posts-stats">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 user-posts-stat">
                <div class="card-body">
                    <span class="text-muted small text-uppercase">Total</span>
                    <div class="display-6 fw-semibold">{{ $stats['total'] }}</div>
                    <div class="text-muted small">User submissions</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 user-posts-stat">
                <div class="card-body">
                    <span class="text-muted small text-uppercase">Pending</span>
                    <div class="display-6 fw-semibold text-warning">{{ $stats['pending'] }}</div>
                    <div class="text-muted small">Awaiting approval</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 user-posts-stat">
                <div class="card-body">
                    <span class="text-muted small text-uppercase">Approved</span>
                    <div class="display-6 fw-semibold text-success">{{ $stats['approved'] }}</div>
                    <div class="text-muted small">Visible on site</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4 user-posts-filter">
        <div class="card-header">
            <h5 class="mb-0">Filter User Posts</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.content.user-posts.index') }}">
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" value="{{ $filters['search'] }}" class="form-control" placeholder="Title, content, author, email">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All statuses</option>
                            <option value="pending" {{ $filters['status'] === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="published" {{ $filters['status'] === 'published' ? 'selected' : '' }}>Approved</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end gap-2">
                        <button type="submit" class="ui-btn ui-btn-primary w-100">Apply</button>
                        <a href="{{ route('admin.content.user-posts.index') }}" class="ui-btn ui-btn-neutral w-100">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm user-posts-card">
        <div class="card-header user-posts-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">User Posts List</h5>
            <div class="d-flex align-items-center gap-2">
                <span class="user-posts-count">{{ $posts->total() }} results</span>
                <span class="user-posts-pending">Pending: {{ $stats['pending'] }}</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive user-posts-wrap">
                <table class="table align-middle mb-0 user-posts-table">
                    <colgroup>
                        <col style="width: 28%;">
                        <col style="width: 18%;">
                        <col>
                        <col style="width: 10%;">
                        <col style="width: 10%;">
                        <col style="width: 16%;">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>Post</th>
                            <th>Author</th>
                            <th>Content</th>
                            <th>Status</th>
                            <th>Submitted</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                            <tr class="{{ $post->status === 'pending' ? 'is-pending' : '' }}">
                                <td data-label="Post">
                                    <div class="user-posts-post">
                                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="user-posts-thumb">
                                        <div>
                                            <a href="{{ route('post.show', $post->slug) }}" target="_blank" class="user-posts-title">
                                                {{ \Illuminate\Support\Str::limit($post->title, 56) }}
                                            </a>
                                            <span class="user-posts-category">{{ $post->category->name ?? 'General' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Author">
                                    <div class="user-posts-author">
                                        <img src="{{ $post->user?->avatar_path ? asset($post->user->avatar_path) : asset('adminlte/img/avatar.png') }}" alt="{{ $post->user->name ?? 'User' }}">
                                        <div>
                                            <strong>{{ $post->user->name ?? 'User' }}</strong>
                                            <span>{{ $post->user->email ?? '-' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Content">
                                    <p class="user-posts-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags((string) $post->content), 110) }}</p>
                                </td>
                                <td data-label="Status">
                                    <span class="user-posts-status {{ $post->status === 'published' ? 'approved' : 'pending' }}">
                                        {{ $post->status === 'published' ? 'Approved' : 'Pending' }}
                                    </span>
                                </td>
                                <td data-label="Submitted">
                                    <span class="user-posts-date">{{ $post->created_at->format('d M Y') }}</span>
                                    <span class="user-posts-time">{{ $post->created_at->format('H:i') }}</span>
                                </td>
                                <td data-label="Actions" class="text-end">
                                    <div class="user-posts-actions">
                                        <form method="POST" action="{{ route('admin.content.user-posts.status', $post) }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="published">
                                            <button type="submit" class="ui-btn ui-btn-success ui-btn-sm" {{ $post->status === 'published' ? 'disabled' : '' }}>Approve</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.content.user-posts.status', $post) }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="pending">
                                            <button type="submit" class="ui-btn ui-btn-warning ui-btn-sm" {{ $post->status === 'pending' ? 'disabled' : '' }}>Pending</button>
                                        </form>
                                        <button type="button" class="ui-btn ui-btn-danger ui-btn-sm user-posts-details"
                                            data-bs-toggle="modal"
                                            data-bs-target="#userPostDetailsModal"
                                            data-title="{{ $post->title }}"
                                            data-author="{{ $post->user->name ?? 'User' }}"
                                            data-email="{{ $post->user->email ?? '-' }}"
                                            data-avatar="{{ $post->user?->avatar_path ? asset($post->user->avatar_path) : asset('adminlte/img/avatar.png') }}"
                                            data-image="{{ $post->image_url }}"
                                            data-category="{{ $post->category->name ?? 'General' }}"
                                            data-status="{{ $post->status === 'published' ? 'Approved' : 'Pending' }}"
                                            data-date="{{ $post->created_at->format('d M Y H:i') }}"
                                            data-content="{{ $post->content }}"
                                        >Details</button>
                                        <form method="POST" action="{{ route('admin.content.user-posts.destroy', $post) }}" onsubmit="return confirm('Delete this user post?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="ui-btn ui-btn-danger ui-btn-sm">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">No user posts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white d-flex flex-column flex-md-row align-items-center justify-content-between">
            <small class="text-muted">
                Showing {{ $posts->firstItem() ?? 0 }}-{{ $posts->lastItem() ?? 0 }} of {{ $posts->total() }} user posts
            </small>
            {{ $posts->links() }}
        </div>
    </div>
</div>

<div class="modal fade user-post-modal" id="userPostDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">User Post Details</h5>
                    <small class="text-muted" id="userPostDetailDate">-</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="user-post-modal-hero">
                    <img id="userPostDetailImage" src="" alt="">
                    <div>
                        <span id="userPostDetailCategory">-</span>
                        <h3 id="userPostDetailTitle">-</h3>
                        <div class="user-post-modal-author">
                            <img id="userPostDetailAvatar" src="" alt="">
                            <div>
                                <strong id="userPostDetailAuthor">-</strong>
                                <small id="userPostDetailEmail">-</small>
                            </div>
                        </div>
                        <span class="user-posts-status pending" id="userPostDetailStatus">-</span>
                    </div>
                </div>
                <div class="user-post-modal-content" id="userPostDetailContent"></div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('.user-posts-details').forEach((button) => {
        button.addEventListener('click', () => {
            document.getElementById('userPostDetailImage').src = button.dataset.image || '';
            document.getElementById('userPostDetailAvatar').src = button.dataset.avatar || '';
            document.getElementById('userPostDetailTitle').textContent = button.dataset.title || '-';
            document.getElementById('userPostDetailAuthor').textContent = button.dataset.author || '-';
            document.getElementById('userPostDetailEmail').textContent = button.dataset.email || '-';
            document.getElementById('userPostDetailCategory').textContent = button.dataset.category || '-';
            document.getElementById('userPostDetailDate').textContent = button.dataset.date || '-';
            document.getElementById('userPostDetailStatus').textContent = button.dataset.status || '-';
            document.getElementById('userPostDetailStatus').className = 'user-posts-status ' + (button.dataset.status === 'Approved' ? 'approved' : 'pending');
            document.getElementById('userPostDetailContent').textContent = button.dataset.content || '';
        });
    });
</script>
@endpush
@endsection

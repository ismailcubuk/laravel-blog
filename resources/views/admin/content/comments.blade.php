@extends('admin.layouts.app')

@section('title', ' Comments')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="mb-1 text-primary">Comments Management</h1>
            <p class="text-muted mb-0">Postlara gelen tum yorumlar burada listelenir ve admin tarafindan yonetilir.</p>
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
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Author</th>
                            <th>Comment</th>
                            <th>Post</th>
                            <th>Status</th>
                            <th>Submitted</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($comments as $comment)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $comment->name }}</div>
                                    <div class="small text-muted">{{ $comment->email }}</div>
                                </td>
                                <td style="min-width: 280px;">
                                    {{ \Illuminate\Support\Str::limit($comment->message, 110) }}
                                </td>
                                <td>
                                    @if($comment->post)
                                        <a href="{{ route('post.show', $comment->post->slug) }}#comments" target="_blank" class="text-decoration-none">
                                            {{ $comment->post->title }}
                                        </a>
                                    @else
                                        <span class="text-muted">Deleted post</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $badgeClass = match ($comment->status) {
                                            'approved' => 'bg-success',
                                            default => 'bg-warning text-dark',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ ucfirst($comment->status) }}</span>
                                </td>
                                <td>{{ $comment->created_at->format('d M Y H:i') }}</td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2 flex-wrap">
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
                                <td colspan="6" class="text-center py-4">No comments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
            <small class="text-muted">
                Showing {{ $comments->firstItem() ?? 0 }}-{{ $comments->lastItem() ?? 0 }} of {{ $comments->total() }} comments
            </small>
            {{ $comments->links() }}
        </div>
    </div>
</div>
@endsection

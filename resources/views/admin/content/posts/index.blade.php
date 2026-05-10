@extends('admin.layouts.app')

@section('content')
@php
    $currentSort = $sort ?? 'created_at';
    $currentDirection = $direction ?? 'desc';

    $nextDirection = fn (string $column) => $currentSort === $column && $currentDirection === 'asc' ? 'desc' : 'asc';

    $sortIcon = function (string $column) use ($currentSort, $currentDirection): string {
        if ($currentSort !== $column) {
            return 'bi-arrow-down-up';
        }

        return $currentDirection === 'asc' ? 'bi-sort-alpha-down' : 'bi-sort-alpha-up';
    };
@endphp

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/posts/index.css') }}">
@endpush

<div class="container-fluid py-4">
    <div class="d-flex align-items-center mb-4">
        <h1 class="mb-0 text-primary">Posts Management</h1>
    </div>

    @if(session('success'))
        <div class="flash-toast" id="flashToast" role="status" aria-live="polite" aria-atomic="true">
            <div class="flash-toast-head">
                <span>{{ session('success') }}</span>
            </div>
            <div class="flash-toast-progress" aria-hidden="true">
                <div class="flash-toast-progress-bar" id="flashProgressBar"></div>
            </div>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center">
                    <h5 class="mb-0">Posts List</h5>
                    <a href="{{ route('admin.content.posts.create') }}" class="ui-btn ui-btn-success ui-btn-sm ms-auto">
                        <i class="bi bi-plus-lg"></i> New Post
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>
                                        <a
                                            href="{{ route('admin.content.posts.index', array_merge(request()->except('page'), ['sort' => 'title', 'direction' => $nextDirection('title')])) }}"
                                            class="sort-link"
                                        >
                                            Name
                                            <i class="bi {{ $sortIcon('title') }}"></i>
                                        </a>
                                    </th>
                                    <th>
                                        <a
                                            href="{{ route('admin.content.posts.index', array_merge(request()->except('page'), ['sort' => 'author', 'direction' => $nextDirection('author')])) }}"
                                            class="sort-link"
                                        >
                                            Author
                                            <i class="bi {{ $sortIcon('author') }}"></i>
                                        </a>
                                    </th>
                                    <th>
                                        <a
                                            href="{{ route('admin.content.posts.index', array_merge(request()->except('page'), ['sort' => 'category', 'direction' => $nextDirection('category')])) }}"
                                            class="sort-link"
                                        >
                                            Category
                                            <i class="bi {{ $sortIcon('category') }}"></i>
                                        </a>
                                    </th>
                                    <th>
                                        <a
                                            href="{{ route('admin.content.posts.index', array_merge(request()->except('page'), ['sort' => 'created_at', 'direction' => $nextDirection('created_at')])) }}"
                                            class="sort-link"
                                        >
                                            Created At
                                            <i class="bi {{ $sortIcon('created_at') }}"></i>
                                        </a>
                                    </th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($posts as $post)
                                    <tr>
                                        <td>
                                            <img
                                                src="{{ $post->image ? asset(ltrim($post->image, '/')) : asset('assets/images/blog-post-01.jpg') }}"
                                                alt="{{ $post->title }}"
                                                width="48"
                                                height="48"
                                                class="rounded"
                                                style="object-fit: cover;"
                                            >
                                        </td>
                                        <td>
                                            <a href="{{ route('post.show', $post->slug) }}" class="fw-semibold text-decoration-none">
                                                {{ $post->title }}
                                            </a>
                                        </td>
                                        <td>{{ $post->user->name ?? 'Unknown Admin' }}</td>
                                        <td>{{ $post->category->name ?? 'N/A' }}</td>
                                        <td>{{ $post->created_at->format('d M Y') }}</td>
                                        <td class="text-center">
                                            <div class="posts-actions">
                                                <a href="{{ route('admin.content.posts.edit', $post) }}" class="ui-btn ui-btn-warning ui-btn-sm">Edit</a>
                                                <form action="{{ route('admin.content.posts.destroy', $post) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="ui-btn ui-btn-danger ui-btn-sm" onclick="return confirm('Delete this post?')">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-3">No posts found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3 d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
                        <small class="text-muted">
                            Showing {{ $posts->firstItem() ?? 0 }}-{{ $posts->lastItem() ?? 0 }} of {{ $posts->total() }} posts
                        </small>

                        @if ($posts->hasPages())
                            <nav aria-label="Posts pagination">
                                <ul class="pagination pagination-sm mb-0">
                                    <li class="page-item {{ $posts->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $posts->previousPageUrl() ?? '#' }}" aria-label="Previous">
                                            &laquo;
                                        </a>
                                    </li>

                                    @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                                        <li class="page-item {{ $page == $posts->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    <li class="page-item {{ $posts->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link" href="{{ $posts->nextPageUrl() ?? '#' }}" aria-label="Next">
                                            &raquo;
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
@push('scripts')
<script src="{{ asset('assets/js/admin/posts/flash-toast.js') }}"></script>
@endpush
@endif
@endsection


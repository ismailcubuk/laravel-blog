@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex align-items-center mb-4">
        <h1 class="mb-0 text-primary">Posts Management</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white d-flex align-items-center">
                    <h5 class="mb-0">Posts List</h5>
                    <a href="{{ route('admin.content.posts.create') }}" class="btn btn-success btn-sm ms-auto">
                        <i class="bi bi-plus-lg"></i> New Post
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Category</th>
                                    <th>Created At</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($posts as $post)
                                    <tr>
                                        <td>
                                            <img
                                                src="{{ $post->image ? asset(ltrim($post->image, '/')) : 'https://picsum.photos/seed/' . $post->id . '/60/60' }}"
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
                                            <a href="{{ route('admin.content.posts.edit', $post) }}" class="btn btn-sm btn-warning me-1">Edit</a>
                                            <form action="{{ route('admin.content.posts.destroy', $post) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this post?')">Delete</button>
                                            </form>
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
                    <div class="p-3">{{ $posts->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0 text-primary">Posts Management</h1>
        <a href="{{ route('admin.content.posts.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i> New Post
        </a>
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
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Posts List</h5>
                    <a href="{{ route('admin.content.posts.create') }}" class="btn btn-success btn-sm">
                        <i class="bi bi-plus-lg"></i> New Post
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Created At</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($posts as $post)
                                    <tr>
                                        <td>{{ $post->id }}</td>
                                        <td>{{ $post->title }}</td>
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
                                        <td colspan="5" class="text-center py-3">No posts found</td>
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
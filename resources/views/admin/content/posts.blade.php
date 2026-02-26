@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">

    <h1 class="mb-4 text-primary">Posts Management</h1>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- Form --}}
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ isset($editPost) ? 'Edit Post' : 'Create Post' }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($editPost) ? route('admin.content.posts.update', $editPost) : route('admin.content.posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($editPost))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $editPost->title ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Slug</label>
                            <input type="text" name="slug" class="form-control" value="{{ old('slug', $editPost->slug ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        @if((isset($editPost) && $editPost->category_id == $category->id) || old('category_id') == $category->id) selected @endif>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Content</label>
                            <textarea name="content" class="form-control" rows="5" required>{{ old('content', $editPost->content ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control">
                            @if(isset($editPost) && $editPost->image)
                                <img src="{{ $editPost->image }}" width="100" class="mt-2 rounded">
                            @endif
                        </div>

                        <button class="btn btn-primary w-100">{{ isset($editPost) ? 'Update Post' : 'Create Post' }}</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- List --}}
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Posts List</h5>
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

                    <div class="p-3">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
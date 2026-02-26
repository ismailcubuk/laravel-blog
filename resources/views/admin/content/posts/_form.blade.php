<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">{{ isset($post) ? 'Edit Post' : 'Create Post' }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ isset($post) ? route('admin.content.posts.update', $post) : route('admin.content.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($post))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $post->title ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Slug</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug', $post->slug ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            @if((isset($post) && $post->category_id == $category->id) || old('category_id') == $category->id) selected @endif>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea name="content" class="form-control" rows="5" required>{{ old('content', $post->content ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control">
                @if(isset($post) && $post->image)
                    <img src="{{ $post->image }}" width="100" class="mt-2 rounded">
                @endif
            </div>

            <button class="btn btn-primary w-100">{{ isset($post) ? 'Update Post' : 'Create Post' }}</button>
        </form>
    </div>
</div>
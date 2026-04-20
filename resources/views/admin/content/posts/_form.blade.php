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
                <div class="pro-upload" data-file-upload>
                    <input type="file" name="image" class="pro-upload-input" id="postImageInput">
                    <label for="postImageInput" class="pro-upload-trigger">
                        <span class="pro-upload-icon"><i class="bi bi-cloud-arrow-up"></i></span>
                        <span class="pro-upload-texts">
                            <span class="pro-upload-title">Upload image</span>
                            <span class="pro-upload-sub">JPG, PNG, WEBP</span>
                        </span>
                        <span class="pro-upload-file" data-file-name>No file selected</span>
                    </label>
                </div>
                @if(isset($post) && $post->image)
                    <div class="mt-2">
                        <img src="{{ $post->image }}" width="120" class="rounded border">
                    </div>
                @endif
            </div>

            <button class="btn btn-primary w-100">{{ isset($post) ? 'Update Post' : 'Create Post' }}</button>
        </form>
    </div>
</div>

@once
    @push('styles')
    <style>
        .pro-upload {
            position: relative;
        }

        .pro-upload-input {
            position: absolute;
            width: 1px;
            height: 1px;
            opacity: 0;
            pointer-events: none;
        }

        .pro-upload-trigger {
            width: 100%;
            border: 1px solid var(--admin-input-border);
            border-radius: 14px;
            background: linear-gradient(180deg, rgba(var(--admin-primary-rgb), 0.08), rgba(var(--admin-primary-rgb), 0.03));
            color: var(--admin-text);
            min-height: 58px;
            padding: 0.65rem 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
        }

        .pro-upload-trigger:hover {
            border-color: rgba(var(--admin-primary-rgb), 0.68);
            box-shadow: 0 10px 20px rgba(var(--admin-primary-rgb), 0.14);
            transform: translateY(-1px);
        }

        .pro-upload-input:focus + .pro-upload-trigger {
            border-color: var(--admin-focus);
            box-shadow: 0 0 0 4px rgba(var(--admin-primary-rgb), 0.16);
        }

        .pro-upload-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: rgba(var(--admin-primary-rgb), 0.18);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: var(--admin-primary);
            flex: 0 0 auto;
        }

        .pro-upload-texts {
            display: grid;
            gap: 2px;
            min-width: 0;
        }

        .pro-upload-title {
            font-size: 0.9rem;
            font-weight: 800;
            line-height: 1.2;
        }

        .pro-upload-sub {
            font-size: 0.76rem;
            color: var(--admin-muted);
        }

        .pro-upload-file {
            margin-left: auto;
            max-width: 48%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-size: 0.8rem;
            padding: 0.3rem 0.55rem;
            border-radius: 999px;
            border: 1px solid rgba(var(--admin-primary-rgb), 0.3);
            background: rgba(var(--admin-primary-rgb), 0.12);
            color: var(--admin-text);
            font-weight: 700;
        }

        .admin-dark .pro-upload-trigger {
            border-color: #334155;
            background: linear-gradient(180deg, rgba(30, 41, 59, 0.95), rgba(15, 23, 42, 0.95));
        }

        .admin-dark .pro-upload-icon {
            background: rgba(59, 130, 246, 0.2);
            color: #93c5fd;
        }

        .admin-dark .pro-upload-file {
            border-color: #475569;
            background: rgba(148, 163, 184, 0.16);
            color: #e2e8f0;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-file-upload]').forEach(function (root) {
                const input = root.querySelector('.pro-upload-input');
                const nameTag = root.querySelector('[data-file-name]');
                if (!input || !nameTag) {
                    return;
                }

                input.addEventListener('change', function () {
                    const file = input.files && input.files[0];
                    nameTag.textContent = file ? file.name : 'No file selected';
                });
            });
        });
    </script>
    @endpush
@endonce

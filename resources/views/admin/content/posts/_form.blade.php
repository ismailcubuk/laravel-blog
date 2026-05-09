<div class="card shadow-sm admin-post-form-card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">{{ isset($post) ? 'Edit Post' : 'Create Post' }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ isset($post) ? route('admin.content.posts.update', $post) : route('admin.content.posts.store') }}" method="POST" enctype="multipart/form-data" class="admin-post-form">
            @csrf
            @if(isset($post))
                @method('PUT')
            @endif

            <div class="admin-post-form-layout">
                <div class="admin-post-form-main">
                    <section class="admin-post-section">
                        <div class="admin-post-section-head">
                            <div>
                                <h6>Post identity</h6>
                                <p>Set the public title and URL slug for this article.</p>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-lg-7">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" value="{{ old('title', $post->title ?? '') }}" required data-post-title>
                            </div>
                            <div class="col-lg-5">
                                <label class="form-label">Slug</label>
                                <input type="text" name="slug" class="form-control" value="{{ old('slug', $post->slug ?? '') }}" required data-post-slug>
                            </div>
                        </div>
                    </section>

                    <section class="admin-post-section">
                        <div class="admin-post-section-head">
                            <div>
                                <h6>Content</h6>
                                <p>Format the article with links, lists, quotes, code snippets, and GIF embeds.</p>
                            </div>
                        </div>

                        <div class="admin-post-editor" data-admin-post-editor>
                            <div class="admin-post-editor-toolbar" role="toolbar" aria-label="Post content tools">
                                <button type="button" class="admin-post-editor-tool" data-editor-action="bold" title="Bold"><i class="bi bi-type-bold" aria-hidden="true"></i></button>
                                <button type="button" class="admin-post-editor-tool" data-editor-action="italic" title="Italic"><i class="bi bi-type-italic" aria-hidden="true"></i></button>
                                <span class="admin-post-editor-separator" aria-hidden="true"></span>
                                <button type="button" class="admin-post-editor-tool" data-editor-action="unordered" title="Bullet list"><i class="bi bi-list-ul" aria-hidden="true"></i></button>
                                <button type="button" class="admin-post-editor-tool" data-editor-action="ordered" title="Numbered list"><i class="bi bi-list-ol" aria-hidden="true"></i></button>
                                <button type="button" class="admin-post-editor-tool" data-editor-action="quote" title="Quote"><i class="bi bi-blockquote-left" aria-hidden="true"></i></button>
                                <span class="admin-post-editor-separator" aria-hidden="true"></span>
                                <button type="button" class="admin-post-editor-tool" data-editor-action="link" title="Link"><i class="bi bi-link-45deg" aria-hidden="true"></i></button>
                                <button type="button" class="admin-post-editor-tool" data-editor-action="gif" title="GIF"><span>GIF</span></button>
                                <button type="button" class="admin-post-editor-tool" data-editor-action="code" title="Code"><i class="bi bi-code-slash" aria-hidden="true"></i></button>
                                <span class="admin-post-editor-spacer"></span>
                                <button type="button" class="admin-post-editor-tool" data-editor-action="clear" title="Clear"><i class="bi bi-eraser" aria-hidden="true"></i></button>
                                <button type="button" class="admin-post-editor-tool" data-editor-action="fullscreen" title="Expand"><i class="bi bi-arrows-fullscreen" aria-hidden="true"></i></button>
                            </div>
                            <textarea
                                name="content"
                                class="form-control admin-post-editor-input"
                                rows="8"
                                maxlength="20000"
                                placeholder="Write post content..."
                                required
                            >{{ old('content', $post->content ?? '') }}</textarea>
                            <div class="admin-post-editor-counter">Characters: <span data-editor-count>0</span></div>
                        </div>

                        <div class="admin-post-editor-proof">
                            <div class="admin-post-editor-proof-title">Writing check:</div>
                            <label class="admin-post-editor-check">
                                <input type="checkbox" data-proof-option="punctuation">
                                <span>
                                    <strong>Period</strong>
                                    <small>Adds missing periods to line endings.</small>
                                </span>
                            </label>
                            <label class="admin-post-editor-check">
                                <input type="checkbox" data-proof-option="capital">
                                <span>
                                    <strong>Capital letter</strong>
                                    <small>Fixes sentence starts.</small>
                                </span>
                            </label>
                            <button type="button" class="admin-post-editor-fix" data-proof-fix>
                                <i class="bi bi-spellcheck" aria-hidden="true"></i>
                                Fix
                            </button>
                        </div>
                    </section>
                </div>

                <aside class="admin-post-form-side">
                    <section class="admin-post-side-card admin-post-publish-card">
                        <div class="admin-post-side-head">
                            <span>Publish setup</span>
                            <i class="bi bi-send" aria-hidden="true"></i>
                        </div>

                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    @if((isset($post) && $post->category_id == $category->id) || old('category_id') == $category->id) selected @endif>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        <button class="btn btn-primary w-100 mt-3">{{ isset($post) ? 'Update Post' : 'Create Post' }}</button>
                    </section>

                    <section class="admin-post-side-card">
                        <div class="admin-post-side-head">
                            <span>Cover image</span>
                            <i class="bi bi-image" aria-hidden="true"></i>
                        </div>

                        <div class="pro-upload" data-file-upload>
                            <input type="file" name="image" class="pro-upload-input" id="postImageInput" data-post-image>
                            <label for="postImageInput" class="pro-upload-trigger">
                                <span class="pro-upload-icon"><i class="bi bi-cloud-arrow-up"></i></span>
                                <span class="pro-upload-texts">
                                    <span class="pro-upload-title">Upload image</span>
                                    <span class="pro-upload-sub">JPG, PNG, WEBP, GIF - Max 10 MB - 5000x5000</span>
                                </span>
                                <span class="pro-upload-file" data-file-name>No file selected</span>
                            </label>
                        </div>
                        @if(isset($post) && $post->image)
                            <div class="admin-post-image-preview">
                                <img src="{{ $post->image }}" alt="Current post image">
                            </div>
                        @else
                            <div class="admin-post-image-preview is-empty" data-image-preview-box>
                                <i class="bi bi-card-image" aria-hidden="true"></i>
                                <span>No cover selected</span>
                            </div>
                        @endif
                    </section>

                </aside>
            </div>
        </form>
    </div>
</div>

@once
    @push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/components/file-upload.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/admin/posts/form.css') }}">
@endpush

    @push('scripts')
<script src="{{ asset('assets/js/admin/components/file-upload.js') }}"></script>
<script src="{{ asset('assets/js/admin/posts/form-editor.js') }}"></script>
@endpush
@endonce

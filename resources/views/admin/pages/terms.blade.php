@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4 terms-editor-page">
    <div class="terms-editor-hero mb-3">
        <div>
            <h1 class="terms-editor-title mb-1">Terms of Use</h1>
            <p class="terms-editor-subtitle mb-0">Manage legal text shown in the registration modal.</p>
        </div>
        <div class="terms-editor-badge">
            <i class="fa-solid fa-shield-halved"></i>
            <span>Live Content</span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.pages.terms.update') }}" class="terms-editor-grid">
        @csrf
        @method('PUT')

        <section class="terms-card terms-card-editor">
            <div class="terms-card-head">
                <h5 class="mb-0">Editor</h5>
            </div>
            <div class="terms-card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Title</label>
                    <input
                        type="text"
                        id="termsTitleInput"
                        name="title"
                        class="form-control"
                        value="{{ old('title', $page->title) }}"
                        required
                    >
                </div>

                <div class="mb-2 d-flex align-items-center justify-content-between gap-2">
                    <label class="form-label fw-semibold mb-0">Content</label>
                    <span class="terms-editor-meta" id="termsEditorMeta">0 chars</span>
                </div>
                <textarea
                    id="termsDescriptionInput"
                    name="description"
                    class="form-control terms-textarea"
                    rows="16"
                    required
                >{{ old('description', $page->description) }}</textarea>

                <div class="terms-editor-actions mt-3">
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-floppy-disk me-1"></i>
                        Save Terms
                    </button>
                </div>
            </div>
        </section>

        <section class="terms-card terms-card-preview">
            <div class="terms-card-head">
                <h5 class="mb-0">Live Preview</h5>
            </div>
            <div class="terms-card-body">
                <h4 id="termsPreviewTitle" class="terms-preview-title">{{ old('title', $page->title) }}</h4>
                <div id="termsPreviewBody" class="terms-preview-body">
                    {!! old('description', $page->description) !!}
                </div>
            </div>
        </section>
    </form>
</div>
@endsection

@push('styles')
<style>
    .terms-editor-page {
        --terms-border: rgba(var(--admin-primary-rgb), 0.14);
        --terms-soft: rgba(var(--admin-primary-rgb), 0.06);
    }
    .terms-editor-hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        border: 1px solid var(--terms-border);
        border-radius: 14px;
        background: linear-gradient(135deg, rgba(var(--admin-primary-rgb), 0.11), rgba(var(--admin-primary-rgb), 0.03));
        padding: 0.85rem 1rem;
    }
    .terms-editor-title {
        font-size: 1.55rem;
        font-weight: 800;
        letter-spacing: -0.01em;
    }
    .terms-editor-subtitle {
        color: var(--admin-muted);
    }
    .terms-editor-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        font-weight: 700;
        border: 1px solid var(--terms-border);
        border-radius: 999px;
        background: var(--terms-soft);
        padding: 0.4rem 0.7rem;
        color: var(--admin-text);
        white-space: nowrap;
    }
    .terms-editor-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        gap: 14px;
    }
    .terms-card {
        border: 1px solid var(--terms-border);
        border-radius: 14px;
        background: var(--admin-surface);
        box-shadow: var(--admin-shadow);
        overflow: hidden;
    }
    .terms-card-head {
        border-bottom: 1px solid var(--terms-border);
        background: rgba(var(--admin-primary-rgb), 0.07);
        padding: 0.75rem 0.95rem;
    }
    .terms-card-head h5 {
        font-weight: 800;
        letter-spacing: 0.01em;
    }
    .terms-card-body {
        padding: 0.95rem;
    }
    .terms-textarea { min-height: 390px; }
    .terms-card-editor .ck-editor__editable_inline {
        min-height: 390px;
        max-height: 560px;
    }
    .terms-card-editor .ck.ck-editor__main > .ck-editor__editable {
        background: var(--admin-input-bg);
        color: var(--admin-text);
        border-color: var(--admin-input-border);
    }
    .terms-card-editor .ck.ck-toolbar {
        background: rgba(var(--admin-primary-rgb), 0.08);
        border-color: var(--admin-input-border);
    }
    .terms-card-editor .ck.ck-button,
    .terms-card-editor .ck.ck-button .ck-button__label {
        color: var(--admin-text);
    }
    .terms-card-editor .ck.ck-button:hover,
    .terms-card-editor .ck.ck-button.ck-on {
        background: rgba(var(--admin-primary-rgb), 0.18) !important;
        color: var(--admin-text) !important;
    }
    .terms-card-editor .ck.ck-dropdown__panel,
    .terms-card-editor .ck.ck-list {
        background: var(--admin-surface);
        border-color: var(--admin-input-border);
    }
    .terms-card-editor .ck.ck-list__item .ck-button {
        color: var(--admin-text);
    }
    .terms-card-editor .ck.ck-input {
        background: var(--admin-input-bg);
        color: var(--admin-text);
        border-color: var(--admin-input-border);
    }
    .terms-card-editor .ck.ck-placeholder::before {
        color: var(--admin-muted);
        opacity: 0.9;
    }
    .terms-editor-meta {
        font-size: 0.78rem;
        font-weight: 700;
        color: var(--admin-muted);
        border: 1px solid var(--terms-border);
        border-radius: 999px;
        padding: 0.22rem 0.55rem;
        background: var(--terms-soft);
    }
    .terms-editor-actions {
        display: flex;
        justify-content: flex-end;
    }
    .terms-preview-title {
        font-weight: 800;
        margin-bottom: 0.8rem;
        color: var(--admin-text);
    }
    .terms-preview-body h2,
    .terms-preview-body h3,
    .terms-preview-body h4,
    .terms-preview-body h5,
    .terms-preview-body h6 {
        margin-top: 0.95rem;
        margin-bottom: 0.35rem;
        font-weight: 800;
        color: var(--admin-text);
    }
    .terms-preview-body p,
    .terms-preview-body li,
    .terms-preview-body blockquote {
        color: var(--admin-text);
        line-height: 1.6;
    }
    .terms-preview-body blockquote {
        margin: 0.75rem 0;
        border-left: 3px solid rgba(var(--admin-primary-rgb), 0.45);
        padding: 0.45rem 0.7rem;
        background: rgba(var(--admin-primary-rgb), 0.06);
        border-radius: 0 10px 10px 0;
    }
    .terms-preview-body a {
        color: var(--admin-primary);
        font-weight: 700;
        text-decoration: underline;
    }
    @media (max-width: 991.98px) {
        .terms-editor-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const titleInput = document.getElementById('termsTitleInput');
        const bodyInput = document.getElementById('termsDescriptionInput');
        const previewTitle = document.getElementById('termsPreviewTitle');
        const previewBody = document.getElementById('termsPreviewBody');
        const meta = document.getElementById('termsEditorMeta');

        if (!titleInput || !bodyInput || !previewTitle || !previewBody || !meta) {
            return;
        }

        const syncPreview = function (content) {
            previewTitle.textContent = titleInput.value.trim() || 'Terms of Use';
            previewBody.innerHTML = content || '<p>Terms content will appear here.</p>';
            meta.textContent = `${(content || '').length} chars`;
        };

        titleInput.addEventListener('input', () => syncPreview(bodyInput.value));

        ClassicEditor.create(bodyInput, {
            toolbar: [
                'heading', '|',
                'bold', 'italic', 'link', '|',
                'bulletedList', 'numberedList', 'blockQuote', '|',
                'undo', 'redo'
            ]
        }).then((editor) => {
            const update = () => {
                const data = editor.getData();
                bodyInput.value = data;
                syncPreview(data);
            };

            editor.model.document.on('change:data', update);
            update();
        }).catch(() => {
            bodyInput.addEventListener('input', () => syncPreview(bodyInput.value));
            syncPreview(bodyInput.value);
        });

        syncPreview(bodyInput.value);
    });
</script>
@endpush

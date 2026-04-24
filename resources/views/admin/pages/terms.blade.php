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
                    <button type="submit" class="btn terms-save-btn">
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
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/extracted/admin-pages-terms.css') }}">
@endpush
@endpush

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
@push('scripts')
<script src="{{ asset('assets/js/extracted/admin-pages-terms.js') }}"></script>
@endpush
@endpush




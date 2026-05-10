@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h1 class="mb-4 text-primary">About Page Settings</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.pages.about.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="mb-0">Basic Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Page Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $page->title) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="5">{{ old('description', $page->description) }}</textarea>
                </div>

                <div class="mb-0">
                    <label class="form-label">Image</label>
                    @if($page->hero_image)
                        <div class="mb-2">
                            <img src="{{ asset($page->hero_image) }}" alt="About image" style="max-width:200px" class="img-fluid rounded border">
                        </div>
                    @endif
                    <input type="file" name="hero_image" class="form-control">
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header d-flex align-items-center justify-content-between gap-2">
                <div>
                    <h5 class="mb-1">Sections Builder</h5>
                    <small class="text-light opacity-75">Choose a layout and fill each column content.</small>
                </div>
            </div>
            <div class="card-body">
                <div class="section-layout-grid mb-3">
                    <button type="button" class="section-layout-btn" onclick="addSection('full-width')">
                        <span class="section-layout-icon section-layout-icon-grid section-layout-icon-grid-1"><span></span></span>
                        <span class="section-layout-copy">
                            <strong>Full Width</strong>
                            <small>1 column block</small>
                        </span>
                    </button>
                    <button type="button" class="section-layout-btn" onclick="addSection('two-columns')">
                        <span class="section-layout-icon section-layout-icon-grid section-layout-icon-grid-2"><span></span><span></span></span>
                        <span class="section-layout-copy">
                            <strong>2 Columns</strong>
                            <small>Side by side</small>
                        </span>
                    </button>
                    <button type="button" class="section-layout-btn" onclick="addSection('three-columns')">
                        <span class="section-layout-icon section-layout-icon-grid section-layout-icon-grid-3"><span></span><span></span><span></span></span>
                        <span class="section-layout-copy">
                            <strong>3 Columns</strong>
                            <small>Balanced grid</small>
                        </span>
                    </button>
                    <button type="button" class="section-layout-btn" onclick="addSection('four-columns')">
                        <span class="section-layout-icon section-layout-icon-grid section-layout-icon-grid-4"><span></span><span></span><span></span><span></span></span>
                        <span class="section-layout-copy">
                            <strong>4 Columns</strong>
                            <small>Compact cards</small>
                        </span>
                    </button>
                </div>
                @php $sectionIndex = 0; @endphp
                <div id="sections-area" data-section-index="{{ $sections->count() }}">
                    @foreach($sections as $section)
                        @php
                            $sectionType = $section->first()->section_type;
                            $sectionLabel = match($sectionType) {
                                'two-columns' => '2 Columns',
                                'three-columns' => '3 Columns',
                                'four-columns' => '4 Columns',
                                default => 'Full Width',
                            };
                            $sectionHint = match($sectionType) {
                                'two-columns' => 'Side by side',
                                'three-columns' => 'Balanced grid',
                                'four-columns' => 'Compact cards',
                                default => '1 column block',
                            };
                            $sectionIcon = match($sectionType) {
                                'two-columns' => '2',
                                'three-columns' => '3',
                                'four-columns' => '4',
                                default => '1',
                            };
                            $sectionColumns = match($sectionType) {
                                'two-columns' => 2,
                                'three-columns' => 3,
                                'four-columns' => 4,
                                default => 1,
                            };
                            $columnClass = match($sectionType) {
                                'two-columns' => 'col-12 col-md-6',
                                'three-columns' => 'col-12 col-md-4',
                                'four-columns' => 'col-12 col-md-3',
                                default => 'col-12',
                            };
                        @endphp
                        <div class="section-entry mb-3">
                            <div class="d-flex justify-content-between align-items-center section-entry-header">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <span class="section-layout-icon section-layout-icon-grid section-layout-icon-grid-{{ $sectionIcon }}">
                                        @for($i = 0; $i < (int) $sectionIcon; $i++)
                                            <span></span>
                                        @endfor
                                    </span>
                                    <span class="section-layout-copy">
                                        <strong>{{ $sectionLabel }}</strong>
                                        <small>{{ $sectionHint }}</small>
                                    </span>
                                    <div class="section-collapsed-summary d-inline-flex align-items-center flex-wrap gap-1">
                                        @foreach($section as $columnIndex => $column)
                                            <span class="section-summary-chip">{{ $column->title ?: 'Column ' . ($columnIndex + 1) }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-sm section-action-btn section-action-btn-move" onclick="moveSectionUp(this)">&uarr;</button>
                                    <button type="button" class="btn btn-sm section-action-btn section-action-btn-move" onclick="moveSectionDown(this)">&darr;</button>
                                    <button type="button" class="btn btn-sm section-action-btn section-action-btn-toggle" onclick="toggleSectionCollapse(this)">Expand</button>
                                    <button type="button" class="btn btn-sm section-action-btn section-action-btn-remove" onclick="removeSection(this)">Remove</button>
                                </div>
                            </div>
                            <div class="section-editor-body d-none">
                                <input type="hidden" name="sections[{{$sectionIndex}}][type]" value="{{ $sectionType }}">
                                <div class="row g-2">
                                    @foreach($section as $columnIndex => $column)
                                        <div class="{{ $columnClass }}">
                                            <div class="section-column-shell">
                                                <input class="form-control mb-1" name="sections[{{$sectionIndex}}][columns][{{$columnIndex}}][title]" value="{{$column->title}}" maxlength="255" placeholder="Column Title">
                                                <textarea class="form-control" name="sections[{{$sectionIndex}}][columns][{{$columnIndex}}][content]" placeholder="Column Content">{{$column->content}}</textarea>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @php $sectionIndex++; @endphp
                    @endforeach
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Update Page</button>
        </div>
    </form>
</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/extracted/admin-pages-about.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/extracted/admin-pages-about.js') }}"></script>
@endpush
@endsection











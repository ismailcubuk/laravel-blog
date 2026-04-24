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
                <div id="sections-area">
                    @php $sectionIndex = 0; @endphp
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
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/extracted/admin-pages-about.css') }}">
@endpush
@endpush

@push('scripts')
<script>
    let sectionIndex = {{ $sectionIndex }};

    function getColumnClass(type) {
        switch (type) {
            case 'two-columns':
                return 'col-12 col-md-6';
            case 'three-columns':
                return 'col-12 col-md-4';
            case 'four-columns':
                return 'col-12 col-md-3';
            default:
                return 'col-12';
        }
    }

    function getSectionMeta(type) {
        switch (type) {
            case 'two-columns':
                return { label: '2 Columns', hint: 'Side by side', icon: '2', columns: 2 };
            case 'three-columns':
                return { label: '3 Columns', hint: 'Balanced grid', icon: '3', columns: 3 };
            case 'four-columns':
                return { label: '4 Columns', hint: 'Compact cards', icon: '4', columns: 4 };
            default:
                return { label: 'Full Width', hint: '1 column block', icon: '1', columns: 1 };
        }
    }

    function addSection(type) {
        const counts = {
            'full-width': 1,
            'two-columns': 2,
            'three-columns': 3,
            'four-columns': 4,
        };
        const sectionMeta = getSectionMeta(type);

        let html = '';
        html += `<div class="section-entry mb-3">`;
        html += `
            <div class="d-flex justify-content-between align-items-center section-entry-header">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <span class="section-layout-icon section-layout-icon-grid section-layout-icon-grid-${sectionMeta.icon}">
                        ${Array.from({ length: sectionMeta.columns }).map(() => '<span></span>').join('')}
                    </span>
                    <span class="section-layout-copy">
                        <strong>${sectionMeta.label}</strong>
                        <small>${sectionMeta.hint}</small>
                    </span>
                    <div class="section-collapsed-summary d-inline-flex align-items-center flex-wrap gap-1"></div>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm section-action-btn section-action-btn-move" onclick="moveSectionUp(this)">&uarr;</button>
                    <button type="button" class="btn btn-sm section-action-btn section-action-btn-move" onclick="moveSectionDown(this)">&darr;</button>
                    <button type="button" class="btn btn-sm section-action-btn section-action-btn-toggle" onclick="toggleSectionCollapse(this)">Collapse</button>
                    <button type="button" class="btn btn-sm section-action-btn section-action-btn-remove" onclick="removeSection(this)">Remove</button>
                </div>
            </div>
        `;
        html += `<div class="section-editor-body">`;
        html += `<input type="hidden" name="sections[${sectionIndex}][type]" value="${type}">`;

        const columnClass = getColumnClass(type);
        html += `<div class="row g-2">`;
        for (let i = 0; i < counts[type]; i++) {
            html += `
                <div class="${columnClass}">
                    <div class="section-column-shell">
                        <input class="form-control mb-1" name="sections[${sectionIndex}][columns][${i}][title]" maxlength="255" placeholder="Column Title">
                        <textarea class="form-control" name="sections[${sectionIndex}][columns][${i}][content]" placeholder="Column Content"></textarea>
                    </div>
                </div>
            `;
        }
        html += `</div>`;
        html += `</div>`;

        html += `</div>`;
        const sectionsArea = document.getElementById('sections-area');
        sectionsArea.insertAdjacentHTML('beforeend', html);

        const addedCard = sectionsArea.lastElementChild;
        if (addedCard) {
            updateSectionSummary(addedCard);
            addedCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        sectionIndex++;
    }

    function removeSection(button) {
        button.closest('.section-entry').remove();
        updateSectionOrders();
    }

    function toggleSectionCollapse(button) {
        const card = button.closest('.section-entry');
        if (!card) return;

        const body = card.querySelector('.section-editor-body');
        const summary = card.querySelector('.section-collapsed-summary');
        if (!body) return;

        updateSectionSummary(card);
        const isCollapsed = body.classList.toggle('d-none');
        if (summary) {
            summary.classList.toggle('d-none', !isCollapsed);
        }
        button.textContent = isCollapsed ? 'Expand' : 'Collapse';
    }

    function updateSectionSummary(card) {
        const summary = card.querySelector('.section-collapsed-summary');
        if (!summary) return;

        const titleInputs = card.querySelectorAll('input[name*="[columns]"][name$="[title]"]');
        const badges = [];

        titleInputs.forEach((input, index) => {
            const value = (input.value || '').trim();
            badges.push(`<span class="section-summary-chip">${value || ('Column ' + (index + 1))}</span>`);
        });

        summary.innerHTML = badges.join('');
    }

    document.addEventListener('input', function (event) {
        const target = event.target;
        if (!target || !(target instanceof HTMLInputElement)) return;
        if (!target.name || !target.name.includes('[columns]') || !target.name.endsWith('[title]')) return;

        const card = target.closest('.section-entry');
        if (card) {
            updateSectionSummary(card);
        }
    });

    function moveSectionUp(button) {
        const card = button.closest('.section-entry');
        if (!card) return;
        const container = card.parentNode;
        const prev = card.previousElementSibling;
        if (prev) {
            animateSectionReorder(container, function () {
                container.insertBefore(card, prev);
                updateSectionOrders();
            });
        }
    }

    function moveSectionDown(button) {
        const card = button.closest('.section-entry');
        if (!card) return;
        const container = card.parentNode;
        const next = card.nextElementSibling;
        if (next) {
            animateSectionReorder(container, function () {
                container.insertBefore(next, card);
                updateSectionOrders();
            });
        }
    }

    function animateSectionReorder(container, mutateFn) {
        if (!container || typeof mutateFn !== 'function') {
            return;
        }

        const cardsBefore = Array.from(container.querySelectorAll(':scope > .section-entry'));
        const firstRects = new Map(
            cardsBefore.map((card) => [card, card.getBoundingClientRect()])
        );

        mutateFn();

        const cardsAfter = Array.from(container.querySelectorAll(':scope > .section-entry'));
        cardsAfter.forEach((card) => {
            const firstRect = firstRects.get(card);
            if (!firstRect) {
                return;
            }

            const lastRect = card.getBoundingClientRect();
            const deltaX = firstRect.left - lastRect.left;
            const deltaY = firstRect.top - lastRect.top;

            if (!deltaX && !deltaY) {
                return;
            }

            card.animate(
                [
                    { transform: `translate(${deltaX}px, ${deltaY}px)` },
                    { transform: 'translate(0, 0)' },
                ],
                {
                    duration: 220,
                    easing: 'cubic-bezier(0.22, 1, 0.36, 1)',
                }
            );
        });
    }

    function updateSectionOrders() {
        const cards = document.querySelectorAll('#sections-area .section-entry');
        cards.forEach((card, newIndex) => {
            card.querySelectorAll('input, textarea').forEach((input) => {
                input.name = input.name.replace(/sections\[\d+\]/, `sections[${newIndex}]`);
            });
        });
    }
</script>
@endpush
@endsection










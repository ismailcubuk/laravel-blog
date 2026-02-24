@extends('admin.layouts.app')
@section('content')
    <h1>Edit About Us Page</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.pages.about.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        {{-- BASIC PAGE DATA --}}
        <div class="mb-3">
            <label>Page Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $page->title) }}">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"
                rows="5">{{ old('description', $page->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label>Image</label>
            @if($page->hero_image)
                <div class="mb-2">
                    <img src="{{ asset($page->hero_image) }}" style="max-width:200px">
                </div>
            @endif
            <input type="file" name="hero_image" class="form-control">
        </div>
        <hr>
        <h3>Sections Builder</h3>
        <div class="mb-3">
            <button type="button" class="btn btn-secondary" onclick="addSection('full-width')">
                Full Width
            </button>
            <button type="button" class="btn btn-secondary" onclick="addSection('two-columns')">
                2 Columns
            </button>
            <button type="button" class="btn btn-secondary" onclick="addSection('three-columns')">
                3 Columns
            </button>
            <button type="button" class="btn btn-secondary" onclick="addSection('four-columns')">
                4 Columns
            </button>
        </div>

        <div id="sections-area">
            @php $sectionIndex = 0; @endphp
            @foreach($sections as $section)
                <div class="card mb-3 p-3">
                    {{-- HEADER --}}
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="m-0">
                            {{ $section->first()->section_type }}
                        </h5>
                        <div>
                            <button type="button" class="btn btn-sm btn-secondary" onclick="moveSectionUp(this)">
                                ↑
                            </button>
                            <button type="button" class="btn btn-sm btn-secondary" onclick="moveSectionDown(this)">
                                ↓
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="removeSection(this)">
                                Remove
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="sections[{{$sectionIndex}}][type]" value="{{$section->first()->section_type}}">
                    @foreach($section as $columnIndex => $column)
                        <div class="mb-2">
                            <input class="form-control mb-1" name="sections[{{$sectionIndex}}][columns][{{$columnIndex}}][title]"
                                value="{{$column->title}}" placeholder="Column Title">
                            <textarea class="form-control" name="sections[{{$sectionIndex}}][columns][{{$columnIndex}}][content]"
                                placeholder="Column Content">{{$column->content}}</textarea>
                        </div>
                    @endforeach
                </div>
                @php $sectionIndex++; @endphp
            @endforeach
        </div>
        <hr>
        <button type="submit" class="btn btn-primary">
            Update Page
        </button>
    </form>
    <script>
        let sectionIndex = {{ $sectionIndex }};
        // ADD SECTION
        function addSection(type) {
            let counts =
            {
                'full-width': 1,
                'two-columns': 2,
                'three-columns': 3,
                'four-columns': 4
            };
            let html = '';
            html += `<div class="card mb-3 p-3">`;
            html += `
    <div class="d-flex justify-content-between align-items-center mb-2">
    <h5 class="m-0">${type}</h5>
    <div>
    <button type="button"
    class="btn btn-sm btn-secondary"
    onclick="moveSectionUp(this)">
    ↑
    </button>
    <button type="button"
    class="btn btn-sm btn-secondary"
    onclick="moveSectionDown(this)">
    ↓
    </button>
    <button type="button"
    class="btn btn-danger btn-sm"
    onclick="removeSection(this)">
    Remove
    </button>
    </div>
    </div>
    `;
            html += `
    <input type="hidden"
    name="sections[${sectionIndex}][type]"
    value="${type}">
    `;
            for (let i = 0; i < counts[type]; i++) {
                html += `
    <div class="mb-2">

    <input class="form-control mb-1"
    name="sections[${sectionIndex}][columns][${i}][title]"
    placeholder="Column Title">

    <textarea class="form-control"
    name="sections[${sectionIndex}][columns][${i}][content]"
    placeholder="Column Content"></textarea>

    </div>
    `;
            }
            html += `</div>`;
            document.getElementById('sections-area')
                .insertAdjacentHTML('beforeend', html);
            sectionIndex++;
        }
        // REMOVE SECTION
        function removeSection(button) {
            button.closest('.card').remove();
            updateSectionOrders();
        }
        // MOVE UP
        function moveSectionUp(button) {
            const card = button.closest('.card');
            const prev = card.previousElementSibling;
            if (prev) {
                card.parentNode.insertBefore(card, prev);
                updateSectionOrders();
            }
        }
        // MOVE DOWN
        function moveSectionDown(button) {
            const card = button.closest('.card');
            const next = card.nextElementSibling;
            if (next) {
                card.parentNode.insertBefore(next, card);
                updateSectionOrders();
            }
        }
        // UPDATE INDEXES
        function updateSectionOrders() {
            const cards =
                document.querySelectorAll('#sections-area .card');
            cards.forEach((card, newIndex) => {
                card.querySelectorAll('input, textarea')
                    .forEach(input => {
                        input.name =
                            input.name.replace(/sections\[\d+\]/, `sections[${newIndex}]`);
                    });
            });
        }
    </script>
@endsection
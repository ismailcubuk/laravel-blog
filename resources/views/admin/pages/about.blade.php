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
            <label>Hero Image</label>
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
            {{-- EXISTING SECTIONS --}}
            @php $sectionIndex = 0; @endphp
            @foreach($sections as $section)
                <div class="card mb-3 p-3">
                    <h5>{{ $section->first()->section_type }}</h5>
                    <input type="hidden" name="sections[{{$sectionIndex}}][type]" value="{{$section->first()->section_type}}">
                    @foreach($section as $columnIndex => $column)
                        <div class="mb-2">
                            <input class="form-control mb-1" name="sections[{{$sectionIndex}}][columns][{{$columnIndex}}][title]"
                                value="{{$column->title}}" placeholder="Column Title">
                            <textarea class="form-control" name="sections[{{$sectionIndex}}][columns][{{$columnIndex}}][content]"
                                placeholder="Column Content">{{$column->content}}</textarea>
                        </div>
                    @endforeach
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeSection(this)">
                        Remove Section
                    </button>
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
            html += `<h5>${type}</h5>`;
            html += `<input type="hidden"
                name="sections[${sectionIndex}][type]"
                value="${type}">`;
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
            html += `
                <button type="button"
                class="btn btn-danger btn-sm"
                onclick="removeSection(this)">
                Remove Section
                </button>
                `;
            html += `</div>`;
            document.getElementById('sections-area')
                .insertAdjacentHTML('beforeend', html);
            sectionIndex++;
        }
        function removeSection(button) {
            button.closest('.card').remove();
        }
    </script>


@endsection
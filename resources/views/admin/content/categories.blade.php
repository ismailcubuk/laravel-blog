@extends('admin.layouts.app')

@section('content')
@php
    $currentSort = $sort ?? 'created_at';
    $currentDirection = $direction ?? 'desc';

    $nextDirection = fn (string $column) => $currentSort === $column && $currentDirection === 'asc' ? 'desc' : 'asc';

    $sortIcon = function (string $column) use ($currentSort, $currentDirection): string {
        if ($currentSort !== $column) {
            return 'bi-arrow-down-up';
        }

        return $currentDirection === 'asc' ? 'bi-sort-alpha-down' : 'bi-sort-alpha-up';
    };
@endphp

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/extracted/admin-content-categories.css') }}">
@endpush

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0 text-primary">Categories</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center">
                    <h5 class="mb-0">Kategori Listesi</h5>
                    <button
                        type="button"
                        class="ui-btn ui-btn-success ui-btn-sm ms-auto"
                        data-bs-toggle="modal"
                        data-bs-target="#newCategoryModal"
                    >
                        <i class="bi bi-plus-lg me-1"></i> Yeni Kategori
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0 categories-table">
                            <thead>
                                <tr>
                                    <th class="category-name-col">
                                        <a
                                            href="{{ route('admin.content.categories.index', array_merge(request()->except('page'), ['sort' => 'name', 'direction' => $nextDirection('name')])) }}"
                                            class="sort-link"
                                        >
                                            Name
                                            <i class="bi {{ $sortIcon('name') }}"></i>
                                        </a>
                                    </th>
                                    <th class="category-slug-col">
                                        <a
                                            href="{{ route('admin.content.categories.index', array_merge(request()->except('page'), ['sort' => 'slug', 'direction' => $nextDirection('slug')])) }}"
                                            class="sort-link"
                                        >
                                            Slug
                                            <i class="bi {{ $sortIcon('slug') }}"></i>
                                        </a>
                                    </th>
                                    <th>Posts</th>
                                    <th>Created</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td class="category-name-col">
                                            <span id="categoryNameText-{{ $category->id }}">{{ $category->name }}</span>
                                            <input
                                                type="text"
                                                id="categoryNameInput-{{ $category->id }}"
                                                name="name"
                                                value="{{ $category->name }}"
                                                class="form-control form-control-sm d-none category-name-input"
                                                form="updateCategoryForm-{{ $category->id }}"
                                                required
                                            >
                                        </td>
                                        <td class="category-slug-col"><code class="category-slug-value">{{ $category->slug }}</code></td>
                                        <td>{{ $category->posts_count }}</td>
                                        <td>{{ optional($category->created_at)->format('d M Y') }}</td>
                                        <td class="text-end">
                                            <div class="category-actions">
                                            <form
                                                id="updateCategoryForm-{{ $category->id }}"
                                                action="{{ route('admin.content.categories.update', $category) }}"
                                                method="POST"
                                                class="d-inline"
                                            >
                                                @csrf
                                                @method('PUT')
                                            </form>
                                            <button
                                                type="button"
                                                class="ui-btn ui-btn-neutral ui-btn-sm"
                                                id="editCategoryBtn-{{ $category->id }}"
                                                onclick="toggleCategoryEdit({{ $category->id }}, true)"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                type="submit"
                                                form="updateCategoryForm-{{ $category->id }}"
                                                class="ui-btn ui-btn-primary ui-btn-sm d-none"
                                                id="saveCategoryBtn-{{ $category->id }}"
                                            >
                                                Save
                                            </button>
                                            <button
                                                type="button"
                                                class="ui-btn ui-btn-neutral ui-btn-sm d-none"
                                                id="cancelCategoryBtn-{{ $category->id }}"
                                                onclick="toggleCategoryEdit({{ $category->id }}, false)"
                                            >
                                                Vazgeç
                                            </button>
                                            <form
                                                action="{{ route('admin.content.categories.destroy', $category) }}"
                                                method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Bu kategori silinsin mi?');"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="ui-btn ui-btn-danger ui-btn-sm">Sil</button>
                                            </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-3">No categories found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="newCategoryModal" tabindex="-1" aria-hidden="true" data-has-validation-errors="{{ $errors->any() ? 'true' : 'false' }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.content.categories.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-0">
                        <label class="form-label">Kategori Adı</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="ui-btn ui-btn-neutral" data-bs-dismiss="modal">Vazgeç</button>
                    <button type="submit" class="ui-btn ui-btn-success">Kategoriyi Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script src="{{ asset('assets/js/extracted/admin-content-categories.js') }}"></script>
@endpush
@endsection


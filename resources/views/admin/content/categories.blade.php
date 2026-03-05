@extends('admin.layouts.app')

@section('content')
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
                <div class="card-header bg-dark text-white d-flex align-items-center">
                    <h5 class="mb-0">Category List</h5>
                    <button
                        type="button"
                        class="btn btn-success btn-sm ms-auto"
                        data-bs-toggle="modal"
                        data-bs-target="#newCategoryModal"
                    >
                        <i class="bi bi-plus-lg me-1"></i> New Category
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Posts</th>
                                    <th>Created</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td>
                                            <span id="categoryNameText-{{ $category->id }}">{{ $category->name }}</span>
                                            <input
                                                type="text"
                                                id="categoryNameInput-{{ $category->id }}"
                                                name="name"
                                                value="{{ $category->name }}"
                                                class="form-control form-control-sm d-none"
                                                form="updateCategoryForm-{{ $category->id }}"
                                                required
                                            >
                                        </td>
                                        <td>{{ $category->slug }}</td>
                                        <td>{{ $category->posts_count }}</td>
                                        <td>{{ optional($category->created_at)->format('d M Y') }}</td>
                                        <td class="text-end">
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
                                                class="btn btn-sm btn-outline-primary"
                                                id="editCategoryBtn-{{ $category->id }}"
                                                onclick="toggleCategoryEdit({{ $category->id }}, true)"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                type="submit"
                                                form="updateCategoryForm-{{ $category->id }}"
                                                class="btn btn-sm btn-primary d-none"
                                                id="saveCategoryBtn-{{ $category->id }}"
                                            >
                                                Save
                                            </button>
                                            <button
                                                type="button"
                                                class="btn btn-sm btn-secondary d-none"
                                                id="cancelCategoryBtn-{{ $category->id }}"
                                                onclick="toggleCategoryEdit({{ $category->id }}, false)"
                                            >
                                                Cancel
                                            </button>
                                            <form
                                                action="{{ route('admin.content.categories.destroy', $category) }}"
                                                method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this category?');"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                            </form>
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

<div class="modal fade" id="newCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.content.categories.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-0">
                        <label class="form-label">Category Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
function toggleCategoryEdit(categoryId, enableEdit) {
    const nameText = document.getElementById('categoryNameText-' + categoryId);
    const nameInput = document.getElementById('categoryNameInput-' + categoryId);
    const editBtn = document.getElementById('editCategoryBtn-' + categoryId);
    const saveBtn = document.getElementById('saveCategoryBtn-' + categoryId);
    const cancelBtn = document.getElementById('cancelCategoryBtn-' + categoryId);

    if (!nameText || !nameInput || !editBtn || !saveBtn || !cancelBtn) {
        return;
    }

    if (enableEdit) {
        nameText.classList.add('d-none');
        nameInput.classList.remove('d-none');
        editBtn.classList.add('d-none');
        saveBtn.classList.remove('d-none');
        cancelBtn.classList.remove('d-none');
        nameInput.focus();
        nameInput.select();
        return;
    }

    nameInput.value = nameText.textContent.trim();
    nameText.classList.remove('d-none');
    nameInput.classList.add('d-none');
    editBtn.classList.remove('d-none');
    saveBtn.classList.add('d-none');
    cancelBtn.classList.add('d-none');
}

document.addEventListener('DOMContentLoaded', function () {
    const hasValidationErrors = {{ $errors->any() ? 'true' : 'false' }};
    if (!hasValidationErrors) {
        return;
    }

    const modalElement = document.getElementById('newCategoryModal');
    if (!modalElement || !window.bootstrap) {
        return;
    }

    const modal = new bootstrap.Modal(modalElement);
    modal.show();
});
</script>
@endsection

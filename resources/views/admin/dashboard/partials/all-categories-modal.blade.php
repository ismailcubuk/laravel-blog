<div class="modal fade" id="allCategoriesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content all-categories-modal-content">
            <div class="modal-header all-categories-modal-header">
                <h5 class="modal-title mb-0">All Categories</h5>
                <div class="ms-auto me-2" style="width: 320px; max-width: 50vw;">
                    <input type="text" id="allCategoriesSearchInput" class="form-control form-control-sm" placeholder="Search categories...">
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="list-group list-group-flush" id="allCategoriesList">
                    @forelse($allCategories as $category)
                        <div class="list-group-item all-categories-item" data-search="{{ mb_strtolower(($category->name ?? '') . ' ' . ($category->slug ?? '')) }}">
                            <div class="d-flex justify-content-between align-items-center gap-3">
                                <div style="min-width:0;">
                                    <div class="fw-semibold text-truncate">{{ $category->name }}</div>
                                    <div class="text-muted small text-truncate">{{ $category->slug }}</div>
                                </div>
                                <div class="text-end">
                                    <span class="badge text-bg-light border">{{ $category->posts_count ?? 0 }} posts</span>
                                    <div class="text-muted small mt-1">{{ optional($category->created_at)->format('d.m.Y') }}</div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-muted">No categories found.</div>
                    @endforelse
                </div>
                <div id="allCategoriesEmptyState" class="p-4 text-center text-muted d-none">
                    No categories match your search.
                </div>
            </div>
        </div>
    </div>
</div>

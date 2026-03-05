<div class="modal fade" id="activityDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header activity-modal-header">
                <h5 class="modal-title d-flex align-items-center gap-2 mb-0">
                    <i class="fa-solid fa-chart-column"></i>
                    <span class="badge text-bg-light activity-count-badge" id="activityDetailCount">0</span>
                    <span id="activityDetailTitle">Activity Detail</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 activity-modal-body" id="activityDetailBody"></div>
        </div>
    </div>
</div>

<template id="activityEmptyStateTemplate">
    <div class="p-4 text-center text-muted">No record found.</div>
</template>

<template id="activityPostItemTemplate">
    <a class="d-flex p-3 border-bottom activity-post-item activity-post-link">
        <div class="me-3">
            <img width="72" height="72" style="object-fit:cover; border-radius:8px;" alt="Post image">
        </div>
        <div class="flex-grow-1">
            <h6 class="mb-1" data-role="title"></h6>
            <p class="mb-1 text-muted small" data-role="excerpt"></p>
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-secondary">
                    <i class="fa fa-clock"></i>
                    <span data-role="time"></span>
                </small>
            </div>
        </div>
    </a>
</template>

<template id="activityUserItemTemplate">
    <div class="d-flex align-items-center justify-content-between p-3 border-bottom activity-user-item">
        <div class="d-flex align-items-center gap-3">
            <div class="activity-avatar" data-role="avatar"></div>
            <div>
                <div class="fw-semibold" data-role="name"></div>
                <div class="text-muted small" data-role="email"></div>
            </div>
        </div>
        <small class="text-secondary">
            <i class="fa fa-clock"></i>
            <span data-role="time"></span>
        </small>
    </div>
</template>

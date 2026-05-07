<div class="modal fade" id="activityDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable activity-modal-dialog">
        <div class="modal-content activity-sheet">
            <div class="modal-header activity-modal-header">
                <div class="activity-modal-headline">
                    <span class="activity-modal-title-icon"><i class="fa-solid fa-chart-column"></i></span>
                    <div>
                        <h5 class="modal-title mb-0" id="activityDetailTitle">Activity Detail</h5>
                        <small class="text-muted">Daily activity breakdown</small>
                    </div>
                    <span class="badge text-bg-light activity-count-badge" id="activityDetailCount">0</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body activity-modal-body" id="activityDetailBody"></div>
        </div>
    </div>
</div>

<template id="activityEmptyStateTemplate">
    <div class="activity-empty-state">
        <div class="activity-empty-icon"><i class="bi bi-inbox"></i></div>
        <h6 class="mb-1">No activity found</h6>
        <p class="mb-0 text-muted">There are no records for the selected day.</p>
    </div>
</template>

<template id="activityPostItemTemplate">
    <a class="activity-post-item activity-post-link" href="#">
        <div class="activity-post-visual">
            <img class="activity-post-thumb" width="78" height="78" alt="Post image">
        </div>

        <div class="activity-post-content">
            <div class="activity-post-author">
                <img data-role="author-avatar" width="24" height="24" alt="Author avatar">
                <span data-role="author-name"></span>
            </div>
            <h6 class="activity-post-title mb-1" data-role="title"></h6>
            <p class="activity-post-excerpt mb-2" data-role="excerpt"></p>
        </div>

        <span class="activity-time-chip activity-post-time">
            <i class="fa fa-clock"></i>
            <span data-role="time"></span>
        </span>
    </a>
</template>

<template id="activityUserItemTemplate">
    <div class="activity-user-item">
        <div class="activity-user-left">
            <div class="activity-avatar" data-role="avatar"></div>
            <div class="activity-user-meta">
                <div class="activity-user-name" data-role="name"></div>
                <div class="activity-user-email" data-role="email"></div>
            </div>
        </div>

        <span class="activity-time-chip">
            <i class="fa fa-clock"></i>
            <span data-role="time"></span>
        </span>
    </div>
</template>

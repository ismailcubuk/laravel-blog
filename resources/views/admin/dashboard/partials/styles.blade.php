<style>
.small-box .icon {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 70px;
    opacity: 0.2;
}

.dashboard-card {
    height: 400px;
}

.dashboard-card .card-body {
    height: calc(100% - 60px);
}

.latest-posts-body {
    overflow-y: auto;
}

.latest-post-item {
    color: inherit;
    text-decoration: none;
    transition: background-color 0.2s ease;
}

.latest-post-item:hover {
    color: inherit;
    text-decoration: none;
    background-color: #e9f2ff;
    box-shadow: inset 4px 0 0 #0d6efd;
}

.latest-post-excerpt {
    font-size: 14px;
}

#blogChart {
    width: 100% !important;
    height: 100% !important;
}

.activity-modal-header {
    background: linear-gradient(135deg, #f8fafc, #eef2f7);
    border-bottom: 1px solid #e9ecef;
}

.activity-count-badge {
    font-size: 12px;
    min-width: 34px;
    text-align: center;
}

.activity-modal-body {
    max-height: 70vh;
    overflow-y: auto;
}

.activity-post-item:hover,
.activity-user-item:hover {
    background-color: #e9f2ff;
    box-shadow: inset 4px 0 0 #0d6efd;
}

.activity-view-link {
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
}

.activity-post-link {
    color: inherit;
    text-decoration: none;
}

.activity-post-link:hover {
    color: inherit;
    text-decoration: none;
}

.activity-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #198754;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
}
</style>

<style>
.dashboard-hero {
    border: 1px solid #dce6f4;
    border-radius: 20px;
    padding: 20px;
    margin-bottom: 16px;
    background:
        radial-gradient(circle at 88% 14%, rgba(61, 131, 255, 0.22), transparent 36%),
        linear-gradient(145deg, #ffffff 0%, #f4f8ff 100%);
    box-shadow: 0 16px 34px rgba(12, 31, 63, 0.08);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
}

.dashboard-hero-kicker {
    margin: 0 0 6px;
    color: #4f78c7;
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.08em;
}

.dashboard-hero-title {
    margin: 0;
    font-size: clamp(24px, 2.6vw, 34px);
    line-height: 1.15;
    font-weight: 800;
    color: #15243c;
    letter-spacing: -0.01em;
}

.dashboard-hero-subtitle {
    margin: 8px 0 0;
    color: #607089;
    font-size: 14px;
    max-width: 720px;
}

.dashboard-hero-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.dashboard-ghost-btn {
    background: #ffffff;
    border: 1px solid #cdd9ee;
    color: #2a436d;
}

.dashboard-primary-btn {
    background: linear-gradient(135deg, #1f6bff 0%, #0f4fd9 100%);
}

.dashboard-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 14px;
    margin-bottom: 18px;
}

.dashboard-stat-card {
    position: relative;
    overflow: hidden;
    border: 1px solid #dce6f4;
    border-radius: 16px;
    background: #fff;
    box-shadow: 0 12px 24px rgba(11, 35, 72, 0.07);
    padding: 16px;
    min-height: 122px;
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
}

.dashboard-stat-card::after {
    content: '';
    position: absolute;
    right: -20px;
    bottom: -24px;
    width: 90px;
    height: 90px;
    border-radius: 50%;
    opacity: 0.1;
    background: currentColor;
}

.dashboard-stat-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 8px;
}

.dashboard-stat-label {
    color: #677891;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}

.dashboard-stat-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 14px;
}

.dashboard-stat-value {
    display: block;
    margin: 14px 0 6px;
    color: #192941;
    font-size: 32px;
    line-height: 1;
    font-weight: 800;
}

.dashboard-stat-hint {
    margin: 0;
    color: #7a889f;
    font-size: 12px;
}

.stat-primary { color: #1f6bff; }
.stat-primary .dashboard-stat-icon { background: linear-gradient(135deg, #1f6bff 0%, #3e86ff 100%); }
.stat-success { color: #1ea271; }
.stat-success .dashboard-stat-icon { background: linear-gradient(135deg, #1ea271 0%, #32bf8a 100%); }
.stat-amber { color: #cf8d16; }
.stat-amber .dashboard-stat-icon { background: linear-gradient(135deg, #f0a529 0%, #e38a00 100%); }
.stat-danger { color: #c94b58; }
.stat-danger .dashboard-stat-icon { background: linear-gradient(135deg, #de5f6e 0%, #c53c4c 100%); }

.dashboard-panel {
    border: 1px solid #dce6f4;
    border-radius: 16px;
    background: #fff;
    box-shadow: 0 14px 30px rgba(13, 33, 66, 0.07);
    overflow: hidden;
}

.dashboard-panel-header {
    padding: 15px 16px;
    border-bottom: 1px solid #e3eaf6;
    background: linear-gradient(115deg, #0f1f3a 0%, #1b325a 100%);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}

.dashboard-panel-title {
    margin: 0;
    font-size: 15px;
    font-weight: 700;
    letter-spacing: 0.01em;
}

.dashboard-panel-link {
    color: rgba(255, 255, 255, 0.9);
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
}

.dashboard-panel-link:hover {
    color: #fff;
}

.dashboard-activity-panel .activity-panel-header {
    flex-wrap: wrap;
}

.activity-panel-subtitle {
    margin: 4px 0 0;
    color: rgba(255, 255, 255, 0.78);
    font-size: 12px;
}

.activity-legend {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.activity-legend-btn {
    border: 1px solid rgba(255, 255, 255, 0.24);
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    padding: 5px 10px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: opacity 0.2s ease, background-color 0.2s ease;
}

.activity-legend-btn.is-muted {
    opacity: 0.5;
    background: rgba(255, 255, 255, 0.06);
}

.activity-legend-dot {
    width: 10px;
    height: 10px;
    border-radius: 999px;
    display: inline-block;
}

.activity-legend-dot.blogs { background: #2e7bff; }
.activity-legend-dot.users { background: #20b26b; }

.activity-insights {
    padding: 12px 12px 0;
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 10px;
}

.activity-insight-card {
    border: 1px solid #e1e9f6;
    border-radius: 12px;
    background: #f8fbff;
    padding: 10px 12px;
}

.activity-insight-label {
    display: block;
    color: #6c7e97;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}

.activity-insight-value {
    display: block;
    margin-top: 5px;
    font-size: 22px;
    line-height: 1.1;
    color: #162741;
    font-weight: 800;
}

.activity-chart-wrap {
    padding: 12px;
    height: 300px;
}

#blogChart {
    width: 100% !important;
    height: 100% !important;
}

.latest-panel .latest-posts-list {
    max-height: 430px;
    overflow-y: auto;
}

.latest-post-item {
    display: grid;
    grid-template-columns: 72px minmax(0, 1fr);
    gap: 12px;
    align-items: start;
    padding: 12px;
    text-decoration: none;
    color: inherit;
    border-bottom: 1px solid #edf2fa;
    transition: background-color 0.16s ease, box-shadow 0.16s ease;
}

.latest-post-item:hover {
    color: inherit;
    background: #f3f7ff;
    box-shadow: inset 3px 0 0 #1f6bff;
}

.latest-post-item:last-child {
    border-bottom: 0;
}

.latest-post-thumb {
    width: 72px;
    height: 72px;
    object-fit: cover;
    border-radius: 10px;
}

.latest-post-content {
    min-width: 0;
}

.latest-post-title {
    margin: 0 0 4px;
    font-size: 15px;
    line-height: 1.35;
    color: #1b2b44;
    font-weight: 700;
}

.latest-post-meta {
    margin: 0;
    color: #6e7f97;
    font-size: 12px;
    display: inline-flex;
    gap: 6px;
    align-items: center;
}

.latest-post-excerpt {
    margin: 6px 0 0;
    font-size: 13px;
    color: #61748e;
}

.latest-post-empty {
    padding: 16px;
    color: #6b7d95;
}

.all-posts-modal-content {
    border: 1px solid #dce6f4;
    border-radius: 16px;
    overflow: hidden;
}

.all-posts-modal-header {
    background: linear-gradient(135deg, #f8fafc, #eef2f7);
    border-bottom: 1px solid #e9ecef;
}

.all-posts-item {
    transition: background-color 0.2s ease;
}

.all-posts-item:hover {
    background-color: #e9f2ff;
    box-shadow: inset 4px 0 0 #0d6efd;
}

.activity-modal-dialog .modal-content {
    border: 1px solid #dce5f3;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 20px 34px rgba(10, 28, 57, 0.16);
}

.activity-modal-header {
    background: linear-gradient(135deg, #f8fafc, #eef2f7);
    border-bottom: 1px solid #e9ecef;
    padding: 14px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.activity-modal-headline {
    display: flex;
    align-items: center;
    gap: 12px;
}

.activity-modal-title-icon {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    background: #1f6bff;
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}

.activity-modal-headline .modal-title {
    font-size: 16px;
    font-weight: 800;
    color: #1c2d47;
}

.activity-modal-headline small {
    display: block;
    font-size: 12px;
    color: #6f7f95;
}

.activity-count-badge {
    min-width: 34px;
    text-align: center;
    border: 1px solid #d9e4f5;
    color: #2d4f85;
}

.activity-modal-body {
    max-height: 70vh;
    overflow-y: auto;
    padding: 10px;
    background: #f7faff;
}

.activity-empty-state {
    padding: 42px 18px;
    text-align: center;
}

.activity-empty-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    margin: 0 auto 12px;
    background: #e8f0ff;
    color: #2c65db;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
}

.activity-post-item,
.activity-user-item {
    margin: 8px 0;
    border: 1px solid #dfe8f6;
    border-radius: 12px;
    background: #fff;
    transition: background-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
}

.activity-post-item:hover,
.activity-user-item:hover {
    background-color: #f2f7ff;
    box-shadow: 0 8px 18px rgba(17, 44, 85, 0.08);
    transform: translateY(-1px);
}

.activity-post-item {
    display: grid;
    grid-template-columns: 78px minmax(0, 1fr);
    gap: 12px;
    padding: 10px;
}

.activity-post-link {
    color: inherit;
    text-decoration: none;
}

.activity-post-link:hover {
    color: inherit;
    text-decoration: none;
}

.activity-post-thumb {
    border-radius: 10px;
    object-fit: cover;
}

.activity-post-content {
    min-width: 0;
}

.activity-post-title {
    font-weight: 700;
    color: #1d2e49;
}

.activity-post-excerpt {
    font-size: 13px;
    color: #627892;
    line-height: 1.42;
}

.activity-user-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 10px 12px;
}

.activity-user-left {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 0;
}

.activity-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #198754;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    flex: 0 0 auto;
}

.activity-user-meta {
    min-width: 0;
}

.activity-user-name {
    font-weight: 700;
    color: #1d2e49;
}

.activity-user-email {
    font-size: 12px;
    color: #70829a;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 360px;
}

.activity-time-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #5e7291;
    font-size: 12px;
    background: #eef3fb;
    border: 1px solid #d8e3f4;
    border-radius: 999px;
    padding: 4px 8px;
    white-space: nowrap;
}

@media (max-width: 1199.98px) {
    .dashboard-stats-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 991.98px) {
    .activity-insights {
        grid-template-columns: 1fr;
    }

    .activity-chart-wrap {
        height: 270px;
    }
}

@media (max-width: 767.98px) {
    .dashboard-hero {
        padding: 16px;
    }

    .dashboard-hero-actions {
        width: 100%;
    }

    .dashboard-hero-actions .btn {
        width: 100%;
    }

    .dashboard-stats-grid {
        grid-template-columns: 1fr;
    }

    .latest-post-item {
        grid-template-columns: 64px minmax(0, 1fr);
    }

    .latest-post-thumb {
        width: 64px;
        height: 64px;
    }

    .activity-modal-headline {
        align-items: flex-start;
    }

    .activity-post-item {
        grid-template-columns: 1fr;
    }

    .activity-post-thumb {
        width: 100%;
        height: 170px;
    }

    .activity-user-item {
        flex-direction: column;
        align-items: flex-start;
    }
}

.dashboard-stat-card.is-clickable {
    cursor: pointer;
}

.dashboard-stat-card.is-clickable:hover {
    transform: translateY(-3px);
    box-shadow: 0 18px 32px rgba(16, 39, 77, 0.12);
    border-color: #cbd9f1;
}`r`n

.dashboard-stat-card.is-clickable:focus-visible {
    outline: 2px solid #7aa6ff;
    outline-offset: 2px;
}

.dashboard-stat-action {
    display: inline-flex;
    margin-top: 8px;
    font-size: 12px;
    font-weight: 700;
    color: #2f5ca8;
}

.all-users-modal-content {
    border: 1px solid #dce6f4;
    border-radius: 16px;
    overflow: hidden;
}

.all-users-modal-header {
    background: linear-gradient(135deg, #f8fafc, #eef2f7);
    border-bottom: 1px solid #e9ecef;
}

.all-users-item {
    transition: background-color 0.2s ease;
}

.all-users-item:hover {
    background-color: #eef5ff;
    box-shadow: inset 4px 0 0 #2f6eea;
}

.all-categories-modal-content,
.all-comments-modal-content {
    border: 1px solid #dce6f4;
    border-radius: 16px;
    overflow: hidden;
}

.all-categories-modal-header,
.all-comments-modal-header {
    background: linear-gradient(135deg, #f8fafc, #eef2f7);
    border-bottom: 1px solid #e9ecef;
}

.all-categories-item,
.all-comments-item {
    transition: background-color 0.2s ease;
}

.all-categories-item:hover,
.all-comments-item:hover {
    background-color: #eef5ff;
    box-shadow: inset 4px 0 0 #2f6eea;
}
</style>






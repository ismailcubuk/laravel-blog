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

.activity-insight-card.is-clickable {
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
}

.activity-insight-card.is-clickable:hover {
    transform: translateY(-2px);
    border-color: #c6d8f7;
    box-shadow: 0 10px 18px rgba(16, 57, 117, 0.12);
}

.activity-insight-card.is-clickable:focus-visible {
    outline: 2px solid #7aa6ff;
    outline-offset: 2px;
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
    scrollbar-width: thin;
    scrollbar-color: rgba(var(--admin-primary-rgb), 0.72) rgba(var(--admin-primary-rgb), 0.12);
    padding-right: 4px;
}

.latest-panel .latest-posts-list::-webkit-scrollbar {
    width: 10px;
}

.latest-panel .latest-posts-list::-webkit-scrollbar-track {
    background: rgba(var(--admin-primary-rgb), 0.12);
    border-radius: 999px;
}

.latest-panel .latest-posts-list::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, rgba(var(--admin-primary-rgb), 0.88), rgba(var(--admin-primary-rgb), 0.64));
    border-radius: 999px;
    border: 2px solid rgba(15, 23, 42, 0.08);
}

.latest-panel .latest-posts-list::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(180deg, rgba(var(--admin-primary-rgb), 1), rgba(var(--admin-primary-rgb), 0.78));
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

.recent-comments-header-actions {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.recent-comments-result-badge {
    border: 1px solid #d9e4f5;
    background: #f8fbff;
    color: #1f3a60;
    font-weight: 700;
}

.recent-comments-table-header {
    justify-content: space-between;
}

.recent-comments-table-head {
    display: grid;
    grid-template-columns: 1.15fr 1.15fr 1.4fr 0.55fr 0.55fr 0.9fr 0.85fr;
    gap: 14px;
    padding: 12px 16px;
    border-top: 1px solid #e4ebf8;
    border-bottom: 1px solid #e4ebf8;
    background: #0d284b;
    color: #ffffff;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}

.recent-comments-pending-badge {
    border: 1px solid rgba(245, 158, 11, 0.45);
    background: rgba(245, 158, 11, 0.14);
    color: #9a6703;
    font-weight: 700;
}

.recent-comments-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    padding: 10px 10px 0;
    flex-wrap: wrap;
}

.recent-comments-filters {
    display: inline-flex;
    gap: 6px;
    flex-wrap: wrap;
}

.recent-filter-btn {
    border: 1px solid #d6e0ef;
    border-radius: 999px;
    background: #f8fbff;
    color: #415a7f;
    font-size: 12px;
    font-weight: 700;
    padding: 5px 11px;
    transition: all 0.18s ease;
}

.recent-filter-btn:hover {
    border-color: #bad0f1;
    background: #eef4ff;
}

.recent-filter-btn.is-active {
    border-color: rgba(var(--admin-primary-rgb), 0.42);
    background: rgba(var(--admin-primary-rgb), 0.14);
    color: #1f4ea2;
}

.recent-comments-search-wrap {
    position: relative;
    width: min(380px, 100%);
}

.recent-comments-search-wrap i {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #7287a3;
    font-size: 12px;
}

.recent-comments-search {
    padding-left: 30px;
}

.recent-comments-loading {
    display: none;
    gap: 10px;
    padding: 10px;
}

.recent-comment-skeleton {
    border: 1px solid #dfe8f6;
    border-radius: 14px;
    background: #fff;
    padding: 12px;
}

.recent-skeleton-line {
    display: block;
    height: 10px;
    border-radius: 999px;
    margin-bottom: 8px;
    background: linear-gradient(90deg, #edf2fb 0%, #dfe9f7 45%, #edf2fb 100%);
    background-size: 220% 100%;
    animation: recentSkeleton 1.4s ease infinite;
}

.recent-skeleton-line.w-40 { width: 40%; }
.recent-skeleton-line.w-70 { width: 70%; }
.recent-skeleton-line.w-90 { width: 90%; margin-bottom: 0; }

@keyframes recentSkeleton {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

.recent-comments-list {
    padding: 0;
    display: grid;
    gap: 0;
}

.recent-comments-list.is-hydrating {
    opacity: 0;
}

.recent-comment-item {
    border-bottom: 1px solid #e4ebf8;
    border-left: 1px solid #e4ebf8;
    border-right: 1px solid #e4ebf8;
    background: #ffffff;
    padding: 12px 16px;
    display: grid;
    grid-template-columns: 1.15fr 1.15fr 1.4fr 0.55fr 0.55fr 0.9fr 0.85fr;
    align-items: start;
    gap: 14px;
    transition: background-color 0.2s ease, box-shadow 0.2s ease;
}

.recent-comment-item.is-priority {
    box-shadow: inset 4px 0 0 rgba(245, 158, 11, 0.72);
    background: #fffbf2;
}

.recent-comment-item:hover {
    background: #f6f9ff;
    box-shadow: inset 4px 0 0 rgba(var(--admin-primary-rgb), 0.72);
}

.recent-comment-main {
    min-width: 0;
    padding: 0;
    border: 0;
    background: transparent;
}

.recent-comment-post-col {
    display: block;
    min-width: 0;
    min-height: 64px;
}

.recent-comment-post-inline {
    display: grid;
    grid-template-columns: 66px minmax(0, 1fr);
    gap: 8px;
    align-items: center;
    min-width: 0;
}

.recent-comment-post-cover {
    display: block;
    width: 66px;
}

.recent-comment-post-thumb-lg {
    width: 66px;
    height: 48px;
    border-radius: 9px;
    object-fit: cover;
    border: 1px solid #dbe5f4;
    display: block;
}

.rc-post-meta {
    min-width: 0;
    display: grid;
    gap: 5px;
}

.recent-comment-post-title {
    color: #1f3f73;
    font-size: 20px;
    font-weight: 800;
    line-height: 1.3;
    text-decoration: none;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.recent-comment-post-title:hover {
    color: #184085;
}

.recent-comment-user-col {
    display: block;
    min-width: 0;
    padding: 0;
    border: 0;
    background: transparent;
    min-height: 64px;
}

.recent-comment-author-inline {
    display: grid;
    grid-template-columns: 40px minmax(0, 1fr);
    align-items: center;
    gap: 8px;
    min-width: 0;
}

.recent-comment-topline {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.recent-comment-avatar {
    width: 40px;
    height: 40px;
    border-radius: 999px;
    object-fit: cover;
    border: 1px solid #d7e2f2;
    flex: 0 0 auto;
}

.recent-comment-author-stack {
    display: flex;
    flex-direction: column;
    min-width: 0;
    margin-right: 0;
    gap: 2px;
}

.recent-comment-author {
    color: #1d2e49;
    font-size: 17px;
    line-height: 1.25;
}

.recent-comment-email {
    color: #647891;
    font-size: 13px;
    line-height: 1.35;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.recent-comment-alert {
    font-size: 10px;
    font-weight: 800;
    border: 1px solid rgba(220, 38, 38, 0.45);
    background: rgba(239, 68, 68, 0.12);
    color: #b91c1c;
    justify-self: flex-start;
    margin-top: 6px;
}

.recent-comment-status {
    font-size: 12px;
    font-weight: 700;
    border: 1px solid transparent;
    justify-self: flex-start;
    margin-left: auto;
}

.recent-comment-status.is-approved {
    color: #0f8b5b;
    background: #e9f8f2;
    border-color: #b9ebd4;
}

.recent-comment-status.is-pending {
    color: #9a6703;
    background: #fff6df;
    border-color: #f6db9e;
}

.recent-comment-message {
    margin: 0 0 8px;
    color: #2f4363;
    font-size: 13px;
    line-height: 1.45;
    white-space: pre-wrap;
    overflow-wrap: anywhere;
    word-break: break-word;
}

.recent-comment-message.is-collapsed {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.recent-comment-expand {
    border: 0;
    background: transparent;
    color: #2f5ca8;
    font-size: 12px;
    font-weight: 700;
    padding: 0;
    margin: 0;
}

.recent-comment-expand:hover {
    text-decoration: underline;
}

.recent-comment-expand-wrap {
    display: flex;
    justify-content: flex-start;
    margin-top: 4px;
}

.recent-comment-flag {
    padding: 0 4px;
    border-radius: 4px;
    background: rgba(239, 68, 68, 0.18);
    color: #b91c1c;
}

.recent-comment-post-row {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 5px;
    flex-wrap: wrap;
}

.recent-comment-post-thumb {
    width: 36px;
    height: 28px;
    border-radius: 7px;
    object-fit: cover;
    border: 1px solid #dbe5f4;
    flex: 0 0 auto;
}

.recent-comment-post-label {
    color: #6b7f98;
    font-size: 12px;
    font-weight: 700;
}

.recent-comment-post-missing {
    color: #8395ab;
    font-size: 12px;
}

.recent-reply-badge {
    font-size: 11px;
    font-weight: 700;
    border: 1px solid transparent;
}

.recent-reply-badge.yes {
    color: #0f8b5b;
    background: #e9f8f2;
    border-color: #b9ebd4;
}

.recent-reply-badge.no {
    color: #996f09;
    background: #fff6df;
    border-color: #f6db9e;
}

.recent-comment-submitted-date {
    display: block;
    color: #647891;
    font-size: 13px;
    line-height: 1.3;
}

.recent-comment-submitted-time {
    display: block;
    color: #1f3f73;
    font-size: 18px;
    font-weight: 800;
    line-height: 1.2;
}

.rc-cell {
    min-width: 0;
}

.rc-actions {
    display: flex;
    justify-content: flex-end;
}

.recent-comment-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.recent-comment-time,
.recent-comment-post-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
}

.recent-comment-time {
    color: #647891;
}

.recent-comment-post-link {
    color: #2f5ca8;
    text-decoration: none;
    font-weight: 700;
    max-width: 65ch;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.recent-comment-post-link:hover {
    color: #1f4b97;
}

.recent-comment-post-tag {
    font-size: 10px;
    font-weight: 800;
    border: 1px solid rgba(var(--admin-primary-rgb), 0.35);
    background: rgba(var(--admin-primary-rgb), 0.12);
    color: #2a4f8f;
    text-transform: uppercase;
    justify-self: flex-start;
    width: fit-content;
}

.recent-comment-actions {
    display: flex;
    flex-direction: row;
    align-items: stretch;
    gap: 6px;
    flex-wrap: wrap;
    justify-content: flex-end;
}

.recent-comment-actions form {
    margin: 0;
}

.recent-comment-actions .btn {
    width: auto;
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
    background: #ffffff;
    border-color: #e4ebf7;
    color: #1f2d44;
}

#allBlogPostsModal .modal-body,
#allUsersModal .modal-body,
#allCategoriesModal .modal-body,
#allCommentsModal .modal-body {
    scrollbar-width: thin;
    scrollbar-color: rgba(var(--admin-primary-rgb), 0.72) rgba(var(--admin-primary-rgb), 0.12);
}

#allBlogPostsModal .modal-body::-webkit-scrollbar,
#allUsersModal .modal-body::-webkit-scrollbar,
#allCategoriesModal .modal-body::-webkit-scrollbar,
#allCommentsModal .modal-body::-webkit-scrollbar {
    width: 10px;
}

#allBlogPostsModal .modal-body::-webkit-scrollbar-track,
#allUsersModal .modal-body::-webkit-scrollbar-track,
#allCategoriesModal .modal-body::-webkit-scrollbar-track,
#allCommentsModal .modal-body::-webkit-scrollbar-track {
    background: rgba(var(--admin-primary-rgb), 0.12);
    border-radius: 999px;
}

#allBlogPostsModal .modal-body::-webkit-scrollbar-thumb,
#allUsersModal .modal-body::-webkit-scrollbar-thumb,
#allCategoriesModal .modal-body::-webkit-scrollbar-thumb,
#allCommentsModal .modal-body::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, rgba(var(--admin-primary-rgb), 0.9), rgba(var(--admin-primary-rgb), 0.68));
    border-radius: 999px;
    border: 2px solid rgba(15, 23, 42, 0.08);
}

#allBlogPostsModal .modal-body::-webkit-scrollbar-thumb:hover,
#allUsersModal .modal-body::-webkit-scrollbar-thumb:hover,
#allCategoriesModal .modal-body::-webkit-scrollbar-thumb:hover,
#allCommentsModal .modal-body::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(180deg, rgba(var(--admin-primary-rgb), 1), rgba(var(--admin-primary-rgb), 0.8));
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
}

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
    background: #ffffff;
    border-color: #e4ebf7;
    color: #1f2d44;
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
    background: #ffffff;
    border-color: #e4ebf7;
    color: #1f2d44;
}

.all-categories-item:hover,
.all-comments-item:hover {
    background-color: #eef5ff;
    box-shadow: inset 4px 0 0 #2f6eea;
}

.admin-dark .dashboard-hero {
    border-color: #334155;
    background:
        radial-gradient(circle at 88% 14%, rgba(148, 163, 184, 0.18), transparent 36%),
        linear-gradient(145deg, #0f172a 0%, #111b2f 100%);
}

.admin-dark .dashboard-hero-kicker {
    color: #93c5fd;
}

.admin-dark .dashboard-hero-title {
    color: #f8fafc;
}

.admin-dark .dashboard-hero-subtitle {
    color: #e2e8f0;
}

.admin-dark .dashboard-ghost-btn {
    background: #0f172a;
    border-color: #334155;
    color: #e2e8f0;
}

.admin-dark .dashboard-ghost-btn:hover {
    background: #111b2f;
    color: #ffffff;
}

.admin-dark .dashboard-stat-card,
.admin-dark .dashboard-panel,
.admin-dark .activity-insight-card,
.admin-dark .activity-post-item,
.admin-dark .activity-user-item {
    background: #0f172a;
    border-color: #334155;
}

.admin-dark .dashboard-stat-label,
.admin-dark .dashboard-stat-hint,
.admin-dark .activity-insight-label,
.admin-dark .latest-post-meta,
.admin-dark .latest-post-excerpt,
.admin-dark .latest-post-empty,
.admin-dark .activity-post-excerpt,
.admin-dark .activity-user-email,
.admin-dark .activity-time-chip,
.admin-dark .activity-modal-headline small {
    color: #e2e8f0;
}

.admin-dark .dashboard-stat-value,
.admin-dark .latest-post-title,
.admin-dark .activity-insight-value,
.admin-dark .activity-post-title,
.admin-dark .activity-user-name,
.admin-dark .activity-modal-headline .modal-title {
    color: #f8fafc;
}

.admin-dark .latest-post-item,
.admin-dark .activity-post-item,
.admin-dark .activity-user-item,
.admin-dark .activity-time-chip,
.admin-dark .activity-count-badge {
    border-color: #334155;
}

.admin-dark .activity-time-chip {
    background: rgba(148, 163, 184, 0.16);
    color: #f8fafc !important;
    border-color: rgba(148, 163, 184, 0.34);
}

.admin-dark .activity-time-chip i,
.admin-dark .activity-time-chip [data-role="time"] {
    color: #f8fafc !important;
    opacity: 1;
}

.admin-dark .latest-panel .latest-posts-list {
    scrollbar-color: rgba(var(--admin-primary-rgb), 0.82) rgba(148, 163, 184, 0.16);
}

.admin-dark .latest-panel .latest-posts-list::-webkit-scrollbar-track {
    background: rgba(148, 163, 184, 0.16);
}

.admin-dark .latest-panel .latest-posts-list::-webkit-scrollbar-thumb {
    border-color: rgba(15, 23, 42, 0.42);
}

.admin-dark .latest-post-item:hover,
.admin-dark .all-posts-item:hover,
.admin-dark .all-users-item:hover,
.admin-dark .all-categories-item:hover,
.admin-dark .all-comments-item:hover,
.admin-dark .activity-post-item:hover,
.admin-dark .activity-user-item:hover {
    background-color: #111b2f;
}

.admin-dark .activity-modal-body {
    background: #0b1220;
}

.admin-dark .activity-empty-icon {
    background: rgba(59, 130, 246, 0.2);
    color: #93c5fd;
}

.admin-dark .all-posts-modal-header,
.admin-dark .all-users-modal-header,
.admin-dark .all-categories-modal-header,
.admin-dark .all-comments-modal-header,
.admin-dark .activity-modal-header {
    background: linear-gradient(135deg, #0f172a, #111b2f);
    border-bottom-color: #334155;
}

.admin-dark .all-posts-modal-header .modal-title,
.admin-dark .all-users-modal-header .modal-title,
.admin-dark .all-categories-modal-header .modal-title,
.admin-dark .all-comments-modal-header .modal-title {
    color: #f8fafc;
}

.admin-dark .all-posts-modal-header .form-control,
.admin-dark .all-users-modal-header .form-control,
.admin-dark .all-categories-modal-header .form-control,
.admin-dark .all-comments-modal-header .form-control {
    background: #0b1220;
    border-color: rgba(var(--admin-primary-rgb), 0.6);
    color: #e2e8f0;
    box-shadow: 0 0 0 1px rgba(var(--admin-primary-rgb), 0.2);
}

.admin-dark .all-posts-modal-header .form-control::placeholder,
.admin-dark .all-users-modal-header .form-control::placeholder,
.admin-dark .all-categories-modal-header .form-control::placeholder,
.admin-dark .all-comments-modal-header .form-control::placeholder {
    color: #94a3b8;
    opacity: 1;
}

.admin-dark .all-posts-modal-content .modal-body,
.admin-dark .all-users-modal-content .modal-body,
.admin-dark .all-categories-modal-content .modal-body,
.admin-dark .all-comments-modal-content .modal-body {
    background: #0b1220;
}

.admin-dark #allBlogPostsModal .modal-body,
.admin-dark #allUsersModal .modal-body,
.admin-dark #allCategoriesModal .modal-body,
.admin-dark #allCommentsModal .modal-body {
    scrollbar-color: rgba(var(--admin-primary-rgb), 0.82) rgba(148, 163, 184, 0.16);
}

.admin-dark #allBlogPostsModal .modal-body::-webkit-scrollbar-track,
.admin-dark #allUsersModal .modal-body::-webkit-scrollbar-track,
.admin-dark #allCategoriesModal .modal-body::-webkit-scrollbar-track,
.admin-dark #allCommentsModal .modal-body::-webkit-scrollbar-track {
    background: rgba(148, 163, 184, 0.16);
}

.admin-dark #allBlogPostsModal .modal-body::-webkit-scrollbar-thumb,
.admin-dark #allUsersModal .modal-body::-webkit-scrollbar-thumb,
.admin-dark #allCategoriesModal .modal-body::-webkit-scrollbar-thumb,
.admin-dark #allCommentsModal .modal-body::-webkit-scrollbar-thumb {
    border-color: rgba(15, 23, 42, 0.42);
}

.admin-dark .all-posts-item,
.admin-dark .all-users-item,
.admin-dark .all-categories-item,
.admin-dark .all-comments-item {
    background: #0f172a !important;
    border-color: #334155 !important;
    color: #f8fafc !important;
}

.admin-dark .all-posts-item .text-muted,
.admin-dark .all-users-item .text-muted,
.admin-dark .all-categories-item .text-muted,
.admin-dark .all-comments-item .text-muted,
.admin-dark .all-posts-item small,
.admin-dark .all-users-item small,
.admin-dark .all-categories-item small,
.admin-dark .all-comments-item small {
    color: #cbd5e1 !important;
}

.admin-dark .all-users-item .badge.text-bg-light,
.admin-dark .all-categories-item .badge.text-bg-light {
    background: rgba(var(--admin-primary-rgb), 0.18) !important;
    color: #f8fafc !important;
    border-color: rgba(var(--admin-primary-rgb), 0.42) !important;
}

.admin-dark .all-comments-item .badge.text-bg-success {
    background: rgba(16, 185, 129, 0.22) !important;
    color: #86efac !important;
    border: 1px solid rgba(16, 185, 129, 0.45);
}

.admin-dark .all-comments-item .badge.text-bg-warning {
    background: rgba(245, 158, 11, 0.2) !important;
    color: #fde68a !important;
    border: 1px solid rgba(245, 158, 11, 0.42);
}

.admin-dark .all-posts-modal-content .btn-close,
.admin-dark .all-users-modal-content .btn-close,
.admin-dark .all-categories-modal-content .btn-close,
.admin-dark .all-comments-modal-content .btn-close {
    filter: invert(1) grayscale(100%) brightness(170%);
    opacity: 0.8;
}

.admin-dark .activity-modal-dialog .btn-close {
    filter: invert(1) grayscale(100%) brightness(185%);
    opacity: 0.92;
}

.admin-dark .all-posts-modal-content .btn-close:hover,
.admin-dark .all-users-modal-content .btn-close:hover,
.admin-dark .all-categories-modal-content .btn-close:hover,
.admin-dark .all-comments-modal-content .btn-close:hover {
    opacity: 1;
}

.admin-dark .activity-modal-dialog .btn-close:hover {
    opacity: 1;
}

.admin-dark .modal-content,
.admin-dark .all-posts-modal-content,
.admin-dark .all-users-modal-content,
.admin-dark .all-categories-modal-content,
.admin-dark .all-comments-modal-content,
.admin-dark .activity-modal-dialog .modal-content {
    background: #0f172a;
    border-color: #334155;
    color: #e2e8f0;
}

.admin-dark .modal-body .text-muted,
.admin-dark .modal-content .text-muted {
    color: #e2e8f0 !important;
}

.admin-dark .dashboard-hero-content,
.admin-dark .dashboard-hero-content * {
    color: #f8fafc !important;
}

.admin-dark .dashboard-hero-content .dashboard-hero-subtitle {
    color: #e2e8f0 !important;
}

.admin-dark .recent-comments-pending-badge {
    color: #fde68a;
    background: rgba(245, 158, 11, 0.2);
    border-color: rgba(245, 158, 11, 0.42);
}

.admin-dark .recent-comments-result-badge {
    border-color: #334155;
    background: #0b1220;
    color: #e2e8f0;
}

.admin-dark .recent-comments-table-head {
    border-top-color: #334155;
    border-bottom-color: #334155;
    background: #0b1f36;
}

.admin-dark .recent-filter-btn {
    border-color: #334155;
    background: #0b1220;
    color: #cbd5e1;
}

.admin-dark .recent-filter-btn:hover {
    border-color: #4b5d79;
    background: #111b2f;
}

.admin-dark .recent-filter-btn.is-active {
    border-color: rgba(var(--admin-primary-rgb), 0.55);
    background: rgba(var(--admin-primary-rgb), 0.2);
    color: #dbeafe;
}

.admin-dark .recent-comments-search-wrap i {
    color: #94a3b8;
}

.admin-dark .recent-comment-item {
    border-left-color: #334155;
    border-right-color: #334155;
    border-bottom-color: #334155;
    background: #0f172a;
}

.admin-dark .recent-comment-item.is-priority {
    border-color: rgba(245, 158, 11, 0.5);
    box-shadow: inset 4px 0 0 rgba(245, 158, 11, 0.72);
    background: #1a1720;
}

.admin-dark .recent-comment-item:hover {
    background: #111b2f;
    box-shadow: inset 4px 0 0 rgba(var(--admin-primary-rgb), 0.72);
}

.admin-dark .recent-comment-author {
    color: #f8fafc;
}

.admin-dark .recent-comment-avatar {
    border-color: #334155;
}

.admin-dark .recent-comment-email,
.admin-dark .recent-comment-message,
.admin-dark .recent-comment-time,
.admin-dark .recent-comment-post-label,
.admin-dark .recent-comment-post-missing {
    color: #cbd5e1;
}

.admin-dark .recent-comment-post-thumb {
    border-color: #334155;
}

.admin-dark .recent-comment-post-thumb-lg {
    border-color: #334155;
}

.admin-dark .recent-comment-alert {
    color: #fecaca;
    background: rgba(239, 68, 68, 0.22);
    border-color: rgba(248, 113, 113, 0.52);
}

.admin-dark .recent-comment-status.is-approved {
    color: #86efac;
    background: rgba(16, 185, 129, 0.2);
    border-color: rgba(16, 185, 129, 0.4);
}

.admin-dark .recent-comment-status.is-pending {
    color: #fde68a;
    background: rgba(245, 158, 11, 0.2);
    border-color: rgba(245, 158, 11, 0.4);
}

.admin-dark .recent-comment-post-link {
    color: #93c5fd;
}

.admin-dark .recent-comment-post-link:hover {
    color: #bfdbfe;
}

.admin-dark .recent-comment-post-title {
    color: #bfdbfe;
}

.admin-dark .recent-comment-post-title:hover {
    color: #dbeafe;
}

.admin-dark .recent-comment-post-tag {
    color: #dbeafe;
    border-color: rgba(var(--admin-primary-rgb), 0.45);
    background: rgba(var(--admin-primary-rgb), 0.2);
}

.admin-dark .recent-comment-expand {
    color: #93c5fd;
}

.admin-dark .recent-comment-expand:hover {
    color: #bfdbfe;
}

.admin-dark .recent-comment-flag {
    background: rgba(239, 68, 68, 0.24);
    color: #fecaca;
}

.admin-dark .recent-comment-skeleton {
    border-color: #334155;
    background: #0f172a;
}

.admin-dark .recent-skeleton-line {
    background: linear-gradient(90deg, #1e293b 0%, #334155 45%, #1e293b 100%);
}

.admin-dark .recent-reply-badge.yes {
    color: #86efac;
    background: rgba(16, 185, 129, 0.2);
    border-color: rgba(16, 185, 129, 0.4);
}

.admin-dark .recent-reply-badge.no {
    color: #fde68a;
    background: rgba(245, 158, 11, 0.2);
    border-color: rgba(245, 158, 11, 0.4);
}

.admin-dark .recent-comment-submitted-date {
    color: #94a3b8;
}

.admin-dark .recent-comment-submitted-time {
    color: #e2e8f0;
}

@media (max-width: 991.98px) {
    .recent-comments-table-header {
        gap: 10px;
        flex-wrap: wrap;
    }

    .recent-comments-header-actions {
        width: 100%;
        justify-content: flex-start;
    }

    .recent-comments-toolbar {
        align-items: stretch;
    }

    .recent-comments-search-wrap {
        width: 100%;
    }

    .recent-comments-table-head {
        display: none;
    }

    .recent-comment-item {
        grid-template-columns: repeat(6, minmax(0, 1fr));
        gap: 10px;
        padding: 12px;
        border-left: 0;
        border-right: 0;
    }

    .recent-comment-post-col { display: block; }

    .recent-comment-post-inline {
        grid-template-columns: 72px minmax(0, 1fr);
        align-items: center;
        gap: 10px;
    }

    .recent-comment-post-cover {
        width: 72px;
    }

    .recent-comment-post-thumb-lg {
        width: 72px;
        height: 52px;
    }

    .rc-post,
    .rc-author {
        grid-column: span 3;
        min-height: 120px;
    }

    .rc-post.recent-comment-post-col .rc-post-meta {
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 6px;
        min-width: 0;
    }

    .rc-author.recent-comment-user-col { display: block; }

    .recent-comment-author-inline {
        grid-template-columns: 44px minmax(0, 1fr);
        align-items: center;
        gap: 10px;
    }

    .recent-comment-author-stack {
        flex-direction: column;
        align-items: flex-start;
        gap: 2px;
        flex-wrap: nowrap;
        min-width: 0;
    }

    .recent-comment-author,
    .recent-comment-email {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .rc-post-meta {
        display: grid;
        align-items: start;
        gap: 4px;
        flex-wrap: nowrap;
        min-width: 0;
    }

    .recent-comment-post-title {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: block;
        -webkit-line-clamp: unset;
        -webkit-box-orient: unset;
    }

    .recent-comment-post-tag {
        flex: 0 0 auto;
    }

    .rc-comment {
        grid-column: 1 / -1;
    }

    .rc-reply,
    .rc-status,
    .rc-submitted {
        grid-column: span 2;
        min-height: 92px;
    }

    .rc-actions {
        grid-column: 1 / -1;
        display: flex;
        flex-direction: column;
        align-items: stretch;
    }

    .recent-comment-actions {
        justify-content: center;
        flex-direction: row;
        align-items: stretch;
        width: 100%;
        flex-wrap: nowrap;
        gap: 8px;
        margin-top: 2px;
    }

    .rc-actions {
        justify-content: flex-start;
        align-items: stretch;
    }

    .rc-actions::before {
        text-align: center;
        width: 100%;
        margin-bottom: 10px;
    }

    .rc-cell {
        padding: 8px 10px;
        border: 1px solid rgba(148, 163, 184, 0.26);
        border-radius: 10px;
        background: rgba(248, 251, 255, 0.75);
    }

    .rc-cell::before {
        content: attr(data-label);
        display: block;
        margin-bottom: 6px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        color: #6881a3;
    }

    .recent-comment-actions form,
    .recent-comment-actions > .btn {
        flex: 1 1 0;
        min-width: 0;
    }

    .recent-comment-actions .btn {
        width: 100%;
        justify-content: center;
    }

    .admin-dark .rc-cell {
        border-color: rgba(148, 163, 184, 0.22);
        background: rgba(11, 18, 32, 0.72);
    }

    .admin-dark .rc-cell::before {
        color: #93a9c8;
    }
}

@media (max-width: 767.98px) {
    .recent-comment-message {
        overflow-wrap: anywhere;
        word-break: break-all;
    }

    .recent-comment-user-col { display: block; }
    .recent-comment-post-col { display: block; }

    .recent-comment-post-inline {
        grid-template-columns: 72px minmax(0, 1fr);
        align-items: center;
        gap: 10px;
    }

    .recent-comment-author-inline {
        grid-template-columns: 44px minmax(0, 1fr);
        align-items: center;
        gap: 10px;
    }

    .recent-comment-author-stack {
        flex-direction: column;
        align-items: flex-start;
        gap: 2px;
        flex-wrap: nowrap;
        min-width: 0;
    }

    .recent-comment-author,
    .recent-comment-email {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .recent-comment-status,
    .recent-comment-alert {
        margin-left: 0;
    }

    .recent-comment-item {
        grid-template-columns: repeat(6, minmax(0, 1fr));
    }

    .rc-post,
    .rc-author {
        grid-column: span 3;
        min-height: 116px;
    }

    .rc-comment {
        grid-column: 1 / -1;
    }

    .rc-reply,
    .rc-status,
    .rc-submitted {
        grid-column: span 2;
        min-height: 88px;
    }

    .rc-actions {
        grid-column: 1 / -1;
        display: flex;
        flex-direction: column;
        align-items: stretch;
    }

    .recent-comment-actions {
        flex-wrap: nowrap;
        justify-content: center;
        gap: 8px;
    }

    .recent-comment-actions form,
    .recent-comment-actions > .btn {
        flex: 1 1 0;
    }

    .rc-actions::before {
        text-align: center;
        width: 100%;
        margin-bottom: 10px;
    }
}

@media (max-width: 575.98px) {
    .rc-post,
    .rc-author {
        grid-column: 1 / -1;
        min-height: 104px;
    }
}
</style>

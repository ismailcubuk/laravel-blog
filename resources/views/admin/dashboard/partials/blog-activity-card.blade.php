<div class="col-lg-8">
    <section class="dashboard-panel dashboard-activity-panel h-100">
        <header class="dashboard-panel-header activity-panel-header">
            <div>
                <h3 class="dashboard-panel-title">Blog Activity</h3>
                <p class="activity-panel-subtitle">New blogs and new users over the last 7 days.</p>
            </div>

            <div class="activity-legend" id="activityLegend">
                <button type="button" class="activity-legend-btn" data-series="blogs" aria-pressed="true">
                    <span class="activity-legend-dot blogs"></span>
                    New Blogs
                </button>
                <button type="button" class="activity-legend-btn" data-series="users" aria-pressed="true">
                    <span class="activity-legend-dot users"></span>
                    New Users
                </button>
            </div>
        </header>

        <div class="activity-insights">
            <article class="activity-insight-card">
                <span class="activity-insight-label">Blogs This Week</span>
                <strong class="activity-insight-value" id="activityBlogsTotal">0</strong>
            </article>

            <article class="activity-insight-card">
                <span class="activity-insight-label">Users This Week</span>
                <strong class="activity-insight-value" id="activityUsersTotal">0</strong>
            </article>

            <article class="activity-insight-card">
                <span class="activity-insight-label">Peak Day</span>
                <strong class="activity-insight-value" id="activityPeakDay">-</strong>
            </article>
        </div>

        <div class="activity-chart-wrap">
            <canvas id="blogChart"></canvas>
        </div>
    </section>
</div>

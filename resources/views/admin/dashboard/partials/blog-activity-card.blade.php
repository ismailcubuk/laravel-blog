<div class="col-lg-8">
    <section class="dashboard-panel dashboard-activity-panel h-100">
        <header class="dashboard-panel-header activity-panel-header">
            <div>
                <h3 class="dashboard-panel-title">Blog Aktivitesi</h3>
                <p class="activity-panel-subtitle">Son 7 gündeki yeni yazılar ve kullanıcılar.</p>
            </div>

            <div class="activity-legend" id="activityLegend">
                <button type="button" class="activity-legend-btn" data-series="blogs" aria-pressed="true">
                    <span class="activity-legend-dot blogs"></span>
                    Yeni Yazılar
                </button>
                <button type="button" class="activity-legend-btn" data-series="users" aria-pressed="true">
                    <span class="activity-legend-dot users"></span>
                    Yeni Kullanıcılar
                </button>
            </div>
        </header>

        <div class="activity-insights">
            <article class="activity-insight-card is-clickable" id="activityBlogsWeekCard" role="button" tabindex="0">
                <span class="activity-insight-label">Bu Haftaki Yazılar</span>
                <strong class="activity-insight-value" id="activityBlogsTotal">0</strong>
            </article>

            <article class="activity-insight-card is-clickable" id="activityUsersWeekCard" role="button" tabindex="0"><span class="activity-insight-label">Bu Haftaki Kullanıcılar</span>
                <strong class="activity-insight-value" id="activityUsersTotal">0</strong>
            </article>

            <article class="activity-insight-card is-clickable" id="activityPeakDayCard" role="button" tabindex="0"><span class="activity-insight-label">En Yoğun Gün</span>
                <strong class="activity-insight-value" id="activityPeakDay">-</strong>
            </article>
        </div>

        <div class="activity-chart-wrap">
            <canvas id="blogChart"></canvas>
        </div>
    </section>
</div>

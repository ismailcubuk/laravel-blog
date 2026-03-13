@php
    $newPostsWeek = array_sum($newBlogsData ?? []);
    $newUsersWeek = array_sum($newUsersData ?? []);

    $stats = [
        [
            'theme' => 'primary',
            'icon' => 'bi-journal-richtext',
            'value' => $totalPosts ?? 0,
            'label' => 'Total Posts',
            'hint' => $newPostsWeek . ' published this week',
            'action' => ['target' => '#allBlogPostsModal', 'label' => 'View all posts'],
        ],
        [
            'theme' => 'success',
            'icon' => 'bi-people-fill',
            'value' => $totalUsers ?? 0,
            'label' => 'Total Users',
            'hint' => $newUsersWeek . ' joined this week',
            'action' => ['target' => '#allUsersModal', 'label' => 'View all users'],
        ],
        [
            'theme' => 'amber',
            'icon' => 'bi-grid-3x3-gap-fill',
            'value' => $totalCategories ?? 0,
            'label' => 'Categories',
            'hint' => 'Content is grouped by topic',
            'action' => ['target' => '#allCategoriesModal', 'label' => 'View all categories'],
        ],
        [
            'theme' => 'danger',
            'icon' => 'bi-chat-dots-fill',
            'value' => $totalComments ?? 0,
            'label' => 'Comments',
            'hint' => ($pendingComments ?? 0) . ' pending moderation',
            'action' => ['target' => '#allCommentsModal', 'label' => 'View all comments'],
        ],
    ];
@endphp

<section class="dashboard-stats-grid">
    @foreach($stats as $stat)
        <article
            class="dashboard-stat-card stat-{{ $stat['theme'] }} is-clickable"
            role="button"
            tabindex="0"
            data-bs-toggle="modal"
            data-bs-target="{{ $stat['action']['target'] }}"
        >
            <div class="dashboard-stat-top">
                <span class="dashboard-stat-label">{{ $stat['label'] }}</span>
                <span class="dashboard-stat-icon"><i class="bi {{ $stat['icon'] }}"></i></span>
            </div>
            <strong class="dashboard-stat-value">{{ $stat['value'] }}</strong>
            <p class="dashboard-stat-hint">{{ $stat['hint'] }}</p>
            <span class="dashboard-stat-action">{{ $stat['action']['label'] }}</span>
        </article>
    @endforeach
</section>

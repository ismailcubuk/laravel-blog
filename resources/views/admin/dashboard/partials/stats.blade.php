@php
    $newPostsWeek = array_sum($newBlogsData ?? []);
    $newUsersWeek = array_sum($newUsersData ?? []);

    $stats = [
        [
            'theme' => 'primary',
            'icon' => 'bi-journal-richtext',
            'value' => $totalPosts ?? 0,
            'label' => 'Toplam Yazı',
            'hint' => $newPostsWeek . ' bu hafta yayınlandı',
            'action' => ['target' => '#allBlogPostsModal', 'label' => 'Tüm yazıları gör'],
        ],
        [
            'theme' => 'success',
            'icon' => 'bi-people-fill',
            'value' => $totalUsers ?? 0,
            'label' => 'Toplam Kullanıcı',
            'hint' => $newUsersWeek . ' bu hafta katıldı',
            'action' => ['target' => '#allUsersModal', 'label' => 'Tüm kullanıcıları gör'],
        ],
        [
            'theme' => 'amber',
            'icon' => 'bi-grid-3x3-gap-fill',
            'value' => $totalCategories ?? 0,
            'label' => 'Kategoriler',
            'hint' => 'İçerikler konuya göre gruplandı',
            'action' => ['target' => '#allCategoriesModal', 'label' => 'Tüm kategorileri gör'],
        ],
        [
            'theme' => 'danger',
            'icon' => 'bi-chat-dots-fill',
            'value' => $totalComments ?? 0,
            'label' => 'Yorumlar',
            'hint' => ($pendingComments ?? 0) . ' moderasyon bekliyor',
            'action' => ['target' => '#allCommentsModal', 'label' => 'Tüm yorumları gör'],
        ],
    ];
@endphp

<section class="dashboard-stats-grid">
    @foreach($stats as $stat)
        <article
            class="dashboard-stat-card stat-{{ $stat['theme'] }} is-clickable"
            role="button"
            tabindex="0"
            data-toggle="modal"
            data-target="{{ $stat['action']['target'] }}"
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

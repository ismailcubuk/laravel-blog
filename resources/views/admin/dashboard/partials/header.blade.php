@php
    $adminName = auth()->user()->name ?? 'Admin';
    $todayLabel = now()->translatedFormat('d F Y, l');
@endphp

<section class="dashboard-hero">
    <div class="dashboard-hero-content">
        <p class="dashboard-hero-kicker">Control Center</p>
        <h1 class="dashboard-hero-title">Welcome back, {{ $adminName }}</h1>
        <p class="dashboard-hero-subtitle">{{ $todayLabel }} - Monitor content performance and manage updates in one place.</p>
    </div>

    <div class="dashboard-hero-actions">
        <button type="button" class="btn btn-outline-light dashboard-ghost-btn" data-toggle="modal" data-target="#allBlogPostsModal" data-bs-toggle="modal" data-bs-target="#allBlogPostsModal">
            <i class="bi bi-collection me-1"></i> All Posts
        </button>
        <a href="{{ route('admin.content.posts.create') }}" class="btn btn-primary dashboard-primary-btn">
            <i class="bi bi-plus-lg me-1"></i> Yeni Yazı
        </a>
    </div>
</section>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    @php($siteName = $settings['site_name'] ?? config('app.name', 'My Website'))
    @php($pageTitle = trim($__env->yieldContent('title')))
    @php($themeKey = $settings['ui_theme'] ?? 'orange')
    @php($uiTheme = in_array($themeKey, ['orange', 'blue', 'emerald', 'rose', 'violet'], true) ? $themeKey : 'orange')
    @php($modeKey = $settings['ui_mode'] ?? 'white')
    @php($uiMode = in_array($modeKey, ['white', 'dark'], true) ? $modeKey : 'white')
    @php($themePalette = [
        'orange' => ['primary' => '#f48840', 'secondary' => '#fb9857', 'focus' => '#f5b58a', 'rgb' => '244, 136, 64'],
        'blue' => ['primary' => '#1f6bff', 'secondary' => '#0f4fd9', 'focus' => '#93b8ff', 'rgb' => '31, 107, 255'],
        'emerald' => ['primary' => '#10b981', 'secondary' => '#059669', 'focus' => '#6ee7b7', 'rgb' => '16, 185, 129'],
        'rose' => ['primary' => '#e11d48', 'secondary' => '#be123c', 'focus' => '#f9a8d4', 'rgb' => '225, 29, 72'],
        'violet' => ['primary' => '#7c3aed', 'secondary' => '#6d28d9', 'focus' => '#c4b5fd', 'rgb' => '124, 58, 237'],
    ][$uiTheme])
    <title>{{ $siteName }}{{ $pageTitle ? ' ' . $pageTitle : ' Admin Panel' }}</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
       <!-- Site Favicon -->
    <link rel="icon" href="{{ asset($settings['site_favicon'] ?? 'default-favicon.ico') }}" type="image/x-icon">
    @include('admin.partials.theme-vars')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/layout.css') }}">
    @include('partials.global-select-styles')
    @stack('styles')
</head>

<body class="hold-transition sidebar-mini sidebar-expand-lg layout-fixed {{ $uiMode === 'dark' ? 'admin-dark' : 'admin-light' }}">

    <div class="app-wrapper">
        {{-- Sidebar --}}
        @include('admin.partials.sidebar')
        <div class="admin-sidebar-backdrop" id="adminSidebarBackdrop"></div>

        {{-- Content --}}
        <main class="app-main">
            <div class="app-content">
                <div class="container-fluid">
                    <button type="button" class="admin-sidebar-toggle" id="adminSidebarToggle" aria-label="Open sidebar" title="Open sidebar">
                        <i class="fa-solid fa-bars" id="adminSidebarToggleIcon"></i>
                    </button>
                    @yield('content')
                </div>
            </div>
        </main>

        {{-- Footer --}}
        @include('admin.partials.footer')

    </div>

    <!-- Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AdminLTE JS -->
    <script src="{{ asset('adminlte/js/adminlte.js') }}"></script>

    <script src="{{ asset('assets/js/shared/auto-alerts.js') }}"></script>
    <script src="{{ asset('assets/js/admin/sidebar.js') }}"></script>
    <script src="{{ asset('assets/js/shared/form-spellcheck.js') }}"></script>
    @include('partials.global-select-scripts')
    @yield('scripts')
    @stack('scripts')

</body>

</html>






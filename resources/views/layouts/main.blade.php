<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @php($siteName = $settings['site_name'] ?? config('app.name', 'My Website'))
    @php($themeKey = $settings['ui_theme'] ?? 'orange')
    @php($uiTheme = in_array($themeKey, ['orange', 'blue', 'emerald', 'rose', 'violet'], true) ? $themeKey : 'orange')
    @php($modeKey = session('ui_mode', request()->cookie('ui_mode', $settings['ui_mode'] ?? 'white')))
    @php($uiMode = in_array($modeKey, ['white', 'dark'], true) ? $modeKey : 'white')
    @php($themePalette = [
        'orange' => ['primary' => '#f48840', 'secondary' => '#fb9857', 'softBg' => '#fff1e8', 'softBorder' => '#ffd7bf', 'focus' => '#f5b58a', 'rgb' => '244, 136, 64'],
        'blue' => ['primary' => '#1f6bff', 'secondary' => '#3a84ff', 'softBg' => '#edf3ff', 'softBorder' => '#d6e3ff', 'focus' => '#93b8ff', 'rgb' => '31, 107, 255'],
        'emerald' => ['primary' => '#10b981', 'secondary' => '#34d399', 'softBg' => '#ecfdf5', 'softBorder' => '#a7f3d0', 'focus' => '#6ee7b7', 'rgb' => '16, 185, 129'],
        'rose' => ['primary' => '#e11d48', 'secondary' => '#fb7185', 'softBg' => '#fff1f2', 'softBorder' => '#fecdd3', 'focus' => '#f9a8d4', 'rgb' => '225, 29, 72'],
        'violet' => ['primary' => '#7c3aed', 'secondary' => '#a78bfa', 'softBg' => '#f5f3ff', 'softBorder' => '#ddd6fe', 'focus' => '#c4b5fd', 'rgb' => '124, 58, 237'],
    ][$uiTheme])
    @php($themeCss = [
        'orange' => 'assets/css/templatemo-stand-blog.css',
        'blue' => 'assets/css/templatemo-stand-blog-blue.css',
        'emerald' => 'assets/css/templatemo-stand-blog-emerald.css',
        'rose' => 'assets/css/templatemo-stand-blog-rose.css',
        'violet' => 'assets/css/templatemo-stand-blog-violet.css',
    ][$uiTheme])
    <title>@hasSection('title'){{ $siteName }} @yield('title')@else{{ $siteName }}@endif</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset($themeCss) }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.css') }}">

    <link rel="icon" href="{{ asset($settings['site_favicon'] ?? 'default-favicon.ico') }}" type="image/x-icon">

    @include('partials.frontend-theme-vars')
    <link rel="stylesheet" href="{{ asset('assets/css/frontend/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/extracted/partials-header.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/frontend/author-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/frontend/post-create.css') }}">
    @include('partials.global-select-styles')
    <meta name="pjax-head-start" content="front">
    @stack('styles')
    <meta name="pjax-head-end" content="front">
</head>

<body class="front-body {{ $uiMode === 'dark' ? 'front-dark' : 'front-light' }}">

    @include('partials.preloader')
    @include('partials.header')
    <main class="front-main" id="front-pjax" data-pjax-container="front">
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/js/shared/auto-alerts.js') }}?v={{ filemtime(public_path('assets/js/shared/auto-alerts.js')) }}"></script>
    <script src="{{ asset('assets/js/shared/form-spellcheck.js') }}"></script>
    @include('partials.global-select-scripts')
    <script src="{{ asset('assets/js/shared/pjax.js') }}"></script>
    <script src="{{ asset('assets/js/frontend/navigation-optimizer.js') }}"></script>
    <script src="{{ asset('assets/js/extracted/partials-header-mode-switch.js') }}"></script>
    @stack('scripts')

</body>

</html>

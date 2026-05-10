<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php($siteName = $settings['site_name'] ?? config('app.name', 'My Website'))
    @php($pageTitle = trim($__env->yieldContent('title')))
    @php($modeKey = $settings['ui_mode'] ?? 'white')
    @php($isDarkMode = $modeKey === 'dark')
    <title>{{ $siteName }}{{ $pageTitle ? ' ' . $pageTitle : ' Admin Login' }}</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Site Favicon -->
    <link rel="icon" href="{{ asset($settings['site_favicon'] ?? 'default-favicon.ico') }}" type="image/x-icon">
    <style>
        :root {
            --auth-bg-a: {{ $isDarkMode ? '#0b1220' : '#0f1f3a' }};
            --auth-bg-b: {{ $isDarkMode ? '#111b2f' : '#1f3c6f' }};
            --auth-surface: {{ $isDarkMode ? '#0f172a' : '#ffffff' }};
            --auth-border: {{ $isDarkMode ? '#334155' : '#e2e8f4' }};
            --auth-text: {{ $isDarkMode ? '#e2e8f0' : '#1a2433' }};
            --auth-muted: {{ $isDarkMode ? '#94a3b8' : '#6b778e' }};
            --auth-primary: #1f6bff;
            --auth-primary-2: #0f4fd9;
            --auth-input-bg: {{ $isDarkMode ? '#111b2f' : '#fbfcff' }};
            --auth-input-border: {{ $isDarkMode ? '#334155' : '#d6deec' }};
            --auth-label: {{ $isDarkMode ? '#cbd5e1' : '#4b5b74' }};
            --auth-label-active: {{ $isDarkMode ? '#e2e8f0' : '#1f2e46' }};
            --auth-check-label: {{ $isDarkMode ? '#e2e8f0' : '#344258' }};
            --auth-addon-bg: {{ $isDarkMode ? 'rgba(15, 23, 42, 0.72)' : '#f2f6ff' }};
            --auth-addon-bg-focus: {{ $isDarkMode ? 'rgba(15, 23, 42, 0.8)' : '#e8f0ff' }};
            --auth-addon-color: {{ $isDarkMode ? '#cbd5e1' : '#4c5e7d' }};
            --auth-link: {{ $isDarkMode ? '#93c5fd' : '#1f6bff' }};
            --auth-link-hover: {{ $isDarkMode ? '#bfdbfe' : '#0f4fd9' }};
            --auth-page-glow: {{ $isDarkMode ? 'rgba(59, 130, 246, 0.24)' : '#2b4e8c' }};
            --auth-alert-success-border: {{ $isDarkMode ? 'rgba(34, 197, 94, 0.45)' : '#bde8d6' }};
            --auth-alert-success-bg: {{ $isDarkMode ? '#0b3b2e' : '#eaf8f2' }};
            --auth-alert-success-text: {{ $isDarkMode ? '#86efac' : '#12684a' }};
            --auth-alert-danger-border: {{ $isDarkMode ? 'rgba(251, 113, 133, 0.45)' : '#f1cad0' }};
            --auth-alert-danger-bg: {{ $isDarkMode ? '#4c1d24' : '#fff1f3' }};
            --auth-alert-danger-text: {{ $isDarkMode ? '#fda4af' : '#8f2532' }};
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/extracted/admin-layouts-auth.css') }}">
    @include('partials.global-select-styles')
    @stack('styles')
</head>

<body class="login-page">

    @yield('content')

    @push('scripts')
<script src="{{ asset('assets/js/extracted/admin-layouts-auth.js') }}"></script>
@endpush

    @push('scripts')
<script src="{{ asset('assets/js/extracted/admin-layouts-auth-2.js') }}"></script>
@endpush

    <!-- Bootstrap 5 JS (required for modal) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AdminLTE JS -->
    <script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>
    @include('partials.global-select-scripts')
    @stack('scripts')
</body>

</html>





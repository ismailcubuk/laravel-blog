<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @php($siteName = $settings['site_name'] ?? config('app.name', 'My Website'))
    @php($themeKey = $settings['ui_theme'] ?? 'orange')
    @php($uiTheme = in_array($themeKey, ['orange', 'blue', 'emerald', 'rose', 'violet'], true) ? $themeKey : 'orange')
    @php($modeKey = $settings['ui_mode'] ?? 'white')
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

    <style>
        :root {
            --front-bg-a: {{ $uiMode === 'dark' ? '#0b1220' : '#f8fbff' }};
            --front-bg-b: {{ $uiMode === 'dark' ? '#111a2e' : '#eef3fb' }};
            --front-surface: {{ $uiMode === 'dark' ? '#0f172a' : '#ffffff' }};
            --front-border: {{ $uiMode === 'dark' ? '#25324a' : '#e2e8f4' }};
            --front-text: {{ $uiMode === 'dark' ? '#e2e8f0' : '#1a2433' }};
            --front-muted: {{ $uiMode === 'dark' ? '#94a3b8' : '#1f2e46' }};
            --front-primary: {{ $themePalette['primary'] }};
            --front-primary-2: {{ $themePalette['secondary'] }};
            --front-soft-bg: {{ $themePalette['softBg'] }};
            --front-soft-border: {{ $themePalette['softBorder'] }};
            --front-focus: {{ $themePalette['focus'] }};
            --front-primary-rgb: {{ $themePalette['rgb'] }};
            --front-input-bg: {{ $uiMode === 'dark' ? '#111b2f' : '#fbfcff' }};
            --front-shadow: {{ $uiMode === 'dark' ? '0 14px 30px rgba(2, 6, 23, 0.45)' : '0 14px 30px rgba(16, 33, 61, 0.08)' }};
            --front-radius: 16px;
        }

        body.front-body {
            margin: 0;
            font-family: "Manrope", sans-serif;
            color: var(--front-text);
            background: linear-gradient(165deg, var(--front-bg-a) 0%, var(--front-bg-b) 100%);
            min-height: 100vh;
        }

        .front-main {
            padding: 1.2rem 0 1.8rem;
        }

        .maintenance-banner {
            margin: 0.9rem auto 0;
            width: min(1120px, calc(100% - 24px));
            border-radius: 12px;
            border: 1px solid rgba(var(--front-primary-rgb), 0.3);
            background: rgba(var(--front-primary-rgb), 0.1);
            color: var(--front-text);
            padding: 0.62rem 0.9rem;
            font-weight: 700;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .front-card,
        .blog-post,
        .sidebar-item,
        .contact-us .down-contact,
        .about-us img {
            border: 1px solid var(--front-border);
            border-radius: var(--front-radius);
            background: var(--front-surface);
            box-shadow: var(--front-shadow);
            overflow: hidden;
        }

        .front-section-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--front-text);
            margin-bottom: 1rem;
        }

        .main-button,
        .main-button a,
        .front-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            min-height: 42px;
            border: 0;
            border-radius: 12px;
            padding: 0.45rem 1rem;
            font-size: 0.92rem;
            font-weight: 700;
            text-transform: none;
            color: #fff;
            background: linear-gradient(135deg, var(--front-primary) 0%, var(--front-primary-2) 100%);
            box-shadow: 0 10px 18px rgba(var(--front-primary-rgb), 0.24);
            transition: all 0.2s ease;
        }

        .main-button:hover,
        .main-button a:hover,
        .front-btn:hover {
            color: #fff;
            filter: brightness(1.03);
            transform: translateY(-1px);
            text-decoration: none;
        }

        .btn:not(.btn-close) {
            --front-btn-bg: rgba(var(--front-primary-rgb), 0.14);
            --front-btn-color: var(--front-text);
            --front-btn-border: rgba(var(--front-primary-rgb), 0.34);
            --front-btn-shadow: 0 8px 18px rgba(var(--front-primary-rgb), 0.14);
            --front-btn-hover-bg: rgba(var(--front-primary-rgb), 0.22);
            --front-btn-hover-border: rgba(var(--front-primary-rgb), 0.62);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.38rem;
            min-height: 40px;
            padding: 0.45rem 0.95rem;
            border-radius: 12px;
            border: 1px solid var(--front-btn-border);
            background: var(--front-btn-bg);
            color: var(--front-btn-color) !important;
            font-size: 0.86rem;
            font-weight: 800;
            line-height: 1;
            text-decoration: none;
            box-shadow: var(--front-btn-shadow);
            transition: transform 0.16s ease, background-color 0.16s ease, border-color 0.16s ease;
        }

        .btn:not(.btn-close):hover {
            background: var(--front-btn-hover-bg);
            border-color: var(--front-btn-hover-border);
            color: var(--front-btn-color) !important;
            transform: translateY(-1px);
            text-decoration: none;
        }

        .btn:not(.btn-close):focus-visible {
            outline: 0;
            box-shadow: 0 0 0 4px rgba(var(--front-primary-rgb), 0.16);
        }

        .btn-primary:not(.btn-close),
        .btn-outline-primary:not(.btn-close),
        .btn-success:not(.btn-close),
        .btn-outline-success:not(.btn-close) {
            --front-btn-bg: linear-gradient(135deg, var(--front-primary) 0%, var(--front-primary-2) 100%);
            --front-btn-color: #ffffff;
            --front-btn-border: transparent;
            --front-btn-shadow: 0 10px 18px rgba(var(--front-primary-rgb), 0.24);
            --front-btn-hover-bg: linear-gradient(135deg, var(--front-primary) 0%, var(--front-primary-2) 100%);
            --front-btn-hover-border: transparent;
        }

        .btn-warning:not(.btn-close),
        .btn-outline-warning:not(.btn-close) {
            --front-btn-bg: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            --front-btn-color: #ffffff;
            --front-btn-border: transparent;
            --front-btn-shadow: 0 10px 18px rgba(217, 119, 6, 0.24);
            --front-btn-hover-bg: linear-gradient(135deg, #f9ab17 0%, #db800d 100%);
            --front-btn-hover-border: transparent;
        }

        .btn-danger:not(.btn-close),
        .btn-outline-danger:not(.btn-close) {
            --front-btn-bg: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            --front-btn-color: #ffffff;
            --front-btn-border: transparent;
            --front-btn-shadow: 0 10px 18px rgba(220, 38, 38, 0.24);
            --front-btn-hover-bg: linear-gradient(135deg, #f05252 0%, #e03232 100%);
            --front-btn-hover-border: transparent;
        }

        .btn-secondary:not(.btn-close),
        .btn-outline-secondary:not(.btn-close),
        .btn-light:not(.btn-close),
        .btn-outline-light:not(.btn-close) {
            --front-btn-bg: rgba(148, 163, 184, 0.18);
            --front-btn-color: var(--front-text);
            --front-btn-border: rgba(148, 163, 184, 0.4);
            --front-btn-shadow: none;
            --front-btn-hover-bg: rgba(148, 163, 184, 0.26);
            --front-btn-hover-border: rgba(148, 163, 184, 0.62);
        }

        .heading-page .page-heading {
            padding: 2.4rem 0;
            border: 1px solid var(--front-border);
            border-radius: var(--front-radius);
            background: linear-gradient(120deg, #0f1f3a 0%, #1a2f56 100%);
            box-shadow: var(--front-shadow);
        }

        .heading-page .text-content h2,
        .heading-page .text-content h4 {
            color: #fff;
        }

        .alert {
            border-radius: 12px;
            border: 1px solid transparent;
            font-weight: 600;
        }

        .alert-success {
            border-color: #bde8d6;
            background: #eaf8f2;
            color: #12684a;
        }

        .alert-danger {
            border-color: #f1cad0;
            background: #fff1f3;
            color: #8f2532;
        }

        .form-control,
        .form-select,
        .contact-form input,
        .contact-form textarea,
        .searchText {
            border: 1px solid var(--front-border);
            border-radius: 12px;
            background: var(--front-input-bg);
            color: var(--front-text);
            min-height: 42px;
            padding: 0.62rem 0.85rem;
            width: 100%;
        }

        .form-control:focus,
        .form-select:focus,
        .contact-form input:focus,
        .contact-form textarea:focus,
        .searchText:focus {
            border-color: var(--front-focus);
            box-shadow: 0 0 0 4px rgba(var(--front-primary-rgb), 0.12);
            background: var(--front-surface);
            outline: none;
        }

        .form-control:-webkit-autofill,
        .form-control:-webkit-autofill:hover,
        .form-control:-webkit-autofill:focus,
        .form-control:-webkit-autofill:active,
        .form-select:-webkit-autofill,
        .form-select:-webkit-autofill:hover,
        .form-select:-webkit-autofill:focus,
        .form-select:-webkit-autofill:active,
        .contact-form input:-webkit-autofill,
        .contact-form input:-webkit-autofill:hover,
        .contact-form input:-webkit-autofill:focus,
        .contact-form input:-webkit-autofill:active,
        .contact-form textarea:-webkit-autofill,
        .contact-form textarea:-webkit-autofill:hover,
        .contact-form textarea:-webkit-autofill:focus,
        .contact-form textarea:-webkit-autofill:active,
        .searchText:-webkit-autofill,
        .searchText:-webkit-autofill:hover,
        .searchText:-webkit-autofill:focus,
        .searchText:-webkit-autofill:active {
            -webkit-text-fill-color: var(--front-text) !important;
            caret-color: var(--front-text) !important;
            -webkit-box-shadow: inset 0 0 0 1000px var(--front-input-bg) !important;
            box-shadow: inset 0 0 0 1000px var(--front-input-bg) !important;
            transition: background-color 9999s ease-out 0s !important;
            border: 1px solid var(--front-border) !important;
        }

        .form-control:-webkit-autofill:focus,
        .form-control:-webkit-autofill:active,
        .form-select:-webkit-autofill:focus,
        .form-select:-webkit-autofill:active,
        .contact-form input:-webkit-autofill:focus,
        .contact-form input:-webkit-autofill:active,
        .contact-form textarea:-webkit-autofill:focus,
        .contact-form textarea:-webkit-autofill:active,
        .searchText:-webkit-autofill:focus,
        .searchText:-webkit-autofill:active {
            -webkit-box-shadow: inset 0 0 0 1000px var(--front-surface) !important;
            box-shadow: inset 0 0 0 1000px var(--front-surface) !important;
            border-color: var(--front-focus) !important;
        }

        .sidebar-item {
            margin-bottom: 1rem;
            padding: 1rem;
        }

        .sidebar-item .sidebar-heading h2 {
            margin: 0 0 0.8rem;
            font-size: 1rem;
            font-weight: 800;
            color: var(--front-text);
        }

        .sidebar-item .content ul li {
            border-color: var(--front-border);
        }

        .sidebar-item .content ul li a,
        .sidebar-item .content ul li a h5,
        .sidebar-item .content ul li a span {
            color: {{ $uiMode === 'dark' ? '#cbd5e1' : '#41506a' }};
        }

        .sidebar-item .content ul li a:hover,
        .sidebar-item .content ul li a:hover h5 {
            color: var(--front-primary);
        }

        .pagination .page-link {
            border-radius: 10px !important;
            margin: 0 3px;
            border-color: var(--front-border);
            background: {{ $uiMode === 'dark' ? 'rgba(15, 23, 42, 0.86)' : '#ffffff' }};
            color: {{ $uiMode === 'dark' ? '#cbd5e1' : '#35507f' }};
            font-weight: 700;
            min-width: 38px;
            text-align: center;
        }

        .pagination .page-link:hover {
            background: {{ $uiMode === 'dark' ? 'rgba(30, 41, 59, 0.95)' : '#f8fbff' }};
            color: {{ $uiMode === 'dark' ? '#f8fafc' : '#1f3b63' }};
            border-color: {{ $uiMode === 'dark' ? '#475569' : '#bcd0f5' }};
        }

        .pagination .active > .page-link {
            background: var(--front-primary);
            border-color: var(--front-primary);
            color: #fff;
        }

        .pagination .disabled .page-link {
            background: {{ $uiMode === 'dark' ? 'rgba(15, 23, 42, 0.72)' : '#f3f6fb' }};
            color: {{ $uiMode === 'dark' ? '#64748b' : '#8aa0c2' }};
            border-color: var(--front-border);
        }

        .page-numbers li a {
            border-radius: 10px !important;
            border: 1px solid var(--front-border);
            background: {{ $uiMode === 'dark' ? 'rgba(15, 23, 42, 0.86)' : '#ffffff' }};
            color: {{ $uiMode === 'dark' ? '#e2e8f0' : '#35507f' }} !important;
            font-weight: 700;
        }

        .page-numbers li a:hover {
            background: {{ $uiMode === 'dark' ? 'rgba(30, 41, 59, 0.95)' : '#f8fbff' }};
            color: {{ $uiMode === 'dark' ? '#f8fafc' : '#1f3b63' }} !important;
            border-color: {{ $uiMode === 'dark' ? '#475569' : '#bcd0f5' }};
        }

        .page-numbers li.active a {
            color: #fff !important;
            border-color: var(--front-primary) !important;
            background: var(--front-primary) !important;
        }

        .page-numbers li.disabled a {
            color: {{ $uiMode === 'dark' ? '#64748b' : '#8aa0c2' }} !important;
            background: {{ $uiMode === 'dark' ? 'rgba(15, 23, 42, 0.72)' : '#f3f6fb' }} !important;
        }

        .text-muted {
            color: var(--front-muted) !important;
        }

        @media (max-width: 991.98px) {
            .front-main {
                padding-top: 0.7rem;
            }
        }

        .front-dark .heading-page .text-content h2,
        .front-dark .heading-page .text-content h4,
        .front-dark .blog-post .down-content h1,
        .front-dark .blog-post .down-content h2,
        .front-dark .blog-post .down-content h3,
        .front-dark .blog-post .down-content h4,
        .front-dark .blog-post .down-content h5,
        .front-dark .blog-post .down-content h6,
        .front-dark .sidebar .sidebar-item .sidebar-heading h2,
        .front-dark .contact-us .sidebar-heading h2,
        .front-dark .about-us h1,
        .front-dark .about-us h2,
        .front-dark .about-us h3,
        .front-dark .about-us h4,
        .front-dark .about-us h5,
        .front-dark .about-us h6 {
            color: #f1f5f9 !important;
        }

        .front-dark .blog-post .down-content p,
        .front-dark .blog-post .down-content li,
        .front-dark .blog-post .down-content span,
        .front-dark .blog-post .down-content strong,
        .front-dark .sidebar .sidebar-item .content,
        .front-dark .sidebar .sidebar-item .content p,
        .front-dark .sidebar .sidebar-item .content span,
        .front-dark .sidebar .sidebar-item .content li,
        .front-dark .contact-us p,
        .front-dark .contact-us li,
        .front-dark .contact-us span,
        .front-dark .about-us p,
        .front-dark .about-us li,
        .front-dark .about-us span,
        .front-dark .copyright-text,
        .front-dark .copyright-text p {
            color: #cbd5e1 !important;
        }

        .front-dark .text-muted {
            color: var(--front-muted) !important;
        }

        .front-dark .blog-post .down-content a,
        .front-dark .sidebar .sidebar-item .content a,
        .front-dark .contact-us a,
        .front-dark .about-us a,
        .front-dark .post-info li a,
        .front-dark .post-tags a,
        .front-dark .social-icons a {
            color: #e2e8f0;
        }

        .front-dark .blog-post .down-content a:hover,
        .front-dark .sidebar .sidebar-item .content a:hover,
        .front-dark .contact-us a:hover,
        .front-dark .about-us a:hover,
        .front-dark .post-info li a:hover,
        .front-dark .post-tags a:hover,
        .front-dark .social-icons a:hover {
            color: var(--front-primary);
        }

        .front-dark .blog-post .down-content span {
            color: var(--front-primary) !important;
        }

        .front-dark .post-info li::after {
            background-color: rgba(148, 163, 184, 0.5) !important;
        }

        .front-dark .sidebar-item .content ul li,
        .front-dark .contact-us .contact-information ul li {
            border-color: rgba(148, 163, 184, 0.25) !important;
        }

        .front-dark .contact-us .contact-information ul li h5 {
            color: #f1f5f9 !important;
        }

        .front-dark #preloader {
            background-color: #020617;
        }

        .front-dark .jumper > div {
            background-color: var(--front-primary);
        }

        .front-dark .pagination .page-link {
            background: rgba(15, 23, 42, 0.75);
        }

        .front-dark .pagination .disabled .page-link {
            color: #64748b;
            border-color: var(--front-border);
            background: rgba(15, 23, 42, 0.6);
        }

        .front-dark .alert-success {
            border-color: rgba(34, 197, 94, 0.45);
            background: #0b3b2e;
            color: #86efac;
        }

        .front-dark .alert-danger {
            border-color: rgba(251, 113, 133, 0.45);
            background: #4c1d24;
            color: #fda4af;
        }

        .auto-alert-host {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 1080;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
            width: min(92vw, 380px);
            pointer-events: none;
        }

        .auto-alert-toast {
            pointer-events: auto;
            opacity: 0;
            transform: translateY(-8px);
            transition: opacity 0.22s ease, transform 0.22s ease;
        }

        .auto-alert-toast.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .auto-alert-toast .alert.is-auto-toast {
            margin: 0;
            box-shadow: 0 14px 30px rgba(2, 6, 23, 0.32);
        }

        .auto-alert-progress {
            margin-top: 0.42rem;
            height: 4px;
            border-radius: 999px;
            overflow: hidden;
            background: rgba(148, 163, 184, 0.22);
        }

        .auto-alert-progress-bar {
            width: 100%;
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.92), rgba(255, 255, 255, 0.66));
            transition: width var(--alert-duration, 4000ms) linear;
        }
    </style>
    @include('partials.global-select-styles')
    @stack('styles')
</head>

<body class="front-body {{ $uiMode === 'dark' ? 'front-dark' : 'front-light' }}">

    @include('partials.preloader')
    @include('partials.header')
    @if(($settings['maintenance_mode'] ?? '0') === '1')
        <div class="maintenance-banner" role="status" aria-live="polite">
            <i class="bi bi-tools"></i>
            <span>{{ $settings['maintenance_message'] ?: 'We are currently doing scheduled maintenance. Some features may be limited.' }}</span>
        </div>
    @endif

    <main class="front-main">
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const alerts = Array.from(document.querySelectorAll('.alert'))
                .filter((node) => !node.closest('.modal') && !node.hasAttribute('data-no-toast'));

            if (!alerts.length) {
                return;
            }

            let host = document.getElementById('autoAlertHost');
            if (!host) {
                host = document.createElement('div');
                host.id = 'autoAlertHost';
                host.className = 'auto-alert-host';
                document.body.appendChild(host);
            }

            const dismissToast = function (toast) {
                toast.classList.remove('is-visible');
                setTimeout(function () {
                    toast.remove();
                }, 220);
            };

            alerts.forEach(function (alertNode) {
                const durationMs = alertNode.classList.contains('alert-danger') ? 6000 : 4000;
                const toast = document.createElement('div');
                toast.className = 'auto-alert-toast';
                toast.style.setProperty('--alert-duration', durationMs + 'ms');

                alertNode.classList.add('is-auto-toast');
                const closeButton = alertNode.querySelector('.btn-close');
                if (closeButton) {
                    closeButton.remove();
                }

                const progress = document.createElement('div');
                progress.className = 'auto-alert-progress';

                const progressBar = document.createElement('div');
                progressBar.className = 'auto-alert-progress-bar';
                progress.appendChild(progressBar);

                toast.appendChild(alertNode);
                toast.appendChild(progress);
                host.appendChild(toast);

                requestAnimationFrame(function () {
                    toast.classList.add('is-visible');
                    requestAnimationFrame(function () {
                        progressBar.style.width = '0%';
                    });
                });

                setTimeout(function () {
                    dismissToast(toast);
                }, durationMs);
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('input.form-control').forEach(function (input) {
                const type = (input.getAttribute('type') || 'text').toLowerCase();
                if ((type === 'text' || type === 'email' || type === 'password') && !input.hasAttribute('spellcheck')) {
                    input.setAttribute('spellcheck', 'false');
                }
            });
        });
    </script>
    @include('partials.global-select-scripts')
    @stack('scripts')

</body>

</html>

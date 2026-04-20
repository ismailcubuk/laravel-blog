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
        }

        body.login-page {
            font-family: "Manrope", sans-serif;
            color: var(--auth-text);
            background: radial-gradient(circle at top right, {{ $isDarkMode ? 'rgba(59, 130, 246, 0.24)' : '#2b4e8c' }} 0%, transparent 45%),
                        linear-gradient(145deg, var(--auth-bg-a) 0%, var(--auth-bg-b) 100%);
        }

        .login-box,
        .register-box {
            width: min(430px, calc(100% - 24px));
        }

        .card {
            border: 1px solid var(--auth-border);
            border-radius: 16px;
            box-shadow: 0 20px 34px rgba(4, 16, 38, 0.28);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.96) 0%, rgba(17, 27, 47, 0.96) 100%);
            border-bottom: 1px solid var(--auth-border);
        }

        .card-header a,
        .card-header h1,
        .card-header h2,
        .card-header h3,
        .card-header h4,
        .card-header h5,
        .card-header h6 {
            color: #f8fafc !important;
        }

        .card-body {
            padding: 1.3rem;
            background: var(--auth-surface);
            color: var(--auth-text);
        }

        .login-logo a,
        .register-logo a {
            color: #fff;
            font-weight: 800;
            letter-spacing: 0.01em;
        }

        .form-control {
            border-radius: 12px;
            border: 1px solid var(--auth-input-border);
            min-height: 42px;
            background: var(--auth-input-bg);
            color: var(--auth-text);
        }

        .form-control:focus {
            border-color: #93b8ff;
            box-shadow: 0 0 0 4px rgba(31, 107, 255, 0.12);
            background: var(--auth-surface);
            color: var(--auth-text);
        }

        .form-control:-webkit-autofill,
        .form-control:-webkit-autofill:hover,
        .form-control:-webkit-autofill:focus,
        .form-control:-webkit-autofill:active {
            -webkit-text-fill-color: var(--auth-text) !important;
            caret-color: var(--auth-text) !important;
            -webkit-box-shadow: inset 0 0 0 1000px var(--auth-input-bg) !important;
            box-shadow: inset 0 0 0 1000px var(--auth-input-bg) !important;
            transition: background-color 9999s ease-out 0s !important;
            border: 1px solid var(--auth-input-border) !important;
        }

        .form-control:-webkit-autofill:focus,
        .form-control:-webkit-autofill:active {
            -webkit-box-shadow: inset 0 0 0 1000px var(--auth-surface) !important;
            box-shadow: inset 0 0 0 1000px var(--auth-surface) !important;
            border-color: #93b8ff !important;
        }

        .form-control::placeholder {
            color: var(--auth-muted);
        }

        .form-floating > label {
            color: #cbd5e1 !important;
            opacity: 0.95 !important;
        }

        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
            color: #e2e8f0 !important;
            opacity: 1 !important;
        }

        .form-floating > .form-control:-webkit-autofill,
        .form-floating > .form-control:-webkit-autofill:hover,
        .form-floating > .form-control:-webkit-autofill:focus,
        .form-floating > .form-control:-webkit-autofill:active {
            -webkit-text-fill-color: var(--auth-text) !important;
            caret-color: var(--auth-text) !important;
            box-shadow: inset 0 0 0 1000px var(--auth-input-bg) !important;
            -webkit-box-shadow: inset 0 0 0 1000px var(--auth-input-bg) !important;
            transition: background-color 9999s ease-out 0s !important;
            border: 0 !important;
        }

        .form-floating > .form-control:-webkit-autofill ~ label {
            color: #e2e8f0 !important;
            opacity: 1 !important;
            transform: scale(.85) translateY(-.5rem) translateX(.15rem);
        }

        .form-floating > label::after {
            background: transparent !important;
        }

        .form-check-label {
            color: #e2e8f0 !important;
        }

        .input-group {
            border: 1px solid var(--auth-input-border);
            border-radius: 12px;
            background: var(--auth-input-bg);
            overflow: hidden;
            transition: border-color 0.18s ease, box-shadow 0.18s ease, background-color 0.18s ease;
        }

        .input-group .form-floating {
            flex: 1 1 auto;
            min-width: 0;
        }

        .input-group .form-floating > .form-control {
            border: 0 !important;
            border-radius: 0 !important;
            background: transparent !important;
            box-shadow: none !important;
        }

        .input-group-text {
            border: 0;
            border-left: 1px solid var(--auth-input-border);
            background: rgba(15, 23, 42, 0.72);
            color: #cbd5e1;
        }

        .input-group:focus-within {
            border-color: #93b8ff;
            box-shadow: 0 0 0 4px rgba(31, 107, 255, 0.12);
            background: var(--auth-surface);
        }

        .input-group:focus-within .input-group-text {
            border-left-color: #93b8ff;
            background: rgba(15, 23, 42, 0.8);
        }

        .login-card-body,
        .register-card-body {
            background: var(--auth-surface);
            color: var(--auth-text);
        }

        .login-box-msg,
        .register-box-msg,
        .text-muted {
            color: var(--auth-muted) !important;
        }

        .btn-primary {
            border: 0;
            border-radius: 12px;
            min-height: 42px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--auth-primary) 0%, var(--auth-primary-2) 100%);
            box-shadow: 0 10px 18px rgba(31, 107, 255, 0.28);
        }

        .alert {
            border-radius: 12px;
        }

        .alert-success {
            border-color: {{ $isDarkMode ? 'rgba(34, 197, 94, 0.45)' : '#bde8d6' }};
            background: {{ $isDarkMode ? '#0b3b2e' : '#eaf8f2' }};
            color: {{ $isDarkMode ? '#86efac' : '#12684a' }};
        }

        .alert-danger {
            border-color: {{ $isDarkMode ? 'rgba(251, 113, 133, 0.45)' : '#f1cad0' }};
            background: {{ $isDarkMode ? '#4c1d24' : '#fff1f3' }};
            color: {{ $isDarkMode ? '#fda4af' : '#8f2532' }};
        }

        .login-card-body a,
        .register-card-body a {
            color: #93c5fd;
        }

        .login-card-body a:hover,
        .register-card-body a:hover {
            color: #bfdbfe;
        }

        .skip-link {
            display: none !important;
        }

        .auth-icon-svg {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 1rem;
            height: 1rem;
            color: #e2e8f0 !important;
            opacity: 1;
        }

        .auth-icon-svg svg {
            width: 1rem;
            height: 1rem;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
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

<body class="login-page">

    @yield('content')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('a').forEach(function (link) {
                const text = (link.textContent || '').trim().toLowerCase();
                if (text === 'skip to main content' || text === 'skip to navigation') {
                    link.remove();
                }
            });

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

    <!-- AdminLTE JS -->
    <script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>
    @include('partials.global-select-scripts')
    @stack('scripts')
</body>

</html>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php($siteName = $settings['site_name'] ?? config('app.name', 'My Website'))
    @php($pageTitle = trim($__env->yieldContent('title')))
    <title>{{ $siteName }}{{ $pageTitle ? ' ' . $pageTitle : ' Admin Login' }}</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Site Favicon -->
    <link rel="icon" href="{{ asset($settings['site_favicon'] ?? 'default-favicon.ico') }}" type="image/x-icon">
    <style>
        :root {
            --auth-bg-a: #0f1f3a;
            --auth-bg-b: #1f3c6f;
            --auth-surface: #ffffff;
            --auth-border: #e2e8f4;
            --auth-text: #1a2433;
            --auth-muted: #6b778e;
            --auth-primary: #1f6bff;
            --auth-primary-2: #0f4fd9;
        }

        body.login-page {
            font-family: "Manrope", sans-serif;
            color: var(--auth-text);
            background: radial-gradient(circle at top right, #2b4e8c 0%, transparent 45%),
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

        .card-body {
            padding: 1.3rem;
            background: var(--auth-surface);
        }

        .login-logo a,
        .register-logo a {
            color: #fff;
            font-weight: 800;
            letter-spacing: 0.01em;
        }

        .form-control {
            border-radius: 12px;
            border: 1px solid #d6deec;
            min-height: 42px;
            background: #fbfcff;
        }

        .form-control:focus {
            border-color: #93b8ff;
            box-shadow: 0 0 0 4px rgba(31, 107, 255, 0.12);
            background: #fff;
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
    </style>
    @stack('styles')
</head>

<body class="login-page bg-body-secondary">

    @yield('content')

    <!-- AdminLTE JS -->
    <script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>
    @stack('scripts')
</body>

</html>

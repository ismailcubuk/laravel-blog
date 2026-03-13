<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    @php($siteName = $settings['site_name'] ?? config('app.name', 'My Website'))
    @php($pageTitle = trim($__env->yieldContent('title')))
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
    <style>
        :root {
            --admin-bg-a: #f8fbff;
            --admin-bg-b: #f1f4fb;
            --admin-surface: #ffffff;
            --admin-border: #e2e8f4;
            --admin-text: #1a2433;
            --admin-muted: #6b778e;
            --admin-primary: #1f6bff;
            --admin-primary-2: #0f4fd9;
            --admin-success: #179d6d;
            --admin-danger: #d13c4a;
            --admin-shadow: 0 14px 30px rgba(16, 33, 61, 0.08);
        }

        body {
            font-family: "Manrope", sans-serif;
            color: var(--admin-text);
            background: linear-gradient(165deg, var(--admin-bg-a) 0%, var(--admin-bg-b) 100%);
        }

        .app-main {
            background: transparent;
        }

        .app-content {
            padding: 1.1rem 1.2rem;
        }

        .app-content h1 {
            font-weight: 800;
            color: var(--admin-text);
            letter-spacing: -0.01em;
        }

        .app-content .text-primary {
            color: #1f4ba8 !important;
        }

        .app-footer {
            border-top: 1px solid var(--admin-border);
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(4px);
            color: var(--admin-muted);
            font-weight: 600;
        }

        .app-sidebar {
            border-right: 1px solid rgba(255, 255, 255, 0.06);
            background: linear-gradient(180deg, #0f1f3a 0%, #162b4f 100%) !important;
        }

        .sidebar-brand {
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .brand-link {
            color: #fff !important;
            font-weight: 800;
            letter-spacing: 0.01em;
        }

        .sidebar-menu .nav-link {
            border-radius: 10px;
            margin: 2px 8px;
            color: rgba(255, 255, 255, 0.85);
            transition: all 0.2s ease;
        }

        .sidebar-menu .nav-link:hover {
            background: rgba(255, 255, 255, 0.09);
            color: #fff;
        }

        .sidebar-menu .nav-link.active {
            background: linear-gradient(135deg, #1f6bff 0%, #3a84ff 100%);
            color: #fff;
            box-shadow: 0 10px 20px rgba(31, 107, 255, 0.35);
        }

        .sidebar-menu .nav-item.menu-open > .nav-link {
            background: transparent !important;
            box-shadow: none !important;
            color: rgba(255, 255, 255, 0.9);
        }

        .sidebar-menu .nav-icon {
            opacity: 0.95;
        }

        .card {
            border: 1px solid var(--admin-border);
            border-radius: 16px;
            box-shadow: var(--admin-shadow);
            background: var(--admin-surface);
            overflow: hidden;
        }

        .card-header {
            border-bottom: 1px solid var(--admin-border);
            background: linear-gradient(120deg, #0f1f3a 0%, #1a2f56 100%);
            color: #fff;
            padding: 0.9rem 1rem;
            font-weight: 700;
        }

        .card-header h1,
        .card-header h2,
        .card-header h3,
        .card-header h4,
        .card-header h5,
        .card-header h6 {
            margin: 0;
            font-weight: 700;
        }

        .card-body {
            padding: 1.15rem;
        }

        .form-label,
        .col-form-label {
            color: #3a4860;
            font-weight: 600;
            font-size: 0.88rem;
        }

        .form-control,
        .form-select {
            border: 1px solid #d6deec;
            border-radius: 12px;
            min-height: 42px;
            color: var(--admin-text);
            background: #fbfcff;
        }

        textarea.form-control {
            min-height: 110px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #93b8ff;
            box-shadow: 0 0 0 4px rgba(31, 107, 255, 0.12);
            background: #fff;
        }

        .btn {
            border-radius: 12px;
            font-weight: 700;
            min-height: 40px;
            padding: 0.45rem 0.95rem;
            border: 0;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-2) 100%);
            box-shadow: 0 10px 18px rgba(31, 107, 255, 0.24);
        }

        .btn-success {
            background: linear-gradient(135deg, #1ca876 0%, var(--admin-success) 100%);
            box-shadow: 0 10px 18px rgba(23, 157, 109, 0.24);
        }

        .btn-danger {
            background: linear-gradient(135deg, #e04755 0%, var(--admin-danger) 100%);
            box-shadow: 0 10px 18px rgba(209, 60, 74, 0.24);
        }

        .table {
            border-color: #e4ebf5;
        }

        .table th {
            color: #40506c;
            font-weight: 700;
            border-bottom-width: 1px;
        }

        .table td {
            vertical-align: middle;
        }

        .alert {
            border-radius: 12px;
            border: 1px solid transparent;
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

        .badge {
            border-radius: 999px;
            font-weight: 700;
            padding: 0.42em 0.75em;
        }

        .pagination .page-link {
            border-radius: 10px !important;
            margin: 0 3px;
            border-color: #d7e1f1;
            color: #35507f;
        }

        .pagination .active > .page-link {
            background: var(--admin-primary);
            border-color: var(--admin-primary);
        }
    </style>
    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed ">

    <div class="app-wrapper">
        {{-- Sidebar --}}
        @include('admin.partials.sidebar')

        {{-- Content --}}
        <main class="app-main">
            <div class="app-content">
                <div class="container-fluid">
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

    @yield('scripts')

</body>

</html>

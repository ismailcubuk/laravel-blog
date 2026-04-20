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
    <style>
        :root {
            --admin-bg-a: {{ $uiMode === 'dark' ? '#0b1220' : '#f8fbff' }};
            --admin-bg-b: {{ $uiMode === 'dark' ? '#111a2e' : '#f1f4fb' }};
            --admin-surface: {{ $uiMode === 'dark' ? '#0f172a' : '#ffffff' }};
            --admin-border: {{ $uiMode === 'dark' ? '#25324a' : '#e2e8f4' }};
            --admin-text: {{ $uiMode === 'dark' ? '#e2e8f0' : '#1a2433' }};
            --admin-muted: {{ $uiMode === 'dark' ? '#94a3b8' : '#1f2e46' }};
            --admin-primary: {{ $themePalette['primary'] }};
            --admin-primary-2: {{ $themePalette['secondary'] }};
            --admin-success: {{ $uiMode === 'dark' ? '#34d399' : '#179d6d' }};
            --admin-danger: {{ $uiMode === 'dark' ? '#fb7185' : '#d13c4a' }};
            --admin-primary-rgb: {{ $themePalette['rgb'] }};
            --admin-focus: {{ $themePalette['focus'] }};
            --admin-input-bg: {{ $uiMode === 'dark' ? '#111b2f' : '#fbfcff' }};
            --admin-input-border: {{ $uiMode === 'dark' ? '#334155' : '#d6deec' }};
            --admin-shadow: {{ $uiMode === 'dark' ? '0 14px 30px rgba(2, 6, 23, 0.45)' : '0 14px 30px rgba(16, 33, 61, 0.08)' }};
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

        .admin-sidebar-toggle {
            position: sticky;
            top: 0.85rem;
            z-index: 1035;
            width: 42px;
            height: 42px;
            border: 0;
            border-radius: 12px;
            color: #fff;
            background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-2) 100%);
            box-shadow: 0 10px 22px rgba(var(--admin-primary-rgb), 0.28);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.85rem;
        }

        .admin-sidebar-toggle:hover {
            filter: brightness(1.03);
            transform: translateY(-1px);
        }

        .admin-sidebar-toggle:focus-visible {
            outline: 0;
            box-shadow: 0 0 0 4px rgba(var(--admin-primary-rgb), 0.18);
        }

        .app-content h1 {
            font-weight: 800;
            color: var(--admin-text);
            letter-spacing: -0.01em;
        }

        .app-content .text-primary {
            color: var(--admin-primary) !important;
        }

        .app-footer {
            border-top: 1px solid var(--admin-border);
            background: {{ $uiMode === 'dark' ? 'rgba(15, 23, 42, 0.85)' : 'rgba(255, 255, 255, 0.8)' }};
            backdrop-filter: blur(4px);
            color: var(--admin-muted);
            font-weight: 600;
        }

        .app-sidebar {
            border-right: 1px solid rgba(255, 255, 255, 0.06);
            background: {{ $uiMode === 'dark' ? 'linear-gradient(180deg, #020617 0%, #0f172a 100%)' : 'linear-gradient(180deg, #0f1f3a 0%, #162b4f 100%)' }} !important;
        }

        .admin-sidebar-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(9, 18, 35, 0.48);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease;
            z-index: 1040;
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
            background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-2) 100%);
            color: #fff;
            box-shadow: 0 10px 20px rgba(var(--admin-primary-rgb), 0.35);
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
            color: var(--admin-text);
        }

        .card-body h1,
        .card-body h2,
        .card-body h3,
        .card-body h4,
        .card-body h5,
        .card-body h6,
        .card-body p,
        .card-body small,
        .card-body li {
            color: var(--admin-text);
        }

        .card-body .text-muted {
            color: var(--admin-muted) !important;
        }

        .text-muted {
            color: var(--admin-muted) !important;
        }

        .form-label,
        .col-form-label {
            color: {{ $uiMode === 'dark' ? '#cbd5e1' : '#3a4860' }};
            font-weight: 600;
            font-size: 0.88rem;
        }

        .form-control,
        .form-select {
            border: 1px solid var(--admin-input-border);
            border-radius: 12px;
            min-height: 42px;
            color: var(--admin-text);
            background: var(--admin-input-bg);
        }

        input[type="file"].form-control {
            padding: 0;
            overflow: hidden;
        }

        input[type="file"].form-control::file-selector-button {
            height: 100%;
            min-height: 42px;
            border: 0;
            border-right: 1px solid var(--admin-input-border);
            border-top-left-radius: 11px;
            border-bottom-left-radius: 11px;
            background: rgba(var(--admin-primary-rgb), 0.14);
            color: var(--admin-text);
            font-weight: 700;
            padding: 0 1rem;
            margin-right: 0.7rem;
            transition: background-color 0.18s ease, color 0.18s ease;
        }

        input[type="file"].form-control:hover::file-selector-button {
            background: rgba(var(--admin-primary-rgb), 0.22);
            color: var(--admin-text);
        }

        input[type="file"].form-control::-webkit-file-upload-button {
            height: 100%;
            min-height: 42px;
            border: 0;
            border-right: 1px solid var(--admin-input-border);
            border-top-left-radius: 11px;
            border-bottom-left-radius: 11px;
            background: rgba(var(--admin-primary-rgb), 0.14);
            color: var(--admin-text);
            font-weight: 700;
            padding: 0 1rem;
            margin-right: 0.7rem;
            transition: background-color 0.18s ease, color 0.18s ease;
        }

        input[type="file"].form-control:hover::-webkit-file-upload-button {
            background: rgba(var(--admin-primary-rgb), 0.22);
            color: var(--admin-text);
        }

        textarea.form-control {
            min-height: 110px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--admin-focus);
            box-shadow: 0 0 0 4px rgba(var(--admin-primary-rgb), 0.12);
            background: var(--admin-surface);
        }

        .form-control:-webkit-autofill,
        .form-control:-webkit-autofill:hover,
        .form-control:-webkit-autofill:focus,
        .form-control:-webkit-autofill:active,
        .form-select:-webkit-autofill,
        .form-select:-webkit-autofill:hover,
        .form-select:-webkit-autofill:focus,
        .form-select:-webkit-autofill:active {
            -webkit-text-fill-color: var(--admin-text) !important;
            caret-color: var(--admin-text) !important;
            -webkit-box-shadow: inset 0 0 0 1000px var(--admin-input-bg) !important;
            box-shadow: inset 0 0 0 1000px var(--admin-input-bg) !important;
            transition: background-color 9999s ease-out 0s !important;
            border: 1px solid var(--admin-input-border) !important;
        }

        .form-control:-webkit-autofill:focus,
        .form-control:-webkit-autofill:active,
        .form-select:-webkit-autofill:focus,
        .form-select:-webkit-autofill:active {
            -webkit-box-shadow: inset 0 0 0 1000px var(--admin-surface) !important;
            box-shadow: inset 0 0 0 1000px var(--admin-surface) !important;
            border-color: var(--admin-focus) !important;
        }

        .btn:not(.btn-close) {
            --ui-btn-bg: rgba(var(--admin-primary-rgb), 0.14);
            --ui-btn-color: var(--admin-text);
            --ui-btn-border: rgba(var(--admin-primary-rgb), 0.34);
            --ui-btn-shadow: 0 8px 18px rgba(var(--admin-primary-rgb), 0.14);
            --ui-btn-hover-bg: rgba(var(--admin-primary-rgb), 0.22);
            --ui-btn-hover-border: rgba(var(--admin-primary-rgb), 0.62);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.42rem;
            min-height: 34px;
            padding: 0.35rem 0.72rem;
            border-radius: 10px;
            border: 1px solid var(--ui-btn-border);
            background: var(--ui-btn-bg);
            color: var(--ui-btn-color) !important;
            font-size: 0.76rem;
            font-weight: 800;
            line-height: 1;
            text-decoration: none;
            box-shadow: var(--ui-btn-shadow);
            transition: transform 0.16s ease, background-color 0.16s ease, border-color 0.16s ease, color 0.16s ease, box-shadow 0.16s ease;
        }

        .btn:not(.btn-close):hover {
            background: var(--ui-btn-hover-bg);
            border-color: var(--ui-btn-hover-border);
            color: var(--ui-btn-color) !important;
            transform: translateY(-1px);
            text-decoration: none;
        }

        .btn:not(.btn-close):focus-visible {
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(var(--admin-primary-rgb), 0.24);
        }

        .btn:disabled,
        .btn.disabled {
            opacity: 0.58;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-sm:not(.btn-close) {
            min-height: 30px;
            padding: 0.28rem 0.6rem;
            border-radius: 9px;
            font-size: 0.7rem;
        }

        .btn-lg:not(.btn-close) {
            min-height: 42px;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-size: 0.86rem;
        }

        .btn-primary:not(.btn-close),
        .btn-outline-primary:not(.btn-close) {
            --ui-btn-bg: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-2) 100%);
            --ui-btn-color: #ffffff;
            --ui-btn-border: transparent;
            --ui-btn-shadow: 0 10px 18px rgba(var(--admin-primary-rgb), 0.28);
            --ui-btn-hover-bg: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-2) 100%);
            --ui-btn-hover-border: transparent;
        }

        .btn-success:not(.btn-close),
        .btn-outline-success:not(.btn-close) {
            --ui-btn-bg: linear-gradient(135deg, #18a871 0%, #0f8a5d 100%);
            --ui-btn-color: #ffffff;
            --ui-btn-border: transparent;
            --ui-btn-shadow: 0 10px 18px rgba(22, 163, 74, 0.26);
            --ui-btn-hover-bg: linear-gradient(135deg, #1cb77b 0%, #0f9664 100%);
            --ui-btn-hover-border: transparent;
        }

        .btn-warning:not(.btn-close),
        .btn-outline-warning:not(.btn-close) {
            --ui-btn-bg: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            --ui-btn-color: #ffffff;
            --ui-btn-border: transparent;
            --ui-btn-shadow: 0 10px 18px rgba(217, 119, 6, 0.24);
            --ui-btn-hover-bg: linear-gradient(135deg, #f9ab17 0%, #db800d 100%);
            --ui-btn-hover-border: transparent;
        }

        .btn-danger:not(.btn-close),
        .btn-outline-danger:not(.btn-close) {
            --ui-btn-bg: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            --ui-btn-color: #ffffff;
            --ui-btn-border: transparent;
            --ui-btn-shadow: 0 10px 18px rgba(220, 38, 38, 0.24);
            --ui-btn-hover-bg: linear-gradient(135deg, #f05252 0%, #e03232 100%);
            --ui-btn-hover-border: transparent;
        }

        .btn-secondary:not(.btn-close),
        .btn-outline-secondary:not(.btn-close),
        .btn-light:not(.btn-close),
        .btn-outline-light:not(.btn-close) {
            --ui-btn-bg: rgba(148, 163, 184, 0.18);
            --ui-btn-color: var(--admin-text);
            --ui-btn-border: rgba(148, 163, 184, 0.4);
            --ui-btn-shadow: none;
            --ui-btn-hover-bg: rgba(148, 163, 184, 0.26);
            --ui-btn-hover-border: rgba(148, 163, 184, 0.62);
        }

        .btn-link:not(.btn-close) {
            --ui-btn-bg: transparent;
            --ui-btn-color: var(--admin-primary);
            --ui-btn-border: transparent;
            --ui-btn-shadow: none;
            --ui-btn-hover-bg: rgba(var(--admin-primary-rgb), 0.12);
            --ui-btn-hover-border: transparent;
            text-decoration: none;
        }

        .ui-btn {
            --ui-btn-bg: rgba(var(--admin-primary-rgb), 0.14);
            --ui-btn-color: var(--admin-text);
            --ui-btn-border: rgba(var(--admin-primary-rgb), 0.34);
            --ui-btn-shadow: 0 8px 18px rgba(var(--admin-primary-rgb), 0.14);
            --ui-btn-hover-bg: rgba(var(--admin-primary-rgb), 0.22);
            --ui-btn-hover-border: rgba(var(--admin-primary-rgb), 0.62);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.42rem;
            min-height: 34px;
            padding: 0.35rem 0.72rem;
            border-radius: 10px;
            border: 1px solid var(--ui-btn-border);
            background: var(--ui-btn-bg);
            color: var(--ui-btn-color) !important;
            font-size: 0.76rem;
            font-weight: 800;
            line-height: 1;
            text-decoration: none;
            box-shadow: var(--ui-btn-shadow);
            transition: transform 0.16s ease, background-color 0.16s ease, border-color 0.16s ease, color 0.16s ease, box-shadow 0.16s ease;
        }

        .ui-btn:hover {
            background: var(--ui-btn-hover-bg);
            border-color: var(--ui-btn-hover-border);
            color: var(--ui-btn-color) !important;
            transform: translateY(-1px);
            text-decoration: none;
        }

        .ui-btn:focus-visible {
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(var(--admin-primary-rgb), 0.24);
        }

        .ui-btn:disabled,
        .ui-btn.disabled {
            opacity: 0.58;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .ui-btn-sm {
            min-height: 30px;
            padding: 0.28rem 0.6rem;
            border-radius: 9px;
            font-size: 0.7rem;
        }

        .ui-btn-primary {
            --ui-btn-bg: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-2) 100%);
            --ui-btn-color: #ffffff;
            --ui-btn-border: transparent;
            --ui-btn-shadow: 0 10px 18px rgba(var(--admin-primary-rgb), 0.28);
            --ui-btn-hover-bg: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-2) 100%);
            --ui-btn-hover-border: transparent;
        }

        .ui-btn-success {
            --ui-btn-bg: linear-gradient(135deg, #18a871 0%, #0f8a5d 100%);
            --ui-btn-color: #ffffff;
            --ui-btn-border: transparent;
            --ui-btn-shadow: 0 10px 18px rgba(22, 163, 74, 0.26);
            --ui-btn-hover-bg: linear-gradient(135deg, #1cb77b 0%, #0f9664 100%);
            --ui-btn-hover-border: transparent;
        }

        .ui-btn-warning {
            --ui-btn-bg: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            --ui-btn-color: #ffffff;
            --ui-btn-border: transparent;
            --ui-btn-shadow: 0 10px 18px rgba(217, 119, 6, 0.24);
            --ui-btn-hover-bg: linear-gradient(135deg, #f9ab17 0%, #db800d 100%);
            --ui-btn-hover-border: transparent;
        }

        .ui-btn-danger {
            --ui-btn-bg: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            --ui-btn-color: #ffffff;
            --ui-btn-border: transparent;
            --ui-btn-shadow: 0 10px 18px rgba(220, 38, 38, 0.24);
            --ui-btn-hover-bg: linear-gradient(135deg, #f05252 0%, #e03232 100%);
            --ui-btn-hover-border: transparent;
        }

        .ui-btn-neutral {
            --ui-btn-bg: rgba(148, 163, 184, 0.18);
            --ui-btn-color: var(--admin-text);
            --ui-btn-border: rgba(148, 163, 184, 0.4);
            --ui-btn-shadow: none;
            --ui-btn-hover-bg: rgba(148, 163, 184, 0.26);
            --ui-btn-hover-border: rgba(148, 163, 184, 0.62);
        }

        .table {
            border-color: var(--admin-border);
        }

        .table th {
            color: {{ $uiMode === 'dark' ? '#cbd5e1' : '#40506c' }};
            font-weight: 700;
            border-bottom-width: 1px;
        }


        .admin-dark .table {
            border-color: #334155;
        }

        .admin-dark .table thead th {
            background: #0b1f36 !important;
            color: #f8fafc !important;
            border-color: #334155 !important;
        }

        .admin-dark .table > :not(caption) > * > * {
            background: #0f172a !important;
            color: #e2e8f0 !important;
            border-color: #334155 !important;
        }

        .admin-dark .table.table-striped > tbody > tr:nth-of-type(odd) > * {
            background: #0f172a !important;
        }

        .admin-dark .table.table-striped > tbody > tr:nth-of-type(even) > * {
            background: #111b2f !important;
        }

        .admin-dark .table.table-hover > tbody > tr:hover > * {
            background: #13213a !important;
            color: #f8fafc !important;
        }

        .admin-dark .card-footer.bg-white,
        .admin-dark .modal-footer.bg-white {
            background: #0b1220 !important;
            color: #e2e8f0 !important;
            border-color: #334155 !important;
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
            border-color: var(--admin-border);
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
            background: var(--admin-primary);
            border-color: var(--admin-primary);
            color: #fff;
        }

        .pagination .disabled .page-link {
            background: {{ $uiMode === 'dark' ? 'rgba(15, 23, 42, 0.72)' : '#f3f6fb' }};
            color: {{ $uiMode === 'dark' ? '#64748b' : '#8aa0c2' }};
            border-color: var(--admin-border);
        }

        .admin-dark .alert-success {
            border-color: rgba(34, 197, 94, 0.45);
            background: #0b3b2e;
            color: #86efac;
        }

        .admin-dark .alert-danger {
            border-color: rgba(251, 113, 133, 0.45);
            background: #4c1d24;
            color: #fda4af;
        }

        .admin-dark .form-control,
        .admin-dark .form-select,
        .admin-dark textarea.form-control {
            color: #e2e8f0 !important;
            -webkit-text-fill-color: #e2e8f0 !important;
            caret-color: #f8fafc;
        }

        .admin-dark .form-control:focus,
        .admin-dark .form-control:active,
        .admin-dark .form-control:hover,
        .admin-dark textarea.form-control:focus,
        .admin-dark textarea.form-control:active,
        .admin-dark textarea.form-control:hover {
            color: #f8fafc !important;
            -webkit-text-fill-color: #f8fafc !important;
            caret-color: #f8fafc !important;
        }

        .admin-dark input.form-control:-webkit-autofill,
        .admin-dark input.form-control:-webkit-autofill:hover,
        .admin-dark input.form-control:-webkit-autofill:focus,
        .admin-dark input.form-control:-webkit-autofill:active,
        .admin-dark textarea.form-control:-webkit-autofill,
        .admin-dark textarea.form-control:-webkit-autofill:hover,
        .admin-dark textarea.form-control:-webkit-autofill:focus,
        .admin-dark textarea.form-control:-webkit-autofill:active {
            -webkit-text-fill-color: #f8fafc !important;
            caret-color: #f8fafc !important;
            -webkit-box-shadow: inset 0 0 0 1000px #0f172a !important;
            box-shadow: inset 0 0 0 1000px #0f172a !important;
            border-color: #334155 !important;
        }

        .admin-dark .form-control::placeholder,
        .admin-dark textarea.form-control::placeholder {
            color: #94a3b8 !important;
            opacity: 1;
        }

        .admin-dark .form-select option {
            color: #e2e8f0;
            background: #0f172a;
        }

        .admin-dark input[type="file"].form-control::file-selector-button {
            color: #e2e8f0;
            background: rgba(30, 41, 59, 0.95);
            border: 0;
            border-right: 1px solid #334155;
        }

        .admin-dark input[type="file"].form-control:hover::file-selector-button,
        .admin-dark input[type="file"].form-control:hover::-webkit-file-upload-button {
            background: rgba(51, 65, 85, 0.98);
            color: #f8fafc;
            border-right-color: #475569;
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

        @media (max-width: 991.98px) {
            .app-sidebar {
                position: fixed !important;
                top: 0;
                left: 0;
                bottom: 0;
                width: 280px;
                margin-left: 0 !important;
                transform: translateX(-100%);
                transition: transform 0.22s ease;
                z-index: 1045;
            }

            .app-main,
            .app-footer {
                margin-left: 0 !important;
            }

            .admin-sidebar-toggle {
                position: fixed;
                top: 0.9rem;
                left: 0.9rem;
                margin-bottom: 0;
                z-index: 1055;
            }

            body.sidebar-mobile-open .app-sidebar {
                transform: translateX(0);
            }

            body.sidebar-mobile-open .admin-sidebar-backdrop {
                opacity: 1;
                pointer-events: auto;
            }
        }

        @media (min-width: 992px) {
            .admin-sidebar-backdrop {
                display: none;
            }

            .admin-sidebar-toggle {
                display: none;
            }
        }
    </style>
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
            const body = document.body;
            const toggleBtn = document.getElementById('adminSidebarToggle');
            const toggleIcon = document.getElementById('adminSidebarToggleIcon');
            const backdrop = document.getElementById('adminSidebarBackdrop');
            const sidebar = document.querySelector('.app-sidebar');
            const mobileMedia = window.matchMedia('(max-width: 991.98px)');

            if (!toggleBtn) {
                return;
            }

            const isMobile = function () {
                return mobileMedia.matches;
            };

            const syncToggleState = function () {
                const mobileOpen = body.classList.contains('sidebar-mobile-open');
                toggleBtn.setAttribute('aria-label', mobileOpen ? 'Close sidebar' : 'Open sidebar');
                toggleBtn.setAttribute('title', mobileOpen ? 'Close sidebar' : 'Open sidebar');

                if (toggleIcon) {
                    toggleIcon.classList.toggle('fa-bars', !mobileOpen);
                    toggleIcon.classList.toggle('fa-xmark', mobileOpen);
                    toggleIcon.classList.remove('fa-angles-right');
                }
            };

            body.classList.remove('sidebar-collapse');
            syncToggleState();

            const closeMobileSidebar = function () {
                body.classList.remove('sidebar-mobile-open');
                syncToggleState();
            };

            toggleBtn.addEventListener('click', function () {
                if (isMobile()) {
                    body.classList.toggle('sidebar-mobile-open');
                }
                syncToggleState();
            });

            if (backdrop) {
                backdrop.addEventListener('click', closeMobileSidebar);
            }

            if (sidebar) {
                sidebar.addEventListener('click', function (event) {
                    if (!isMobile()) {
                        return;
                    }

                    const target = event.target.closest('a.nav-link, button.nav-link');
                    if (!target) {
                        return;
                    }

                    if (target.matches('a.nav-link')) {
                        const href = target.getAttribute('href');
                        if (!href || href === '#') {
                            return;
                        }
                    }

                    closeMobileSidebar();
                });
            }

            window.addEventListener('resize', function () {
                if (!isMobile()) {
                    body.classList.remove('sidebar-mobile-open');
                }
                body.classList.remove('sidebar-collapse');
                syncToggleState();
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
    @yield('scripts')
    @stack('scripts')

</body>

</html>


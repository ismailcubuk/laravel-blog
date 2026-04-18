@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h1 class="mb-4 text-primary">General Settings</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Site Settings</h5>
        </div>
        <div class="card-body">
            <form id="generalSettingsForm" action="{{ route('admin.settings.general.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <h5 class="mb-3">Site Information</h5>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Site Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="site_name" class="form-control" value="{{ old('site_name', $settings['site_name'] ?? '') }}">
                    </div>
                </div>

                <div class="mb-3 row align-items-center">
                    <label class="col-sm-2 col-form-label">Site Logo</label>
                    <div class="col-sm-10">
                        <input type="file" name="site_logo" class="form-control" id="siteLogoInput">
                        <div class="mt-2">
                            <img id="siteLogoPreview" src="{{ asset($settings['site_logo'] ?? 'default-logo.png') }}"
                                 alt="Logo" class="img-fluid border rounded" style="max-height:100px;">
                        </div>
                    </div>
                </div>

                <div class="mb-3 row align-items-center">
                    <label class="col-sm-2 col-form-label">Site Favicon</label>
                    <div class="col-sm-10">
                        <input type="file" name="site_favicon" class="form-control" id="siteFaviconInput">
                        <div class="mt-2">
                            <img id="siteFaviconPreview" src="{{ asset($settings['site_favicon'] ?? 'default-favicon.ico') }}"
                                 alt="Favicon" class="img-fluid border rounded" style="max-height:32px;">
                        </div>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Site Tagline</label>
                    <div class="col-sm-10">
                        <input type="text" name="site_tagline" class="form-control" value="{{ old('site_tagline', $settings['site_tagline'] ?? '') }}">
                    </div>
                </div>

                <div class="mb-4 row">
                    <label class="col-sm-2 col-form-label">Footer Text</label>
                    <div class="col-sm-10">
                        <input type="text" name="footer_text" class="form-control" value="{{ old('footer_text', $settings['footer_text'] ?? '') }}">
                    </div>
                </div>

                <hr class="my-4">
                <h5 class="mb-3">Theme Settings</h5>

                @php($selectedTheme = old('ui_theme', $settings['ui_theme'] ?? 'orange'))
                @php($selectedMode = old('ui_mode', $settings['ui_mode'] ?? 'white'))
                @php($isDarkMode = $selectedMode === 'dark')

                <div class="mb-4 row">
                    <label class="col-sm-2 col-form-label">Color Palette</label>
                    <div class="col-sm-10">
                        <div class="theme-grid">
                            <input type="radio" class="theme-input" id="theme_orange" name="ui_theme" value="orange" {{ $selectedTheme === 'orange' ? 'checked' : '' }}>
                            <label class="theme-card" for="theme_orange">
                                <span class="theme-title">Orange Palette</span>
                                <span class="theme-dots"><i style="background:#f48840"></i><i style="background:#fb9857"></i><i style="background:#0f1f3a"></i></span>
                            </label>

                            <input type="radio" class="theme-input" id="theme_blue" name="ui_theme" value="blue" {{ $selectedTheme === 'blue' ? 'checked' : '' }}>
                            <label class="theme-card" for="theme_blue">
                                <span class="theme-title">Blue Palette</span>
                                <span class="theme-dots"><i style="background:#1f6bff"></i><i style="background:#3a84ff"></i><i style="background:#0f1f3a"></i></span>
                            </label>

                            <input type="radio" class="theme-input" id="theme_emerald" name="ui_theme" value="emerald" {{ $selectedTheme === 'emerald' ? 'checked' : '' }}>
                            <label class="theme-card" for="theme_emerald">
                                <span class="theme-title">Emerald Palette</span>
                                <span class="theme-dots"><i style="background:#10b981"></i><i style="background:#34d399"></i><i style="background:#0f1f3a"></i></span>
                            </label>

                            <input type="radio" class="theme-input" id="theme_rose" name="ui_theme" value="rose" {{ $selectedTheme === 'rose' ? 'checked' : '' }}>
                            <label class="theme-card" for="theme_rose">
                                <span class="theme-title">Rose Palette</span>
                                <span class="theme-dots"><i style="background:#e11d48"></i><i style="background:#fb7185"></i><i style="background:#0f1f3a"></i></span>
                            </label>

                            <input type="radio" class="theme-input" id="theme_violet" name="ui_theme" value="violet" {{ $selectedTheme === 'violet' ? 'checked' : '' }}>
                            <label class="theme-card" for="theme_violet">
                                <span class="theme-title">Violet Palette</span>
                                <span class="theme-dots"><i style="background:#7c3aed"></i><i style="background:#a78bfa"></i><i style="background:#0f1f3a"></i></span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-4 row">
                    <label class="col-sm-2 col-form-label">UI Mode</label>
                    <div class="col-sm-10">
                        <div class="mode-grid">
                            <input type="radio" class="theme-input" id="mode_white" name="ui_mode" value="white" {{ $selectedMode === 'white' ? 'checked' : '' }}>
                            <label class="mode-card" for="mode_white">
                                <span class="mode-title">White Mode</span>
                                <span class="mode-preview mode-preview-white"></span>
                            </label>

                            <input type="radio" class="theme-input" id="mode_dark" name="ui_mode" value="dark" {{ $selectedMode === 'dark' ? 'checked' : '' }}>
                            <label class="mode-card" for="mode_dark">
                                <span class="mode-title">Dark Mode</span>
                                <span class="mode-preview mode-preview-dark"></span>
                            </label>
                        </div>
                        <small class="text-muted d-block mt-2">Selections apply to both Admin UI and User UI. Click any palette/mode to apply instantly.</small>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success btn-lg">Save Settings</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .theme-grid,
    .mode-grid {
        display: grid;
        gap: 12px;
    }

    .theme-grid {
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    }

    .mode-grid {
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    }

    .theme-input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .theme-card,
    .mode-card {
        border: 1px solid {{ $isDarkMode ? '#334155' : '#d6deec' }};
        border-radius: 10px;
        padding: 12px;
        background: {{ $isDarkMode ? '#0f172a' : '#ffffff' }};
        color: {{ $isDarkMode ? '#f8fafc' : '#0f172a' }} !important;
        cursor: pointer;
        transition: all 0.2s ease;
        min-height: 70px;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-direction: column;
        gap: 10px;
    }

    .theme-title,
    .mode-title {
        font-weight: 700;
        color: inherit !important;
    }

    .theme-dots {
        display: inline-flex;
        gap: 8px;
    }

    .theme-dots i {
        width: 22px;
        height: 22px;
        border-radius: 999px;
        display: inline-block;
    }

    .mode-preview {
        width: 100%;
        height: 22px;
        border-radius: 999px;
        border: 1px solid {{ $isDarkMode ? '#334155' : '#d6deec' }};
        display: block;
    }

    .mode-preview-white {
        background: linear-gradient(90deg, #ffffff 0%, #edf2fb 100%);
    }

    .mode-preview-dark {
        border-color: #2e3e56;
        background: linear-gradient(90deg, #0f172a 0%, #1e293b 100%);
    }

    .theme-input:checked + .theme-card,
    .theme-input:checked + .mode-card {
        border-color: var(--admin-primary);
        box-shadow: 0 0 0 4px rgba(var(--admin-primary-rgb), 0.14);
        transform: translateY(-1px);
    }

    .theme-card:hover,
    .mode-card:hover {
        border-color: {{ $isDarkMode ? '#64748b' : '#b4c5e2' }};
    }

    .theme-card .theme-dots i {
        box-shadow: 0 0 0 1px rgba(15, 23, 42, 0.12);
    }

    .mode-grid + small.text-muted,
    .theme-grid + small.text-muted {
        color: {{ $isDarkMode ? '#e2e8f0' : '#334155' }} !important;
    }
</style>
@endpush

@push('scripts')
<script>
    const settingsForm = document.getElementById('generalSettingsForm');
    const logoInput = document.getElementById('siteLogoInput');
    const logoPreview = document.getElementById('siteLogoPreview');

    if (logoInput && logoPreview) {
        logoInput.addEventListener('change', e => {
            const file = e.target.files[0];
            if (file) logoPreview.src = URL.createObjectURL(file);
        });
    }

    const faviconInput = document.getElementById('siteFaviconInput');
    const faviconPreview = document.getElementById('siteFaviconPreview');

    if (faviconInput && faviconPreview) {
        faviconInput.addEventListener('change', e => {
            const file = e.target.files[0];
            if (file) faviconPreview.src = URL.createObjectURL(file);
        });
    }

    let themeAutoSubmitting = false;
    document.querySelectorAll('input.theme-input[name="ui_theme"], input.theme-input[name="ui_mode"]').forEach((input) => {
        input.addEventListener('change', () => {
            if (!settingsForm || themeAutoSubmitting) {
                return;
            }

            themeAutoSubmitting = true;
            settingsForm.requestSubmit();
        });
    });
</script>
@endpush

@endsection



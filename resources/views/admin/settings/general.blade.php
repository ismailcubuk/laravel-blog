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

    <div class="card shadow-sm settings-page-card">
        <div class="card-header">
            <h5 class="mb-0">Site Settings</h5>
        </div>
        <div class="card-body">
            <form id="generalSettingsForm" action="{{ route('admin.settings.general.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="settings-shell">
                    <div class="settings-panel">
                        <div class="settings-panel-head">Core Information</div>
                        <div class="settings-panel-body row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Site Name</label>
                                <input type="text" name="site_name" class="form-control" value="{{ old('site_name', $settings['site_name'] ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Site Tagline</label>
                                <input type="text" name="site_tagline" class="form-control" value="{{ old('site_tagline', $settings['site_tagline'] ?? '') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Footer Text</label>
                                <input type="text" name="footer_text" class="form-control" value="{{ old('footer_text', $settings['footer_text'] ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <div class="settings-panel">
                        <div class="settings-panel-head">Brand Assets</div>
                        <div class="settings-panel-body row g-3">
                            <div class="col-lg-6 col-md-6">
                                <div class="asset-block">
                                    <label class="form-label">Site Logo</label>
                                    <div class="settings-preview asset-preview mb-2">
                                        <img id="siteLogoPreview" src="{{ asset($settings['site_logo'] ?? 'default-logo.png') }}"
                                             alt="Logo" class="img-fluid border rounded asset-preview-image">
                                    </div>
                                    <div class="asset-file-name" id="siteLogoFileName">No file selected</div>
                                    <div class="pro-upload" data-file-upload>
                                        <input type="file" name="site_logo" class="pro-upload-input" id="siteLogoInput" accept="image/*">
                                        <label for="siteLogoInput" class="pro-upload-trigger pro-upload-trigger-button">
                                            <span class="pro-upload-icon"><i class="bi bi-cloud-arrow-up"></i></span>
                                            <span class="pro-upload-texts">
                                                <span class="pro-upload-title">Change Logo</span>
                                                <span class="pro-upload-sub">PNG, JPG, SVG</span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="asset-block">
                                    <label class="form-label">Site Favicon</label>
                                    <div class="settings-preview asset-preview mb-2">
                                        <img id="siteFaviconPreview" src="{{ asset($settings['site_favicon'] ?? 'default-favicon.ico') }}"
                                             alt="Favicon" class="img-fluid border rounded asset-preview-image">
                                    </div>
                                    <div class="asset-file-name" id="siteFaviconFileName">No file selected</div>
                                    <div class="pro-upload" data-file-upload>
                                        <input type="file" name="site_favicon" class="pro-upload-input" id="siteFaviconInput" accept="image/*">
                                        <label for="siteFaviconInput" class="pro-upload-trigger pro-upload-trigger-button">
                                            <span class="pro-upload-icon"><i class="bi bi-cloud-arrow-up"></i></span>
                                            <span class="pro-upload-texts">
                                                <span class="pro-upload-title">Change Favicon</span>
                                                <span class="pro-upload-sub">ICO, PNG, SVG</span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="settings-section-head mb-2">
                        <h5 class="mb-0">Theme Settings</h5>
                    </div>

@php($selectedTheme = old('ui_theme', $settings['ui_theme'] ?? 'orange'))
@php($selectedMode = old('ui_mode', $settings['ui_mode'] ?? 'white'))

                    <div class="settings-panel mb-3">
                        <div class="settings-panel-head">Color Palette</div>
                        <div class="settings-panel-body">
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

                    <div class="settings-panel">
                        <div class="settings-panel-head">Interface Mode</div>
                        <div class="settings-panel-body">
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
                        </div>
                    </div>

                    <div class="settings-savebar">
                        <button type="submit" class="ui-btn ui-btn-success">Save Settings</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .settings-shell {
        display: grid;
        gap: 0.75rem;
    }

    .settings-page-card {
        border: 0;
        border-radius: 16px;
        background: transparent;
        box-shadow: none !important;
    }

    .settings-page-card > .card-header {
        border: 0;
        border-radius: 16px 16px 0 0;
        background: rgba(var(--admin-primary-rgb), 0.08);
        padding: 0.75rem 1rem;
    }

    .settings-page-card > .card-body {
        border: 0;
        border-radius: 0 0 16px 16px;
        background: rgba(var(--admin-primary-rgb), 0.03);
        padding: 0.8rem 1rem 0.95rem;
    }

    .settings-section-head h5 {
        font-weight: 800;
        letter-spacing: -0.01em;
    }

    .settings-panel {
        border: 0;
        border-radius: 14px;
        background: rgba(var(--admin-primary-rgb), 0.025);
        box-shadow: inset 0 0 0 1px rgba(var(--admin-primary-rgb), 0.06);
        overflow: hidden;
    }

    .settings-panel-head {
        padding: 0.6rem 0.8rem;
        border-bottom: 1px solid rgba(var(--admin-primary-rgb), 0.08);
        font-size: 0.8rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--admin-muted);
        background: transparent;
    }

    .settings-panel-body {
        padding: 0.75rem;
    }

    .settings-preview {
        border: 1px dashed rgba(var(--admin-primary-rgb), 0.16);
        border-radius: 12px;
        min-height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem;
        background: rgba(var(--admin-primary-rgb), 0.03);
    }

    .asset-block {
        border-radius: 10px;
        padding: 0.15rem 0.1rem 0.1rem;
    }

    .asset-block + .asset-block {
        margin-top: 0.65rem;
        padding-top: 0.85rem;
        border-top: 1px solid rgba(var(--admin-primary-rgb), 0.1);
    }

    .asset-preview {
        min-height: 72px;
    }

    .asset-preview-image {
        width: 84px;
        height: 84px;
        object-fit: contain;
        display: block;
    }

    .asset-file-name {
        margin: 0 0 0.45rem;
        font-size: 0.78rem;
        font-weight: 700;
        color: var(--admin-muted);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .settings-savebar {
        margin-top: 0.15rem;
        border: 0;
        border-radius: 14px;
        padding: 0.65rem 0.8rem;
        background: transparent;
        box-shadow: none;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.7rem;
        flex-wrap: wrap;
    }

    .pro-upload {
        position: relative;
    }

    .pro-upload-input {
        position: absolute;
        width: 1px;
        height: 1px;
        opacity: 0;
        pointer-events: none;
    }

    .pro-upload-trigger {
        width: 100%;
        border: 1px solid var(--admin-input-border);
        border-radius: 14px;
        background: linear-gradient(180deg, rgba(var(--admin-primary-rgb), 0.08), rgba(var(--admin-primary-rgb), 0.03));
        color: var(--admin-text);
        min-height: 44px;
        padding: 0.5rem 0.65rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        cursor: pointer;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
    }

    .pro-upload-trigger.pro-upload-trigger-button {
        min-height: 40px;
        padding: 0.45rem 0.62rem;
        border-radius: 11px;
        background: rgba(var(--admin-primary-rgb), 0.07);
    }

    .pro-upload-trigger:hover {
        border-color: rgba(var(--admin-primary-rgb), 0.68);
        box-shadow: 0 10px 20px rgba(var(--admin-primary-rgb), 0.14);
        transform: translateY(-1px);
    }

    .pro-upload-input:focus + .pro-upload-trigger {
        border-color: var(--admin-focus);
        box-shadow: 0 0 0 4px rgba(var(--admin-primary-rgb), 0.16);
    }

    .pro-upload-icon {
        width: 30px;
        height: 30px;
        border-radius: 9px;
        background: rgba(var(--admin-primary-rgb), 0.18);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: var(--admin-primary);
        flex: 0 0 auto;
    }

    .pro-upload-texts {
        display: grid;
        gap: 2px;
        min-width: 0;
    }

    .pro-upload-title {
        font-size: 0.84rem;
        font-weight: 800;
        line-height: 1.2;
    }

    .pro-upload-sub {
        font-size: 0.72rem;
        color: var(--admin-muted);
    }

    .pro-upload-file {
        margin-left: auto;
        max-width: 48%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 0.8rem;
        padding: 0.3rem 0.55rem;
        border-radius: 999px;
        border: 1px solid rgba(var(--admin-primary-rgb), 0.3);
        background: rgba(var(--admin-primary-rgb), 0.12);
        color: var(--admin-text);
        font-weight: 700;
    }

    .admin-dark .pro-upload-trigger {
        border-color: #334155;
        background: linear-gradient(180deg, rgba(30, 41, 59, 0.95), rgba(15, 23, 42, 0.95));
    }

    .admin-dark .pro-upload-icon {
        background: rgba(59, 130, 246, 0.2);
        color: #93c5fd;
    }

    .admin-dark .pro-upload-file {
        border-color: #475569;
        background: rgba(148, 163, 184, 0.16);
        color: #e2e8f0;
    }

    .admin-dark .settings-panel {
        background: rgba(15, 23, 42, 0.76);
        box-shadow: inset 0 0 0 1px rgba(51, 65, 85, 0.68);
    }

    .admin-dark .asset-block + .asset-block {
        border-top-color: rgba(71, 85, 105, 0.7);
    }

    .admin-dark .settings-panel-head {
        background: rgba(15, 23, 42, 0.06);
        border-bottom-color: rgba(71, 85, 105, 0.65);
        color: #cbd5e1;
    }

    .admin-dark .settings-preview {
        border-color: #334155;
        background: rgba(15, 23, 42, 0.74);
    }

    .admin-dark .settings-savebar {
        background: transparent;
        box-shadow: none;
    }

    .admin-dark .settings-page-card > .card-header {
        background: rgba(15, 23, 42, 0.78);
    }

    .admin-dark .settings-page-card > .card-body {
        background: rgba(15, 23, 42, 0.44);
    }

    .color-field {
        display: flex;
        align-items: center;
        gap: 0.55rem;
    }

    .color-field .form-control-color {
        width: 52px;
        min-width: 52px;
        padding: 0.18rem;
        border-radius: 10px;
    }

    .color-field .color-hex-readonly {
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        letter-spacing: 0.02em;
    }

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
        border: 1px solid var(--admin-input-border);
        border-radius: 10px;
        padding: 10px;
        background: var(--admin-surface);
        color: var(--admin-text) !important;
        cursor: pointer;
        transition: all 0.2s ease;
        min-height: 58px;
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
        border: 1px solid var(--admin-input-border);
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
        border-color: var(--admin-focus);
    }

    .theme-card .theme-dots i {
        box-shadow: 0 0 0 1px rgba(15, 23, 42, 0.12);
    }

    .mode-grid + small.text-muted,
    .theme-grid + small.text-muted {
        color: var(--admin-muted) !important;
    }

    @media (max-width: 767.98px) {
        .settings-panel-body {
            padding: 0.8rem;
        }

        .settings-savebar {
            flex-direction: column;
            align-items: stretch;
        }

        .settings-savebar .ui-btn {
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    const settingsForm = document.getElementById('generalSettingsForm');
    const logoInput = document.getElementById('siteLogoInput');
    const logoPreview = document.getElementById('siteLogoPreview');
    const logoFileName = document.getElementById('siteLogoFileName');

    if (logoInput && logoPreview) {
        logoInput.addEventListener('change', e => {
            const file = e.target.files[0];
            if (file) {
                logoPreview.src = URL.createObjectURL(file);
            }
            if (logoFileName) {
                logoFileName.textContent = file ? file.name : 'No file selected';
            }
        });
    }

    const faviconInput = document.getElementById('siteFaviconInput');
    const faviconPreview = document.getElementById('siteFaviconPreview');
    const faviconFileName = document.getElementById('siteFaviconFileName');

    if (faviconInput && faviconPreview) {
        faviconInput.addEventListener('change', e => {
            const file = e.target.files[0];
            if (file) {
                faviconPreview.src = URL.createObjectURL(file);
            }
            if (faviconFileName) {
                faviconFileName.textContent = file ? file.name : 'No file selected';
            }
        });
    }

    const hexToRgb = (hex) => {
        const value = (hex || '').trim().replace('#', '');
        if (!/^[0-9a-fA-F]{3}$|^[0-9a-fA-F]{6}$/.test(value)) {
            return null;
        }

        const normalized = value.length === 3
            ? value.split('').map((ch) => ch + ch).join('')
            : value;

        const int = parseInt(normalized, 16);
        const r = (int >> 16) & 255;
        const g = (int >> 8) & 255;
        const b = int & 255;
        return `${r}, ${g}, ${b}`;
    };

    const bindColorField = (name) => {
        const colorInput = document.querySelector(`input[name="${name}"]`);
        const textInput = colorInput ? colorInput.parentElement.querySelector('.color-hex-readonly') : null;
        if (!colorInput || !textInput) {
            return;
        }

        const sync = () => {
            textInput.value = colorInput.value;
            applyAdminPreview();
        };

        colorInput.addEventListener('input', sync);
        colorInput.addEventListener('change', sync);
        sync();
    };

    const themePalettes = {
        orange: { primary: '#f48840', secondary: '#fb9857', focus: '#f5b58a', rgb: '244, 136, 64' },
        blue: { primary: '#1f6bff', secondary: '#0f4fd9', focus: '#93b8ff', rgb: '31, 107, 255' },
        emerald: { primary: '#10b981', secondary: '#059669', focus: '#6ee7b7', rgb: '16, 185, 129' },
        rose: { primary: '#e11d48', secondary: '#be123c', focus: '#f9a8d4', rgb: '225, 29, 72' },
        violet: { primary: '#7c3aed', secondary: '#6d28d9', focus: '#c4b5fd', rgb: '124, 58, 237' },
    };

    const modeColors = {
        white: {
            bgA: '#f8fbff',
            bgB: '#f1f4fb',
            surface: '#ffffff',
            border: '#e2e8f4',
            text: '#1a2433',
            muted: '#1f2e46',
            inputBg: '#fbfcff',
            inputBorder: '#d6deec',
            shadow: '0 14px 30px rgba(16, 33, 61, 0.08)',
            success: '#179d6d',
            danger: '#d13c4a',
        },
        dark: {
            bgA: '#0b1220',
            bgB: '#111a2e',
            surface: '#0f172a',
            border: '#25324a',
            text: '#e2e8f0',
            muted: '#e2e8f0',
            inputBg: '#111b2f',
            inputBorder: '#334155',
            shadow: '0 14px 30px rgba(2, 6, 23, 0.45)',
            success: '#34d399',
            danger: '#fb7185',
        },
    };

    const applyAdminPreview = () => {
        const selectedThemeInput = document.querySelector('input.theme-input[name="ui_theme"]:checked');
        const selectedModeInput = document.querySelector('input.theme-input[name="ui_mode"]:checked');

        const selectedTheme = selectedThemeInput ? selectedThemeInput.value : 'orange';
        const selectedMode = selectedModeInput ? selectedModeInput.value : 'white';

        const palette = themePalettes[selectedTheme] ?? themePalettes.orange;
        const mode = modeColors[selectedMode] ?? modeColors.white;
        const primaryColorInput = document.querySelector('input[name="brand_primary_color"]');
        const secondaryColorInput = document.querySelector('input[name="brand_secondary_color"]');
        const customPrimary = primaryColorInput ? primaryColorInput.value : '';
        const customSecondary = secondaryColorInput ? secondaryColorInput.value : '';
        const primaryRgb = hexToRgb(customPrimary);

        const root = document.documentElement;
        root.style.setProperty('--admin-bg-a', mode.bgA);
        root.style.setProperty('--admin-bg-b', mode.bgB);
        root.style.setProperty('--admin-surface', mode.surface);
        root.style.setProperty('--admin-border', mode.border);
        root.style.setProperty('--admin-text', mode.text);
        root.style.setProperty('--admin-muted', mode.muted);
        root.style.setProperty('--admin-primary', customPrimary || palette.primary);
        root.style.setProperty('--admin-primary-2', customSecondary || palette.secondary);
        root.style.setProperty('--admin-focus', palette.focus);
        root.style.setProperty('--admin-primary-rgb', primaryRgb || palette.rgb);
        root.style.setProperty('--admin-input-bg', mode.inputBg);
        root.style.setProperty('--admin-input-border', mode.inputBorder);
        root.style.setProperty('--admin-shadow', mode.shadow);
        root.style.setProperty('--admin-success', mode.success);
        root.style.setProperty('--admin-danger', mode.danger);

        document.body.classList.toggle('admin-dark', selectedMode === 'dark');
        document.body.classList.toggle('admin-light', selectedMode !== 'dark');
    };

    document.querySelectorAll('input.theme-input[name="ui_theme"], input.theme-input[name="ui_mode"]').forEach((input) => {
        input.addEventListener('change', applyAdminPreview);
    });

    bindColorField('brand_primary_color');
    bindColorField('brand_secondary_color');
    applyAdminPreview();
</script>
@endpush

@endsection



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
<link rel="stylesheet" href="{{ asset('assets/css/admin/settings/general.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/admin/settings/general.js') }}"></script>
@endpush

@endsection




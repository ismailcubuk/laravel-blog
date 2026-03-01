@extends('admin.layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-primary">General Settings</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.settings.general.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Site Info --}}
                <h5 class="mb-3">Site Information</h5>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Site Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? '' }}">
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
                        <input type="text" name="site_tagline" class="form-control" value="{{ $settings['site_tagline'] ?? '' }}">
                    </div>
                </div>

                <div class="mb-4 row">
                    <label class="col-sm-2 col-form-label">Footer Text</label>
                    <div class="col-sm-10">
                        <input type="text" name="footer_text" class="form-control" value="{{ $settings['footer_text'] ?? '' }}">
                    </div>
                </div>

                {{-- Social Links --}}
                <h5 class="mb-3">Social Links</h5>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Facebook</label>
                    <div class="col-sm-10">
                        <input type="text" name="facebook_url" class="form-control" value="{{ $settings['facebook_url'] ?? '' }}">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Twitter</label>
                    <div class="col-sm-10">
                        <input type="text" name="twitter_url" class="form-control" value="{{ $settings['twitter_url'] ?? '' }}">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Instagram</label>
                    <div class="col-sm-10">
                        <input type="text" name="instagram_url" class="form-control" value="{{ $settings['instagram_url'] ?? '' }}">
                    </div>
                </div>

                <div class="mb-4 row">
                    <label class="col-sm-2 col-form-label">LinkedIn</label>
                    <div class="col-sm-10">
                        <input type="text" name="linkedin_url" class="form-control" value="{{ $settings['linkedin_url'] ?? '' }}">
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success btn-lg">Save Settings</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Live Preview Script --}}
@push('scripts')
<script>
    const logoInput = document.getElementById('siteLogoInput');
    const logoPreview = document.getElementById('siteLogoPreview');

    logoInput.addEventListener('change', e => {
        const file = e.target.files[0];
        if(file) logoPreview.src = URL.createObjectURL(file);
    });

    const faviconInput = document.getElementById('siteFaviconInput');
    const faviconPreview = document.getElementById('siteFaviconPreview');

    faviconInput.addEventListener('change', e => {
        const file = e.target.files[0];
        if(file) faviconPreview.src = URL.createObjectURL(file);
    });
</script>
@endpush

@endsection
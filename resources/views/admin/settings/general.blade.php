@extends('admin.layouts.app')

@section('content')
<h1>General Settings</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('admin.settings.general.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div>
        <label>Site Name</label>
        <input type="text" name="site_name" value="{{ $settings['site_name'] ?? '' }}">
    </div>

    <div>
        <label>Site Logo</label>
        <input type="file" name="site_logo">
        @if(!empty($settings['site_logo']))
            <img src="{{ asset($settings['site_logo']) }}" alt="Logo" width="100">
        @endif
    </div>

    <div>
        <label>Site Favicon</label>
        <input type="file" name="site_favicon">
        @if(!empty($settings['site_favicon']))
            <img src="{{ asset($settings['site_favicon']) }}" alt="Favicon" width="32">
        @endif
    </div>

    <div>
        <label>Site Tagline</label>
        <input type="text" name="site_tagline" value="{{ $settings['site_tagline'] ?? '' }}">
    </div>

    <div>
        <label>Footer Text</label>
        <input type="text" name="footer_text" value="{{ $settings['footer_text'] ?? '' }}">
    </div>

    <div>
        <label>Facebook URL</label>
        <input type="text" name="facebook_url" value="{{ $settings['facebook_url'] ?? '' }}">
    </div>

    <div>
        <label>Twitter URL</label>
        <input type="text" name="twitter_url" value="{{ $settings['twitter_url'] ?? '' }}">
    </div>

    <div>
        <label>Instagram URL</label>
        <input type="text" name="instagram_url" value="{{ $settings['instagram_url'] ?? '' }}">
    </div>

    <div>
        <label>LinkedIn URL</label>
        <input type="text" name="linkedin_url" value="{{ $settings['linkedin_url'] ?? '' }}">
    </div>

    <button type="submit">Save Settings</button>
</form>
@endsection
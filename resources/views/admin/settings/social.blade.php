@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h1 class="mb-4 text-primary">Social Media Settings</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Social Links</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.settings.social.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Facebook</label>
                    <div class="col-sm-10">
                        <input type="text" name="facebook_url" class="form-control" value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Twitter</label>
                    <div class="col-sm-10">
                        <input type="text" name="twitter_url" class="form-control" value="{{ old('twitter_url', $settings['twitter_url'] ?? '') }}">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Instagram</label>
                    <div class="col-sm-10">
                        <input type="text" name="instagram_url" class="form-control" value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}">
                    </div>
                </div>

                <div class="mb-4 row">
                    <label class="col-sm-2 col-form-label">LinkedIn</label>
                    <div class="col-sm-10">
                        <input type="text" name="linkedin_url" class="form-control" value="{{ old('linkedin_url', $settings['linkedin_url'] ?? '') }}">
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success btn-lg">Save Social Settings</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

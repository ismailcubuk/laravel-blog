@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <h1 class="mb-4 text-primary">Contact Page Settings</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Contact Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pages.contact.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Page Title</label>
                        <input type="text" name="title" class="form-control" value="{{ $page->title }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="contact_phone" class="form-control" value="{{ $page->contact_phone }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="contact_email" class="form-control" value="{{ $page->contact_email }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="contact_address" class="form-control" rows="3">{{ $page->contact_address }}</textarea>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <label class="form-label">Google Map URL</label>
                            <input type="text" id="map_src_input" name="contact_map_src" class="form-control"
                                value="{{ $page->contact_map_src ?? '' }}" placeholder="https://maps.google.com/embed?...">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Map Preview</label>
                            <div id="map_preview" style="width: 100%; height: 250px; border: 1px solid var(--admin-border); border-radius: 12px; overflow: hidden; background: var(--admin-input-bg);">
                                @if($page->contact_map_src)
                                    <iframe src="{{ $page->contact_map_src }}" width="100%" height="100%" frameborder="0"
                                        style="border:0;" allowfullscreen>
                                    </iframe>
                                @endif
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @push('scripts')
<script src="{{ asset('assets/js/extracted/admin-pages-contact.js') }}"></script>
@endpush
@endsection



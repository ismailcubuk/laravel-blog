@extends('admin.layouts.app')

@section('content')
    @include('admin.dashboard.partials.header')
    @include('admin.dashboard.partials.stats')
    @include('admin.dashboard.partials.all-posts-modal')

    <div class="row g-4">
        @include('admin.dashboard.partials.blog-activity-card')
        @include('admin.dashboard.partials.latest-posts-card')
    </div>

    @include('admin.dashboard.partials.activity-detail-modal')
@endsection

@push('styles')
    @include('admin.dashboard.partials.styles')
@endpush

@section('scripts')
    @include('admin.dashboard.partials.scripts')
@endsection

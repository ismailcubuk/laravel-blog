@extends('admin.layouts.app')

@section('content')
    @include('admin.dashboard.partials.header')
    @include('admin.dashboard.partials.stats')
    @include('admin.dashboard.partials.all-posts-modal')
    @include('admin.dashboard.partials.all-users-modal')
    @include('admin.dashboard.partials.all-categories-modal')
    @include('admin.dashboard.partials.all-comments-modal')

    <div class="row g-4">
        @include('admin.dashboard.partials.blog-activity-card')
        @include('admin.dashboard.partials.latest-posts-card')
    </div>

    <div class="row g-4 mt-1">
        @include('admin.dashboard.partials.latest-comments-card')
    </div>

    @include('admin.dashboard.partials.activity-detail-modal')
@endsection

@push('styles')
    @include('admin.dashboard.partials.styles')
@endpush

@section('scripts')
    @include('admin.dashboard.partials.scripts')
@endsection

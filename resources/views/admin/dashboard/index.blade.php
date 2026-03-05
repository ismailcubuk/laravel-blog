@extends('admin.layouts.app')

@section('content')
    @include('admin.dashboard.partials.header')
    @include('admin.dashboard.partials.stats')
    @include('admin.dashboard.partials.all-posts-modal')

    <div class="row mt-4">
        @include('admin.dashboard.partials.blog-activity-card')
        @include('admin.dashboard.partials.latest-posts-card')
    </div>

    @include('admin.dashboard.partials.activity-detail-modal')
@endsection

@section('scripts')
    @include('admin.dashboard.partials.styles')
    @include('admin.dashboard.partials.scripts')
@endsection

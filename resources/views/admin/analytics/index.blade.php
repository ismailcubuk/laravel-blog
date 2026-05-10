@extends('admin.layouts.app')

@section('title', 'Analytics')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="mb-1 text-primary">Analytics</h1>
            <p class="text-muted mb-0">A compact overview of publishing, users, comments, and moderation health.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <span class="text-muted small text-uppercase">Total Posts</span>
                    <div class="display-6 fw-semibold">{{ \App\Models\Post::count() }}</div>
                    <div class="text-muted small">All statuses included</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <span class="text-muted small text-uppercase">Published</span>
                    <div class="display-6 fw-semibold text-success">{{ \App\Models\Post::query()->where('status', 'published')->count() }}</div>
                    <div class="text-muted small">Visible public posts</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <span class="text-muted small text-uppercase">Pending Comments</span>
                    <div class="display-6 fw-semibold text-warning">{{ \App\Models\Comment::query()->where('status', 'pending')->count() }}</div>
                    <div class="text-muted small">Waiting for review</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <span class="text-muted small text-uppercase">Users</span>
                    <div class="display-6 fw-semibold">{{ \App\Models\User::count() }}</div>
                    <div class="text-muted small">Registered accounts</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-header">
            <h5 class="mb-0">Next Analytics Milestones</h5>
        </div>
        <div class="card-body">
            <ul class="mb-0">
                <li>Track page views and top referrers.</li>
                <li>Show most-read posts and best-performing categories.</li>
                <li>Add search-term reporting for editorial planning.</li>
                <li>Measure contact form conversion and reply time.</li>
            </ul>
        </div>
    </div>
</div>
@endsection

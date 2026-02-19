@extends('admin.layouts.app')

@section('content')

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Dashboard</h3>
</div>

<!-- Stats Boxes -->
<div class="row">
    @php
        $stats = [
            ['bg' => 'info', 'icon' => 'fa-globe', 'count' => 6, 'label' => 'Site Pages'],
            ['bg' => 'success', 'icon' => 'fa-users', 'count' => 5, 'label' => 'Users'],
            ['bg' => 'warning', 'icon' => 'fa-file-lines', 'count' => 8, 'label' => 'Blog Posts'],
            ['bg' => 'danger', 'icon' => 'fa-chart-line', 'count' => 12, 'label' => 'Website Visits'],
        ];
    @endphp

    @foreach($stats as $stat)
        <div class="col-lg-3 col-6">
            <div class="small-box bg-{{ $stat['bg'] }}">
                <div class="inner">
                    <h3>{{ $stat['count'] }}</h3>
                    <p>{{ $stat['label'] }}</p>
                </div>
                <div class="icon"><i class="fa-solid {{ $stat['icon'] }}"></i></div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    @endforeach
</div>

<!-- Dashboard Cards -->
<div class="row mt-4">
    <!-- Blog Activity -->
    <div class="col-lg-6">
        <div class="card card-success h-100 dashboard-card">
            <div class="card-header"><h3 class="card-title">Blog Activity</h3></div>
            <div class="card-body">
                <canvas id="blogChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Latest Blog Posts -->
    <div class="col-lg-6">
        <div class="card card-primary h-100 dashboard-card">
            <div class="card-header"><h3 class="card-title">Latest Blog Posts</h3></div>
            <div class="card-body p-0 latest-posts-body">
                @for($i = 0; $i < 4; $i++)
                    <div class="d-flex p-3 border-bottom">
                        <div class="me-3">
                            <img src="https://picsum.photos/200/300" width="80" height="80" style="object-fit:cover; border-radius:6px;">
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1">Blog Title Example {{ $i+1 }}</h5>
                            <p class="mb-1 text-muted" style="font-size:14px;">Blog content preview goes here...</p>
                            <small class="text-secondary"><i class="fa fa-comments"></i> {{ rand(1,15) }} comments</small>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    new Chart(document.getElementById('blogChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran'],
            datasets: [
                { label: 'New Blogs', backgroundColor: '#007bff', data: [3,5,2,6,4,7] },
                { label: 'Blog Posts', backgroundColor: '#28a745', data: [5,3,4,2,6,5] }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true } }
        }
    });
});
</script>
@endsection

<style>
.small-box .icon { position:absolute; top:10px; right:15px; font-size:70px; opacity:0.2; }
.dashboard-card { height:400px; }
.dashboard-card .card-body { height: calc(100% - 60px); }
.latest-posts-body { overflow-y:auto; }
#blogChart { width:100% !important; height:100% !important; }
</style>

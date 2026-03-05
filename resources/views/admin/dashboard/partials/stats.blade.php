@php
    $stats = [
        ['bg' => 'info', 'icon' => 'fa-file-lines', 'count' => 6, 'label' => 'Site Pages'],
        ['bg' => 'success', 'icon' => 'fa-users', 'count' => 5, 'label' => 'Users'],
        ['bg' => 'warning', 'icon' => 'fa-file-lines', 'count' => 8, 'label' => 'Blog Posts'],
        ['bg' => 'danger', 'icon' => 'fa-chart-line', 'count' => 12, 'label' => 'Website Visits'],
    ];
@endphp

<div class="row">
    @foreach($stats as $stat)
        <div class="col-lg-3 col-6">
            <div class="small-box bg-{{ $stat['bg'] }}">
                <div class="inner">
                    <h3>{{ $stat['count'] }}</h3>
                    <p>{{ $stat['label'] }}</p>
                </div>
                <div class="icon">
                    <i class="fa-solid {{ $stat['icon'] }}"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    @endforeach
</div>

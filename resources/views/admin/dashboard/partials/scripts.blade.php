<script id="dashboardActivityData" type="application/json">
@php
    $dashboardActivityData = [
        'rawNewBlogsData' => $newBlogsData,
        'rawNewUsersData' => $newUsersData,
        'activityLabels' => $activityLabels,
        'activityDates' => $activityDates,
        'newBlogsItemsByDate' => $newBlogsItemsByDate,
        'newUsersItemsByDate' => $newUsersItemsByDate,
        'visualMinValue' => 0.2,
    ];
@endphp
{!! json_encode($dashboardActivityData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
<script src="{{ asset('assets/js/admin/dashboard/activity.js') }}"></script>
<script src="{{ asset('assets/js/admin/dashboard/all-posts-modal.js') }}"></script>
<script src="{{ asset('assets/js/admin/dashboard/all-users-modal.js') }}"></script>
<script src="{{ asset('assets/js/admin/dashboard/all-categories-modal.js') }}"></script>
<script src="{{ asset('assets/js/admin/dashboard/all-comments-modal.js') }}"></script>
<script src="{{ asset('assets/js/admin/dashboard/recent-comments.js') }}"></script>

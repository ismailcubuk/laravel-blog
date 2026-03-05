<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\Admin\DashboardActivityService;

class DashboardController extends Controller
{
    private DashboardActivityService $dashboardActivityService;

    public function __construct(DashboardActivityService $dashboardActivityService)
    {
        $this->dashboardActivityService = $dashboardActivityService;
    }

    public function index()
    {
        $latestPosts = Post::latest()->take(4)->get();
        $activityData = $this->dashboardActivityService->buildWeeklyActivity(7);

        return view('admin.dashboard.index', array_merge(
            ['latestPosts' => $latestPosts],
            $activityData
        ));
    }
}



<?php

namespace App\Services\Admin;

use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DashboardActivityService
{
    public function buildWeeklyActivity(int $days = 7): array
    {
        $days = max(1, $days);
        $startDate = Carbon::now()->subDays($days - 1)->startOfDay();

        $recentPosts = Post::query()
            ->where('created_at', '>=', $startDate)
            ->orderByDesc('created_at')
            ->get(['id', 'title', 'slug', 'image', 'content', 'created_at']);

        $recentUsers = User::query()
            ->where('created_at', '>=', $startDate)
            ->orderByDesc('created_at')
            ->get(['id', 'name', 'email', 'created_at']);

        $newBlogsByDate = $recentPosts
            ->groupBy(fn (Post $post) => optional($post->created_at)->toDateString())
            ->map(fn ($group) => $group->count());

        $newUsersByDate = $recentUsers
            ->groupBy(fn (User $user) => optional($user->created_at)->toDateString())
            ->map(fn ($group) => $group->count());

        $newBlogsItemsByDate = $recentPosts
            ->groupBy(fn (Post $post) => optional($post->created_at)->toDateString())
            ->map(function ($group) {
                return $group->map(function (Post $post) {
                    return [
                        'title' => $post->title,
                        'excerpt' => Str::limit(strip_tags((string) $post->content), 90),
                        'image' => $post->image
                            ? asset(ltrim((string) $post->image, '/'))
                            : 'https://picsum.photos/seed/' . $post->id . '/200/200',
                        'time' => optional($post->created_at)->format('H:i'),
                        'url' => route('post.show', $post->slug),
                    ];
                })->values();
            })
            ->toArray();

        $newUsersItemsByDate = $recentUsers
            ->groupBy(fn (User $user) => optional($user->created_at)->toDateString())
            ->map(function ($group) {
                return $group->map(function (User $user) {
                    return [
                        'name' => $user->name,
                        'email' => $user->email,
                        'time' => optional($user->created_at)->format('H:i'),
                    ];
                })->values();
            })
            ->toArray();

        $activityLabels = [];
        $activityDates = [];
        $newBlogsData = [];
        $newUsersData = [];

        for ($i = 0; $i < $days; $i++) {
            $date = $startDate->copy()->addDays($i);
            $key = $date->toDateString();

            $activityLabels[] = $date->format('d.m');
            $activityDates[] = $key;
            $newBlogsData[] = (int) ($newBlogsByDate[$key] ?? 0);
            $newUsersData[] = (int) ($newUsersByDate[$key] ?? 0);
        }

        return [
            'activityLabels' => $activityLabels,
            'activityDates' => $activityDates,
            'newBlogsData' => $newBlogsData,
            'newUsersData' => $newUsersData,
            'newBlogsItemsByDate' => $newBlogsItemsByDate,
            'newUsersItemsByDate' => $newUsersItemsByDate,
        ];
    }
}

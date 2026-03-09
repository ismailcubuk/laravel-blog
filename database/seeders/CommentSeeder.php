<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        if (!Post::query()->exists()) {
            return;
        }

        Comment::factory(60)->create();

        Post::query()
            ->take(8)
            ->get()
            ->each(function (Post $post, int $index) {
                Comment::factory()->create([
                    'post_id' => $post->id,
                    'user_id' => null,
                    'name' => 'Guest Reader ' . ($index + 1),
                    'email' => 'reader' . ($index + 1) . '@example.com',
                    'message' => 'This seeded comment was added for admin moderation and frontend visibility.',
                    'status' => 'approved',
                ]);
            });
    }
}

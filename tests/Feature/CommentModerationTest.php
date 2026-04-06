<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentModerationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_comment_is_created_as_pending(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        $category = Category::factory()->create();

        $post = Post::factory()->create([
            'category_id' => $category->id,
            'user_id' => $admin->id,
        ]);

        $response = $this->actingAs($user)
            ->post(route('post.comments.store', $post->slug), [
                'message' => 'This is a new comment for moderation',
            ]);

        $response->assertRedirect(route('post.show', $post->slug) . '#comment-form');

        $this->assertDatabaseHas('comments', [
            'post_id' => $post->id,
            'user_id' => $user->id,
            'status' => 'pending',
        ]);
    }
}

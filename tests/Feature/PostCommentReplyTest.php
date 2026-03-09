<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostCommentReplyTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_sees_reply_form_and_not_public_comment_form(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'category_id' => $category->id,
            'user_id' => $admin->id,
        ]);

        Comment::query()->create([
            'post_id' => $post->id,
            'name' => 'Reader',
            'email' => 'reader@example.com',
            'message' => 'Pending comment for admin reply.',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->get(route('post.show', $post->slug));

        $response->assertOk();
        $response->assertSee('Write admin reply');
        $response->assertDontSee('Leave a Comment');
        $response->assertSee('Pending');
    }

    public function test_admin_can_reply_to_comment(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'category_id' => $category->id,
            'user_id' => $admin->id,
        ]);

        $comment = Comment::query()->create([
            'post_id' => $post->id,
            'name' => 'Reader',
            'email' => 'reader@example.com',
            'message' => 'Can admin answer this?',
            'status' => 'approved',
        ]);

        $response = $this->actingAs($admin)->post(route('post.comments.reply', [$post->slug, $comment]), [
            'reply_message' => 'Yes, this is the admin reply.',
        ]);

        $response->assertRedirect(route('post.show', $post->slug) . '#comments');

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'reply_message' => 'Yes, this is the admin reply.',
            'replied_by_user_id' => $admin->id,
        ]);
    }
}

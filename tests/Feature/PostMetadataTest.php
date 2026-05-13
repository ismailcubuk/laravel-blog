<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostMetadataTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_detail_uses_seo_metadata_and_related_tags(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();
        $tag = Tag::query()->create(['name' => 'Laravel', 'slug' => 'laravel']);
        $post = Post::factory()->create([
            'category_id' => $category->id,
            'user_id' => $admin->id,
            'title' => 'Normal title',
            'meta_title' => 'SEO title',
            'meta_description' => 'SEO description for this article.',
            'is_featured' => true,
            'featured_at' => now(),
        ]);
        $post->tags()->attach($tag);

        $response = $this->get(route('post.show', $post->slug));

        $response->assertOk();
        $response->assertSee('SEO title');
        $response->assertSee('SEO description for this article.');
        $response->assertSee(route('blog.tag', $tag));
        $this->assertTrue($post->fresh()->is_featured);
    }

    public function test_tag_and_author_landing_pages_render_published_posts(): void
    {
        $author = User::factory()->create(['role' => 'author', 'bio' => 'Kısa yazar biyografisi']);
        $category = Category::factory()->create();
        $tag = Tag::query()->create(['name' => 'PHP', 'slug' => 'php']);
        $post = Post::factory()->create([
            'category_id' => $category->id,
            'user_id' => $author->id,
            'title' => 'Etiketli yazı',
        ]);
        $post->tags()->attach($tag);

        $this->get(route('blog.tag', $tag))
            ->assertOk()
            ->assertSee('Etiketli yazı');

        $this->get(route('author.show', $author))
            ->assertOk()
            ->assertSee($author->name)
            ->assertSee('Etiketli yazı');
    }
}

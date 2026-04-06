<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPageSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_about_update_sanitizes_rich_html(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $payload = [
            'title' => 'About',
            'description' => '<script>alert(1)</script><p>Safe <strong>text</strong></p><a href="javascript:alert(2)" onclick="evil()">x</a>',
            'sections' => [
                [
                    'type' => 'full-width',
                    'columns' => [
                        [
                            'title' => 'Section',
                            'content' => '<img src=x onerror=alert(1)><p>Content</p>',
                        ],
                    ],
                ],
            ],
        ];

        $response = $this->actingAs($admin)->put(route('admin.pages.about.update'), $payload);
        $response->assertSessionHasNoErrors();

        $page = Page::query()->where('slug', 'about-us')->firstOrFail();

        $this->assertStringNotContainsString('<script', strtolower((string) $page->description));
        $this->assertStringNotContainsString('javascript:', strtolower((string) $page->description));
        $this->assertStringContainsString('<p>Safe', (string) $page->description);
    }

    public function test_contact_update_requires_valid_map_url(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->put(route('admin.pages.contact.update'), [
            'title' => 'Contact',
            'contact_phone' => '123',
            'contact_email' => 'hello@example.com',
            'contact_address' => 'Address',
            'contact_map_src' => 'not-a-url',
        ]);

        $response->assertSessionHasErrors('contact_map_src');
    }
}

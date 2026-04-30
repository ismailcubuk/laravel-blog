<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactMessageAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_submission_is_saved_for_admin_review(): void
    {
        Mail::fake();

        $response = $this->post(route('contact.submit'), [
            'name' => 'Test Visitor',
            'email' => 'visitor@example.com',
            'subject' => 'Project question',
            'message' => 'Can you help with a Laravel project?',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Test Visitor',
            'email' => 'visitor@example.com',
            'subject' => 'Project question',
            'message' => 'Can you help with a Laravel project?',
        ]);
    }

    public function test_admin_can_see_contact_messages(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->post(route('contact.submit'), [
            'name' => 'Panel Visitor',
            'email' => 'panel@example.com',
            'subject' => 'Admin visible message',
            'message' => 'This message should appear in the admin panel.',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.content.contact-messages.index'));

        $response->assertOk();
        $response->assertSee('Panel Visitor');
        $response->assertSee('Admin visible message');
        $response->assertSee('This message should appear in the admin panel.');
    }
}

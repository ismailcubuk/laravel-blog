<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_mail_password_is_stored_encrypted(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->put(route('admin.settings.mail.update'), [
            'mail_username' => 'mailer@example.com',
            'mail_password' => 'SuperSecret123',
            'mail_from_address' => 'mailer@example.com',
        ]);

        $response->assertSessionHasNoErrors();

        $storedPassword = Setting::query()->where('key', 'mail_password')->value('value');

        $this->assertNotNull($storedPassword);
        $this->assertStringStartsWith('enc:', (string) $storedPassword);
        $this->assertSame('SuperSecret123', Setting::maybeDecrypt($storedPassword));
    }
}

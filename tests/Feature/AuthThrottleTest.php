<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthThrottleTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_auth_pages_render_successfully(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Log In');

        $this->get(route('password.request'))
            ->assertOk()
            ->assertSee('Send Reset Link');
    }

    public function test_login_is_rate_limited_after_six_attempts(): void
    {
        for ($i = 0; $i < 6; $i++) {
            $this->post(route('login.post'), [
                'email' => 'nobody@example.com',
                'password' => 'wrong-password',
            ]);
        }

        $response = $this->post(route('login.post'), [
            'email' => 'nobody@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(429);
    }
}

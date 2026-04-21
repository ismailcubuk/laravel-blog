<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $settings = Setting::allAsKeyValue();

        $defaultSettings = [
            'site_name' => 'My Website',
            'site_logo' => null,
            'site_favicon' => null,
            'site_tagline' => '',
            'footer_text' => 'Copyright 2026 My Website',
            'facebook_url' => '',
            'twitter_url' => '',
            'instagram_url' => '',
            'linkedin_url' => '',
            'mail_mailer' => env('MAIL_MAILER', 'smtp'),
            'mail_host' => env('MAIL_HOST', '127.0.0.1'),
            'mail_port' => (string) env('MAIL_PORT', 587),
            'mail_username' => env('MAIL_USERNAME'),
            'mail_password' => env('MAIL_PASSWORD'),
            'mail_encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'mail_from_address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
            'ui_theme' => 'orange',
            'ui_mode' => 'white',
            'brand_primary_color' => '#f48840',
            'brand_secondary_color' => '#fb9857',
        ];

        $settings = array_merge($defaultSettings, $settings);
        $settings['mail_password'] = Setting::maybeDecrypt($settings['mail_password']);

        config([
            'mail.default' => $settings['mail_mailer'] ?: env('MAIL_MAILER', 'smtp'),
            'mail.mailers.smtp.host' => $settings['mail_host'] ?: env('MAIL_HOST', '127.0.0.1'),
            'mail.mailers.smtp.port' => (int) ($settings['mail_port'] ?: env('MAIL_PORT', 587)),
            'mail.mailers.smtp.username' => $settings['mail_username'] ?: env('MAIL_USERNAME'),
            'mail.mailers.smtp.password' => $settings['mail_password'] ?: env('MAIL_PASSWORD'),
            'mail.mailers.smtp.encryption' => $settings['mail_encryption'] ?: env('MAIL_ENCRYPTION', 'tls'),
            'mail.from.address' => $settings['mail_from_address'] ?: env('MAIL_FROM_ADDRESS', 'hello@example.com'),
            'mail.from.name' => $settings['site_name'] ?: env('MAIL_FROM_NAME', 'My Website'),
        ]);

        View::share('settings', $settings);
    }
}

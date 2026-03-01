<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // DB’den ayarları çek
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        // Default değerler
        $defaultSettings = [
            'site_name'     => 'My Website',
            'site_logo'     => null,
            'site_favicon'  => null,
            'site_tagline'  => '',
            'footer_text'   => '© 2026 My Website',
            'facebook_url'  => '#',
            'twitter_url'   => '#',
            'instagram_url' => '#',
            'linkedin_url'  => '#',
        ];

        // Merge DB ve default
        $settings = array_merge($defaultSettings, $settings);

        // Tüm view’lara gönder
        View::share('settings', $settings);
    }
}
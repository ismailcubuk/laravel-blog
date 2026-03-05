<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    // Admin General Settings sayfasÄ±nÄ± gÃ¶ster
    public function general()
    {
        // Default deÄŸerler
        $defaultSettings = [
            'site_name'     => 'My Website',
            'site_logo'     => null,
            'site_favicon'  => null,
            'site_tagline'  => '',
            'footer_text'   => '',
            'facebook_url'  => '',
            'twitter_url'   => '',
            'instagram_url' => '',
            'linkedin_url'  => '',
        ];

        // VeritabanÄ±ndaki mevcut ayarlarÄ± al
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        // Default ile birleÅŸtir
        $settings = array_merge($defaultSettings, $settings);

        return view('admin.settings.general', compact('settings'));
    }

    // Form submit iÅŸlemi
    public function update(Request $request)
    {
        $fields = [
            'site_name', 'site_logo', 'site_favicon', 'site_tagline',
            'footer_text', 'facebook_url', 'twitter_url', 'instagram_url', 'linkedin_url'
        ];

        foreach ($fields as $field) {
            $value = $request->input($field);

            // Dosya varsa kaydet
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $path = $file->store('uploads', 'public');
                $value = 'storage/' . $path;
            }

            Setting::updateOrCreate(
                ['key' => $field],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}

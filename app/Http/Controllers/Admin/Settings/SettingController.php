<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function general()
    {
        $defaultSettings = [
            'site_name' => 'My Website',
            'site_logo' => null,
            'site_favicon' => null,
            'site_tagline' => '',
            'footer_text' => '',
            'ui_theme' => 'orange',
            'ui_mode' => 'white',
        ];

        $settings = Setting::allAsKeyValue();
        $settings = array_merge($defaultSettings, $settings);

        return view('admin.settings.general', compact('settings'));
    }

    public function social()
    {
        $defaultSettings = [
            'facebook_url' => '',
            'twitter_url' => '',
            'instagram_url' => '',
            'linkedin_url' => '',
        ];

        $settings = Setting::allAsKeyValue();
        $settings = array_merge($defaultSettings, $settings);

        return view('admin.settings.social', compact('settings'));
    }

    public function mail()
    {
        $defaultSettings = [
            'mail_username' => '',
            'mail_password' => '',
            'mail_from_address' => 'hello@example.com',
        ];

        $settings = Setting::allAsKeyValue();
        $settings['mail_password'] = Setting::maybeDecrypt($settings['mail_password'] ?? null);
        $settings = array_merge($defaultSettings, $settings);

        return view('admin.settings.mail', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => ['nullable', 'string', 'max:255'],
            'site_logo' => ['nullable', 'image', 'max:2048'],
            'site_favicon' => ['nullable', 'file', 'mimes:ico,png,jpg,jpeg,svg', 'max:1024'],
            'site_tagline' => ['nullable', 'string', 'max:255'],
            'footer_text' => ['nullable', 'string', 'max:255'],
            'ui_theme' => ['required', 'in:orange,blue,emerald,rose,violet'],
            'ui_mode' => ['required', 'in:white,dark'],
        ]);

        $fields = [
            'site_name',
            'site_logo',
            'site_favicon',
            'site_tagline',
            'footer_text',
            'ui_theme',
            'ui_mode',
        ];

        $currentSettings = Setting::allAsKeyValue();

        foreach ($fields as $field) {
            $value = $validated[$field] ?? null;

            if ($request->hasFile($field)) {
                if (in_array($field, ['site_logo', 'site_favicon'], true)) {
                    $this->deleteStorageAsset($currentSettings[$field] ?? null);
                }

                $path = $request->file($field)->store('uploads', 'public');
                $value = 'storage/' . $path;
            } elseif (in_array($field, ['site_logo', 'site_favicon'], true) && $value === null) {
                continue;
            }

            Setting::updateOrCreate(
                ['key' => $field],
                ['value' => $value]
            );
        }

        Setting::clearCache();

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }

    public function updateSocial(Request $request)
    {
        $validated = $request->validate([
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'twitter_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
        ]);

        $fields = [
            'facebook_url',
            'twitter_url',
            'instagram_url',
            'linkedin_url',
        ];

        foreach ($fields as $field) {
            Setting::updateOrCreate(
                ['key' => $field],
                ['value' => $validated[$field] ?? null]
            );
        }

        Setting::clearCache();

        return redirect()->back()->with('success', 'Social settings updated successfully!');
    }

    public function updateMail(Request $request)
    {
        $validated = $request->validate([
            'mail_username' => ['required', 'string', 'max:255'],
            'mail_password' => ['nullable', 'string', 'max:255'],
            'mail_from_address' => ['required', 'email', 'max:255'],
        ]);

        $fields = [
            'mail_username',
            'mail_password',
            'mail_from_address',
        ];

        Setting::updateOrCreate(['key' => 'mail_mailer'], ['value' => 'smtp']);
        Setting::updateOrCreate(['key' => 'mail_encryption'], ['value' => 'tls']);
        Setting::updateOrCreate(['key' => 'mail_host'], ['value' => 'smtp.gmail.com']);
        Setting::updateOrCreate(['key' => 'mail_port'], ['value' => '587']);

        foreach ($fields as $field) {
            if ($field === 'mail_password' && empty($validated[$field])) {
                continue;
            }

            $value = $validated[$field] ?? null;
            if ($field === 'mail_password' && !empty($value)) {
                $value = Setting::maybeEncrypt($value);
            }

            Setting::updateOrCreate(
                ['key' => $field],
                ['value' => $value]
            );
        }

        Setting::clearCache();

        return redirect()->back()->with('success', 'Mail settings updated successfully!');
    }

    private function deleteStorageAsset(?string $assetPath): void
    {
        if (!$assetPath || !str_starts_with($assetPath, 'storage/')) {
            return;
        }

        Storage::disk('public')->delete(substr($assetPath, 8));
    }
}

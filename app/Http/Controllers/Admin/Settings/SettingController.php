<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

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
            'brand_primary_color' => '#f48840',
            'brand_secondary_color' => '#fb9857',
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
            'brand_primary_color' => ['nullable', 'regex:/^#(?:[0-9a-fA-F]{3}){1,2}$/'],
            'brand_secondary_color' => ['nullable', 'regex:/^#(?:[0-9a-fA-F]{3}){1,2}$/'],
        ]);

        $fields = [
            'site_name',
            'site_logo',
            'site_favicon',
            'site_tagline',
            'footer_text',
            'ui_theme',
            'ui_mode',
            'brand_primary_color',
            'brand_secondary_color',
        ];

        $currentSettings = Setting::allAsKeyValue();

        foreach ($fields as $field) {
            $value = $validated[$field] ?? null;

            if ($request->hasFile($field)) {
                if (in_array($field, ['site_logo', 'site_favicon'], true)) {
                    $this->deleteStorageAsset($currentSettings[$field] ?? null);
                }

                $value = $this->storePublicUpload($request->file($field));
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
            'facebook_url' => ['nullable', 'string', 'max:255'],
            'twitter_url' => ['nullable', 'string', 'max:255'],
            'instagram_url' => ['nullable', 'string', 'max:255'],
            'linkedin_url' => ['nullable', 'string', 'max:255'],
        ]);

        $fields = [
            'facebook_url',
            'twitter_url',
            'instagram_url',
            'linkedin_url',
        ];

        foreach ($fields as $field) {
            $value = $this->normalizeSocialUrl($field, $validated[$field] ?? null);

            Setting::updateOrCreate(
                ['key' => $field],
                ['value' => $value]
            );
        }

        Setting::clearCache();

        return redirect()->back()->with('success', 'Social settings updated successfully!');
    }

    private function normalizeSocialUrl(string $field, ?string $value): ?string
    {
        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }

        if (preg_match('/^https?:\/\//i', $value)) {
            return $value;
        }

        $value = preg_replace('/^@+/', '', $value);
        $value = trim((string) $value, "/ \t\n\r\0\x0B");

        if ($value === '') {
            return null;
        }

        if (str_contains($value, '.')) {
            return 'https://' . $value;
        }

        return match ($field) {
            'facebook_url' => 'https://facebook.com/' . $value,
            'twitter_url' => 'https://x.com/' . $value,
            'instagram_url' => 'https://instagram.com/' . $value,
            'linkedin_url' => 'https://linkedin.com/in/' . $value,
            default => $value,
        };
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

        $relativePath = ltrim(substr($assetPath, 8), '/');
        if ($relativePath === '' || str_contains($relativePath, '..')) {
            return;
        }

        $candidates = [
            base_path('../storage/' . $relativePath),
            public_path('storage/' . $relativePath),
            storage_path('app/public/' . $relativePath),
        ];

        foreach ($candidates as $candidate) {
            if (is_file($candidate)) {
                @unlink($candidate);
            }
        }
    }

    private function storePublicUpload(\Illuminate\Http\UploadedFile $file): string
    {
        $filename = $file->hashName();
        $destination = $this->resolveUploadDestination();

        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $file->move($destination, $filename);

        return 'storage/uploads/' . $filename;
    }

    private function resolveUploadDestination(): string
    {
        $preferred = base_path('../storage/uploads');
        $fallback = public_path('storage/uploads');

        return is_dir(dirname($preferred)) ? $preferred : $fallback;
    }
}

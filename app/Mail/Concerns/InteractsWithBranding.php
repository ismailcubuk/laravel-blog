<?php

namespace App\Mail\Concerns;

use App\Models\Setting;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;

trait InteractsWithBranding
{
    protected ?string $brandLogoAbsolutePath = null;
    protected ?string $brandIconAbsolutePath = null;

    /** @return array{brandLogoSrc:?string,brandIconSrc:?string,siteName:string} */
    protected function brandingViewData(): array
    {
        $siteName = Setting::get('site_name', config('app.name', 'My Website'));

        $logoPath = Setting::get('site_logo', 'default-logo.png');
        $faviconPath = Setting::get('site_favicon');

        $this->brandLogoAbsolutePath = $this->resolvePublicOrStoragePath($logoPath);

        $faviconExt = $faviconPath ? strtolower(pathinfo((string) $faviconPath, PATHINFO_EXTENSION)) : null;
        $faviconAllowed = in_array($faviconExt, ['png', 'jpg', 'jpeg', 'webp', 'gif', 'svg'], true);

        $this->brandIconAbsolutePath = $faviconAllowed
            ? $this->resolvePublicOrStoragePath($faviconPath)
            : null;

        if (!$this->brandIconAbsolutePath) {
            $this->brandIconAbsolutePath = $this->brandLogoAbsolutePath;
        }

        return [
            'siteName' => $siteName,
            'brandLogoSrc' => $this->brandLogoAbsolutePath ? '__CID_LOGO__' : null,
            'brandIconSrc' => $this->brandIconAbsolutePath ? '__CID_ICON__' : null,
        ];
    }

    protected function injectBrandingCids(Email $message): void
    {
        $htmlBody = $message->getHtmlBody();
        $html = is_string($htmlBody) ? $htmlBody : '';

        if ($this->brandLogoAbsolutePath && is_file($this->brandLogoAbsolutePath)) {
            $logoPart = DataPart::fromPath($this->brandLogoAbsolutePath, 'brand-logo')->asInline();
            $message->addPart($logoPart);
            $logoCid = 'cid:' . $logoPart->getContentId();
            $html = str_replace('__CID_LOGO__', $logoCid, $html);
        }

        if ($this->brandIconAbsolutePath && is_file($this->brandIconAbsolutePath)) {
            $iconPart = DataPart::fromPath($this->brandIconAbsolutePath, 'brand-icon')->asInline();
            $message->addPart($iconPart);
            $iconCid = 'cid:' . $iconPart->getContentId();
            $html = str_replace('__CID_ICON__', $iconCid, $html);
        }

        $message->html($html);
    }

    protected function resolvePublicOrStoragePath(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return null;
        }

        $normalized = ltrim($path, '/');

        $publicCandidate = public_path($normalized);
        if (is_file($publicCandidate)) {
            return $publicCandidate;
        }

        if (str_starts_with($normalized, 'storage/')) {
            $storageRelative = substr($normalized, strlen('storage/'));
            $storageCandidate = storage_path('app/public/' . $storageRelative);
            if (is_file($storageCandidate)) {
                return $storageCandidate;
            }
        }

        return null;
    }
}

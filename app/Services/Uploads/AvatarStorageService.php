<?php

namespace App\Services\Uploads;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class AvatarStorageService
{
    public function store(UploadedFile $file, ?string $oldAvatarPath = null): string
    {
        $destination = $this->resolveDestination();

        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $this->delete($oldAvatarPath);

        $filename = $this->makeFilename($file);
        $file->move($destination, $filename);

        return '/uploads/profiles/' . $filename;
    }

    public function delete(?string $avatarPath): void
    {
        $avatarPath = (string) $avatarPath;

        if ($avatarPath === '' || !str_starts_with($avatarPath, '/uploads/profiles/')) {
            return;
        }

        $relative = ltrim($avatarPath, '/');

        foreach ($this->candidateBasePaths() as $basePath) {
            $candidate = rtrim($basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $relative;

            if (is_file($candidate)) {
                @unlink($candidate);
            }
        }
    }

    private function resolveDestination(): string
    {
        foreach ($this->candidateBasePaths() as $basePath) {
            $destination = rtrim($basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'profiles';

            if (is_dir($destination) && is_writable($destination)) {
                return $destination;
            }

            $parent = dirname($destination);
            if ((is_dir($parent) && is_writable($parent)) || (is_dir(dirname($parent)) && is_writable(dirname($parent)))) {
                return $destination;
            }
        }

        return public_path('uploads/profiles');
    }

    /**
     * Shared hosts may serve Laravel from htdocs/public_html while the app base path
     * lives one level deeper. Prefer the real web root when PHP exposes it.
     */
    private function candidateBasePaths(): array
    {
        $paths = [
            env('AVATAR_UPLOAD_ROOT'),
            $_SERVER['DOCUMENT_ROOT'] ?? null,
            public_path(),
            base_path('../'),
        ];

        return array_values(array_unique(array_filter(array_map(
            static fn ($path) => $path ? rtrim(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, (string) $path), DIRECTORY_SEPARATOR) : null,
            $paths
        ))));
    }

    private function makeFilename(UploadedFile $file): string
    {
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'jpg');
        $safeName = Str::slug($name) ?: 'avatar';

        return time() . '_' . Str::random(8) . '_' . $safeName . '.' . $extension;
    }
}

<?php

use Illuminate\Support\Facades\Route;

require __DIR__ . '/frontend.php';
require __DIR__ . '/admin.php';

// Shared hosting fallback for /uploads files.
Route::get('/uploads/{path}', function (string $path) {
    $relativePath = ltrim(str_replace('\\', '/', $path), '/');

    if ($relativePath === '' || str_contains($relativePath, '../')) {
        abort(404);
    }

    $publicUploadsRoot = realpath(public_path('uploads'));
    $legacyHtdocsUploadsRoot = realpath(base_path('../uploads'));

    $candidates = [
        public_path('uploads/' . $relativePath),
        base_path('../uploads/' . $relativePath),
    ];

    foreach ($candidates as $candidate) {
        if (!is_file($candidate)) {
            continue;
        }

        $realCandidate = realpath($candidate);
        if ($realCandidate === false) {
            continue;
        }

        $allowedRoots = array_filter([
            $publicUploadsRoot,
            $legacyHtdocsUploadsRoot,
        ]);

        foreach ($allowedRoots as $root) {
            if ($realCandidate === $root || str_starts_with($realCandidate, $root . DIRECTORY_SEPARATOR)) {
                return response()->file($realCandidate);
            }
        }
    }

    abort(404);
})->where('path', '.*');

// Shared hosting fallback for /storage files when symlink/static mapping is unavailable.
Route::get('/storage/{path}', function (string $path) {
    $relativePath = ltrim(str_replace('\\', '/', $path), '/');

    if ($relativePath === '' || str_contains($relativePath, '../')) {
        abort(404);
    }

    $publicStorageRoot = realpath(public_path('storage'));
    $appStorageRoot = realpath(storage_path('app/public'));
    $legacyHtdocsStorageRoot = realpath(base_path('../storage'));
    $legacyHtdocsPublicStorageRoot = realpath(base_path('../public/storage'));

    $candidates = [
        public_path('storage/' . $relativePath),
        storage_path('app/public/' . $relativePath),
        base_path('../storage/' . $relativePath),
        base_path('../public/storage/' . $relativePath),
    ];

    foreach ($candidates as $candidate) {
        if (!is_file($candidate)) {
            continue;
        }

        $realCandidate = realpath($candidate);
        if ($realCandidate === false) {
            continue;
        }

        $allowedRoots = array_filter([
            $publicStorageRoot,
            $appStorageRoot,
            $legacyHtdocsStorageRoot,
            $legacyHtdocsPublicStorageRoot,
        ]);
        foreach ($allowedRoots as $root) {
            if ($realCandidate === $root || str_starts_with($realCandidate, $root . DIRECTORY_SEPARATOR)) {
                return response()->file($realCandidate);
            }
        }
    }

    abort(404);
})->where('path', '.*');

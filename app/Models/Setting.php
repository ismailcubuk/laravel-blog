<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public const CACHE_KEY = 'settings.key_value_map';

    public static function allAsKeyValue(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function (): array {
            return self::query()->pluck('value', 'key')->toArray();
        });
    }

    public static function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    public static function get($key, $default = null)
    {
        $settings = self::allAsKeyValue();

        return $settings[$key] ?? $default;
    }

    public static function maybeEncrypt(string $value): string
    {
        return 'enc:' . Crypt::encryptString($value);
    }

    public static function maybeDecrypt(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return $value;
        }

        if (!Str::startsWith($value, 'enc:')) {
            return $value;
        }

        try {
            return Crypt::decryptString(Str::after($value, 'enc:'));
        } catch (\Throwable) {
            return null;
        }
    }
}

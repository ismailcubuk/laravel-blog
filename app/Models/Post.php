<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'category_id',
        'user_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getImageUrlAttribute(): string
    {
        $rawImage = trim((string) $this->image);
        $fallback = 'https://picsum.photos/seed/' . $this->id . '/200/300';

        if ($rawImage === '') {
            return $fallback;
        }

        if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $rawImage, $matches)) {
            $rawImage = $matches[1];
        }

        if (Str::startsWith($rawImage, ['http://', 'https://', '//', 'data:'])) {
            // Prevent loading arbitrary third-party/data URLs in public listing pages.
            if (Str::startsWith($rawImage, 'data:')) {
                return $fallback;
            }

            $appBaseUrl = config('app.url', URL::to('/'));
            $appScheme = parse_url($appBaseUrl, PHP_URL_SCHEME) ?: 'https';
            $candidateUrl = Str::startsWith($rawImage, '//')
                ? $appScheme . ':' . $rawImage
                : $rawImage;

            $candidateHost = parse_url($candidateUrl, PHP_URL_HOST);
            $appHost = parse_url($appBaseUrl, PHP_URL_HOST);

            if (!is_string($candidateHost) || !is_string($appHost)) {
                return $fallback;
            }

            return strcasecmp($candidateHost, $appHost) === 0 ? $candidateUrl : $fallback;
        }

        return asset(ltrim($rawImage, '/'));
    }
}

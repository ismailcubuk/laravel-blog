<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'canonical_url',
        'og_image',
        'image',
        'category_id',
        'user_id',
        'status',
        'is_featured',
        'featured_at',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'featured_at' => 'datetime',
        ];
    }

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

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public static function tagsTableExists(): bool
    {
        static $exists = null;

        if ($exists !== null) {
            return $exists;
        }

        try {
            return $exists = Schema::hasTable('tags') && Schema::hasTable('post_tag');
        } catch (\Throwable) {
            return $exists = false;
        }
    }

    public static function featuredColumnsExist(): bool
    {
        static $exists = null;

        if ($exists !== null) {
            return $exists;
        }

        try {
            return $exists = Schema::hasColumn('posts', 'is_featured') && Schema::hasColumn('posts', 'featured_at');
        } catch (\Throwable) {
            return $exists = false;
        }
    }

    public static function seoColumnsExist(): bool
    {
        static $exists = null;

        if ($exists !== null) {
            return $exists;
        }

        try {
            return $exists = Schema::hasColumn('posts', 'meta_title')
                && Schema::hasColumn('posts', 'meta_description')
                && Schema::hasColumn('posts', 'canonical_url')
                && Schema::hasColumn('posts', 'og_image');
        } catch (\Throwable) {
            return $exists = false;
        }
    }

    public function scopeWithAvailableRelations($query, array $relations)
    {
        if (!self::tagsTableExists()) {
            $relations = array_values(array_filter($relations, fn ($relation) => $relation !== 'tags'));
        }

        return $relations === [] ? $query : $query->with($relations);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function getImageUrlAttribute(): string
    {
        $rawImage = trim((string) $this->image);
        $fallback = asset('assets/images/default-post.jpg');

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

    public function getExcerptAttribute(): string
    {
        return Str::limit(trim(strip_tags((string) $this->content)), 170);
    }

    public function getSeoTitleAttribute(): string
    {
        return trim((string) $this->meta_title) ?: $this->title;
    }

    public function getSeoDescriptionAttribute(): string
    {
        return trim((string) $this->meta_description) ?: Str::limit(strip_tags((string) $this->content), 155);
    }

    public function getSeoImageUrlAttribute(): string
    {
        $image = trim((string) $this->og_image);

        if ($image === '') {
            return $this->image_url;
        }

        return Str::startsWith($image, ['http://', 'https://']) ? $image : asset(ltrim($image, '/'));
    }

    public function getReadingTimeAttribute(): int
    {
        $wordCount = str_word_count(strip_tags((string) $this->content));

        return max(1, (int) ceil($wordCount / 200));
    }
}

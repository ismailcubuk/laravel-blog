<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Str;

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

        if ($rawImage === '') {
            return 'https://picsum.photos/seed/' . $this->id . '/200/300';
        }

        if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $rawImage, $matches)) {
            $rawImage = $matches[1];
        }

        if (Str::startsWith($rawImage, ['http://', 'https://', '//', 'data:'])) {
            return $rawImage;
        }

        return asset(ltrim($rawImage, '/'));
    }
}

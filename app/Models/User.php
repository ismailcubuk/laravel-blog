<?php

namespace App\Models;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'bio',
        'avatar_path',
        'ui_mode',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url',
        'github_url',
        'website_url',
        'email_verified_at',
        'last_login_at',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function socialLinks(): array
    {
        return array_values(array_filter([
            ['label' => 'Facebook', 'url' => $this->facebook_url, 'icon' => 'facebook'],
            ['label' => 'X', 'url' => $this->twitter_url, 'icon' => 'twitter'],
            ['label' => 'Instagram', 'url' => $this->instagram_url, 'icon' => 'instagram'],
            ['label' => 'LinkedIn', 'url' => $this->linkedin_url, 'icon' => 'linkedin'],
            ['label' => 'GitHub', 'url' => $this->github_url, 'icon' => 'github'],
            ['label' => 'Website', 'url' => $this->website_url, 'icon' => 'globe'],
        ], fn ($item) => filled($item['url'])));
    }
}

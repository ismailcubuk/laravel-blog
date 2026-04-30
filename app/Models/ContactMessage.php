<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'user_id',
        'subject',
        'message',
        'reply_message',
        'replied_by_user_id',
        'replied_at',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'replied_at' => 'datetime',
            'read_at' => 'datetime',
        ];
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function repliedBy()
    {
        return $this->belongsTo(User::class, 'replied_by_user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(ContactMessageReply::class)->latest();
    }
}

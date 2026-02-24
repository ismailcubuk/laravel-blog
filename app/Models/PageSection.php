<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PageSection extends Model
{

protected $fillable =
[
'page_id',
'section_type',
'section_order',
'column_index',
'title',
'content',
'uuid'
];

protected static function boot()
{
    parent::boot();

    static::creating(function ($model)
    {
        if(empty($model->uuid))
        {
            $model->uuid = Str::uuid();
        }
    });
}
}
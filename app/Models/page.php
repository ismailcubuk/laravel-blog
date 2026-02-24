<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PageSection;
class Page extends Model
{

protected $fillable =
[
'slug',
'title',
'description',
'hero_image',

'contact_phone',
'contact_email',
'contact_address',
'contact_map_src'
];

public function sections()
{
return $this->hasMany(PageSection::class);
}

}
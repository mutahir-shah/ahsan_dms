<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'is_featured',
        'image'
    ];

    public function translations()
    {
        return $this->hasMany(BlogTranslation::class);
    }
}

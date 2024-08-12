<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogTranslation extends Model
{
    protected $fillable = [
        'blog_id', 'language_id', 'title', 'description'
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}

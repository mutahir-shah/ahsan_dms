<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CMS extends Model
{
    protected $table = 'cms';
    protected $fillable = [
        'language_id',
        'site_title',
        'site_sub_title',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'introduction_text',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $guarded = ['id', '_token', '_method'];

    public function keywords()
    {
        return $this->belongsToMany(Keyword::class, 'language_keyword', 'language_id', 'keyword_id')
            ->withPivot('translation');
    }

    public function cms()
    {
        return $this->hasMany(CMS::class, 'language_id');
    }

    public function contactSettings()
    {
        return $this->hasMany(ContactSetting::class, 'Language_id', 'id');
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'language_id');
    }
}

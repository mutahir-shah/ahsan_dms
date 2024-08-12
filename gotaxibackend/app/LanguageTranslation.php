<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LanguageTranslation extends Model
{

    protected $fillable = ['language_id', 'name', 'description', 'question', 'answer'];

    public function translationable()
    {
        return $this->morphTo();
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}

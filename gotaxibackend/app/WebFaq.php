<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebFaq extends Model
{
    protected $fillable = [
        'language_id',
        'question',
        'answer',
        'question_index'
    ];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function translations()
    {
        return $this->hasMany(WebFaq::class, 'parent_id', 'id');
    }
}

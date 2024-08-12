<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Onboarding extends Model
{
    protected $guarded = ['id', '_token', '_method'];

    // public function translations()
    // {
    //     return $this->hasMany(Onboarding::class, 'parent_id', 'id');
    // }

    public function translations()
    {
        return $this->morphMany(LanguageTranslation::class, 'translationable');
    }
}

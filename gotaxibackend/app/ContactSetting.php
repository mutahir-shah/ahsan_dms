<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{

    protected $fillable = ['language_id', 'contact_city', 'contact_address'];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }
}

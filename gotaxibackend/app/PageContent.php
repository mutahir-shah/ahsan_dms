<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    protected $fillable = [
        'language_id',
        'privacy_content',
        'terms_content',
        'driver_content',
        'about_content',
    ];
}

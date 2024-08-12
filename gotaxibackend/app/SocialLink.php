<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    protected $fillable = ['facebook', 'instagram', 'linkedin', 'twitter', 'youtube'];
}

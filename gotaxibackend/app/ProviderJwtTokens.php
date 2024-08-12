<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProviderJwtTokens extends Model
{
    protected $fillable = ['provider_id', 'token'];
}

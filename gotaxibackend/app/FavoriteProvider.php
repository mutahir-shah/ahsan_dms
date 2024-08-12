<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FavoriteProvider extends Model
{
    protected $fillable = [
        'user_id',
        'provider_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function provider()
    {
        return $this->belongsTo('App\Provider')->with(['service']);
    }

    public $timestamps = false;
}

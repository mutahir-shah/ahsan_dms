<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestOffer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'request_id', 'provider_id', 'offer_price', 'is_accepted', 'is_skipped', 'is_declined'
    ];

    /**
     * Provider Model Linked
     */
    public function provider()
    {
        return $this->belongsTo('App\Provider', 'provider_id');
    }

    public function getRequestIdAttribute($value)
    {
        return (float)$value;
    }
}

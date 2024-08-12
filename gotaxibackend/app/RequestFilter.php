<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestFilter extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'request_id', 'provider_id', 'status', 'service_id', 'is_cancelled'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    /**
     * The services that belong to the user.
     */
    public function request()
    {
        return $this->belongsTo('App\UserRequests')->with('service_type');
    }

    public function getProviderIdAttribute($value)
    {
        return (float)$value;
    }

    public function getRequestIdAttribute($value)
    {
        return (float)$value;
    }

    public function getStatusAttribute($value)
    {
        return (float)$value;
    }
}

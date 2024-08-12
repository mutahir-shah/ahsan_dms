<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use SoftDeletes;

    protected $table = "states";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'iso2', 'details', 'country_id'
    ];

    protected $dates = ['deleted_at'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function country()
    {
        return $this->belongsTo('App\Country', 'country_id');
    }
    
    public function city()
    {
        return $this->hasMany('App\City', 'state_id');
    }
}

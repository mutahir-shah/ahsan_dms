<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;

    protected $table = "countries";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'iso2', 'details'
    ];

    protected $dates = ['deleted_at'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function states()
    {
        return $this->hasMany('App\State', 'country_id', 'id')->with('city');
    }
}

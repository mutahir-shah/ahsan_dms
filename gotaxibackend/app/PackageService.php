<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageService extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service_type_id',
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];


    public function package()
    {
        return $this->belongsTo('App\Package');
    }

    public function service_type()
    {
        return $this->belongsTo('App\ServiceType');
    }
}

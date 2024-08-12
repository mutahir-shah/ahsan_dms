<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name',
        'base_time',
        'base_distance',
        'base_price',
        'after_time_price',
        'after_distance_price'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppLinks extends Model
{
    protected $fillable = [
        'f_u_url', 'f_p_url', 'user_store_link_ios', 'driver_store_link_ios',
    ];
}

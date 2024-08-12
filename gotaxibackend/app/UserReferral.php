<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReferral extends Model
{
    protected $table = 'user_referrals';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'reffered_id',
        'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];
}

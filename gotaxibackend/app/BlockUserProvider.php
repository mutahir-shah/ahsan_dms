<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlockUserProvider extends Model
{
    protected $table = 'block_users_providers';

    protected $fillable = [
        'user_id',
        'provider_id',
        'blocked_by',
        'block_reason'
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

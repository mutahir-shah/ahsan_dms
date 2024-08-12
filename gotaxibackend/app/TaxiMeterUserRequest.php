<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaxiMeterUserRequest extends Model
{
    protected $table = 'taximeter_user_requests';
    protected $fillable = [
        'id',
        'provider_id',
        'distance',
        'amount'
    ];

    // public $timestamps = ["created_at"];
    public $timestamps = false;
}

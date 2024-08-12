<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingRequest extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // 'booking_type',
        'name',
        'phone',
        'dname',
        'dphone',
        'sdestination',
        'edestination',
        'date',
        'car_type',
        'special_note', 'email', 'vehicle_model', 'vehicle_number'
    ];
}

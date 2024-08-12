<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZoneService extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'zone_services';

    protected $fillable = [
        'zone_id',
        'service_id',
        // 'zones',
        'name',
        'type',
        'image',
        'map_icon',
        'price',
        'fixed',
        'description',
        'status',
        'minute',
        'distance',
        'calculator',
        'capacity',
        'phourfrom',
        'phourto',
        'pextra',
        'locked_pricing',
        'apply_after_1',
        'apply_after_2',
        'apply_after_3',
        'apply_after_4',
        'after_1_price',
        'after_2_price',
        'after_3_price',
        'after_4_price',
        'peak_apply_after_1',
        'peak_apply_after_2',
        'peak_apply_after_3',
        'peak_apply_after_4',
        'peak_after_1_price',
        'peak_after_2_price',
        'peak_after_3_price',
        'peak_after_4_price',
        'peak_monday',
        'peak_tuesday',
        'peak_wednesday',
        'peak_thursday',
        'peak_friday',
        'peak_saturday',
        'peak_sunday',
        'is_free'
    ];

    // public $timestamps = false; 

    public function service()
    {
        return $this->belongsTo('App\ServiceType', 'service_id');
    }

    public function zone()
    {
        return $this->belongsTo('App\Zones', 'zone_id');
    }

    public function getCapacityAttribute($value)
    {
        return (string) $value;
    }

    public function getIsFreeAttribute($value)
    {
        return (boolean) $value;
    }
}

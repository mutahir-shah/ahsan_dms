<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZoneCharge extends Model
{
    protected $fillable = [ 'name', 'zone_id', 'type', 'charge_type', 'charge_value', 'created_by',
    'updated_by',
    'deleted_by' ];

    public function zone() {
        return $this->belongsTo(Zones::class);
    }
}

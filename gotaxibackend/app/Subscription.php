<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'value', 'type', 'days', 'rides', 'stripe_price_id', 'trial_period',  'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function translations()
    {
        return $this->morphMany(LanguageTranslation::class, 'translationable');
    }
}

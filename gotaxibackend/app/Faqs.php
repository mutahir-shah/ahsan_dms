<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Faqs extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'question',
        'answer',
        'type',
        'created_by',
        'updated_by',
        'deleted_by',
        'language_id',
        'parent_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    /**
     * Scope a query to only include popular users.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeVehicle($query)
    {
        return $query->where('type', 'VEHICLE');
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeDriver($query)
    {
        return $query->where('type', 'DRIVER');
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeUser($query)
    {
        return $query->where('type', 'USER');
    }

    public function getIdAttribute($value)
    {
        return (string)$value;
    }

    /**
     * Get all of the translations for the FAQ.
     */
    public function translations()
    {
        return $this->hasMany(Faqs::class, 'parent_id', 'id');
    }
}

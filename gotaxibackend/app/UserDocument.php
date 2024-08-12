<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDocument extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'document_id',
        'expiry_date',
        'url',
        'unique_id',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    protected $casts = [
        'expiry_date' => 'date',
    ];

    /**
     * The services that belong to the user.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * The services that belong to the user.
     */
    public function document()
    {
        return $this->belongsTo('App\Document');
    }

}

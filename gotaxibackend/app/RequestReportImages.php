<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestReportImages extends Model
{

    protected $table = 'requests_report_images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image', 'type', 'request_id'
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
     * The services that belong to the user.
     */
    public function request()
    {
        return $this->belongsTo('App\UserRequests');
    }

    // public function getImageAttribute($value) {
    //     return asset('storage/reports/' .$value);
    // }
}

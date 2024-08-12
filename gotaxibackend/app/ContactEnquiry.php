<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactEnquiry extends Model
{
    protected $table = "contact_enquiries";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'subject',
        'content'
    ];
}

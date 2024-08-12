<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RejectedRequest extends Model
{
    protected $guarded = ['id', '_token', '_method'];
}

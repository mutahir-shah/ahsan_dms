<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CancellationReason extends Model
{
    protected $guarded = ['id', '_token', '_method'];

    public function translations()
    {
        return $this->hasMany(CancellationReason::class, 'parent_id', 'id');
    }
}

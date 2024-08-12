<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    protected $guarded = ['id', '_token', '_method'];

    /**
     * Get the module that owns the Privilege
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

}

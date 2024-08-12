<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $guarded = ['id', '_token', '_method'];

    /**
     * Get all of the operations for the Module
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function operations()
    {
        return $this->hasMany(Module::class, 'parent', 'id');
    }

}

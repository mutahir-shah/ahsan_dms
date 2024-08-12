<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = ['id', '_token', '_method'];

    /**
     * Get all of the priviliges for the Role
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function priviliges()
    {
        return $this->hasMany(Privilege::class);
    }

}

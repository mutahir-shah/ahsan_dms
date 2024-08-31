<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'icon', 'data_key', 'data_id', 'route', 'type', 'index', 'is_collapseable', 'parent_id'];

    /**
     * Get all of the modules for the Module
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function modules(): HasMany
    {
        return $this->hasMany(Module::class, 'parent_id', 'id')->orderBy('index', 'asc');
    }

}

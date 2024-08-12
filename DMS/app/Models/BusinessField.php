<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessField extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['business_id', 'name', 'type', 'required', 'admin_only'];
}

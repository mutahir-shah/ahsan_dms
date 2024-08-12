<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ServiceTypeMutatorsTrait;
class ServiceType extends Model
{
    use ServiceTypeMutatorsTrait;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var arraycalculator
     */
    protected $fillable = [
        'type', 
        'name', 
        'zones', 
        'provider_name', 
        'image', 
        'map_icon',
        'capacity', 
        'fixed', 
        'price', 
        
        // Apply after fields
        'apply_after_1', 
        'apply_after_2', 
        'apply_after_3', 
        'apply_after_4', 
        'after_1_price', 
        'after_2_price', 
        'after_3_price', 
        'after_4_price',
        'after_1_minute', 
        'after_2_minute', 
        'after_3_minute', 
        
        // Peak pricing fields
        'peak_percentage', 
        'peak_fixed_pricing', 
        'peak_apply_after_1', 
        'peak_apply_after_2', 
        'peak_apply_after_3', 
        'peak_apply_after_4', 
        'peak_after_1_price', 
        'peak_after_2_price', 
        'peak_after_3_price', 
        'peak_after_4_price',
        
        // Peak days fields
        'peak_monday', 
        'peak_tuesday', 
        'peak_wednesday', 
        'peak_thursday', 
        'peak_friday', 
        'peak_saturday', 
        'peak_sunday',
    
        // Pricing details
        'phourfrom', 
        'phourto', 
        'pextra', 
        'minute', 
        'distance', 
        'calculator', 
        'description', 
        'locked_pricing', 
        'status', 
        
        // Additional fields
        'booking_fee_type', 
        'booking_fee_amount', 
        'commission_type', 
        'commission_percentage', 
        'tax_percentage',
        'weight', 
        'is_free',
    
        // User tracking fields
        'created_by', 
        'updated_by', 
        'deleted_by',
        
        // Hour range fields
        'phourfromone', 
        'phourtoone', 
        'phourfromtwo', 
        'phourtotwo',
        
        // Peak values
        'peak1', 
        'peak2', 
        'peak3',
    
        // Timestamps
        'created_at', 
        'updated_at',
    ];
    

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    
    public function services()
    {
        return $this->hasMany('App\ProviderService')->with('service_type');
    }

    public function translations()
    {
        return $this->morphMany(LanguageTranslation::class, 'translationable');
    }
}

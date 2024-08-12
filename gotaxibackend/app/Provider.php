<?php

namespace App;

use anlutro\LaravelSettings\Facade as Setting;
use App\Notifications\ProviderResetPassword;
use DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Provider extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'mobile',
        'wallet',
        'address',
        'picture',
        'gender',
        'gender_pref',
        'latitude',
        'longitude',
        'status',
        'is_approved',
        'avatar',
        'social_unique_id',
        'fleet',
        'subscription_id',
        'is_verified',
        'routing_numb',
        'company_name',
        'company_address',
        'company_vat',
        'fleet_invoice',
        'language',
        'stripe_subscription_id',
        'rides_left',
        'trial_availed',
        'referral_code',
        'user_referral_count',
        'provider_referral_count',
        'is_subscribed',
        'zone_id',
        'dob',
        'address',
        'trial_end_time',
        'subscription_status',
        'tax_tps_info',
        'tax_tvq_info',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $appends = ['is_fav', 'is_block', 'block_reason', 'service_status', 'enabled_services', 'disabled_services'];

    public function getFullNameAttribute() {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getServiceStatusAttribute() 
    {
        $activeServiceCount = $this->service()->where('is_selected', 1)->where('is_approved', 1)->where('status', 'active')->count();
        $ridingServiceCount = $this->service()->where('is_selected', 1)->where('is_approved', 1)->where('status', 'riding')->count();

        if($activeServiceCount > 0) {
            $service_status = 'active';
        } else if($ridingServiceCount > 0) {
            $service_status = 'riding';
        } else {
            $service_status = 'offline';
        }
        
        return $service_status;
    }

    public function getEnabledServicesAttribute() 
    {
        $services = $this->service()->where('is_child', 0)->get();
        $serviceTypeNamesArray = [];

        foreach ($services as $service) {
            $service_id = $service->id;

            $serviceTypeIds = ProviderService::select('service_type_id')
                                ->where(function ($query) use ($service_id) {
                                    $query->where('parent_id', $service_id)
                                    ->orWhere(function ($query) use ($service_id) {
                                        $query
                                            ->whereNull('parent_id')
                                            ->where('id', $service_id);
                                    });
                                })
                                ->where('is_approved', 1)
                                // ->where('is_selected', 1)
                                ->pluck('service_type_id')
                                ->toArray();

            $serviceTypeNamesArray = ServiceType::whereIn('id', $serviceTypeIds)->pluck('name')->toArray();
            $enabled_services = implode(', ', $serviceTypeNamesArray);

            return (count($serviceTypeNamesArray) > 0) ? $enabled_services : 'N/A';
        }

        return "N/A";
    }

    public function getDisabledServicesAttribute() 
    {
        $services = $this->service()->where('is_child', 0)->get();
        $serviceTypeNamesArray = [];

        foreach ($services as $service) {
            $service_id = $service->id;

            $serviceTypeIds = ProviderService::select('service_type_id')
                    ->where(function ($query) use ($service_id) {
                        $query->where('parent_id', $service_id)
                        ->orWhere(function ($query) use ($service_id) {
                            $query
                                ->whereNull('parent_id')
                                ->where('id', $service_id);
                        });
                    })
                    ->where('is_approved', 0)
                    // ->where('is_selected', 1)
                    ->pluck('service_type_id')
                    ->toArray();

            $serviceTypeNamesArray = ServiceType::whereIn('id', $serviceTypeIds)->pluck('name')->toArray();
            $disabled_services = implode(', ', $serviceTypeNamesArray);

            return (count($serviceTypeNamesArray) > 0) ? $disabled_services : 'N/A';
        }

        return "N/A";
    }

    public function getIsFavAttribute() 
    {
        return (int) ($this->favorite()->where('user_id', auth()->id())->count() > 0);
    }

    public function favorite()
    {
        return $this->hasMany('App\FavoriteProvider');
    }

    public function getIsBlockAttribute() 
    {
        return (int) ($this->block_driver()->where('user_id', auth()->id())->count() > 0);
    }

    public function getBlockReasonAttribute() 
    {
        $block_reason = $this->block_driver()->where('user_id', auth()->id())->get(['block_reason'])->first();
        return $block_reason ? $block_reason->block_reason : null;
    }

    public function block_driver()
    {
        return $this->hasMany('App\BlockUserProvider')->where('blocked_by', 'USER');
    }

    /**
     * The services that belong to the user.
     */
    public function service()
    {
        return $this->hasMany('App\ProviderService')->with('service_type');

        //OLD Code
        // if (Setting::get('multi_vehicle_module', 0) == 1) {
        //     // return $this->hasMany('App\ProviderService')->where('is_selected', 1)->with('service_type');
        //     //TODO: to be fixed accross application
        //     return $this->hasOne('App\ProviderService')->where('is_selected', 1)->with('service_type');
        // } else {
        //     return $this->hasOne('App\ProviderService')->with('service_type');
        // }
        
    }

    /**
     * The services that belong to the user.
     */
    public function incoming_requests()
    {
        return $this->hasMany('App\RequestFilter')->where('status', 0);
    }

    /**
     * The services that belong to the user.
     */
    public function requests()
    {
        return $this->hasMany('App\RequestFilter');
    }

    /**
     * The services that belong to the provider.
     */
    public function zone()
    {
        return $this->belongsTo('App\Zones', 'zone_id', 'id');
    }

    /**
     * The services that belong to the user.
     */
    public function profile()
    {
        return $this->hasOne('App\ProviderProfile');
    }

    /**
     * The services that belong to the user.
     */
    public function device()
    {
        return $this->hasOne('App\ProviderDevice');
    }

    /**
     * The services that belong to the user.
     */
    public function trips()
    {
        return $this->hasMany('App\UserRequests');
    }

    /**
     * The services that belong to the fleet.
     */
    public function fleetData()
    {
        return $this->hasOne('App\Fleet', 'id', 'fleet');
    }

    /**
     * The services accepted by the provider
     */
    public function accepted()
    {
        return $this->hasMany('App\UserRequests', 'provider_id')
            ->where('status', '!=', 'CANCELLED');
    }

    /**
     * service cancelled by provider.
     */
    public function cancelled()
    {
        return $this->hasMany('App\UserRequests', 'provider_id')
            ->where('status', 'CANCELLED');
    }

    /**
     * The services that belong to the user.
     */
    public function documents()
    {
        return $this->hasMany('App\ProviderDocument');
    }

    /**
     * The services that belong to the user.
     */
    public function document($id)
    {
        return $this->hasOne('App\ProviderDocument')->where('document_id', $id)->first();
    }

    /**
     * The services that belong to the user.
     */
    public function pending_documents()
    {
        return $this->hasMany('App\ProviderDocument')->whereNull('vehicle_id')->where('status', 'ASSESSING')->count();
    }

    /**
     * The services that belong to the user.
     */
    public function documents_count()
    {
        return $this->hasMany('App\ProviderDocument')->whereNull('vehicle_id')->count();
    }

     /**
     * The services that belong to the user.
     */
    public function vehicle_pending_documents()
    {
        return $this->hasMany('App\ProviderDocument')->whereNotNull('vehicle_id')->where('status', 'ASSESSING')->count();
    }

    /**
     * The services that belong to the user.
     */
    public function vehicle_documents_count()
    {
        return $this->hasMany('App\ProviderDocument')->whereNotNull('vehicle_id')->count();
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ProviderResetPassword($token));
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The subscription that belong to the user.
     */
    public function subscription()
    {
        return $this->belongsTo('App\Subscription', 'subscription_id');
    }

    public function providerRating()
    {
        return $this->hasMany('App\UserRequestRating', 'provider_id', 'id');
    }

    public function getIdAttribute($value)
    {
        return (float)$value;
    }

    public function getFleetAttribute($value)
    {
        return (float)$value;
    }

    public function getLatitudeAttribute($value)
    {
        return (float)$value;
    }

    public function getLongitudeAttribute($value)
    {
        return (float)$value;
    }

    public function getOtpAttribute($value)
    {
        return (float)$value;
    }

    public function getUserReferralCountAttribute($value)
    {
        return (string)$value;
    }

    public function getProviderReferralCountAttribute($value)
    {
        return (string)$value;
    }

}

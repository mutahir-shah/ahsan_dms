<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 
        'last_name', 
        'gender', 
        'gender_pref', 
        'email',
        'mobile', 
        'picture', 
        'password', 
        'device_type',
        'device_token',
        'login_by',
        'payment_mode',
        'social_unique_id',
        'device_id',
        'wallet_balance',
        'reward_points',
        'is_verified',
        'vehicle_make',
        'vehicle_number',
        'language',
        'stripe_subscription_id',
        'subscription_id',
        'status',
        'rides_left',
        'trial_availed',
        'referral_code',
        'user_referral_count',
        'provider_referral_count',
        'is_subscribed',
        'dob',
        'address',
        'zone_id',
        'driver_job_code',
        'driver_name',
        'trial_end_time',
        'subscription_status',
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
        'password', 'remember_token', 'created_at'
    ];

    protected $appends = ['is_block', 'block_reason'];

    public function getFullNameAttribute() {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getIsBlockAttribute() 
    {
        return (int) ($this->block_user()->where('provider_id', auth()->id())->count() > 0);
    }

    public function getBlockReasonAttribute() 
    {
        $block_reason = $this->block_user()->where('provider_id', auth()->id())->get(['block_reason'])->first();
        return $block_reason ? $block_reason->block_reason : null;
    }

    public function block_user()
    {
        return $this->hasMany('App\BlockUserProvider')->where('blocked_by', 'PROVIDER');
    }

    /**
     * The services that belong to the user.
     */
    public function trips()
    {
        return $this->hasMany('App\UserRequests', 'user_id', 'id');
    }


    public function documents()
    {
        return $this->hasMany('App\UserDocument');
    }

    /**
     * The services that belong to the user.
     */
    public function document($id)
    {
        return $this->hasOne('App\UserDocument')->where('document_id', $id)->first();
    }

    /**
     * The services that belong to the user.
     */
    public function zone()
    {
        return $this->belongsTo('App\Zones', 'zone_id', 'id');
    }

    // public function setFirstNameAttribute($value){
    //     $this->attributes['first_name'] = utf8_encode($value);
    // }

    // public function setLastNameAttribute($value){
    //     $this->attributes['last_name'] = utf8_encode($value);
    // }

    public function getLatitudeAttribute($value)
    {
        return (float)$value;
    }

    public function getLongitudeAttribute($value)
    {
        return (float)$value;
    }

    public function getWalletBalanceAttribute($value)
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

    public function getDriverJobCodeAttribute($value)
    {
        return (string)$value;
    }

}

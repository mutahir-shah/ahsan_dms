<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRequestPayment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'request_id', 'peak_active', 'surge_active', 'commission_active', 'booking_fee_active', 'tax_active', 'peak_value', 'peak_type', 'surge_percentage', 'tax_percentage', 'request_category', 'promocode_id', 'payment_id', 'payment_mode', 'fixed', 'distance', 't_price', 'commision', 'commission_type', 'discount', 'tax', 'wallet', 'surge', 'booking_fee', 'total', 'created_at', 'updated_at', 'payable', 'provider_commission', 'provider_commission_paid', 'provider_pay', 'commission_source', 'company_commission', 'government_charges_active', 'government_charges', 'toll_fee_active', 'toll_fee', 'airport_charges_active', 'airport_charges', 'peak_price', 'commission_value', 'bank_charges', 'bank_charges_type', 'bank_charges_value', 'bank_charges_amount', 'card_details'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'status', 'password', 'remember_token', 'created_at', 'updated_at'
    ];

    /**
     * The services that belong to the user.
     */
    public function request()
    {
        return $this->belongsTo('App\UserRequests');
    }

    /**
     * The services that belong to the user.
     */
    public function provider()
    {
        return $this->belongsTo('App\Provider');
    }

    public function getRequestIdAttribute($value)
    {
        return (float)$value;
    }

    public function getFixedAttribute($value)
    {
        return (float)$value;
    }

    public function getDistanceAttribute($value)
    {
        return (float)$value;
    }

    public function getCommisionAttribute($value)
    {
        return (float)$value;
    }

    public function getDiscountAttribute($value)
    {
        return (float)$value;
    }

    public function getTaxAttribute($value)
    {
        return (float)$value;
    }

    public function getWalletAttribute($value)
    {
        return (float)$value;
    }

    public function getSurgeAttribute($value)
    {
        return (float)$value;
    }

    public function getTotalAttribute($value)
    {
        return (float)$value;
    }

    public function getTPriceAttribute($value)
    {
        return (float)$value;
    }

    public function getPayableAttribute($value)
    {
        return (float)$value;
    }

    public function getProviderCommissionAttribute($value)
    {
        return (float)$value;
    }

    public function getProviderCommissionPaidAttribute($value)
    {
        return (float)$value;
    }

    public function getProviderPayAttribute($value)
    {
        return (float)$value;
    }

    public function getBookingFeeAttribute($value)
    {
        return (float)$value;
    }
    

}

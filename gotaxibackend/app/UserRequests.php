<?php

namespace App;

use anlutro\LaravelSettings\Facade as Setting;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRequests extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'provider_id',
        'user_id',
        'current_provider_id',
        'service_type_id',
        'request_category',
        'status',
        'cancelled_by',
        'cancel_amount',
        'cancel_amount_driver',
        'cancel_payment_details',
        'cancellation_reason_id',
        'is_track',
        'travel_time',
        'distance',
        's_latitude',
        'd_latitude',
        's_longitude',
        'd_longitude',
        'track_distance',
        'track_latitude',
        'track_longitude',
        'paid',
        'cancel_reason',
        's_address',
        'd_address',
        'assigned_at',
        'arrived_at',
        'schedule_at',
        'started_at',
        'finished_at',
        'use_wallet',
        'user_rated',
        'provider_rated',
        'surge',
        'amount',
        'ride_amount',
        'driver_amount',
        'client_offer',
        'tip_amount',
        'tip_amount_driver',
        'commission_tip_amount',
        'only_pickup',
        'charge_id',
        'vweight',
        'vehicle_make',
        'vehicle_number',
        'set_dest_later',
        'specialNote',
        'dont_disturb_user',
        'gender_pref_run_time',
        'driver_job_code',
        'booking_fee',
        'is_free',
        'is_peak',
        'prebooking_card_details',
        'prebooking_amount',
        'return_amount',
        'return_ride_amount',
        'return_driver_amount',
        'is_return_trip'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'cancel_payment_details' => 'array',
        'invoice' => 'array',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'assigned_at',
        'schedule_at',
        'started_at',
        'finished_at',
    ];

    /**
     * ServiceType Model Linked
     */
    public function service_type()
    {
        return $this->belongsTo('App\ServiceType');
    }

    public function zone_charges()
    {
        return $this->belongsToMany('App\ZoneCharge');
    }

    // public function zone_charges_amount()
    // {
    //     return $this->belongsToMany('App\ZoneCharge')->sum('charge_amount');;
    // }

    /**
     * UserRequestPayment Model Linked
     */
    public function payment()
    {
        return $this->hasOne('App\UserRequestPayment', 'request_id')->latest();
    }
    

    /**
     * UserRequestRating Model Linked
     */
    public function rating()
    {
        return $this->hasOne('App\UserRequestRating', 'request_id');
    }

    /**
     * UserRequestRating Model Linked
     */
    public function filter()
    {
        return $this->hasMany('App\RequestFilter', 'request_id');
    }

    /**
     * UserRequestReportImages User Model Linked
     */
    public function userReportImages()
    {
        return $this->hasMany('App\RequestReportImages', 'request_id')->where('type', 'User');
    }

     /**
     * UserRequestReportImages User Model Linked
     */
    public function driverReportImages()
    {
        return $this->hasMany('App\RequestReportImages', 'request_id')->where('type', 'Driver');
    }

    /**
     * UserRequestRating Model Linked
     */
    public function offer()
    {
        return $this->hasMany('App\RequestOffer', 'request_id')->where('is_declined', 0);
        // ->where('is_skipped', 0);
    }

    /**
     * The user who created the request.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * The provider assigned to the request.
     */
    public function provider()
    {
        return $this->belongsTo('App\Provider')->with('fleetData');
    }

    public function provider_service()
    {
        if (Setting::get('multi_vehicle_module', 0) == 1) {
            return $this->belongsTo('App\ProviderService', 'provider_id', 'provider_id')->where('is_selected', 1);
        } else {
            return $this->belongsTo('App\ProviderService', 'provider_id', 'provider_id');
        }

    }

    public function scopePendingRequest($query, $user_id)
    {
        return $query->where('user_id', $user_id)
            ->whereNotIn('status', ['CANCELLED', 'COMPLETED', 'SCHEDULED', 'REQUESTED']);
    }

    public function scopePendingDriverRequest($query, $provider_id)
    {
        return $query->where('provider_id', $provider_id)
            ->whereNotIn('status', ['CANCELLED', 'COMPLETED', 'SCHEDULED', 'REQUESTED']);
    }

    public function scopeRequestHistory($query)
    {
        return $query->orderBy('user_requests.created_at', 'desc')
            ->with('user', 'payment', 'provider');
    }

    public function scopeUserTrips($query, $user_id)
    {
        return $query->where('user_requests.user_id', $user_id)
            ->whereIn('user_requests.status', ['COMPLETED', 'CANCELLED'])
            ->orderBy('user_requests.created_at', 'desc')
            ->select('user_requests.*')
            ->with('payment');
    }

    public function scopeUserUpcomingTrips($query, $user_id)
    {
        return $query->where('user_requests.user_id', $user_id)
            ->whereIn('user_requests.status', ['SCHEDULED', 'REQUESTED'])
            ->orderBy('user_requests.created_at', 'desc')
            ->select('user_requests.*')
            ->with('service_type', 'provider');
    }

    public function scopeProviderUpcomingRequest($query, $user_id)
    {
        return $query->where('user_requests.provider_id', $user_id)
            ->whereIn('user_requests.status', ['SCHEDULED', 'REQUESTED'])
            ->select('user_requests.*')
            ->with('service_type', 'user', 'provider');
    }

    public function scopeUserTripDetails($query, $user_id, $request_id)
    {
        return $query->where('user_requests.user_id', $user_id)
            ->where('user_requests.id', $request_id)
            ->where(function ($query) {
                $query->where('user_requests.status', 'COMPLETED')
                    ->orWhere('user_requests.status', 'CANCELLED');
            })
            ->select('user_requests.*')
            ->with('payment', 'service_type', 'user', 'provider', 'rating', 'userReportImages','driverReportImages');
    }

    public function scopeUserUpcomingTripDetails($query, $user_id, $request_id)
    {
        return $query->where('user_requests.user_id', $user_id)
            ->where('user_requests.id', $request_id)
            ->where(function ($query) {
                $query->where('user_requests.status', 'SCHEDULED')
                    ->orWhere('user_requests.status', 'REQUESTED');
            })
            ->select('user_requests.*')
            ->with('service_type', 'user', 'provider');
    }

    public function scopeUserRequestStatusCheck($query, $user_id, $check_status)
    {
        if (Setting::get('negotiation_module', 0) == 1) {
            return $query->where('user_requests.user_id', $user_id)
                ->where('user_requests.user_rated', 0)
                ->whereNotIn('user_requests.status', $check_status)
                ->select('user_requests.*')
                ->with(['user', 'provider', 'service_type', 'provider_service', 'rating', 'payment', 'offer']);
        } else {
            return $query->where('user_requests.user_id', $user_id)
                ->where('user_requests.user_rated', 0)
                ->whereNotIn('user_requests.status', $check_status)
                ->select('user_requests.*')
                ->with(['user', 'provider', 'service_type', 'provider_service', 'rating', 'payment']);
        }
    }

    public function scopeUserRequestAssignProvider($query, $user_id, $check_status)
    {
        return $query->where('user_requests.user_id', $user_id)
            ->where('user_requests.user_rated', 0)
            ->where('user_requests.provider_id', 0)
            ->whereIn('user_requests.status', $check_status)
            ->select('user_requests.*')
            ->with('filter');
    }

    public function getUserIdAttribute($value)
    {
        return (float)$value;
    }

    public function getProviderIdAttribute($value)
    {
        return (float)$value;
    }

    public function getCurrentProviderIdAttribute($value)
    {
        return (float)$value;
    }

    public function getServiceTypeIdAttribute($value)
    {
        return (float)$value;
    }

    public function getOtpAttribute($value)
    {
        return (float)$value;
    }

    public function getReturntripAttribute($value)
    {
        return (float)$value;
    }

    public function getPaidAttribute($value)
    {
        return (float)$value;
    }

    public function getDistanceAttribute($value)
    {
        return (float)$value;
    }

    public function getAmountAttribute($value)
    {
        return (float)$value;
    }

    public function getSLatitudeAttribute($value)
    {
        return (float)$value;
    }

    public function getSLongitudeAttribute($value)
    {
        return (float)$value;
    }

    public function getDLatitudeAttribute($value)
    {
        return (float)$value;
    }

    public function getDLongitudeAttribute($value)
    {
        return (float)$value;
    }

    public function getUserRatedAttribute($value)
    {
        return (float)$value;
    }

    public function getProviderRatedAttribute($value)
    {
        return (float)$value;
    }

    public function getUseWalletAttribute($value)
    {
        return (float)$value;
    }

    public function getSurgeAttribute($value)
    {
        return (float)$value;
    }

    public function getTrackLatitudeAttribute($value)
    {
        return (float)$value;
    }

    public function getTrackLongitudeAttribute($value)
    {
        return (float)$value;
    }

    public function getTrackDistanceAttribute($value)
    {
        return (float)$value;
    }

    public function getIsFreeAttribute($value)
    {
        return (boolean) $value;
    }

    public function getDriverJobCodeAttribute($value)
    {
        return (string)$value;
    }
}

<?php 

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait ServiceTypeMutatorsTrait{
    public function getCapacityAttribute($value)
    {
        return (string) $value;
    }

    public function getIsFreeAttribute($value)
    {
        return (bool) $value;
    }

    public function setCreatedByAttribute(){
        $this->attributes['created_by'] = Auth::guard('admin')->id;
    }

    public function setUpdatedByAttribute(){
        $this->attributes['updated_by'] = Auth::guard('admin')->id;
    }

    public function setLockedPricingAttribute($value)
    {
        $this->attributes['locked_pricing'] = $value ? 1 : 0;
    }

    public function setIsFreeAttribute($value)
    {
        $this->attributes['is_free'] = $value ? 1 : 0;
    }

    public function setIsReturnTripAttribute($value)
    {
        $this->attributes['is_return_trip'] = $value ? 1 : 0;
    }


    // Mutators for peak days
    public function setPeakMondayAttribute($value)
    {
        $this->attributes['peak_monday'] = $value ? 1 : 0;
    }

    public function setPeakTuesdayAttribute($value)
    {
        $this->attributes['peak_tuesday'] = $value ? 1 : 0;
    }

    public function setPeakWednesdayAttribute($value)
    {
        $this->attributes['peak_wednesday'] = $value ? 1 : 0;
    }

    public function setPeakThursdayAttribute($value)
    {
        $this->attributes['peak_thursday'] = $value ? 1 : 0;
    }

    public function setPeakFridayAttribute($value)
    {
        $this->attributes['peak_friday'] = $value ? 1 : 0;
    }

    public function setPeakSaturdayAttribute($value)
    {
        $this->attributes['peak_saturday'] = $value ? 1 : 0;
    }

    public function setPeakSundayAttribute($value)
    {
        $this->attributes['peak_sunday'] = $value ? 1 : 0;
    }

    // Mutators for peak periods
    public function setPeak1Attribute($value)
    {
        $this->attributes['peak1'] = $value ? 1 : 0;
    }

    public function setPeak2Attribute($value)
    {
        $this->attributes['peak2'] = $value ? 1 : 0;
    }

    public function setPeak3Attribute($value)
    {
        $this->attributes['peak3'] = $value ? 1 : 0;
    }

    public function setApplyAfter1Attribute($value)
    {
        $this->attributes['apply_after_1'] = $this->handleNullOrValue($value);
    }

    public function setApplyAfter2Attribute($value)
    {
        $this->attributes['apply_after_2'] = $this->handleNullOrValue($value);
    }

    public function setApplyAfter3Attribute($value)
    {
        $this->attributes['apply_after_3'] = $this->handleNullOrValue($value);
    }

    public function setApplyAfter4Attribute($value)
    {
        $this->attributes['apply_after_4'] = $this->handleNullOrValue($value);
    }

    public function setAfter1PriceAttribute($value)
    {
        $this->attributes['after_1_price'] = $this->handleNullOrValue($value);
    }

    public function setAfter2PriceAttribute($value)
    {
        $this->attributes['after_2_price'] = $this->handleNullOrValue($value);
    }

    public function setAfter3PriceAttribute($value)
    {
        $this->attributes['after_3_price'] = $this->handleNullOrValue($value);
    }

    public function setAfter4PriceAttribute($value)
    {
        $this->attributes['after_4_price'] = $this->handleNullOrValue($value);
    }

    public function setMinuteAttribute($value)
    {
        $this->attributes['minute'] = $this->handleNullOrValue($value);
    }

    public function setDistanceAttribute($value)
    {
        $this->attributes['distance'] = $this->handleNullOrValue($value);
    }

    public function setPeakPercentageAttribute($value)
    {
        $this->attributes['peak_percentage'] = $this->handleNullOrValue($value);
    }

    public function setPeakFixedPricingAttribute($value)
    {
        $this->attributes['peak_fixed_pricing'] = $this->handleNullOrValue($value);
    }

    public function setPeakApplyAfter1Attribute($value)
    {
        $this->attributes['peak_apply_after_1'] = $this->handleNullOrValue($value);
    }

    public function setPeakApplyAfter2Attribute($value)
    {
        $this->attributes['peak_apply_after_2'] = $this->handleNullOrValue($value);
    }

    public function setPeakApplyAfter3Attribute($value)
    {
        $this->attributes['peak_apply_after_3'] = $this->handleNullOrValue($value);
    }

    public function setPeakApplyAfter4Attribute($value)
    {
        $this->attributes['peak_apply_after_4'] = $this->handleNullOrValue($value);
    }

    public function setPeakAfter1PriceAttribute($value)
    {
        $this->attributes['peak_after_1_price'] = $this->handleNullOrValue($value);
    }

    public function setPeakAfter2PriceAttribute($value)
    {
        $this->attributes['peak_after_2_price'] = $this->handleNullOrValue($value);
    }

    public function setPeakAfter3PriceAttribute($value)
    {
        $this->attributes['peak_after_3_price'] = $this->handleNullOrValue($value);
    }

    public function setPeakAfter4PriceAttribute($value)
    {
        $this->attributes['peak_after_4_price'] = $this->handleNullOrValue($value);
    }

    public function setPhourfromAttribute($value)
    {
        $this->attributes['phourfrom'] = $this->handleNullOrValue($value);
    }

    public function setPhourtoAttribute($value)
    {
        $this->attributes['phourto'] = $this->handleNullOrValue($value);
    }

    public function setPextraAttribute($value)
    {
        $this->attributes['pextra'] = $this->handleNullOrValue($value);
    }

    public function setPhourfromoneAttribute($value)
    {
        $this->attributes['phourfromone'] = $this->handleNullOrValue($value);
    }

    public function setPhourtooneAttribute($value)
    {
        $this->attributes['phourtoone'] = $this->handleNullOrValue($value);
    }

    public function setPhourfromtwoAttribute($value)
    {
        $this->attributes['phourfromtwo'] = $this->handleNullOrValue($value);
    }

    public function setPhourtotwoAttribute($value)
    {
        $this->attributes['phourtotwo'] = $this->handleNullOrValue($value);
    }

    // Helper method to handle null or value
    private function handleNullOrValue($value)
    {
        return is_string($value) && trim($value) === '' ? null : $value;
    }
}
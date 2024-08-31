<?php

namespace App\Traits\DMS;
use Illuminate\Support\Str;

use App\Services\{
    DriverService,
};
use Illuminate\Validation\Rule;

trait DriverTrait
{
    // Services
    protected DriverService $driverService;

    protected $driver;

    // Properties
    public ?string $driverId = null;
    public ?string $name = null;
    public ?string $iqaama_number = null;
    public ?string $iqaama_expiry = null;
    public ?string $absher_number = null;
    public ?string $insurance_policy_number = null;
    public ?string $sponsorship = null;
    public ?string $sponsorship_id = null;
    public ?int $vehicle_monthly_cost = 0;
    public ?int $fuel = 0;
    public ?int $gprs = 0;
    public ?int $government_levy_fee = 0;
    public ?int $accommodation = 0;
    public ?int $mobile_data = 0;
    public ?string $email = null;
    public ?string $mobile = null;
    public ?string $dob = null;
    public ?string $license_expiry = null;
    public ?string $insurance_expiry = null;
    public $image;
    public ?string $driver_type_id = null;
    public ?string $branch_id = null;
    public ?string $remarks = null;


    public function mount($id = null){
        if($id)
        {
            $this->driver = $this->driverService->find($id);
            $this->driverId = $id;
            $this->iqaama_number = $this->driver->iqaama_number;
            $this->iqaama_expiry = $this->driver->iqaama_expiry;
            $this->absher_number = $this->driver->absher_number;
            $this->insurance_policy_number = $this->driver->insurance_policy_number;
            $this->sponsorship_id = $this->driver->sponsorship_id;
            $this->vehicle_monthly_cost = $this->driver->vehicle_monthly_cost;
            $this->mobile_data = $this->driver->mobile_data;
            $this->sponsorship = $this->driver->sponsorship;
            $this->name = $this->driver->name;
            $this->email = $this->driver->email;
            $this->mobile = $this->driver->mobile;
            $this->dob = $this->driver->dob;
            $this->license_expiry = $this->driver->license_expiry;
            $this->insurance_expiry = $this->driver->insurance_expiry;
            $this->fuel = $this->driver->fuel;
            $this->gprs = $this->driver->gprs;
            $this->government_levy_fee = $this->driver->government_levy_fee;
            $this->accommodation = $this->driver->accommodation;
            $this->driver_type_id = $this->driver->driver_type_id;
            $this->branch_id = $this->driver->branch_id;
            $this->remarks = $this->driver->remarks;
        }
    }

    public function boot(
        DriverService $driverService,
    ) {
        $this->driverService = $driverService;
    }

    public function validations()
    {

        $validations = [
            'name' => 'required|string|min:3',
            'dob' => 'required|date',
            'iqaama_expiry' => 'required|date',
            'sponsorship' => 'required|string|max:255',
            'sponsorship_id' => 'required|string|max:255',
            'license_expiry' => 'required|date',
            'insurance_expiry' => 'required|date',
            'mobile_data' => 'sometimes|numeric',
            'vehicle_monthly_cost' => 'sometimes|numeric',
            'fuel' => 'sometimes|numeric',
            'gprs' => 'sometimes|numeric',
            'government_levy_fee' => 'sometimes|numeric',
            'accommodation' => 'sometimes|numeric',
            'mobile' => 'required|string|max:255',
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg|max:2048',
            'driver_type_id' => 'required|exists:driver_types,id',
            'branch_id' => 'sometimes|exists:branches,id',
        ];

        if($this->driverId != null){
            $validations['email'] = ['required', 'email', Rule::unique('drivers')->whereNull('deleted_at')->ignore($this->driverId)];
            $validations['iqaama_number'] = ['required', Rule::unique('drivers')->whereNull('deleted_at')->ignore($this->driverId)];
            $validations['absher_number'] = ['required', Rule::unique('drivers')->whereNull('deleted_at')->ignore($this->driverId)];
            $validations['insurance_policy_number'] = ['required', Rule::unique('drivers')->whereNull('deleted_at')->ignore($this->driverId)];
        }else{
            $validations['email'] = ['required', 'email', Rule::unique('drivers')->whereNull('deleted_at')];
            $validations['iqaama_number'] = ['required', Rule::unique('drivers')->whereNull('deleted_at')];
            $validations['absher_number'] = ['required', Rule::unique('drivers')->whereNull('deleted_at')];
            $validations['insurance_policy_number'] = ['required', Rule::unique('drivers')->whereNull('deleted_at')];
        }

        return $this->validate($validations);
    }


}

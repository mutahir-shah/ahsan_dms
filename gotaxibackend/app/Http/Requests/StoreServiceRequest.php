<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required',
            'capacity' => 'required|numeric',
            'fixed' => 'nullable|numeric',
            'minute' => 'nullable|numeric',
            'service_time_duration' => 'nullable|numeric',
            'apply_after_1' => 'nullable|numeric',
            'apply_after_2' => 'nullable|numeric',
            'apply_after_3' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'after_2_price' => 'nullable|numeric',
            'after_3_price' => 'nullable|numeric',
            'distance' => 'nullable|numeric',
            'calculator' => 'required|in:MIN,FIXED,HOUR,DISTANCE,DISTANCEMIN,DISTANCEHOUR,METERING,DISTANCETIER,DISTANCEWEIGHT',
            'image' => 'required|mimes:ico,png',
            'map_icon' => 'required|mimes:ico,png',
            'booking_fee_amount' => 'nullable|numeric',
            'is_free' => 'nullable|numeric',

            // Peak hour validations using before and after rules
            'phourfrom' => 'required_if:peak1,on|date_format:H:i|before:phourto',
            'phourto' => 'required_if:peak1,on|date_format:H:i|after:phourfrom',
            // 'peak2' => 'nullable|in:on',
            'phourfromone' => 'required_if:peak2,on|date_format:H:i|before:phourtoone',
            'phourtoone' => 'required_if:peak2,on|date_format:H:i|after:phourfromone',
            // 'peak3' => 'nullable|in:on',
            'phourfromtwo' => 'required_if:peak3,on|date_format:H:i|before:phourtotwo',
            'phourtotwo' => 'required_if:peak3,on|date_format:H:i|after:phourfromtwo',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $phourfrom = $this->input('phourfrom');
            $phourto = $this->input('phourto');
            $phourfromone = $this->input('phourfromone');
            $phourtoone = $this->input('phourtoone');
            $phourfromtwo = $this->input('phourfromtwo');
            $phourtotwo = $this->input('phourtotwo');
            $peak1 = $this->input('peak1');
            $peak2 = $this->input('peak2');
            $peak3 = $this->input('peak3');

            if ($peak1 === 'on') {
                if ($peak2 === 'on' && ($phourfrom === $phourfromone && $phourto === $phourtoone)) {
                    $validator->errors()->add('phourfrom', 'Peak hour times for Peak Price One and Peak Price Two cannot be identical.');
                }
                if ($peak3 === 'on' && ($phourfrom === $phourfromtwo && $phourto === $phourtotwo)) {
                    $validator->errors()->add('phourfrom', 'Peak hour times for Peak Price One and Peak Price Three cannot be identical.');
                }
            }

            if ($peak2 === 'on' && $peak3 === 'on') {
                if ($phourfromone === $phourfromtwo && $phourtoone === $phourtotwo) {
                    $validator->errors()->add('phourfromone', 'Peak hour times for Peak Price Two and Peak Price Three cannot be identical.');
                }
            }
        });
    }

    public function messages()
    {
        return [
            'type.required' => 'The service type is required.',
            'capacity.required' => 'The capacity field is required.',
            'capacity.numeric' => 'The capacity must be a number.',
            'fixed.numeric' => 'The fixed price must be a number.',
            'minute.numeric' => 'The minute rate must be a number.',
            'service_time_duration.numeric' => 'The service time duration must be a number.',
            'apply_after_1.numeric' => 'The apply after 1 rate must be a number.',
            'apply_after_2.numeric' => 'The apply after 2 rate must be a number.',
            'apply_after_3.numeric' => 'The apply after 3 rate must be a number.',
            'price.numeric' => 'The price must be a number.',
            'after_2_price.numeric' => 'The after 2 price must be a number.',
            'after_3_price.numeric' => 'The after 3 price must be a number.',
            'distance.numeric' => 'The distance must be a number.',
            'calculator.required' => 'The calculator field is required.',
            'calculator.in' => 'The selected calculator is invalid.',
            'image.required' => 'An image is required.',
            'image.mimes' => 'The image must be a file of type: ico, png.',
            'map_icon.required' => 'A map icon is required.',
            'map_icon.mimes' => 'The map icon must be a file of type: ico, png.',
            'booking_fee_amount.numeric' => 'The booking fee amount must be a number.',
            'is_free.numeric' => 'The is free field must be a number.',

            // Peak hour custom validation messages
            'phourfrom.required_if' => 'The start time for Peak Price One is required when Peak Price One is active.',
            'phourto.required_if' => 'The end time for Peak Price One is required when Peak Price One is active.',
            'phourfromone.required_if' => 'The start time for Peak Price Two is required when Peak Price Two is active.',
            'phourtoone.required_if' => 'The end time for Peak Price Two is required when Peak Price Two is active.',
            'phourfromtwo.required_if' => 'The start time for Peak Price Three is required when Peak Price Three is active.',
            'phourtotwo.required_if' => 'The end time for Peak Price Three is required when Peak Price Three is active.',
            'phourfrom.before' => 'The start time for Peak Price One must be before the end time.',
            'phourto.after' => 'The end time for Peak Price One must be after the start time.',
            'phourfromone.before' => 'The start time for Peak Price Two must be before the end time.',
            'phourtoone.after' => 'The end time for Peak Price Two must be after the start time.',
            'phourfromtwo.before' => 'The start time for Peak Price Three must be before the end time.',
            'phourtotwo.after' => 'The end time for Peak Price Three must be after the start time.',
        ];
    }
}

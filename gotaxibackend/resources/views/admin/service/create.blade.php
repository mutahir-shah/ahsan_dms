@extends('admin.layout.base')
@extends('admin.layout.base2')


@section('title', 'Add Service Type ')

@section('styles')
    <style>
        .nav-tabs {
            border-bottom: none !important;
        }


        .nav-tabs .nav-link:hover {
            background-color: {{ getSettings('site_color') }} !important;
            color: #fff;
        }

        .nav-tabs .nav-link {
            border-radius: 18.5px !important;
            border: none;
            outline: none;
            font-size: 12px;
            font-weight: 600px;
            background-color: #F3F3F3;
            text-transform: uppercase;
            transition: all .4s ease;
        }

        .form-control {
            border: none !important;
            outline: none !important;
            background-color: #F3F3F3 !important;
            height: 67px !important;
            border-radius: 33.5px !important;
            padding-left: 40px !important;
            color: #717171 !important;
            font-size: 14px !important;
        }

        textarea.form-control {
            height: 182px !important;
            padding-top: 30px;
            padding-left: 40px;
            border-radius: 50px !important;
        }

        /* Image Styles */

        .dropify-wrapper {
            width: 200px;
            height: 200px;
            border-radius: 15px;
            position: relative;
            display: inline-block;
            background-color: #f0f0f0;
            border: none;
        }

        .dropify-wrapper .dropify-message span.file-icon:before {
            content: '\f030';
            /* FontAwesome camera icon */
            font-family: 'FontAwesome';
            font-size: 25px;
        }

        .dropify-message {
            font-size: 14px;
        }

        .dropify-preview {
            height: 100%;
            border-radius: 15px;
        }

        .dropify-render img {
            height: auto;
            max-height: 100%;
            border-radius: 15px;
        }
    </style>
@endsection


@section('content')


    <div class="content-wrapper">

        <div class="container-fluid">

            <div class="box box-block bg-white border-radius-10">

                <a href="{{ route('admin.service.index') }}" class="btn btn-default pull-right"><i
                        class="fa fa-angle-left"></i> {{ translateKeyword('back') }}</a>


                <h5 style="margin-bottom: 2em;">{{ translateKeyword('Add_Service_Type') }}</h5>
                @include('common.notify')


                <form class="form-horizontal" action="{{ route('admin.service.store') }}" method="POST"
                    enctype="multipart/form-data" role="form">

                    {{ csrf_field() }}

                    <ul class="nav nav-tabs" id="myInnerTab" role="tablist" style="margin: 10px 0 10px 10px">
                        @php($languages = getLanguages())
                        @foreach ($languages as $index => $language)
                            <li class="nav-item">
                                <a class="nav-link {{ $index === 0 ? 'active' : '' }}" data-toggle="tab"
                                    href="#{{ $language->name }}" role="tab"
                                    aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                    {{ $language->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach ($languages as $index => $language)
                            <div class="tab-pane {{ $index === 0 ? 'show active' : '' }}" id="{{ $language->name }}"
                                role="tabpanel">
                                <div class="col-12 mt-1">
                                    <div class="form-group row">
                                        <div class="col-6">
                                            <label for="name_{{ $language->id }}"
                                                class="col-xs-12 col-form-label">{{ translateKeyword('Service_Name') }}</label>

                                            <div class="col-xs-12">

                                                <input class="form-control" type="text"
                                                    value="{{ old('name_' . $language->id) }}"
                                                    name="name_{{ $language->id }}"
                                                    {{ $index === 0 ? 'required-dis' : '' }} id="name_{{ $language->id }}"
                                                    placeholder="{{ translateKeyword('Service_Name') }}">

                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group row">

                                        <div class="col-6">
                                            <label for="description_{{ $language->id }}"
                                                class="col-xs-12 col-form-label">{{ translateKeyword('Description') }}</label>

                                            <div class="col-xs-12">

                                                <textarea class="form-control" name="description_{{ $language->id }}" {{ $index === 0 ? 'required' : '' }}
                                                    id="description_{{ $language->id }}" placeholder="{{ translateKeyword('Description') }}" rows="4">{{ old('description_' . $language->id) }}</textarea>

                                            </div>
                                        </div>

                                    </div>
                                    <!-- Add more fields for each language as needed -->
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <hr>

                    <div class="form-group row" style="display: none;">

                        <label for="provider_name"
                            class="col-xs-12 col-form-label">{{ translateKeyword('driver_name') }}</label>

                        <div class="col-xs-10">

                            <input class="form-control" type="text" value="{{ old('provider_name') }}"
                                name="provider_name" required-dis id="provider_name"
                                placeholder="{{ translateKeyword('driver_name') }}">

                        </div>

                    </div>
                    @if (Setting::get('zone_metering', '') == 1)
                        <div class="form-group row">

                            <label for="provider_name"
                                class="col-xs-12 col-form-label">{{ translateKeyword('Zone(s) Metering') }}</label>

                            <div class="col-xs-10">

                                <select name="zones[]" multiple class="form-control">
                                    <option value="">{{ translateKeyword('none') }}</option>
                                    <option value="all">{{ translateKeyword('All Zones') }}</option>
                                    @foreach ($zones as $zone)
                                        <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                    @endforeach
                                </select>

                            </div>

                        </div>
                    @endif

                    <div class="form-group row">

                        <div class="col-xs-6">
                            <label for="picture"
                                class="col-xs-12 col-form-label">{{ translateKeyword('Service_Image') }}</label>

                            <input type="file" accept="image/*" name="image" class="dropify form-control-file"
                                id="picture" aria-describedby="fileHelp">

                        </div>

                        <div class="col-xs-6">
                            <label for="picture"
                                class="col-xs-12 col-form-label">{{ translateKeyword('Map Icon(40p x 40px)') }}</label>

                            <input type="file" accept="image/*" name="map_icon" class="dropify form-control-file"
                                id="picture" aria-describedby="fileHelp">

                        </div>

                    </div>

                    <div class="form-group row">

                        <div class="col-4">
                            <label for="calculator"
                                class="col-xs-12 col-form-label">{{ translateKeyword('Pricing_Logic') }}</label>

                            <div class="col-xs-12">

                                <select class="form-control" id="calculator" name="calculator"
                                    onchange="selectPricingType()">

                                    <option value="MIN">{{ translateKeyword('MIN') }}</option>
                                    <option value="METERING">{{ translateKeyword('METERING') }}</option>
                                    <option value="FIXED">{{ translateKeyword('FIXED') }}</option>

                                    <option value="HOUR">{{ translateKeyword('HOUR') }}</option>

                                    <option value="DISTANCE">{{ translateKeyword('DISTANCE') }}</option>
                                    <option value="DISTANCETIER">{{ translateKeyword('DISTANCETIER') }}</option>

                                    <option value="DISTANCEMIN">{{ translateKeyword('DISTANCEMIN') }}</option>

                                    <option value="DISTANCEHOUR">{{ translateKeyword('DISTANCEHOUR') }}</option>
                                    <option value="DISTANCEWEIGHT">{{ translateKeyword('DISTANCEWEIGHT') }}</option>

                                </select>

                            </div>
                        </div>

                    </div>
                    <div id="calculation_block" class="row">
                        <div class="form-group col-4" id="locked_pricing_field">
                            <div class="col-xs-12 col-form-label">
                                <label for="UPI_key" class="col-form-label">
                                    {{ translateKeyword('Lock estimated pricing') }}
                                </label>
                            </div>
                            <div class="col-xs-12">
                                <input name="locked_pricing" id="locked_pricing" type="checkbox" class="js-switch"
                                    data-color="#43b968">
                            </div>

                        </div>
                        @if (Setting::get('free_ride') == 1)
                            <div class="form-group col-4" id="is_free_field">
                                <div class="col-xs-12 col-form-label">
                                    <label for="UPI_key" class="col-form-label">
                                        {{ translateKeyword('Free Service') }}
                                    </label>
                                </div>
                                <div class="col-xs-12">
                                    <input name="is_free" id="is_free" type="checkbox" class="js-switch"
                                        data-color="#43b968">
                                </div>

                            </div>
                        @endif

                        @if (Setting::get('return_trip') == 1)
                            <div class="form-group col-4" id="is_free_field">
                                <div class="col-xs-12 col-form-label">
                                    <label for="is_return_trip" class="col-form-label">
                                        {{ translateKeyword('Return Trip') }}
                                    </label>
                                </div>
                                <div class="col-xs-12">
                                    <input name="is_return_trip" id="is_return_trip" type="checkbox" class="js-switch"
                                        data-color="#43b968">
                                </div>

                            </div>
                        @endif

                        @if (Setting::get('booking_fee', 0) == 1 && Setting::get('booking_fee_category', 'global') == 'service')
                            {{-- <div class="form-group row">
                                <label for="booking_fee_type" class="col-xs-12 col-form-label">Booking Fee Type</label>
                                <div class="col-xs-10">
                                    <select name="booking_fee_type" class="form-control">
                                        <option value="fixed"> Fixed
                                        </option>
                                        <option value="percentage"> Percentage
                                        </option>
                                    </select>
                                </div>
                            </div> --}}
                            <div class="form-group col-4">
                                <label for="booking_fee"
                                    class="col-xs-12 col-form-label">{{ translateKeyword('booking-fee') }}
                                    ({{ currencySymbol() }})</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="number" step="any"
                                        value="{{ old('booking_fee_amount') }}" name="booking_fee_amount"
                                        id="booking_fee_amount" min="0" step="0.1"
                                        placeholder="Enter Fee Amount" value="0" required>
                                </div>
                            </div>
                        @endif

                        @if (Setting::get('service_time_duration') == 1)
                            <div class="form-group col-6">

                                <label for="fixed"
                                    class="col-xs-12 col-form-label">{{ translateKeyword('service-time-duration') }}</label>

                                <div class="col-xs-12">

                                    <input class="form-control" type="number" step="any"
                                        value="{{ old('service_time_duration') }}" name="service_time_duration" required
                                        id="service_time_duration" placeholder="{{ translateKeyword('Enter minutes') }}">

                                </div>

                            </div>
                        @endif

                        <div class="form-group col-4">

                            <label for="fixed" class="col-xs-12 col-form-label"><label
                                    id="base_label">{{ translateKeyword('Base') }}</label>
                                {{ translateKeyword('price') }} ({{ currencySymbol() }})</label>

                            <div class="col-xs-12">

                                <input class="form-control" type="text" step="any" value="{{ old('fixed', 1) }}"
                                    name="fixed"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    required id="fixed" placeholder="{{ translateKeyword('base_price') }}">

                            </div>

                        </div>


                        <div class="form-group col-4" id="base_distance">

                            <div class="col-12">
                                <label for="distance"
                                    class="col-xs-12 col-form-label">{{ translateKeyword('Base_Distance') }}
                                    (@if (Setting::get('distance_system') === 'metric')
                                        KM
                                    @else
                                        {{ translateKeyword('Miles') }}
                                    @endif)</label>

                                <div class="col-xs-12">

                                    <input class="form-control" type="text" value="{{ old('distance', '0') }}"
                                        name="distance" id="distance"
                                        placeholder="{{ translateKeyword('Base_Distance') }}" min="0"
                                        step="0.1">

                                </div>
                            </div>

                        </div>
                        <div class="form-group col-4" id="unit_time_pricing">

                            <div class="col-12">
                                <label for="distance"
                                    class="col-xs-12 col-form-label">{{ translateKeyword('Unit Time Pricing (Min/Hours)') }}</label>

                                <div class="col-xs-12">

                                    <input class="form-control" type="text" name="minute"
                                        value="{{ old('minute', '0') }}" min="0" step="0.1"
                                        placeholder="{{ translateKeyword('Unit Time Pricing (Min/Hours)') }}">

                                </div>
                            </div>

                        </div>
                        <div class="form-group .col-4" id="unit_weight_pricing">

                            <label for="distance"
                                class="col-xs-12 col-form-label">{{ translateKeyword('Unit Weight Pricing (Per Kg)') }}</label>

                            <div class="col-xs-12">

                                <input class="form-control" type="text" name="weight"
                                    value="{{ old('weight', '0') }}" min="0" step="0.1"
                                    placeholder="{{ translateKeyword('Unit Weight Pricing (Per Kg)') }}">

                            </div>

                        </div>

                        @if (Setting::get('commission_tax_apply', 'global') == 'service')
                            <div class="form-group col-4">
                                <label for="commission_type"
                                    class="col-xs-12 col-form-label">{{ translateKeyword('commission-type') }}</label>
                                <div class="col-xs-12">
                                    <select name="commission_type" class="form-control">
                                        <option value="fixed"> {{ translateKeyword('fixed') }}
                                        </option>
                                        <option value="percentage"> {{ translateKeyword('percentage') }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="commission_percentage"
                                    class="col-xs-12 col-form-label">{{ translateKeyword('commission-percentage(%)/fixed') }}</label>
                                <div class="col-xs-10">
                                    <input class="form-control" type="text" id="commission_percentage"
                                        name="commission_percentage" min="0" step="0.1" max="100"
                                        placeholder="{{ translateKeyword('commission-percentage(%)/fixed') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tax_percentage"
                                    class="col-xs-12 col-form-label">{{ translateKeyword('tax_percentage') }}</label>
                                <div class="col-xs-10">
                                    <input class="form-control" type="text" id="tax_percentage" name="tax_percentage"
                                        min="0" step="0.1" max="100"
                                        placeholder="{{ translateKeyword('tax_percentage') }}">
                                </div>
                            </div>
                        @endif
                        <div class="form-group col-6" id="pricing_structure">

                            <label class="col-xs-12 col-form-label">{{ translateKeyword('Pricing Structure') }}</label>

                            <div class="col-xs-12">

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{ translateKeyword('Apply After') }}(@if (Setting::get('distance_system') === 'metric')
                                                    KM
                                                @else
                                                    {{ translateKeyword('Miles') }}
                                                @endif)</th>
                                            <th scope="col">{{ translateKeyword('Unit Distance Pricing') }}
                                                (@if (Setting::get('distance_system') === 'metric')
                                                    KM
                                                @else
                                                    {{ translateKeyword('Miles') }}
                                                @endif)</th>
                                            <th scope="col" class="roun_trip_cls">
                                                {{ translateKeyword('Return Trip Unit Distance Pricing') }}
                                                (@if (Setting::get('distance_system') === 'metric')
                                                    KM
                                                @else
                                                    {{ translateKeyword('Miles') }}
                                                @endif)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input class="form-control" type="text" name="apply_after_1"
                                                    min="0.1" step="0.1" value=""
                                                    placeholder="{{ translateKeyword('Apply After') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                            </td>
                                            <td><input class="form-control" type="text" name="price" value="0"
                                                    placeholder="{{ translateKeyword('Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                            </td>
                                            <td class="roun_trip_cls"><input class="form-control" type="text"
                                                    name="return_trip_price_1" value="0"
                                                    placeholder="{{ translateKeyword('Return Trip Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><input class="form-control" type="text" name="apply_after_2"
                                                    min="0.1" step="0.1" value=""
                                                    placeholder="{{ translateKeyword('Apply After') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                            </td>
                                            <td><input class="form-control" type="text" name="after_2_price"
                                                    value="0"
                                                    placeholder="{{ translateKeyword('Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                            </td>
                                            <td class="roun_trip_cls"><input class="form-control" type="text"
                                                    name="return_trip_price_2" value="0"
                                                    placeholder="{{ translateKeyword('Return Trip Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><input class="form-control" type="text" name="apply_after_3"
                                                    min="0.1" step="0.1" value=""
                                                    placeholder="{{ translateKeyword('Apply After') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                            </td>
                                            <td><input class="form-control" type="text" name="after_3_price"
                                                    value="0"
                                                    placeholder="{{ translateKeyword('Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                            </td>
                                            <td class="roun_trip_cls"><input class="form-control" type="text"
                                                    name="return_trip_price_3" value="0"
                                                    placeholder="{{ translateKeyword('Return Trip Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><input class="form-control" type="text" name="apply_after_4"
                                                    min="0.1" step="0.1" value=""
                                                    placeholder="{{ translateKeyword('Apply After') }}(@if (Setting::get('distance_system') === 'metric') KM @else Miles @endif)">
                                            </td>
                                            <td><input class="form-control" type="text" name="after_4_price"
                                                    value="0"
                                                    placeholder="{{ translateKeyword('Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric') KM @else Miles @endif)">
                                            </td>
                                            <td class="roun_trip_cls"><input class="form-control" type="text"
                                                    name="return_trip_price_4" value="0"
                                                    placeholder="{{ translateKeyword('Return Trip Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric') KM @else Miles @endif)">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div id="peak_fields">
                            <div class="form-group row">

                                <label for="peak_days"
                                    class="col-xs-1 col-form-label">{{ translateKeyword('Full Peak Days') }}</label>

                                <div class="col-xs-6">
                                    <div class="form-check form-check-inline">
                                        <input name="peak_monday" class="form-check-input" type="checkbox"
                                            id="inlineCheckbox1" value="0" value="0">
                                        <label class="form-check-label"
                                            for="inlineCheckbox1">{{ translateKeyword('Monday') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name="peak_tuesday" class="form-check-input" type="checkbox"
                                            id="inlineCheckbox1" value="0">
                                        <label class="form-check-label" for="inlineCheckbox1">Tuesday</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name="peak_wednesday" class="form-check-input" type="checkbox"
                                            id="inlineCheckbox1" value="0">
                                        <label class="form-check-label" for="inlineCheckbox1">Wednesday</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name="peak_thursday" class="form-check-input" type="checkbox"
                                            id="inlineCheckbox1" value="0">
                                        <label class="form-check-label" for="inlineCheckbox1">Thursday</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name="peak_friday" class="form-check-input" type="checkbox"
                                            id="inlineCheckbox1" value="0">
                                        <label class="form-check-label" for="inlineCheckbox1">Friday</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name="peak_saturday" class="form-check-input" type="checkbox"
                                            id="inlineCheckbox1" value="0">
                                        <label class="form-check-label" for="inlineCheckbox1">Saturday</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name="peak_sunday" class="form-check-input" type="checkbox"
                                            id="inlineCheckbox1" value="0">
                                        <label class="form-check-label" for="inlineCheckbox1">Sunday</label>
                                    </div>

                                </div>

                            </div>

                            <div class="form-group row">


                                <div class="col-4 p-0 m-0 mb-2 " style="font-size: 16px">
                                    <label for="UPI_key" class="col-xs-6 col-form-label">
                                        {{ translateKeyword('Peak Price One') }}
                                    </label>
                                    <input name="peak1" id="peak" data-id="peak1" type="checkbox"
                                        class="js-switch" data-color="#43b968">
                                </div>

                                <div class="col-4 p-0 m-0 mb-2 ">
                                    <label for="UPI_key" class="col-xs-6 col-form-label" style="font-size: 16px">
                                        {{ translateKeyword('Peak Price Two') }}
                                    </label>
                                    <input name="peak2" id="peak" data-id="peak2" type="checkbox"
                                        class="js-switch" data-color="#43b968">
                                </div>

                                <div class="col-4 p-0 m-0 mb-2 ">
                                    <label for="UPI_key" class="col-xs-6 col-form-label" style="font-size: 16px">
                                        {{ translateKeyword('Peak Price Three') }}
                                    </label>
                                    <input name="peak3" id="peak" data-id="peak3" type="checkbox"
                                        class="js-switch" data-color="#43b968">
                                </div>

                                <div class="col-4 p-0 m-0 mb-2 peak1">
                                    <div class="col-12">
                                        <label for="phourfrom"
                                            class="col-xs-12 col-form-label">{{ translateKeyword('Peak Hour(From)') }}</label>
                                        <div class="col-xs-12">

                                            <input class="form-control" type="time" name="phourfrom" id="phourfrom">

                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="phourto"
                                            class="col-xs-12 col-form-label">{{ translateKeyword('Peak Hour(To)') }}</label>



                                        <div class="col-xs-12">

                                            <input class="form-control" type="time" name="phourto" id="phourto">

                                        </div>
                                    </div>
                                </div>

                                <div class="col-4 p-0 m-0 mb-2 peak2">
                                    <div class="col-12">
                                        <label for="phourfrom"
                                            class="col-xs-12 col-form-label">{{ translateKeyword('Peak Hour(From)') }}</label>
                                        <div class="col-xs-12">

                                            <input class="form-control" type="time" name="phourfromone"
                                                id="phourfromone">

                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="phourto"
                                            class="col-xs-12 col-form-label">{{ translateKeyword('Peak Hour(To)') }}</label>



                                        <div class="col-xs-12">

                                            <input class="form-control" type="time" name="phourtoone"
                                                id="phourtoone">

                                        </div>
                                    </div>
                                </div>

                                <div class="col-4 p-0 m-0 mb-2 peak3">
                                    <div class="col-12">
                                        <label for="phourfrom"
                                            class="col-xs-12 col-form-label">{{ translateKeyword('Peak Hour(From)') }}</label>
                                        <div class="col-xs-12">

                                            <input class="form-control" type="time" name="phourfromtwo"
                                                id="phourfromtwo">

                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="phourtotwo"
                                            class="col-xs-12 col-form-label">{{ translateKeyword('Peak Hour(To)') }}</label>



                                        <div class="col-xs-12">

                                            <input class="form-control" type="time" name="phourtotwo"
                                                id="phourtotwo">

                                        </div>
                                    </div>
                                </div>

                                <div class="col-12"></div>
                                <div class="col-4">
                                    <label for="peak_percentage" class="col-xs-12 col-form-label">
                                        {{ translateKeyword('Peak percentage') }}
                                    </label>
                                    <div class="col-xs-12">
                                        <input name="peak_percentage" id="peak_percentage" type="checkbox"
                                            onchange="peak_percentage_select()" class="js-switch" data-color="#43b968">
                                    </div>
                                </div>

                                <div class="col-4"></div>
                                <div class="col-4"></div>

                                <div class="col-4">
                                    <label for="pextra"
                                        class="col-xs-12 col-form-label">{{ translateKeyword('Peak Hour Extra Price(in %)') }}</label>

                                    <div class="col-xs-12">

                                        <input class="form-control" type="text" value="" name="pextra"
                                            id="pextra" placeholder="In Percentage"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group row" id="peak_pricing_structure">
                            <label for="peak_fixed_pricing" class="col-xs-5 col-form-label">
                                {{ translateKeyword('Peak fixed pricing') }}
                            </label>
                            <div class="col-xs-10">
                                <input name="peak_fixed_pricing" id="peak_fixed_pricing" type="checkbox"
                                    onchange="peak_fixed_select()" class="js-switch" data-color="#43b968">
                            </div>

                            <div class="peak_fixed_pricing_container row" style="margin-left: 3px">
                                <label for="pextra"
                                    class="col-xs-10 col-form-label">{{ translateKeyword('Peak Hour Fixed Price') }}</label>

                                <div class="col-xs-10">

                                    <input class="form-control" type="text"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                        value="" name="pefixed" id="pefixed" placeholder="In Percentage">

                                </div>
                            </div>

                            <label for="peak_percentage" class="col-xs-12 col-form-label">
                                {{ translateKeyword('Peak Pricing Structure') }}
                            </label>
                            <div class="col-xs-10">
                                <input name="peak_pricing_structure_switch" data-id="peak_pricing_structure_container"
                                    id="peak_pricing_structure_switch" type="checkbox" class="js-switch"
                                    data-color="#43b968">
                            </div>
                            <div class="peak_pricing_structure_container">
                                <label
                                    class="col-xs-12 col-form-label">{{ translateKeyword('Peak Pricing Structure') }}</label>

                                <div class="col-xs-10">

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">{{ translateKeyword('Apply After') }}(@if (Setting::get('distance_system') === 'metric')
                                                        KM
                                                    @else
                                                        {{ translateKeyword('Miles') }}
                                                    @endif)</th>
                                                <th scope="col">{{ translateKeyword('Unit Distance Pricing') }}
                                                    (@if (Setting::get('distance_system') === 'metric')
                                                        KM
                                                    @else
                                                        {{ translateKeyword('Miles') }}
                                                    @endif)</th>
                                                <th scope="col" class="roun_trip_cls">
                                                    {{ translateKeyword('Return Trip Unit Distance Pricing') }}
                                                    (@if (Setting::get('distance_system') === 'metric')
                                                        KM
                                                    @else
                                                        {{ translateKeyword('Miles') }}
                                                    @endif)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input class="form-control" type="text" name="peak_apply_after_1"
                                                        min="0.1" step="0.1"
                                                        placeholder="{{ translateKeyword('Apply After') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)"
                                                        value="1"></td>
                                                <td><input class="form-control" type="text" name="peak_after_1_price"
                                                        placeholder="{{ translateKeyword('Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                                </td>
                                                <td class="roun_trip_cls"><input class="form-control" type="text"
                                                        name="peak_return_trip_price_1"
                                                        placeholder="{{ translateKeyword('Return Trip Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input class="form-control" type="text" name="peak_apply_after_2"
                                                        min="0.1" step="0.1"
                                                        placeholder="{{ translateKeyword('Apply After') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)"
                                                        value="1"></td>
                                                <td><input class="form-control" type="text" name="peak_after_2_price"
                                                        placeholder="{{ translateKeyword('Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                                </td>
                                                <td class="roun_trip_cls"><input class="form-control" type="text"
                                                        name="peak_return_trip_price_2"
                                                        placeholder="{{ translateKeyword('Return Trip Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input class="form-control" type="text" name="peak_apply_after_3"
                                                        min="0.1" step="0.1"
                                                        placeholder="{{ translateKeyword('Apply After') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)"
                                                        value="1"></td>
                                                <td><input class="form-control" type="text" name="peak_after_3_price"
                                                        placeholder="{{ translateKeyword('Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                                </td>
                                                <td class="roun_trip_cls"><input class="form-control" type="text"
                                                        name="peak_return_trip_price_3"
                                                        placeholder="{{ translateKeyword('Return Trip Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td><input class="form-control" type="text" name="peak_apply_after_4"
                                                        min="0.1" step="0.1"
                                                        placeholder="{{ translateKeyword('Apply After') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)"
                                                        value="1"></td>
                                                <td><input class="form-control" type="text" name="peak_after_4_price"
                                                        placeholder="{{ translateKeyword('Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                                </td>
                                                <td class="roun_trip_cls"><input class="form-control" type="text"
                                                        name="peak_return_trip_price_4"
                                                        placeholder="{{ translateKeyword('Return Trip Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">

                        <div class="col-4">
                            <label for="capacity"
                                class="col-xs-12 col-form-label">{{ translateKeyword('Seat_Capacity') }}</label>

                            <div class="col-xs-12">

                                <input class="form-control" type="number" step="any"
                                    value="{{ old('capacity') }}" name="capacity" required id="capacity"
                                    placeholder="{{ translateKeyword('capacity') }}" value="0" min="0"
                                    step="0.1">

                            </div>
                        </div>

                        <div class="col-4">
                            <label for="type"
                                class="col-xs-12 col-form-label">{{ translateKeyword('service_type') }}</label>

                            <div class="col-xs-12">

                                <select class="form-control" id="type" name="type">
                                    @foreach ($types as $type)
                                        <option value="{{ $type['value'] }}">
                                            @lang($type['language'])
                                        </option>
                                    @endforeach

                                    {{-- <option value="economy">{{ translateKeyword('Transportation') }}</option>

                                <option value="luxury">{{ translateKeyword('Delivery') }}</option>

                                <option value="extra_seat">{{ translateKeyword('Truck') }}</option>

                                <option value="outstation">{{ translateKeyword('OutStation') }}</option>
                                <option value="road_assistance">{{ translateKeyword('Roadside assistance') }}</option> --}}
                                </select>

                            </div>
                        </div>

                    </div>


                    <div class="form-group row">

                        <div class="col-xs-10">

                            <div class="row">

                                <div class="col-xs-12 col-sm-6 col-md-3">

                                    <a href="{{ route('admin.service.index') }}"
                                        class="btn btn-danger btn-block">{{ translateKeyword('cancel') }}</a>

                                </div>

                                <div class="col-xs-12 col-sm-6 offset-md-6 col-md-3">

                                    <button type="submit"
                                        class="btn btn-primary btn-block">{{ translateKeyword('Add_Service_Type') }}</button>

                                </div>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $(`.peak1`).fadeOut(800);
            $(`.peak2`).fadeOut(800);
            $(`.peak3`).fadeOut(800);

            $('body').delegate('#peak', 'change', function() {
                const div = $(this).attr('data-id');
                console.log($(this).is(':checked'));
                if ($(this).is(':checked')) {
                    $(`.${div}`).fadeIn(800);
                } else {
                    $(`.${div}`).fadeOut(800);
                }

            });

            $('body').delegate('#peak_pricing_structure_switch', 'change', function() {
                const div = $(this).attr('data-id');
                console.log($(this).is(':checked'));
                // peak_pricing_structure_select()
                if ($(this).is(':checked')) {
                    $(`.${div}`).fadeIn(800);
                } else {
                    $(`.${div}`).fadeOut(800);
                }

            });

            $('body').delegate('#peak_percentage', 'change', function() {
                const div = $(this).attr('data-id');
                console.log($(this).is(':checked'));
                // peak_percentage_select()
                if ($(this).is(':checked')) {
                    $(`.${div}`).fadeIn(800);
                } else {
                    $(`.${div}`).fadeOut(800);
                }

            });

            $('body').delegate('#peak_fixed_pricing', 'change', function() {
                const div = $(this).attr('data-id');
                console.log($(this).is(':checked'));
                // peak_fixed_select()
                if ($(this).is(':checked')) {
                    $(`.${div}`).fadeIn(800);
                } else {
                    $(`.${div}`).fadeOut(800);
                }

            });
        });

        function selectPricingType() {
            var pricing = $("#calculator").val();
            switch (pricing) {
                case 'MIN': {
                    $('#base_label').html('Base');
                    $("#calculation_block").fadeIn(800);
                    $("#base_distance").fadeIn(800);
                    $("#unit_time_pricing").fadeIn(800);
                    $("#locked_pricing_field").fadeIn(800);
                    $("#unit_weight_pricing").fadeOut(800);
                    $("#pricing_structure").fadeOut(800);
                    $('#peak_fields').fadeIn(800);
                    $('#peak_pricing_structure').fadeOut(800);
                    $(".roun_trip_cls").fadeOut(800);

                }
                break;
                case 'FIXED': {
                    $('#base_label').html('Fixed');
                    $("#calculation_block").fadeIn(800);
                    $("#base_distance").fadeOut(800);
                    $("#unit_time_pricing").fadeOut(800);
                    $("#locked_pricing_field").fadeOut(800);
                    $("#unit_weight_pricing").fadeOut(800);
                    $("#pricing_structure").fadeOut(800);
                    $('#peak_fields').fadeOut(800);
                    $('#peak_pricing_structure').fadeOut(800);
                    $(".roun_trip_cls").fadeOut(800);
                }
                break;
                case 'HOUR': {
                    $('#base_label').html('Base');
                    $("#calculation_block").fadeIn(800);
                    $("#base_distance").fadeIn(800);
                    $("#unit_time_pricing").fadeIn(800);
                    $("#locked_pricing_field").fadeIn(800);
                    $("#unit_weight_pricing").fadeOut(800);
                    $("#pricing_structure").fadeOut(800);
                    $('#peak_fields').fadeIn(800);
                    $('#peak_pricing_structure').fadeOut(800);
                    $(".roun_trip_cls").fadeOut(800);

                }
                break;
                case 'DISTANCE': {
                    $('#base_label').html('Base');
                    $("#calculation_block").fadeIn(800);
                    $("#base_distance").fadeIn(800);
                    $("#unit_time_pricing").fadeIn(800);
                    $("#locked_pricing_field").fadeIn(800);
                    $("#unit_weight_pricing").fadeOut(800);
                    $("#pricing_structure").fadeIn(800);
                    $('#peak_fields').fadeIn(800);
                    $('#peak_pricing_structure').fadeIn(800);
                    @if (Setting::get('return_trip') == 1)
                        if ($('#is_return_trip').prop('checked')) {
                            $(".roun_trip_cls").fadeIn(800);
                        }
                    @else
                        $(".roun_trip_cls").fadeOut(800);
                    @endif
                }
                break;
                case 'DISTANCETIER': {
                    $('#base_label').html('Base');
                    $("#calculation_block").fadeIn(800);
                    $("#base_distance").fadeIn(800);
                    $("#unit_time_pricing").fadeIn(800);
                    $("#locked_pricing_field").fadeIn(800);
                    $("#unit_weight_pricing").fadeOut(800);
                    $("#pricing_structure").fadeIn(800);
                    $('#peak_fields').fadeIn(800);
                    $('#peak_pricing_structure').fadeIn(800);
                    @if (Setting::get('return_trip') == 1)
                        if ($('#is_return_trip').prop('checked')) {
                            $(".roun_trip_cls").fadeIn(800);
                        }
                    @else
                        $(".roun_trip_cls").fadeOut(800);
                    @endif
                }
                break;
                case 'DISTANCEMIN': {
                    $('#base_label').html('Base');
                    $("#calculation_block").fadeIn(800);
                    $("#base_distance").fadeIn(800);
                    $("#unit_time_pricing").fadeIn(800);
                    $("#locked_pricing_field").fadeIn(800);
                    $("#unit_weight_pricing").fadeOut(800);
                    $("#pricing_structure").fadeIn(800);
                    $('#peak_fields').fadeIn(800);
                    $('#peak_pricing_structure').fadeIn(800);
                    @if (Setting::get('return_trip') == 1)
                        if ($('#is_return_trip').prop('checked')) {
                            $(".roun_trip_cls").fadeIn(800);
                        }
                    @else
                        $(".roun_trip_cls").fadeOut(800);
                    @endif
                }
                break;
                case 'DISTANCEHOUR': {
                    $('#base_label').html('Base');
                    $("#calculation_block").fadeIn(800);
                    $("#base_distance").fadeIn(800);
                    $("#unit_time_pricing").fadeIn(800);
                    $("#locked_pricing_field").fadeIn(800);
                    $("#unit_weight_pricing").fadeOut(800);
                    $("#pricing_structure").fadeIn(800);
                    $('#peak_fields').fadeIn(800);
                    $('#peak_pricing_structure').fadeIn(800);
                    @if (Setting::get('return_trip') == 1)
                        if ($('#is_return_trip').prop('checked')) {
                            $(".roun_trip_cls").fadeIn(800);
                        }
                    @else
                        $(".roun_trip_cls").fadeOut(800);
                    @endif
                }
                break;
                case 'DISTANCEWEIGHT': {
                    $('#base_label').html('Base');
                    $("#calculation_block").fadeIn(800);
                    $("#calculation_block").fadeIn(800);
                    $("#base_distance").fadeIn(800);
                    $("#unit_weight_pricing").fadeIn(800);
                    $("#pricing_structure").fadeIn(800);
                    $('#peak_fields').fadeIn(800);
                    $('#peak_pricing_structure').fadeIn(800);
                    @if (Setting::get('return_trip') == 1)
                        if ($('#is_return_trip').prop('checked')) {
                            $(".roun_trip_cls").fadeIn(800);
                        }
                    @else
                        $(".roun_trip_cls").fadeOut(800);
                    @endif
                }
                break;
                default: {
                    $('#base_label').html('Base');
                    $("#calculation_block").fadeIn(800);
                    $("#base_distance").fadeIn(800);
                    $("#unit_time_pricing").fadeIn(800);
                    $("#locked_pricing_field").fadeIn(800);
                    $("#unit_weight_pricing").fadeOut(800);
                    $("#pricing_structure").fadeOut(800);
                    $('#peak_fields').fadeIn(800);
                    $('#peak_pricing_structure').fadeIn(800);
                }
            }
        }
        $(document).ready(function() {
            $('#is_return_trip').change(function() {
                const return_trip = $(this).prop('checked');
                if (return_trip) {
                    $(".roun_trip_cls").fadeIn(800);
                } else {
                    $(".roun_trip_cls").fadeOut(800);
                }
            });
            // $("#base_distance").hide();
            $("#unit_time_pricing").hide();
            $("#unit_weight_pricing").hide();
            $("#pricing_structure").hide();
            $('#peak_fields').hide();
            $('#peak_pricing_structure').hide();
            $(".roun_trip_cls").fadeOut(800);
            selectPricingType();
        });

        function peak_percentage_select() {
            if ($('#peak_percentage').is(":checked")) {
                if ($('#peak_fixed_pricing').is(":checked")) {
                    $('#peak_fixed_pricing').click();
                }
            }
        }

        function peak_fixed_select() {
            if ($('#peak_fixed_pricing').is(":checked")) {
                if ($('#peak_percentage').is(":checked")) {
                    $('#peak_percentage').click();
                }
            }

        }

        document.addEventListener("DOMContentLoaded", function() {
            // Inner tabs
            const innerTabs = document.querySelectorAll('#myInnerTab .nav-link');

            innerTabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = this.getAttribute('href');
                    document.querySelector(target).classList.add('show', 'active');
                    innerTabs.forEach(t => {
                        if (t !== tab) {
                            const paneId = t.getAttribute('href');
                            document.querySelector(paneId).classList.remove('show',
                                'active');
                        }
                    });
                });
            });
        });
    </script>
@endsection

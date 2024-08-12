@extends('admin.layout.base')
@extends('admin.layout.base2')


@section('title', 'Update Service Type ')


@section('content')


    <div class="content-wrapper">

        <div class="container-fluid">

            <div class="box box-block bg-white border-radius-10">

                <a href="{{ route('admin.service.index') }}" class="btn btn-default pull-right"><i
                        class="fa fa-angle-left"></i> {{ translateKeyword('back') }}</a>


                <h5 style="margin-bottom: 2em;">{{ translateKeyword('Update_Service_Type') }}</h5>
                @include('common.notify')


                <form class="form-horizontal" action="{{ route('admin.service.update', $service->id) }}" method="POST"
                    enctype="multipart/form-data" role="form">

                    {{ csrf_field() }}


                    <input type="hidden" name="_method" value="PATCH">
                    @php
                        $languages = getLanguages();
                    @endphp

                    <ul class="nav nav-tabs" id="myInnerTab" role="tablist" style="margin-bottom:10px">
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
                                        <label for="name_{{ $language->name }}"
                                            class="col-xs-12 col-form-label">{{ translateKeyword('Service_Name') }}</label>

                                        <div class="col-xs-10">

                                            <input class="form-control" type="text"
                                                value="{{ old('name_' . $language->id, $service->translations->where('language_id', $language->id)->first()->name ?? '') }}"
                                                name="name_{{ $language->id }}" {{ $index === 0 ? 'required-dis' : '' }}
                                                id="name_{{ $language->id }}"
                                                placeholder="{{ translateKeyword('Service_Name') }}">

                                        </div>

                                    </div>

                                    <div class="form-group row">

                                        <label for="description_{{ $language->name }}"
                                            class="col-xs-12 col-form-label">{{ translateKeyword('Description') }}</label>

                                        <div class="col-xs-10">

                                            <textarea class="form-control" name="description_{{ $language->id }}" {{ $index === 0 ? 'required' : '' }}
                                                id="description_{{ $language->id }}" placeholder="{{ translateKeyword('Description') }}" rows="4">{{ old('description_' . $language->id, $service->translations->where('language_id', $language->id)->first()->description ?? '') }}</textarea>

                                        </div>

                                    </div>
                                    <!-- Add more fields for each language as needed -->
                                </div>
                            </div>
                        @endforeach
                    </div>


                    <div class="form-group row" style="display: none;">

                        <label for="provider_name"
                            class="col-xs-12 col-form-label">{{ translateKeyword('driver_name') }}</label>

                        <div class="col-xs-10">

                            <input class="form-control" type="text" value="{{ $service->provider_name }}"
                                name="provider_name" required-dis id="provider_name"
                                placeholder="{{ translateKeyword('driver_name') }}">

                        </div>

                    </div>
                    {{-- @if (Setting::get('zone_metering', '') == 1)
                        <div class="form-group row">

                            <label for="provider_name"
                                class="col-xs-12 col-form-label">{{ translateKeyword('Zone(s) Metering') }}</label>

                            <div class="col-xs-10">
                                @php
                                    if ($service->zones) {
                                        $zonesArray = unserialize($service->zones);
                                    } else {
                                        $zonesArray = [];
                                    }
                                @endphp
                                <select name="zones[]" multiple class="form-control">
                                    <option value="">{{ translateKeyword('none') }}</option>
                                    <option value="all">{{ translateKeyword('All Zones') }}</option>
                                    @foreach ($zones as $zone)
                                        <option value="{{ $zone->id }}"
                                            @if (in_array((string) $zone->id, $zonesArray)) selected @endif>{{ $zone->name }}</option>
                                    @endforeach
                                </select>

                            </div>

                        </div>
                    @endif --}}

                    <div class="form-group row">




                        <div class="col-xs-5">
                            <label for="image"
                                class="col-xs-12 col-form-label">{{ translateKeyword('Service_Image') }}</label>

                            @if (isset($service->image))
                                <img style="height: 90px; margin-bottom: 15px; border-radius:2em;"
                                    src="{{ $service->image }}">
                            @endif

                            <input type="file" accept="image/*" name="image" class="dropify form-control-file"
                                id="image" aria-describedby="fileHelp">

                        </div>

                        <div class="col-xs-5">
                            <label for="picture"
                                class="col-xs-12 col-form-label">{{ translateKeyword('Map Icon(40p x 40px)') }}</label>
                            @if (isset($service->map_icon))
                                <img style="height: 90px; margin-bottom: 15px; border-radius:2em;"
                                    src="{{ $service->map_icon }}">
                            @endif
                            <input type="file" accept="image/*" name="map_icon" class="dropify form-control-file"
                                id="picture" aria-describedby="fileHelp">

                        </div>

                    </div>

                    <div class="form-group row">

                        <label for="calculator"
                            class="col-xs-12 col-form-label">{{ translateKeyword('Pricing_Logic') }}</label>

                        <div class="col-xs-10">

                            <select class="form-control" id="calculator" name="calculator" onchange="selectPricingType()">

                                <option value="MIN" @if ($service->calculator == 'MIN') selected @endif>
                                    {{ translateKeyword('MIN') }}
                                </option>
                                <option value="METERING" @if ($service->calculator == 'METERING') selected @endif>
                                    {{ translateKeyword('METERING') }}</option>
                                <option value="FIXED" @if ($service->calculator == 'FIXED') selected @endif>
                                    {{ translateKeyword('FIXED') }}
                                </option>
                                <option value="HOUR" @if ($service->calculator == 'HOUR') selected @endif>
                                    {{ translateKeyword('HOUR') }}
                                </option>

                                <option value="DISTANCE" @if ($service->calculator == 'DISTANCE') selected @endif>
                                    {{ translateKeyword('DISTANCE') }}
                                </option>
                                <option value="DISTANCETIER" @if ($service->calculator == 'DISTANCETIER') selected @endif>
                                    {{ translateKeyword('DISTANCETIER') }}
                                </option>

                                <option value="DISTANCEMIN" @if ($service->calculator == 'DISTANCEMIN') selected @endif>
                                    {{ translateKeyword('DISTANCEMIN') }}</option>

                                <option value="DISTANCEHOUR" @if ($service->calculator == 'DISTANCEHOUR') selected @endif>
                                    {{ translateKeyword('DISTANCEHOUR') }}</option>
                                <option value="DISTANCEWEIGHT" @if ($service->calculator == 'DISTANCEWEIGHT') selected @endif>
                                    {{ translateKeyword('DISTANCEWEIGHT') }}</option>


                            </select>

                        </div>

                    </div>
                    <div id="calculation_block">
                        <div class="form-group row" id="locked_pricing_field">
                            <div class="col-xs-12 col-form-label">
                                <label for="UPI_key" class="col-form-label">
                                    {{ translateKeyword('Lock estimated pricing') }}
                                </label>
                            </div>
                            <div class="col-xs-10">
                                <input name="locked_pricing" @if ($service->locked_pricing == 1) checked @endif
                                    id="locked_pricing" type="checkbox" class="js-switch" data-color="#43b968">
                            </div>

                        </div>
                        @if (Setting::get('free_ride') == 1)
                            <div class="form-group row" id="is_free_field">
                                <div class="col-xs-12 col-form-label">
                                    <label for="UPI_key" class="col-form-label">
                                        {{ translateKeyword('Free Service') }}
                                    </label>
                                </div>
                                <div class="col-xs-10">
                                    <input name="is_free" id="is_free" type="checkbox" class="js-switch"
                                        @if ($service->is_free == 1) checked @endif data-color="#43b968">
                                </div>

                            </div>
                        @endif

                        @if (Setting::get('return_trip') == 1)
                            <div class="form-group row" id="is_free_field">
                                <div class="col-xs-12 col-form-label">
                                    <label for="return_trip" class="col-form-label">
                                        {{ translateKeyword('Return Trip') }}
                                    </label>
                                </div>
                                <div class="col-xs-10">
                                    <input name="is_return_trip" id="is_return_trip" type="checkbox" class="js-switch"
                                        @if ($service->is_return_trip == 1) checked @endif data-color="#43b968">
                                </div>

                            </div>
                        @endif


                        @if (Setting::get('booking_fee', 0) == 1 && Setting::get('booking_fee_category', 'global') == 'service')
                            {{-- <div class="form-group row">
                                <label for="booking_fee_type" class="col-xs-12 col-form-label">Booking Fee Type</label>
                                <div class="col-xs-10">
                                    <select name="booking_fee_type" class="form-control">
                                        <option @if ($service->booking_fee_type == 'fixed') selected
                                                @endif  value="fixed"> Fixed
                                        </option>
                                        <option @if ($service->booking_fee_type == 'percentage') selected
                                                @endif  value="percentage"> Percentage
                                        </option>
                                    </select>
                                </div>
                            </div> --}}
                            <div class="form-group row">
                                <label for="" class="col-xs-12 col-form-label">
                                    {{ translateKeyword('booking-fee') }} ({{ currencySymbol('') }})</label>
                                <div class="col-xs-10">
                                    <input class="form-control" type="number" step="any"
                                        value="{{ $service->booking_fee_amount }}" name="booking_fee_amount"
                                        id="booking_fee_amount" min="0" placeholder="Fee Amount" value="0"
                                        required>
                                </div>
                            </div>
                        @endif

                        @if (Setting::get('service_time_duration') == 1)
                            <div class="form-group row">

                                <label for="fixed"
                                    class="col-xs-12 col-form-label">{{ translateKeyword('service-time-duration') }}</label>

                                <div class="col-xs-10">

                                    <input class="form-control" type="number" step="any"
                                        value="{{ $service->service_time_duration }}" name="service_time_duration"
                                        required id="service_time_duration"
                                        placeholder="{{ translateKeyword('Enter minutes') }}">
                                </div>

                            </div>
                        @endif

                        <div class="form-group row">

                            <label for="fixed" class="col-xs-12 col-form-label"><label
                                    id="base_label">{{ translateKeyword('Base') }}</label>
                                {{ translateKeyword('price') }} ({{ currencySymbol('') }})</label>

                            <div class="col-xs-10">

                                <input class="form-control" type="text" step="any" value="{{ $service->fixed }}"
                                    name="fixed"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    required id="fixed" placeholder="{{ translateKeyword('Base_Price') }}">

                            </div>

                        </div>


                        <div class="form-group row" id="base_distance"
                            @if ($service->calculator == 'FIXED') style="display: none;" @endif>

                            <label for="distance"
                                class="col-xs-12 col-form-label">{{ translateKeyword('Base_Distance') }}
                                (0 @if (Setting::get('distance_system') === 'metric')
                                    KM
                                @else
                                    {{ translateKeyword('Miles') }}
                                @endif)</label>

                            <div class="col-xs-10">

                                <input class="form-control" type="text"
                                    value="{{ $service->distance ? $service->distance : 0 }}" name="distance"
                                    id="distance" placeholder="{{ translateKeyword('Base_Distance') }}" min="0">

                            </div>

                        </div>

                        <div class="form-group row" id="unit_time_pricing"
                            @if ($service->calculator == 'FIXED') style="display: none;" @endif>

                            <label for="distance"
                                class="col-xs-12 col-form-label">{{ translateKeyword('Unit Time Pricing (Min/Hours)') }}</label>

                            <div class="col-xs-10">

                                <input class="form-control" type="text" name="minute"
                                    value="{{ $service->minute ? $service->minute : 0 }}" min="0"
                                    placeholder="{{ translateKeyword('Unit Time Pricing (Min/Hours)') }}">

                            </div>

                        </div>
                        <div class="form-group row" id="unit_weight_pricing">

                            <label for="distance"
                                class="col-xs-12 col-form-label">{{ translateKeyword('Unit Weight Pricing (Per Kg)') }}</label>

                            <div class="col-xs-10">

                                <input class="form-control" type="text" name="weight"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    value="{{ $service->weight ? $service->weight : 0 }}" min="0"
                                    placeholder="{{ translateKeyword('Unit Weight Pricing (Per Kg)') }}">

                            </div>

                        </div>

                        @if (Setting::get('commission_tax_apply', 'global') == 'service')
                            <div class="form-group row">
                                <label for="commission_type"
                                    class="col-xs-12 col-form-label">{{ translateKeyword('commission-type') }}</label>
                                <div class="col-xs-10">
                                    <select name="commission_type" class="form-control" required>
                                        <option @if ($service->commission_type == 'fixed') selected @endif value="fixed">
                                            {{ translateKeyword('fixed') }}
                                        </option>
                                        <option @if ($service->commission_type == 'percentage') selected @endif value="percentage">
                                            {{ translateKeyword('percentage') }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="commission_percentage"
                                    class="col-xs-12 col-form-label">{{ translateKeyword('commission-percentage(%)/fixed') }}</label>
                                <div class="col-xs-10">
                                    <input class="form-control" type="text" id="commission_percentage"
                                        name="commission_percentage" min="0"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                        value="{{ $service->commission_percentage }}" max="100"
                                        placeholder="{{ translateKeyword('commission-percentage(%)/fixed') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tax_percentage"
                                    class="col-xs-12 col-form-label">{{ translateKeyword('tax_percentage') }}</label>
                                <div class="col-xs-10">
                                    <input class="form-control" type="text" id="tax_percentage"
                                        value="{{ $service->tax_percentage }}"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                        name="tax_percentage" min="0" max="100"
                                        placeholder="{{ translateKeyword('tax_percentage') }}">
                                </div>
                            </div>
                        @endif
                        <div class="form-group row" id="pricing_structure"
                            @if ($service->calculator == 'FIXED') style="display: none;" @endif>

                            <label class="col-xs-12 col-form-label">{{ translateKeyword('Pricing Structure') }}</label>

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
                                            <td><input class="form-control" type="text"
                                                    value="{{ $service->apply_after_1 }}" min="0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    name="apply_after_1"
                                                    placeholder="{{ translateKeyword('Apply After') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                            </td>
                                            <td><input class="form-control" type="text" value="{{ $service->price }}"
                                                    name="price"
                                                    placeholder=">{{ translateKeyword('Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric')
KM
@else
{{ translateKeyword('Miles') }}
@endif)">
                                            </td>
                                            <td class="roun_trip_cls"><input class="form-control" type="text"
                                                    value="{{ $service->return_trip_price_1 }}"
                                                    name="return_trip_price_1"
                                                    placeholder="{{ translateKeyword('Return Trip Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><input class="form-control" type="text"
                                                    value="{{ $service->apply_after_2 }}" min="0"
                                                    name="apply_after_2"
                                                    placeholder="{{ translateKeyword('Apply After') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                            </td>
                                            <td><input class="form-control" type="text"
                                                    value="{{ $service->after_2_price }}" name="after_2_price"
                                                    placeholder=">{{ translateKeyword('Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric')
KM
@else
{{ translateKeyword('Miles') }}
@endif)">
                                            </td>
                                            <td class="roun_trip_cls"><input class="form-control" type="text"
                                                    value="{{ $service->return_trip_price_2 }}"
                                                    name="return_trip_price_2"
                                                    placeholder="{{ translateKeyword('Return Trip Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><input class="form-control" type="text"
                                                    value="{{ $service->apply_after_3 }}" min="0"
                                                    name="apply_after_3"
                                                    placeholder="{{ translateKeyword('Apply After') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                            </td>
                                            <td><input class="form-control" type="text"
                                                    value="{{ $service->after_3_price }}" name="after_3_price"
                                                    placeholder=">{{ translateKeyword('Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric')
KM
@else
{{ translateKeyword('Miles') }}
@endif)">
                                            </td>
                                            <td class="roun_trip_cls"><input class="form-control" type="text"
                                                    value="{{ $service->return_trip_price_3 }}"
                                                    name="return_trip_price_3"
                                                    placeholder="{{ translateKeyword('Return Trip Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><input class="form-control" type="text"
                                                    value="{{ $service->apply_after_4 }}" min="0"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                    name="apply_after_4"
                                                    placeholder="{{ translateKeyword('Apply After') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                            </td>
                                            <td><input class="form-control" type="text"
                                                    value="{{ $service->after_4_price }}" name="after_4_price"
                                                    placeholder=">{{ translateKeyword('Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric')
KM
@else
{{ translateKeyword('Miles') }}
@endif)">
                                            </td>
                                            <td class="roun_trip_cls"><input class="form-control" type="text"
                                                    value="{{ $service->return_trip_price_4 }}"
                                                    name="return_trip_price_4"
                                                    placeholder="{{ translateKeyword('Return Trip Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div id="peak_fields">
                            <div class="form-group row">

                                <label for="peak_days"
                                    class="col-xs-1 col-form-label">{{ translateKeyword('Peak Days') }}</label>

                                <div class="col-xs-6">
                                    <div class="form-check form-check-inline">
                                        <input name="peak_monday" class="form-check-input" type="checkbox"
                                            @if ($service->peak_monday == 1) checked value="1" @else value="0" @endif
                                            id="inlineCheckbox1">
                                        <label class="form-check-label"
                                            for="inlineCheckbox1">{{ translateKeyword('Monday') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name="peak_tuesday" class="form-check-input" type="checkbox"
                                            @if ($service->peak_tuesday == 1) checked value="1" @else value="0" @endif
                                            id="inlineCheckbox1">
                                        <label class="form-check-label"
                                            for="inlineCheckbox1">{{ translateKeyword('Tuesday') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name="peak_wednesday" class="form-check-input" type="checkbox"
                                            @if ($service->peak_wednesday == 1) checked value="1" @else value="0" @endif
                                            id="inlineCheckbox1">
                                        <label class="form-check-label"
                                            for="inlineCheckbox1">{{ translateKeyword('Wednesday') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name="peak_thursday" class="form-check-input" type="checkbox"
                                            @if ($service->peak_thursday == 1) checked value="1" @else value="0" @endif
                                            id="inlineCheckbox1">
                                        <label class="form-check-label"
                                            for="inlineCheckbox1">{{ translateKeyword('Thursday') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name="peak_friday" class="form-check-input" type="checkbox"
                                            @if ($service->peak_friday == 1) checked value="1" @else value="0" @endif
                                            id="inlineCheckbox1">
                                        <label class="form-check-label"
                                            for="inlineCheckbox1">{{ translateKeyword('Friday') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name="peak_saturday" class="form-check-input" type="checkbox"
                                            @if ($service->peak_saturday == 1) checked value="1" @else value="0" @endif
                                            id="inlineCheckbox1">
                                        <label class="form-check-label"
                                            for="inlineCheckbox1">{{ translateKeyword('Saturday') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name="peak_sunday" class="form-check-input" type="checkbox"
                                            @if ($service->peak_sunday == 1) checked value="1" @else value="0" @endif
                                            id="inlineCheckbox1">
                                        <label class="form-check-label"
                                            for="inlineCheckbox1">{{ translateKeyword('Sunday') }}</label>
                                    </div>

                                </div>

                            </div>


                            <div class="form-group row" @if ($service->calculator == 'FIXED') style="display: none;" @endif>

                                <div class="col-12 p-0 m-0 mb-2 " style="font-size: 16px">
                                    <label for="UPI_key" class="col-xs-2 col-form-label">
                                        {{ translateKeyword('Peak Price One') }}
                                    </label>
                                    <input name="peak1" id="peak" data-id="peak1" type="checkbox"
                                        class="js-switch" data-color="#43b968"
                                        @if ($service->peak1 == 1) checked @endif>
                                </div>

                                <div class="col-12 p-0 m-0 mb-2 peak1">
                                    <label for="phourfrom"
                                        class="col-xs-5 col-form-label">{{ translateKeyword('Peak Hour(From)') }}</label>

                                    <label for="phourto"
                                        class="col-xs-5 col-form-label">{{ translateKeyword('Peak Hour(To)') }}</label>

                                    <div class="col-xs-5">

                                        <input class="form-control" type="time" name="phourfrom" id="phourfrom"
                                            value="{{ $service->phourfrom }}">

                                    </div>

                                    <div class="col-xs-5">

                                        <input class="form-control" type="time" name="phourto" id="phourto"
                                            value="{{ $service->phourto }}">

                                    </div>
                                </div>

                                <div class="col-12 p-0 m-0 mb-2 ">
                                    <label for="UPI_key" class="col-xs-2 col-form-label" style="font-size: 16px">
                                        {{ translateKeyword('Peak Price Two') }}
                                    </label>
                                    <input name="peak2" id="peak" data-id="peak2"
                                        @if ($service->peak2 == 1) checked @endif type="checkbox"
                                        class="js-switch" data-color="#43b968">
                                </div>

                                <div class="col-12 p-0 m-0 mb-2 peak2">
                                    <label for="phourfrom"
                                        class="col-xs-5 col-form-label">{{ translateKeyword('Peak Hour(From)') }}</label>

                                    <label for="phourto"
                                        class="col-xs-5 col-form-label">{{ translateKeyword('Peak Hour(To)') }}</label>

                                    <div class="col-xs-5">

                                        <input class="form-control" type="time" name="phourfromone" id="phourfromone"
                                            value="{{ $service->phourfromone }}">

                                    </div>

                                    <div class="col-xs-5">

                                        <input class="form-control" type="time" name="phourtoone" id="phourtoone"
                                            value="{{ $service->phourtoone }}">

                                    </div>
                                </div>

                                <div class="col-12 p-0 m-0 mb-2 ">
                                    <label for="UPI_key" class="col-xs-2 col-form-label" style="font-size: 16px">
                                        {{ translateKeyword('Peak Price Three') }}
                                    </label>
                                    <input name="peak3" id="peak" data-id="peak3"
                                        @if ($service->peak3 == 1) checked @endif type="checkbox"
                                        class="js-switch" data-color="#43b968">
                                </div>

                                <div class="col-12 p-0 m-0 mb-2 peak3">
                                    <label for="phourfrom"
                                        class="col-xs-5 col-form-label">{{ translateKeyword('Peak Hour(From)') }}</label>

                                    <label for="phourtotwo"
                                        class="col-xs-5 col-form-label">{{ translateKeyword('Peak Hour(To)') }}</label>

                                    <div class="col-xs-5">

                                        <input class="form-control" type="time" name="phourfromtwo" id="phourfromtwo"
                                            value="{{ $service->phourfromtwo }}">

                                    </div>

                                    <div class="col-xs-5">

                                        <input class="form-control" type="time" name="phourtotwo" id="phourtotwo"
                                            value="{{ $service->phourtotwo }}">

                                    </div>
                                </div>

                                <label for="peak_percentage" class="col-xs-12 col-form-label">
                                    {{ translateKeyword('Peak percentage') }}
                                </label>
                                <div class="col-xs-10">
                                    <input name="peak_percentage" @if ($service->peak_percentage == 1) checked @endif
                                        data-id="peak_percentage_container" id="peak_percentage" type="checkbox"
                                        class="js-switch" data-color="#43b968">
                                </div>


                                <div class="peak_percentage_container row" style="margin-left: 3px">
                                    <label for="pextra"
                                        class="col-xs-10 col-form-label">{{ translateKeyword('Peak Hour Extra Price(in %)') }}</label>

                                    <div class="col-xs-10">

                                        <input class="form-control" type="text"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            value="{{ $service->pextra }}" name="pextra" id="pextra"
                                            placeholder="In Percentage">

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group row" id="peak_pricing_structure">
                            <label for="peak_fixed_pricing" class="col-xs-5 col-form-label">
                                {{ translateKeyword('Peak fixed pricing') }}
                            </label>
                            <div class="col-xs-10">
                                <input name="peak_fixed_pricing"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    @if ($service->peak_fixed_pricing == 1) checked @endif id="peak_fixed_pricing"
                                    data-id="peak_fixed_pricing_container" type="checkbox" class="js-switch"
                                    data-color="#43b968">
                            </div>

                            <div class="peak_fixed_pricing_container row" style="margin-left: 3px">
                                <label for="pextra"
                                    class="col-xs-5 col-form-label">{{ translateKeyword('Peak Hour Fixed Price') }}</label>

                                <div class="col-xs-10">

                                    <input class="form-control" type="text"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                        value="{{ $service->pefixed }}" name="pefixed" id="pefixed"
                                        placeholder="In Percentage">

                                </div>
                            </div>


                            <label for="peak_percentage" class="col-xs-12 col-form-label">
                                {{ translateKeyword('Peak Pricing Structure') }}
                            </label>
                            <div class="col-xs-10">
                                <input name="peak_pricing_structure_switch"
                                    @if ($service->peak_pricing_structure_switch == 1) checked @endif
                                    data-id="peak_pricing_structure_container" id="peak_pricing_structure_switch"
                                    type="checkbox" class="js-switch" data-color="#43b968">
                            </div>
                            <div class="peak_pricing_structure_container">
                                <div class="pricing_strucuture">
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
                                                    <td><input class="form-control" type="text"
                                                            value="{{ $service->peak_apply_after_1 }}" min="0"
                                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                            name="peak_apply_after_1"
                                                            placeholder="{{ translateKeyword('Apply After') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                                    </td>
                                                    <td><input class="form-control" type="text"
                                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                            value="{{ $service->peak_after_1_price }}"
                                                            name="peak_after_1_price"
                                                            placeholder="{{ translateKeyword('Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                                    </td>
                                                    <td class="roun_trip_cls"><input class="form-control" type="text"
                                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                            value="{{ $service->peak_return_trip_price_1 }}"
                                                            name="peak_return_trip_price_1"
                                                            placeholder="{{ translateKeyword('Return Trip Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><input class="form-control" type="text"
                                                            value="{{ $service->peak_apply_after_2 }}" min="0"
                                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                            name="peak_apply_after_2"
                                                            placeholder="{{ translateKeyword('Apply After') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                                    </td>
                                                    <td><input class="form-control" type="text"
                                                            value="{{ $service->peak_after_2_price }}"
                                                            name="peak_after_2_price"
                                                            placeholder="{{ translateKeyword('Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                                    </td>
                                                    <td class="roun_trip_cls"><input class="form-control" type="text"
                                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                            value="{{ $service->peak_return_trip_price_2 }}"
                                                            name="peak_return_trip_price_2"
                                                            placeholder="{{ translateKeyword('Return Trip Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><input class="form-control" type="text"
                                                            value="{{ $service->peak_apply_after_3 }}" min="0"
                                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                            name="peak_apply_after_3"
                                                            placeholder="{{ translateKeyword('Apply After') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                                    </td>
                                                    <td><input class="form-control" type="text"
                                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                            value="{{ $service->peak_after_3_price }}"
                                                            name="peak_after_3_price"
                                                            placeholder="{{ translateKeyword('Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                                    </td>
                                                    <td class="roun_trip_cls"><input class="form-control" type="text"
                                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                            value="{{ $service->peak_return_trip_price_3 }}"
                                                            name="peak_return_trip_price_3"
                                                            placeholder="{{ translateKeyword('Return Trip Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><input class="form-control" type="text"
                                                            value="{{ $service->peak_apply_after_4 }}" min="0"
                                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                            name="peak_apply_after_4"
                                                            placeholder="{{ translateKeyword('Apply After') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                                    </td>
                                                    <td><input class="form-control" type="text"
                                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                                            value="{{ $service->peak_after_4_price }}"
                                                            name="peak_after_4_price"
                                                            placeholder="{{ translateKeyword('Unit Distance Pricing') }}(@if (Setting::get('distance_system') === 'metric') KM @else {{ translateKeyword('Miles') }} @endif)">
                                                    </td>
                                                    <td class="roun_trip_cls"><input class="form-control" type="text"
                                                            value="{{ $service->peak_return_trip_price_4 }}"
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
                    </div>

                    <div class="form-group row">

                        <label for="capacity"
                            class="col-xs-12 col-form-label">{{ translateKeyword('Seat_Capacity') }}</label>

                        <div class="col-xs-10">

                            <input class="form-control" type="number" step="any" value="{{ $service->capacity }}"
                                name="capacity" required id="capacity"
                                placeholder="{{ translateKeyword('Seat_Capacity') }}" min="0">

                        </div>

                    </div>


                    <div class="form-group row">

                        <label for="type"
                            class="col-xs-12 col-form-label">{{ translateKeyword('service_type') }}</label>

                        <div class="col-xs-10">

                            <select class="form-control" id="type" name="type">

                                @foreach ($types as $type)
                                    <option value="{{ $type['value'] }}"
                                        @if ($service->type == $type['value']) selected @endif>
                                        @lang($type['language'])
                                    </option>
                                @endforeach
                            </select>


                        </div>

                    </div>

                    <div class="form-group row">

                        <div class="col-xs-12 col-sm-6 col-md-3">

                            <a href="{{ route('admin.service.index') }}"
                                class="btn btn-danger btn-block">{{ translateKeyword('cancel') }}</a>

                        </div>

                        <div class="col-xs-12 col-sm-6 offset-md-6 col-md-3">

                            <button type="submit"
                                class="btn btn-primary btn-block">{{ translateKeyword('Update_Service_Type') }}</button>

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
            const peak1 = "{{ $service->peak1 }}";
            const peak2 = "{{ $service->peak2 }}";
            const peak3 = "{{ $service->peak3 }}";

            if (peak1 == 0) {
                $(`.peak1`).fadeOut(800);
            }
            if (peak2 == 0) {
                $(`.peak2`).fadeOut(800);
            }
            if (peak3 == 0) {
                $(`.peak3`).fadeOut(800);
            }

            $('body').delegate('#peak', 'change', function() {
                const div = $(this).attr('data-id');
                console.log($(this).is(':checked'));
                if ($(this).is(':checked')) {
                    $(`.${div}`).fadeIn(800);
                } else {
                    $(`.${div}`).fadeOut(800);
                }

            });

            const peak_pricing_structure_switch = "{{ $service->peak_pricing_structure_switch }}";

            if (peak_pricing_structure_switch == 0) {
                $(`.peak_pricing_structure_container`).fadeOut(800);
            }

            $('body').delegate('#peak_pricing_structure_switch', 'change', function() {
                const div = $(this).attr('data-id');
                console.log($(this).is(':checked'));
                peak_pricing_structure_select()
                if ($(this).is(':checked')) {
                    $(`.${div}`).fadeIn(800);
                } else {
                    $(`.${div}`).fadeOut(800);
                }

            });

            $('body').delegate('#peak_percentage', 'change', function() {
                const div = $(this).attr('data-id');
                console.log($(this).is(':checked'));
                peak_percentage_select()
                if ($(this).is(':checked')) {
                    $(`.${div}`).fadeIn(800);
                } else {
                    $(`.${div}`).fadeOut(800);
                }

            });

            $('body').delegate('#peak_fixed_pricing', 'change', function() {
                const div = $(this).attr('data-id');
                console.log($(this).is(':checked'));
                peak_fixed_select()
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
                    $("#base_distance").fadeIn(800);
                    $("#unit_time_pricing").fadeOut(800);
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
            $(".roun_trip_cls").fadeOut(800);
            // $("#base_distance").hide();
            $("#calculation_block").hide();
            $("#unit_time_pricing").hide();
            $("#unit_weight_pricing").hide();
            $("#pricing_structure").hide();
            $('#peak_fields').hide();
            $('#peak_pricing_structure').hide();
            selectPricingType();
        });

        function peak_percentage_select() {
            if ($('#peak_percentage').is(":checked")) {
                if ($('#peak_fixed_pricing').is(":checked")) {
                    $('#peak_fixed_pricing').click();
                }
                if ($('#peak_pricing_structure_switch').is(":checked")) {
                    $('#peak_pricing_structure_switch').click()
                }
            }
        }

        function peak_pricing_structure_select() {
            if ($('#peak_pricing_structure_switch').is(":checked")) {
                if ($('#peak_fixed_pricing').is(":checked")) {
                    $('#peak_fixed_pricing').click();
                }
                if ($('#peak_percentage').is(":checked")) {
                    $('#peak_percentage').click();
                }
            }
        }

        function peak_fixed_select() {
            if ($('#peak_fixed_pricing').is(":checked")) {
                if ($('#peak_percentage').is(":checked")) {
                    $('#peak_percentage').click();
                }
                if ($('#peak_pricing_structure_switch').is(":checked")) {
                    $('#peak_pricing_structure_switch').click()
                }
            }
        }
    </script>
@endsection

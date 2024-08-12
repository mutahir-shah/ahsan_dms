@extends('admin.layout.base')
@extends('admin.layout.base2')


@section('title', 'Update Zone Service Pricing ')



@section('content')

    <div class="content-wrapper">

        <div class="container-fluid">

            <div class="box box-block bg-white">

                <a href="{{ route('admin.service.index') }}" class="btn btn-default pull-right"><i
                            class="fa fa-angle-left"></i> Back</a>


                <h5 style="margin-bottom: 2em;">Update Zone Service Pricing</h5>
                @include('common.notify')


                <form class="form-horizontal" action="{{ route('admin.zone-service.update', $service->id) }}"
                      method="POST"
                      enctype="multipart/form-data" role="form">

                    {{ csrf_field() }}


                    <input type="hidden" name="_method" value="PATCH">

                    <div class="form-group row">

                        <label for="name" class="col-xs-2 col-form-label">Service Name</label>

                        <div class="col-xs-10">

                            <input class="form-control" type="text" value="{{ $service->name }}" name="name" required
                                   id="name" placeholder="Service Name">

                        </div>

                    </div>


                    <div class="form-group row">


                        <label for="image" class="col-xs-2 col-form-label">Picture</label>

                        <div class="col-xs-10">

                            @if (isset($service->image))
                                <img style="height: 90px; margin-bottom: 15px; border-radius:2em;"
                                     src="{{ $service->image }}">
                            @endif

                            <input type="file" accept="image/*" name="image" class="dropify form-control-file"
                                   id="image" aria-describedby="fileHelp">

                        </div>

                    </div>


                    <div class="form-group row">

                        <label for="picture" class="col-xs-2 col-form-label">Map Icon(40p x 40px)</label>

                        <div class="col-xs-10">
                            @if (isset($service->map_icon))
                                <img style="height: 90px; margin-bottom: 15px; border-radius:2em;"
                                     src="{{ $service->map_icon }}">
                            @endif
                            <input type="file" accept="image/*" name="map_icon" class="dropify form-control-file"
                                   id="picture" aria-describedby="fileHelp">

                        </div>

                    </div>

                    <div class="form-group row">

                        <label for="calculator" class="col-xs-2 col-form-label">Pricing Logic</label>

                        <div class="col-xs-10">

                            <select class="form-control" id="calculator" name="calculator"
                                    onchange="selectPricingType()">

                                <option value="MIN"
                                        @if ($service->calculator == 'MIN') selected @endif>{{ translateKeyword('MIN') }}
                                </option>
                                <option value="FIXED"
                                        @if ($service->calculator == 'FIXED') selected @endif>{{ translateKeyword('FIXED') }}
                                </option>
                                <option value="HOUR"
                                        @if ($service->calculator == 'HOUR') selected @endif>{{ translateKeyword('HOUR') }}
                                </option>

                                <option value="DISTANCE"
                                        @if ($service->calculator == 'DISTANCE') selected @endif>{{ translateKeyword('servicetypes.DISTANCE') }}
                                </option>
                                <option value="DISTANCETIER"
                                        @if ($service->calculator == 'DISTANCETIER') selected @endif>
                                    {{ translateKeyword('DISTANCETIER') }}
                                </option>

                                <option value="DISTANCEMIN" @if ($service->calculator == 'DISTANCEMIN') selected @endif>
                                    {{ translateKeyword('DISTANCEMIN') }}</option>

                                <option value="DISTANCEHOUR"
                                        @if ($service->calculator == 'DISTANCEHOUR') selected @endif>
                                    {{ translateKeyword('DISTANCEHOUR') }}</option>

                                <option value="DISTANCEWEIGHT"
                                        @if ($service->calculator == 'DISTANCEWEIGHT') selected @endif>
                                        {{ translateKeyword('DISTANCEWEIGHT') }}</option>


                            </select>

                        </div>

                    </div>
                    <div class="form-group row">
                        <div class="col-xs-2 col-form-label">
                            <label for="UPI_key" class="col-form-label">
                                Lock estimated pricing
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
                                Free Service
                            </label>
                        </div>
                        <div class="col-xs-10">
                            <input name="is_free" id="is_free" type="checkbox" class="js-switch" @if ($service->is_free == 1) checked @endif
                                   data-color="#43b968">
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
                                    Booking Fee ({{ currencySymbol('')}})</label>
                                <div class="col-xs-10">
                                    <input class="form-control" type="number" step="any"
                                           value="{{ $service->booking_fee_amount }}"
                                           name="booking_fee_amount" id="booking_fee_amount" min="0"
                                           placeholder="Fee Amount" value="0" required>
                                </div>
                            </div>
                        @endif
                    <div class="form-group row">

                        <label for="fixed" class="col-xs-2 col-form-label">Base Price ({{ currency('') }})</label>

                        <div class="col-xs-10">

                            <input class="form-control" type="text" value="{{ $service->fixed }}" name="fixed" required
                                   id="fixed" placeholder="Base Price">

                        </div>

                    </div>


                    <div class="form-group row" id="base_distance"
                         @if ($service->calculator == 'FIXED') style="display: none;" @endif>

                        <label for="distance" class="col-xs-2 col-form-label">Base Distance
                            (0 @if (Setting::get('distance_system') === 'metric')
                                KM
                            @else
                                Miles
                            @endif )</label>

                        <div class="col-xs-10">

                            <input class="form-control" type="text"
                                   value="{{ $service->distance ? $service->distance : 0 }}" name="distance"
                                   id="distance"
                                   placeholder="Base Distance" min="0">

                        </div>

                    </div>

                    <div class="form-group row" id="unit_time_pricing"
                         @if ($service->calculator == 'FIXED') style="display: none;" @endif>

                        <label for="distance" class="col-xs-2 col-form-label">Unit Time Pricing (Min/Hours)</label>

                        <div class="col-xs-10">

                            <input class="form-control" type="text" name="minute"
                                   value="{{ $service->minute ? $service->minute : 0 }}" min="0"
                                   placeholder="Unit Time Pricing(Hour/Min)">

                        </div>

                    </div>
                    <div class="form-group row" id="unit_weight_pricing">

                        <label for="distance" class="col-xs-12 col-form-label">Unit Weight Pricing (Per Kg)</label>

                        <div class="col-xs-10">

                            <input class="form-control" type="text" name="weight"
                                   value="{{ $service->weight ? $service->weight : 0 }}"
                                   min="0" placeholder="Unit Weight Pricing (Per Kg)">

                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="commission_type" class="col-xs-2 col-form-label">Commission Type</label>
                        <div class="col-xs-10">
                            <select name="commission_type" class="form-control" required>
                                <option @if ($service->commission_type == 'fixed') selected @endif value="fixed"> Fixed
                                </option>
                                <option @if ($service->commission_type == 'percentage') selected
                                        @endif value="percentage"> Percentage
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="commission_percentage" class="col-xs-2 col-form-label">Commission
                            percentage(%)/Fixed</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="number"
                                   id="commission_percentage" name="commission_percentage" min="0"
                                   value="{{ $service->commission_percentage }}"
                                   max="100" placeholder="Commission percentage/fixed">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tax_percentage" class="col-xs-2 col-form-label">Tax percentage(%)</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" id="tax_percentage"
                                   value="{{ $service->tax_percentage }}"
                                   name="tax_percentage" min="0" max="100"
                                   placeholder="Tax Percentage">
                        </div>
                    </div>
                    <div class="form-group row" id="pricing_structure"
                         @if ($service->calculator == 'FIXED') style="display: none;" @endif>

                        <label class="col-xs-12 col-form-label">Pricing Structure</label>

                        <div class="col-xs-10">

                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Apply After( @if (Setting::get('distance_system') === 'metric')
                                            KM
                                        @else
                                            Miles
                                        @endif )</th>
                                    <th scope="col">Unit Distance Pricing
                                        ( @if (Setting::get('distance_system') === 'metric')
                                            KM
                                        @else
                                            Miles
                                        @endif )</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><input class="form-control" type="number"
                                               value="{{ $service->apply_after_1 }}" min="0"
                                               name="apply_after_1"
                                               placeholder="Apply After( @if (Setting::get('distance_system') === 'metric') KM @else Miles @endif )">
                                    </td>
                                    <td><input class="form-control" type="text" value="{{ $service->price }}"
                                               name="price"
                                               placeholder="Unit Time Pricing( @if (Setting::get('distance_system') === 'metric') KM @else Miles @endif )">
                                    </td>
                                </tr>
                                <tr>
                                    <td><input class="form-control" type="number"
                                               value="{{ $service->apply_after_2 }}" min="0"
                                               name="apply_after_2"
                                               placeholder="Apply After( @if (Setting::get('distance_system') === 'metric') KM @else Miles @endif )">
                                    </td>
                                    <td><input class="form-control" type="text"
                                               value="{{ $service->after_2_price }}" name="after_2_price"
                                               placeholder="Unit Time Pricing( @if (Setting::get('distance_system') === 'metric') KM @else Miles @endif )">
                                    </td>
                                </tr>
                                <tr>
                                    <td><input class="form-control" type="number"
                                               value="{{ $service->apply_after_3 }}" min="0"
                                               name="apply_after_3"
                                               placeholder="Apply After( @if (Setting::get('distance_system') === 'metric') KM @else Miles @endif )">
                                    </td>
                                    <td><input class="form-control" type="text"
                                               value="{{ $service->after_3_price }}" name="after_3_price"
                                               placeholder="Unit Time Pricing( @if (Setting::get('distance_system') === 'metric') KM @else Miles @endif )">
                                    </td>
                                </tr>
                                <tr>
                                    <td><input class="form-control" type="number"
                                               value="{{ $service->apply_after_4 }}" min="0"
                                               name="apply_after_4"
                                               placeholder="Apply After( @if (Setting::get('distance_system') === 'metric') KM @else Miles @endif )">
                                    </td>
                                    <td><input class="form-control" type="text"
                                               value="{{ $service->after_4_price }}" name="after_4_price"
                                               placeholder="Unit Time Pricing( @if (Setting::get('distance_system') === 'metric') KM @else Miles @endif )">
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="form-group row">

                        <label for="peak_days" class="col-xs-1 col-form-label">Peak Days</label>

                        <div class="col-xs-6">
                            <div class="form-check form-check-inline">
                                <input name="peak_monday" class="form-check-input" type="checkbox"
                                       @if ($service->peak_monday == 1) checked value="1" @else value="0"
                                       @endif id="inlineCheckbox1">
                                <label class="form-check-label" for="inlineCheckbox1">Monday</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input name="peak_tuesday" class="form-check-input" type="checkbox"
                                       @if ($service->peak_tuesday == 1) checked value="1" @else value="0"
                                       @endif id="inlineCheckbox1">
                                <label class="form-check-label" for="inlineCheckbox1">Tuesday</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input name="peak_wednesday" class="form-check-input" type="checkbox"
                                       @if ($service->peak_wednesday == 1) checked value="1" @else value="0"
                                       @endif id="inlineCheckbox1">
                                <label class="form-check-label" for="inlineCheckbox1">Wednesday</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input name="peak_thursday" class="form-check-input" type="checkbox"
                                       @if ($service->peak_thursday == 1) checked value="1" @else value="0"
                                       @endif id="inlineCheckbox1">
                                <label class="form-check-label" for="inlineCheckbox1">Thursday</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input name="peak_friday" class="form-check-input" type="checkbox"
                                       @if ($service->peak_friday == 1) checked value="1" @else value="0"
                                       @endif id="inlineCheckbox1">
                                <label class="form-check-label" for="inlineCheckbox1">Friday</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input name="peak_saturday" class="form-check-input" type="checkbox"
                                       @if ($service->peak_saturday == 1) checked value="1" @else value="0"
                                       @endif id="inlineCheckbox1">
                                <label class="form-check-label" for="inlineCheckbox1">Saturday</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input name="peak_sunday" class="form-check-input" type="checkbox"
                                       @if ($service->peak_sunday == 1) checked value="1" @else value="0"
                                       @endif id="inlineCheckbox1">
                                <label class="form-check-label" for="inlineCheckbox1">Sunday</label>
                            </div>

                        </div>

                    </div>


                    <div class="form-group row" id="peak_fields"
                         @if ($service->calculator == 'FIXED') style="display: none;" @endif>

                        <label for="phourfrom" class="col-xs-5 col-form-label">Peak Hour(From)</label>


                        <label for="phourto" class="col-xs-5 col-form-label">Peak Hour(To)</label>

                        <div class="col-xs-5">

                            <input class="form-control" type="time" value="{{ $service->phourfrom }}"
                                   name="phourfrom" id="phourfrom">

                        </div>

                        <div class="col-xs-5">

                            <input class="form-control" type="time" value="{{ $service->phourto }}" name="phourto"
                                   id="phourto">

                        </div>

                        <label for="peak_percentage" class="col-xs-12 col-form-label">
                            Peak percentage
                        </label>
                        <div class="col-xs-10">
                            <input name="peak_percentage" @if ($service->peak_percentage == 1) checked @endif
                            id="peak_percentage" type="checkbox" class="js-switch" data-color="#43b968">
                        </div>


                        <label for="pextra" class="col-xs-5 col-form-label">Peak Hour Extra Price(in %)</label>

                        <div class="col-xs-10">

                            <input class="form-control" type="number" value="{{ $service->pextra }}" name="pextra"
                                   id="pextra" placeholder="In Percentage">

                        </div>

                    </div>
                    <div class="form-group row" id="peak_pricing_structure">
                        <label for="peak_fixed_pricing" class="col-xs-5 col-form-label">
                            Peak fixed pricing
                        </label>
                        <div class="col-xs-10">
                            <input name="peak_fixed_pricing" @if ($service->peak_fixed_pricing == 1) checked @endif
                            id="peak_fixed_pricing" type="checkbox" class="js-switch" data-color="#43b968">
                        </div>
                        <label class="col-xs-12 col-form-label">Peak Pricing Structure</label>

                        <div class="col-xs-10">

                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Apply After( @if (Setting::get('distance_system') === 'metric')
                                            KM
                                        @else
                                            Miles
                                        @endif )</th>
                                    <th scope="col">Unit Distance Pricing
                                        ( @if (Setting::get('distance_system') === 'metric')
                                            KM
                                        @else
                                            Miles
                                        @endif )</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><input class="form-control" type="number"
                                               value="{{ $service->peak_apply_after_1 }}" min="0"
                                               name="peak_apply_after_1"
                                               placeholder="Apply After( @if (Setting::get('distance_system') === 'metric') KM @else Miles @endif )">
                                    </td>
                                    <td><input class="form-control" type="text"
                                               value="{{ $service->peak_after_1_price }}" name="peak_after_1_price"
                                               placeholder="Unit Time Pricing( @if (Setting::get('distance_system') === 'metric') KM @else Miles @endif )">
                                    </td>
                                </tr>
                                <tr>
                                    <td><input class="form-control" type="number"
                                               value="{{ $service->peak_apply_after_2 }}" min="0"
                                               name="peak_apply_after_2"
                                               placeholder="Apply After( @if (Setting::get('distance_system') === 'metric') KM @else Miles @endif )">
                                    </td>
                                    <td><input class="form-control" type="text"
                                               value="{{ $service->peak_after_2_price }}" name="peak_after_2_price"
                                               placeholder="Unit Time Pricing( @if (Setting::get('distance_system') === 'metric') KM @else Miles @endif )">
                                    </td>
                                </tr>
                                <tr>
                                    <td><input class="form-control" type="number"
                                               value="{{ $service->peak_apply_after_3 }}" min="0"
                                               name="peak_apply_after_3"
                                               placeholder="Apply After( @if (Setting::get('distance_system') === 'metric') KM @else Miles @endif )">
                                    </td>
                                    <td><input class="form-control" type="text"
                                               value="{{ $service->peak_after_3_price }}" name="peak_after_3_price"
                                               placeholder="Unit Time Pricing( @if (Setting::get('distance_system') === 'metric') KM @else Miles @endif )">
                                    </td>
                                </tr>
                                <tr>
                                    <td><input class="form-control" type="number"
                                               value="{{ $service->peak_apply_after_4 }}" min="0"
                                               name="peak_apply_after_4"
                                               placeholder="Apply After( @if (Setting::get('distance_system') === 'metric') KM @else Miles @endif )">
                                    </td>
                                    <td><input class="form-control" type="text"
                                               value="{{ $service->peak_after_4_price }}" name="peak_after_4_price"
                                               placeholder="Unit Time Pricing( @if (Setting::get('distance_system') === 'metric') KM @else Miles @endif )">
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>


                    <div class="form-group row">

                        <label for="capacity" class="col-xs-2 col-form-label">Seat Capacity</label>

                        <div class="col-xs-10">

                            <input class="form-control" type="number" value="{{ $service->capacity }}" name="capacity"
                                   required id="capacity" placeholder="Seat Capacity" min="0">

                        </div>

                    </div>


                    <div class="form-group row">

                        <label for="type" class="col-xs-2 col-form-label">Service Type</label>

                        <div class="col-xs-10">

                            <select class="form-control" id="type" name="type">
                                <option value="economy" @if ($service->type == 'economy') selected @endif>
                                    {{ translateKeyword('Transportation') }}</option>

                                <option value="luxury" @if ($service->type == 'luxury') selected @endif>
                                    {{ translateKeyword('Delivery') }}</option>

                                <option value="extra_seat" @if ($service->type == 'extra_seat') selected @endif>
                                    @lang('Truck')</option>

                                <option value="outstation" @if ($service->type == 'outstation') selected @endif>
                                    {{ translateKeyword('OutStation') }}</option>
                                <option value="road_assistance"
                                        @if ($service->type == 'road_assistance') selected @endif>
                                    {{ translateKeyword('road_assistance') }}</option>
                            </select>


                        </div>

                    </div>


                    <div class="form-group row">

                        <label for="description" class="col-xs-2 col-form-label">Description</label>

                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ $service->description }}"
                                   name="description" required id="description" placeholder="Description" rows="4">

                            <!-- <textarea class="form-control" type="text" value="{{ $service->description }}" name="description" required
                                id="description" placeholder="Description" rows="4"></textarea> -->

                        </div>

                    </div>


                    <div class="form-group row">

                        <div class="col-xs-12 col-sm-6 col-md-3">

                            <a href="{{ route('admin.service.index') }}" class="btn btn-danger btn-block">Cancel</a>

                        </div>

                        <div class="col-xs-12 col-sm-6 offset-md-6 col-md-3">

                            <button type="submit" class="btn btn-primary btn-block">Update Service Type</button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection
@section('scripts')
    <script type="text/javascript">
        function selectPricingType() {
            var pricing = $("#calculator").val();
            switch (pricing) {
                case 'MIN': {
                    $("#calculation_block").fadeIn(800);
                    $("#base_distance").fadeIn(800);
                    $("#unit_time_pricing").fadeIn(800);
                    $("#unit_weight_pricing").fadeOut(800);
                    $("#pricing_structure").fadeOut(800);
                    $('#peak_fields').fadeIn(800);
                    $('#peak_pricing_structure').fadeIn(800);
                }
                    break;
                case 'FIXED': {
                    $("#calculation_block").fadeIn(800);
                    $("#base_distance").fadeIn(800);
                    $("#unit_time_pricing").fadeIn(800);
                    $("#unit_weight_pricing").fadeOut(800);
                    $("#pricing_structure").fadeOut(800);
                    $('#peak_fields').fadeOut(800);
                    $('#peak_pricing_structure').fadeOut(800);
                }
                    break;
                case 'HOUR': {
                    $("#calculation_block").fadeIn(800);
                    $("#base_distance").fadeIn(800);
                    $("#unit_time_pricing").fadeIn(800);
                    $("#unit_weight_pricing").fadeOut(800);
                    $("#pricing_structure").fadeOut(800);
                    $('#peak_fields').fadeIn(800);
                    $('#peak_pricing_structure').fadeIn(800);
                }
                    break;
                case 'DISTANCE': {
                    $("#calculation_block").fadeIn(800);
                    $("#base_distance").fadeIn(800);
                    $("#unit_time_pricing").fadeIn(800);
                    $("#unit_weight_pricing").fadeOut(800);
                    $("#pricing_structure").fadeIn(800);
                    $('#peak_fields').fadeIn(800);
                    $('#peak_pricing_structure').fadeIn(800);
                }
                    break;
                case 'DISTANCETIER': {
                    $("#calculation_block").fadeIn(800);
                    $("#base_distance").fadeIn(800);
                    $("#unit_time_pricing").fadeIn(800);
                    $("#unit_weight_pricing").fadeOut(800);
                    $("#pricing_structure").fadeIn(800);
                    $('#peak_fields').fadeIn(800);
                    $('#peak_pricing_structure').fadeIn(800);
                }
                    break;
                case 'DISTANCEMIN': {
                    $("#calculation_block").fadeIn(800);
                    $("#base_distance").fadeIn(800);
                    $("#unit_time_pricing").fadeIn(800);
                    $("#unit_weight_pricing").fadeOut(800);
                    $("#pricing_structure").fadeIn(800);
                    $('#peak_fields').fadeIn(800);
                    $('#peak_pricing_structure').fadeIn(800);
                }
                    break;
                case 'DISTANCEHOUR': {
                    $("#calculation_block").fadeIn(800);
                    $("#base_distance").fadeIn(800);
                    $("#unit_time_pricing").fadeIn(800);
                    $("#unit_weight_pricing").fadeOut(800);
                    $("#pricing_structure").fadeIn(800);
                    $('#peak_fields').fadeIn(800);
                    $('#peak_pricing_structure').fadeIn(800);
                }
                    break;
                case 'DISTANCEWEIGHT': {
                    $("#calculation_block").fadeIn(800);
                    $("#calculation_block").fadeIn(800);
                    $("#base_distance").fadeIn(800);
                    $("#unit_weight_pricing").fadeIn(800);
                    $("#pricing_structure").fadeIn(800);
                    $('#peak_fields').fadeIn(800);
                    $('#peak_pricing_structure').fadeIn(800);
                }
                    break;
                default: {
                    $("#calculation_block").fadeIn(800);
                    $("#base_distance").fadeIn(800);
                    $("#unit_time_pricing").fadeIn(800);
                    $("#unit_weight_pricing").fadeOut(800);
                    $("#pricing_structure").fadeOut(800);
                    $('#peak_fields').fadeIn(800);
                    $('#peak_pricing_structure').fadeIn(800);
                }
            }
        }

        $(document).ready(function () {
            // $("#base_distance").hide();
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
            }
        }

        function peak_fixed_select() {
            if ($('#peak_fixed_pricing').is(":checked")) {
                if ($('#peak_percentage').is(":checked")) {
                    $('#peak_percentage').click();
                }
            }

        }
    </script>
@endsection

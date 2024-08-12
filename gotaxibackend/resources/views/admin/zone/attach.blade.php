@extends('admin.layout.base')
@extends('admin.layout.base2')


@section('title', 'Attach Service ')



@section('content')

    <div class="content-wrapper">

        <div class="container-fluid">

            <div class="box box-block bg-white">

                <a href="{{ route('admin.zone.index') }}" class="btn btn-default pull-right"><i
                            class="fa fa-angle-left"></i> {{ translateKeyword('back') }}</a>


                <h5 style="margin-bottom: 2em;">{{ translateKeyword('attach-service') }}</h5>
                @include('common.notify')


                <form class="form-horizontal" action="{{ route('admin.zone.attach.store') }}" method="POST"
                      enctype="multipart/form-data" role="form">

                    {{ csrf_field() }}


                    <div class="form-group row">
                        <input type="hidden" name="zone_id" value="{{ $zone_id }}"/>
                        <label for="provider_name" class="col-xs-12 col-form-label">{{ translateKeyword('Services')}} - ({{ translateKeyword('note:- s-m-o-p-C/C') }})</label>

                        <div class="col-xs-10">

                            <select name="services[]" multiple class="form-control">
                                <option value="">none</option>
                                <option value="all">{{ translateKeyword('all-services') }}</option>
                                @foreach ($services as $service)
                                    <option value="{{$service->id}}"
                                            @if(in_array($service->id, $zoneServices)) selected @endif>{{$service->name}}</option>
                                @endforeach
                            </select>

                        </div>

                    </div>

                    <div class="form-group row">

                        <div class="col-xs-10">

                            <div class="row">

                                <div class="col-xs-12 col-sm-6 col-md-3">

                                    <a href="{{ route('admin.zone.index') }}"
                                       class="btn btn-danger btn-block">{{ translateKeyword('cancel') }}</a>

                                </div>

                                <div class="col-xs-12 col-sm-6 offset-md-6 col-md-3">

                                    <button type="submit" class="btn btn-primary btn-block">{{ translateKeyword('attach-service') }}</button>

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
        function selectPricingType() {
            var pricing = $("#calculator").val();
            switch (pricing) {
                case 'MIN': {
                    $("#calculation_block").fadeIn(800);
                    $("#base_distance").fadeIn(800);
                    $("#unit_time_pricing").fadeIn(800);
                    $("#pricing_structure").fadeOut(800);
                    $('#peak_fields').fadeIn(800);
                    $('#peak_pricing_structure').fadeIn(800);
                }
                    break;
                case 'FIXED': {
                    $("#calculation_block").fadeIn(800);
                    $("#base_distance").fadeIn(800);
                    $("#unit_time_pricing").fadeIn(800);
                    $("#pricing_structure").fadeOut(800);
                    $('#peak_fields').fadeOut(800);
                    $('#peak_pricing_structure').fadeOut(800);
                }
                    break;
                case 'HOUR': {
                    $("#calculation_block").fadeIn(800);
                    $("#base_distance").fadeIn(800);
                    $("#unit_time_pricing").fadeIn(800);
                    $("#pricing_structure").fadeOut(800);
                    $('#peak_fields').fadeIn(800);
                    $('#peak_pricing_structure').fadeIn(800);
                }
                    break;
                case 'DISTANCE': {
                    $("#calculation_block").fadeIn(800);
                    $("#base_distance").fadeIn(800);
                    $("#unit_time_pricing").fadeIn(800);
                    $("#pricing_structure").fadeIn(800);
                    $('#peak_fields').fadeIn(800);
                    $('#peak_pricing_structure').fadeIn(800);
                }
                    break;
                case 'DISTANCETIER': {
                    $("#calculation_block").fadeIn(800);
                    $("#base_distance").fadeIn(800);
                    $("#unit_time_pricing").fadeIn(800);
                    $("#pricing_structure").fadeIn(800);
                    $('#peak_fields').fadeIn(800);
                    $('#peak_pricing_structure').fadeIn(800);
                }
                    break;
                case 'DISTANCEMIN': {
                    $("#calculation_block").fadeIn(800);
                    $("#base_distance").fadeIn(800);
                    $("#unit_time_pricing").fadeIn(800);
                    $("#pricing_structure").fadeIn(800);
                    $('#peak_fields').fadeIn(800);
                    $('#peak_pricing_structure').fadeIn(800);
                }
                    break;
                case 'DISTANCEHOUR': {
                    $("#calculation_block").fadeIn(800);
                    $("#base_distance").fadeIn(800);
                    $("#unit_time_pricing").fadeIn(800);
                    $("#pricing_structure").fadeIn(800);
                    $('#peak_fields').fadeIn(800);
                    $('#peak_pricing_structure').fadeIn(800);
                }
                    break;
                case 'DISTANCEWEIGHT': {
                    $("#calculation_block").fadeIn(800);
                    $("#calculation_block").fadeIn(800);
                    $("#base_distance").fadeIn(800);
                    $("#unit_time_pricing").fadeIn(800);
                    $("#pricing_structure").fadeIn(800);
                    $('#peak_fields').fadeIn(800);
                    $('#peak_pricing_structure').fadeIn(800);
                }
                    break;
                default: {
                    $("#calculation_block").fadeIn(800);
                    $("#base_distance").fadeIn(800);
                    $("#unit_time_pricing").fadeIn(800);
                    $("#pricing_structure").fadeOut(800);
                    $('#peak_fields').fadeIn(800);
                    $('#peak_pricing_structure').fadeIn(800);
                }
            }
        }

        $(document).ready(function () {
            $("#base_distance").hide();
            $("#unit_time_pricing").hide();
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

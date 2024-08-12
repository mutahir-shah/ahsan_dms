@extends('admin.layout.base')
@extends('admin.layout.base2')
@section('title', 'Update Zone Charge')

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="box box-block bg-white">
                <a href="{{ route('admin.zone-charges.index') }}" class="btn btn-default pull-right"><i
                            class="fa fa-angle-left"></i> {{ translateKeyword('back') }}</a>

                <h5 style="margin-bottom: 2em;">{{ translateKeyword('update-zone-charge')}}</h5>
                @include('common.notify')
                <form class="form-horizontal" action="{{route('admin.zone-charges.update', $zoneCharge->id)}}" method="POST"
                      enctype="multipart/form-data" role="form">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label for="name" class="col-xs-12 col-form-label">{{ translateKeyword('name')}}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ old('name', $zoneCharge->name) }}" name="name" required
                                   id="name" placeholder="{{ translateKeyword('enter-charge-name')}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="type" class="col-xs-12 col-form-label">{{ translateKeyword('type') }}</label>
                        <div class="col-xs-10">
                            <select name="type" class="form-control">
                                @foreach([ 'TOLL_CHARGE', 'AIRPORT_SURCHARGE', 'ADDITIONAL_CHARGE' ] as $type)
                                    <option value="{{ $type }}" @if ($type == old('type', $zoneCharge->type)) selected @endif>{{ ucwords(strtolower(str_replace('_', ' ', $type))) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="zone_id" class="col-xs-12 col-form-label">{{translateKeyword('zone') }}</label>
                        <div class="col-xs-10">
                            <select name="zone_id" class="form-control">
                                @foreach($zones as $zone)
                                    <option value="{{ $zone->id }}" @if ($zone->id == old('zone_id', $zoneCharge->zone_id)) selected @endif>{{ $zone->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="charge_type" class="col-xs-12 col-form-label">{{translateKeyword('charge-type')}}</label>
                        <div class="col-xs-10">
                            <select name="charge_type" class="form-control">
                                {{-- @foreach (['PERCENTAGE', 'FIXED' ] as $type) --}}
                                @foreach (['FIXED' ] as $type)
                                    <option value="{{ $type }}" @if ($type == old('charge_type', $zoneCharge->charge_type)) selected @endif>{{ ucwords(strtolower(str_replace('_', ' ', $type))) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @php($chargeLabels = [ 'PERCENTAGE' => 'Charge Percentage', 'FIXED' => 'Charge Amount' ])
                    <div class="form-group row">
                        <label for="charge_value" class="col-xs-12 col-form-label">{{ $chargeLabels[old('charge_type', 'FIXED')] }}</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="{{ old('charge_value', $zoneCharge->charge_value) }}" name="charge_value" required
                                   id="charge_value" placeholder="Enter {{ strtolower($chargeLabels[old('charge_type', 'FIXED')]) }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="zipcode" class="col-xs-12 col-form-label"></label>
                        <div class="col-xs-10">
                            <button type="submit" class="btn btn-primary">{{ translateKeyword('update-zone-charge') }}</button>
                            <a href="{{route('admin.zone-charges.index')}}" class="btn btn-default">{{ translateKeyword('cancel') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const chargeLabels = @json($chargeLabels);
        const chargeTypeSelect = $('[name=charge_type]');
        const chargeInputLabel = $('[for=charge_value]');
        const chargeValueInput = $('[name=charge_value]');

        function validatePercentageInput() {
            const chargeType = chargeTypeSelect.find('option:selected').val();

            if (chargeType === 'PERCENTAGE') {
                const value = chargeValueInput.val();
                if (!(value >= 0 && value <= 100))
                    chargeValueInput.val(value > 100 ? value.slice(0, 2): '');
            }
        };

        chargeTypeSelect.on('change', function() {
            chargeInputLabel.text(chargeLabels[$(this).val()]);
            validatePercentageInput();
        });

        chargeValueInput.on('input', validatePercentageInput);
    </script>
@endsection
